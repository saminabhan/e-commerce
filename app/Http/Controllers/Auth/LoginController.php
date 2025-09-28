<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // تحقق من محاولات تسجيل الدخول المتعددة
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // محاولة تسجيل الدخول
        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // زيادة عدد المحاولات الفاشلة
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * After user is authenticated
     */
    protected function authenticated(Request $request, $user)
    {
        // تسجيل دخول ناجح بدون أي تحقق
        return redirect()->intended($this->redirectPath())
            ->with('success', 'Welcome back to Sami Store!');
    }

    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // التحقق من وجود المستخدم
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->with('error', 'We could not find a user with that email address.');
        }

        try {
            // إنشاء token للإعادة تعيين
            $token = Str::random(60);
            
            // حفظ التوكن في قاعدة البيانات (تحتاج إنشاء جدول password_resets)
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => Hash::make($token),
                    'created_at' => now()
                ]
            );

            // إرسال الإيميل
            $resetUrl = url('password/reset/' . $token . '?email=' . urlencode($request->email));
            
            Mail::raw(
                "Hello,\n\n" .
                "You are receiving this email because we received a password reset request for your account.\n\n" .
                "Click the link below to reset your password:\n" .
                $resetUrl . "\n\n" .
                "This password reset link will expire in 60 minutes.\n\n" .
                "If you did not request a password reset, no further action is required.\n\n" .
                "Regards,\nSami Store Team",
                function ($message) use ($request) {
                    $message->to($request->email)
                           ->subject('Reset Password Notification')
                           ->from(config('mail.from.address', 'noreply@samistore.com'), 
                                  config('mail.from.name', 'Sami Store'));
                }
            );

            return back()->with('status', 'We have emailed your password reset link!');

        } catch (\Exception $e) {
            Log::error('Password reset email failed', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to send password reset email. Please try again.');
        }
    }

    /**
     * Display the password reset form.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // التحقق من التوكن
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'This password reset token is invalid.']);
        }

        // التحقق من انتهاء صلاحية التوكن (60 دقيقة)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            return back()->withErrors(['email' => 'This password reset token has expired.']);
        }

        // العثور على المستخدم وتحديث كلمة المرور
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // تحديث كلمة المرور
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->save();

        // حذف التوكن المستخدم
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset! Please login with your new password.');
    }
}