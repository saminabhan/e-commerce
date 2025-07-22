<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show checkout page
     */
public function showCheckout()
{
    $cartItems = Cart::where('user_id', Auth::id())->get();
    
    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
    }

    $subTotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
    $vat = $subTotal * 0.15;
    $total = $subTotal + $vat;

    $addresses = Address::where('user_id', Auth::id())->get();

    return view('payment.checkout', [
        'items' => $cartItems,
        'subTotal' => $subTotal,
        'vat' => $vat,
        'total' => $total,
        'addresses' => $addresses,
    ]);
}

    /**
     * Place order
     */
public function placeOrder(Request $request)
{
    // التحقق من طريقة الدفع أولاً
    $request->validate([
        'payment_method' => 'required|in:cash_on_delivery,bank_transfer,check_payment,stripe',
    ]);

    $useExistingAddress = $request->filled('selected_address_id') && $request->selected_address_id !== 'new';

    if ($useExistingAddress) {
        // استخدام العنوان الموجود
        $address = Address::where('user_id', Auth::id())
                          ->where('id', $request->selected_address_id)
                          ->firstOrFail();

        $validated = [
            'name' => $address->name,
            'phone' => $address->phone,
            'zip' => $address->zip,
            'state' => $address->state,
            'city' => $address->city,
            'address' => $address->address,
            'locality' => $address->locality,
            'landmark' => $address->landmark,
        ];
    } else {
        // التحقق من البيانات الجديدة
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'zip' => 'required|string|max:10',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'locality' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
        ]);
    }

    $cartItems = Cart::where('user_id', Auth::id())->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('checkout.index')->with('error', 'Your cart is empty.');
    }

    $subTotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
    $vat = $subTotal * 0.15;
    $total = $subTotal + $vat;

    try {
        DB::beginTransaction();
        $user = Auth::user();
        $lastInvoiceNumber = Order::where('user_id', $user->id)->max('user_invoice_number');
        $nextInvoiceNumber = $lastInvoiceNumber ? $lastInvoiceNumber + 1 : 1;

        // إنشاء الطلب
        $order = Order::create([
            'user_id' => $user->id,
            'user_invoice_number' => $nextInvoiceNumber,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'zip' => $validated['zip'],
            'state' => $validated['state'],
            'city' => $validated['city'],
            'address' => $validated['address'],
            'locality' => $validated['locality'],
            'landmark' => $validated['landmark'] ?? null,
            'subtotal' => $subTotal,
            'vat' => $vat,
            'total' => $total,
            'status' => $request->payment_method === 'cash_on_delivery' ? 'pending' : 'unpaid',
            'payment_method' => $request->payment_method,
            'confirmation_expires_at' => now()->addMinutes(5),

        ]);

        // حفظ العنوان الجديد فقط إذا لم يكن موجوداً
        if (!$useExistingAddress) {
            Address::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'zip' => $validated['zip'],
                'state' => $validated['state'],
                'city' => $validated['city'],
                'address' => $validated['address'],
                'locality' => $validated['locality'],
                'landmark' => $validated['landmark'] ?? null,
            ]);
        }

        // إضافة عناصر الطلب
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // مسح السلة
        Cart::where('user_id', Auth::id())->delete();

        DB::commit();

        // توجيه المستخدم حسب طريقة الدفع
        return match ($request->payment_method) {
            'cash_on_delivery', 'bank_transfer', 'check_payment' =>
                redirect()->route('order.confirmation', $order->id)->with('success', 'Order placed successfully!'),
            'stripe' =>
                redirect()->route('payment.stripe.form', $order->id),
            default =>
                redirect()->route('checkout.index')->with('error', 'Invalid payment method selected.'),
        };

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Order failed: ' . $e->getMessage(), [
            'user_id' => Auth::id(),
            'error' => $e->getTraceAsString()
        ]);
        return redirect()->route('checkout.index')->with('error', 'Something went wrong. Please try again.');
    }
}

    /**
     * Show Stripe payment form
     */
    public function showStripeForm(Order $order)
    {
        // Security checks
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to order.');
        }

        if ($order->status === 'paid') {
            return redirect()->route('order.confirmation', $order->id)
                ->with('info', 'This order is already paid.');
        }

        if ($order->payment_method !== 'stripe') {
            return redirect()->route('order.confirmation', $order->id)
                ->with('error', 'Invalid payment method for this order.');
        }

        return view('payment.stripe', compact('order'));
    }

    /**
     * Process Stripe payment
     */
    public function processStripe(Request $request)
    {
        $validated = $request->validate([
            'stripeToken' => 'required|string',
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        // Security checks
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to order.');
        }

        if ($order->status === 'paid') {
            return redirect()->route('order.confirmation', $order->id)
                ->with('info', 'This order is already paid.');
        }

        try {
            // Set Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create charge
            $charge = Charge::create([
                'amount' => intval($order->total * 100), // Convert to cents
                'currency' => 'usd',
                'description' => 'Order Payment #' . $order->id,
                'source' => $validated['stripeToken'],
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'customer_name' => $order->name,
                ]
            ]);

            // Check if charge was successful
            if ($charge->status === 'succeeded') {
                $order->update([
                    'status' => 'paid',
                    'stripe_charge_id' => $charge->id,
                    'transaction_id' => $charge->balance_transaction ?? null,
                ]);

                Log::info('Payment successful', [
                    'order_id' => $order->id,
                    'charge_id' => $charge->id,
                    'amount' => $charge->amount / 100
                ]);

                return redirect()->route('order.confirmation', $order->id)
                    ->with('success', 'Payment successful! Your order has been confirmed.');
            } else {
                Log::warning('Payment not successful', [
                    'order_id' => $order->id,
                    'charge_status' => $charge->status
                ]);

                return redirect()->route('payment.stripe.form', $order->id)
                    ->with('error', 'Payment was not successful. Please try again.');
            }

        } catch (\Stripe\Exception\CardException $e) {
            // Card was declined
            Log::error('Stripe Card Exception', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'decline_code' => $e->getDeclineCode()
            ]);
            
            return redirect()->route('payment.stripe.form', $order->id)
                ->with('error', 'Your card was declined: ' . $e->getMessage());

        } catch (\Stripe\Exception\RateLimitException $e) {
            Log::error('Stripe Rate Limit Exception', ['error' => $e->getMessage()]);
            return redirect()->route('payment.stripe.form', $order->id)
                ->with('error', 'Too many payment attempts. Please wait and try again.');

        } catch (\Stripe\Exception\InvalidRequestException $e) {
            Log::error('Stripe Invalid Request Exception', ['error' => $e->getMessage()]);
            return redirect()->route('payment.stripe.form', $order->id)
                ->with('error', 'Invalid payment request. Please try again.');

        } catch (\Stripe\Exception\AuthenticationException $e) {
            Log::error('Stripe Authentication Exception', ['error' => $e->getMessage()]);
            return redirect()->route('payment.stripe.form', $order->id)
                ->with('error', 'Payment configuration error. Please contact support.');

        } catch (\Stripe\Exception\ApiConnectionException $e) {
            Log::error('Stripe API Connection Exception', ['error' => $e->getMessage()]);
            return redirect()->route('payment.stripe.form', $order->id)
                ->with('error', 'Network error. Please check your connection and try again.');

        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe API Exception', ['error' => $e->getMessage()]);
            return redirect()->route('payment.stripe.form', $order->id)
                ->with('error', 'Payment failed. Please try again.');

        } catch (\Exception $e) {
            Log::error('General Exception during payment', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('payment.stripe.form', $order->id)
                ->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


public function orderConfirmation(Order $order)
{
    // تحقق من ملكية الطلب
    if ($order->user_id !== Auth::id()) {
        abort(403, 'Unauthorized access to order.');
    }

    // تحقق من صلاحية الرابط
    if ($order->is_confirmed) {
        abort(403, 'This order has already been confirmed.');
    }

    if ($order->confirmation_expires_at && $order->confirmation_expires_at->lt(now())) {
        abort(403, 'This confirmation link has expired.');
    }

    // علّم الطلب كمؤكد
    $order->update(['is_confirmed' => true]);

    $order->load('items');

    return view('payment.order-confirmation', compact('order'));
}


    public function cancelOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to order.');
        }

        if ($order->status === 'paid') {
            return redirect()->route('order.confirmation', $order->id)
                ->with('error', 'Cannot cancel a paid order.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('user.orders')
            ->with('success', 'Order cancelled successfully.');
    }

    
}