<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function details()
    {
        return view('user.account-details');
    }

    public function updateDetails(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id),
            ],
        ], [
            'email.unique' => 'This email address is already registered with another account.',
            'mobile.unique' => 'This mobile number is already registered with another account.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        // التحقق من تغيير الإيميل
        if ($validatedData['email'] !== $user->email) {
            // تحقق إضافي من عدم وجود الإيميل (للتأكد المضاعف)
            $emailExists = User::where('email', $validatedData['email'])
                              ->where('id', '!=', $user->id)
                              ->exists();
            
            if ($emailExists) {
                if ($request->ajax()) {
                    return response()->json([
                        'error' => true,
                        'message' => 'This email address is already registered with another account.'
                    ], 422);
                }
                
                return redirect()->back()
                    ->withErrors(['email' => 'This email address is already registered with another account.'])
                    ->withInput();
            }

            // حفظ البيانات المؤقتة في الجلسة
            Session::put('pending_user_update', [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'mobile' => $validatedData['mobile'],
                'original_email' => $user->email
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'confirm_email_change' => true,
                    'message' => 'You are about to change your email address. This will require email verification.',
                    'new_email' => $validatedData['email']
                ]);
            }

            // إذا لم يكن AJAX، اعرض صفحة التأكيد مباشرة
            return view('user.confirm-email-change', [
                'new_email' => $validatedData['email'],
                'current_email' => $user->email
            ]);
        }

        // إذا لم يتغير الإيميل، قم بالتحديث مباشرة
        $user->update($validatedData);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Account details updated successfully!'
            ]);
        }

        return redirect()->route('user.details')
            ->with('success', 'Account details updated successfully!');
    }

    public function confirmEmailChange(Request $request)
    {
        $pendingUpdate = Session::get('pending_user_update');
        
        if (!$pendingUpdate) {
            return redirect()->route('user.details')
                ->with('error', 'No pending email change found.');
        }

        if ($request->input('confirm') === 'yes') {
            // إرسال رمز التحقق للإيميل الجديد
            $verificationCode = rand(100000, 999999);
            
            Session::put('email_verification', [
                'code' => $verificationCode,
                'expires_at' => now()->addMinutes(5),
                'pending_update' => $pendingUpdate
            ]);

            try {
                // التحقق من إعدادات الـ Mail أولاً
                if (!config('mail.default')) {
                    throw new \Exception('Mail configuration not found');
                }

                // استخدام Mail::raw كبديل أولاً للاختبار
                Mail::send('emails.email_change_verification', [
                    'verificationCode' => $verificationCode,
                    'user' => Auth::user()
                ], function ($message) use ($pendingUpdate) {
                    $message->to($pendingUpdate['email'])
                        ->subject('Email Verification - Account Update')
                        ->from(config('mail.from.address', 'noreply@samistore.com'), 
                                config('mail.from.name', 'Sami Store'));
                });


                return redirect()->route('user.verify.email.form')
                    ->with('success', 'Verification code sent to your new email address: ' . $pendingUpdate['email']);
                    
            } catch (\Exception $e) {
                // تسجيل الخطأ للمراجعة
                Log::error('Failed to send email verification', [
                    'error' => $e->getMessage(),
                    'email' => $pendingUpdate['email'],
                    'user_id' => Auth::id()
                ]);

                // عرض رسالة خطأ مفصلة للمطور
                $errorMessage = 'Failed to send verification email. Error: ' . $e->getMessage();
                
                return redirect()->route('user.details')
                    ->with('error', $errorMessage);
            }
        } else {
            // إلغاء التحديث
            Session::forget('pending_user_update');
            return redirect()->route('user.details')
                ->with('info', 'Email change cancelled.');
        }
    }

    public function showEmailVerificationForm()
    {
        $emailVerification = Session::get('email_verification');
        
        if (!$emailVerification || now()->gt($emailVerification['expires_at'])) {
            Session::forget(['email_verification', 'pending_user_update']);
            return redirect()->route('user.details')
                ->with('error', 'Verification code expired. Please try again.');
        }

        return view('user.verify-email-change');
    }

    public function verifyEmailChange(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|digits:6'
        ]);

        $emailVerification = Session::get('email_verification');
        
        if (!$emailVerification || now()->gt($emailVerification['expires_at'])) {
            Session::forget(['email_verification', 'pending_user_update']);
            return redirect()->route('user.details')
                ->with('error', 'Verification code expired. Please try again.');
        }

        if ($request->input('verification_code') != $emailVerification['code']) {
            return back()->withErrors(['verification_code' => 'Invalid verification code.']);
        }

        // تحديث بيانات المستخدم
        /** @var User $user */
        $user = Auth::user();
        $pendingUpdate = $emailVerification['pending_update'];
        
        $user->update([
            'name' => $pendingUpdate['name'],
            'email' => $pendingUpdate['email'],
            'mobile' => $pendingUpdate['mobile']
        ]);

        // مسح البيانات المؤقتة
        Session::forget(['email_verification', 'pending_user_update']);

        return redirect()->route('user.details')
            ->with('success', 'Account details updated successfully! Your new email address has been verified.');
    }

public function resendEmailVerification()
{
    $emailVerification = Session::get('email_verification');
    
    if (!$emailVerification) {
        return redirect()->route('user.details')
            ->with('error', 'No pending email verification found.');
    }

    $newCode = rand(100000, 999999);
    $emailVerification['code'] = $newCode;
    $emailVerification['expires_at'] = now()->addMinutes(5);
    Session::put('email_verification', $emailVerification);

    $pendingUpdate = $emailVerification['pending_update'];

    try {
        Mail::send('emails.email_change_verification', [
            'verificationCode' => $newCode,
            'user' => Auth::user()
        ], function ($message) use ($pendingUpdate) {
            $message->to($pendingUpdate['email'])
                   ->subject('Email Verification - Account Update (Resend)')
                   ->from(config('mail.from.address', 'noreply@samistore.com'), 
                          config('mail.from.name', 'Sami Store'));
        });

        return back()->with('success', 'New verification code sent to your email: ' . $pendingUpdate['email']);
        
    } catch (\Exception $e) {
        Log::error('Failed to resend email verification', [
            'error' => $e->getMessage(),
            'email' => $pendingUpdate['email'],
            'user_id' => Auth::id()
        ]);

        return back()->with('error', 'Failed to send verification email. Error: ' . $e->getMessage());
    }
}

    public function checkEmailAvailability(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = Auth::user();
        $email = $request->input('email');

        // إذا كان نفس الإيميل الحالي، فهو متاح
        if ($email === $user->email) {
            return response()->json(['available' => true]);
        }

        // تحقق من وجود الإيميل في قاعدة البيانات
        $emailExists = User::where('email', $email)->exists();

        return response()->json([
            'available' => !$emailExists,
            'message' => $emailExists ? 'This email address is already registered.' : 'Email is available.'
        ]);
    }

    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The current password is incorrect.');
                    }
                },
            ],
            'new_password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ]);

        $user->password = Hash::make($validatedData['new_password']);
        $user->save();

        return redirect()->route('user.details')
            ->with('success', 'Password updated successfully!');
    }

    public function orders()
    {
        $user = Auth::user();

        $orders = Order::withCount('items')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.account-orders', compact('orders'));
    }

    public function orderDetails(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'tracking']);

        return view('user.order-details', compact('order'));
    }

    // طريقة للاختبار (احذفها بعد حل المشكلة)
    public function testEmailConfiguration()
    {
        try {
            // اختبار إعدادات الـ Mail
            $config = [
                'mail_driver' => config('mail.default'),
                'mail_host' => config('mail.mailers.smtp.host'),
                'mail_port' => config('mail.mailers.smtp.port'),
                'mail_username' => config('mail.mailers.smtp.username'),
                'mail_encryption' => config('mail.mailers.smtp.encryption'),
                'mail_from_address' => config('mail.from.address'),
            ];

            // اختبار إرسال إيميل بسيط
            Mail::raw('This is a test email from Sami Store', function ($message) {
                $message->to(Auth::user()->email)
                       ->subject('Test Email Configuration');
            });

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully',
                'config' => $config
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'config' => config('mail')
            ]);
        }
    }
}