<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
     * Rate limiting لطلبات إعادة التعيين
     */
    protected function checkRateLimit(Request $request)
    {
        $key = 'password-reset-' . $request->ip();
        $maxAttempts = 5; // 5 محاولات كحد أقصى
        $decayMinutes = 60; // خلال 60 دقيقة
        
        if (cache()->has($key) && cache()->get($key) >= $maxAttempts) {
            return true; // تم تجاوز الحد الأقصى
        }
        
        return false;
    }

    /**
     * تسجيل محاولة إعادة التعيين
     */
    protected function logResetAttempt(Request $request)
    {
        $key = 'password-reset-' . $request->ip();
        $attempts = cache()->get($key, 0) + 1;
        cache()->put($key, $attempts, 60); // حفظ لمدة 60 دقيقة
    }

    /**
     * Send a reset link to the given user.
     */
   public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // فحص Rate Limiting (محاولات كثيرة)
    if ($this->checkRateLimit($request)) {
        return back()->with('error', 'Too many password reset attempts. Please try again later.');
    }

    // تسجيل المحاولة
    $this->logResetAttempt($request);

    // التحقق من وجود المستخدم
    $user = User::where('email', $request->email)->first();
    
    if (!$user) {
        Log::warning('Password reset attempted for non-existent email', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        return back()->with('error', 'We could not find a user with that email address.');
    }

    try {
        // فحص إذا فيه token حديث (لمنع التكرار)
        $existingToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($existingToken && $existingToken->created_at > now()->subMinutes(2)) {
            $secondsLeft = now()->diffInSeconds(
                \Carbon\Carbon::parse($existingToken->created_at)->addMinutes(2),
                false
            );

            return back()->with([
                'error' => 'A password reset email was already sent recently. Please check your email or wait a few minutes before trying again.',
                'retry_after' => $secondsLeft > 0 ? $secondsLeft : 0
            ])->withInput();
        }

        // إنشاء token جديد
        $token = Str::random(60);
        
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

        Mail::send('emails.password_reset', ['resetUrl' => $resetUrl, 'user' => $user], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Password Notification')
                    ->from(config('mail.from.address', 'noreply@samistore.com'), 
                        config('mail.from.name', 'Sami Store'));
        });


        return back()->with('status', 'We have emailed your password reset link to ' . $request->email);

    } catch (\Exception $e) {
        Log::error('Password reset email failed', [
            'email' => $request->email,
            'error' => $e->getMessage(),
            'ip' => $request->ip()
        ]);
        
        return back()->with('error', 'Failed to send password reset email. Please try again.');
    }
}


    /**
     * Display the password reset form.
     */
   /**
 * Display the password reset form.
 */
public function showResetForm(Request $request, $token = null)
{
    // التحقق من وجود token و email
    if (!$token || !$request->email) {
        return redirect()->route('password.request')
            ->withErrors(['email' => 'Invalid password reset link.']);
    }

    // البحث عن token في الداتابيس
    $passwordReset = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->first();

    // التحقق من وجود سجل للإيميل هذا
    if (!$passwordReset) {
        Log::warning('Password reset form accessed with non-existent or already used token', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);
        
        return redirect()->route('password.request')
            ->withErrors(['email' => 'This password reset link is invalid or has already been used.']);
    }

    // التحقق من صحة الـ token
    if (!Hash::check($token, $passwordReset->token)) {
        Log::warning('Password reset form accessed with invalid token', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);
        
        return redirect()->route('password.request')
            ->withErrors(['email' => 'This password reset link is invalid.']);
    }

    // التحقق من انتهاء صلاحية الـ token (60 دقيقة)
    $tokenAge = now()->diffInMinutes($passwordReset->created_at);
    if ($tokenAge > 60) {
        // حذف الـ token المنتهي
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();
        
        Log::warning('Password reset form accessed with expired token', [
            'email' => $request->email,
            'token_age_minutes' => $tokenAge,
            'ip' => $request->ip()
        ]);
        
        return redirect()->route('password.request')
            ->withErrors(['email' => 'This password reset link has expired. Please request a new one.']);
    }

    // كل شي تمام، اعرض الـ form
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
        'email' => 'required|email', // إضافة التحقق من الإيميل
        'password' => 'required|min:8|confirmed',
    ]);

    // فحص Rate Limiting لإعادة التعيين أيضاً
    $resetKey = 'password-reset-submit-' . $request->ip();
    if (cache()->has($resetKey) && cache()->get($resetKey) >= 3) {
        return back()->withErrors(['email' => 'Too many reset attempts. Please try again later.']);
    }

    // جلب السجل المرتبط بالإيميل فقط
    $passwordReset = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->first();

    // التحقق من وجود سجل
    if (!$passwordReset) {
        cache()->put($resetKey, cache()->get($resetKey, 0) + 1, 60);
        
        Log::warning('Password reset attempted with non-existent email', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return back()->withErrors(['email' => 'This password reset link is invalid.']);
    }

    // التحقق من صحة التوكن
    if (!Hash::check($request->token, $passwordReset->token)) {
        cache()->put($resetKey, cache()->get($resetKey, 0) + 1, 60);

        Log::warning('Invalid password reset token used', [
            'email' => $request->email,
            'token_provided' => substr($request->token, 0, 10) . '...',
            'ip' => $request->ip()
        ]);

        return back()->withErrors(['token' => 'This password reset token is invalid.']);
    }

    // التحقق من انتهاء صلاحية التوكن (60 دقيقة)
    $tokenAge = now()->diffInMinutes($passwordReset->created_at);
    if ($tokenAge > 60) {
        DB::table('password_reset_tokens')->where('email', $passwordReset->email)->delete();
        
        Log::warning('Expired password reset token used', [
            'email' => $request->email,
            'token_age_minutes' => $tokenAge,
            'ip' => $request->ip()
        ]);
        
        return back()->withErrors(['token' => 'This password reset token has expired. Please request a new one.']);
    }

    // العثور على المستخدم المرتبط بالبريد
    $user = User::where('email', $passwordReset->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'We could not find a user with that email address.']);
    }

    // تحديث كلمة المرور
    $user->forceFill([
        'password' => Hash::make($request->password)
    ])->save();

    // حذف التوكن المستخدم (مهم جداً!)
    DB::table('password_reset_tokens')->where('email', $passwordReset->email)->delete();

    Log::info('Password reset successful', [
        'user_id' => $user->id,
        'email' => $passwordReset->email,
        'ip' => $request->ip()
    ]);

    return redirect()->route('login')->with('status', 'Your password has been reset successfully! Please login with your new password.');
}

    /**
     * طريقة للاختبار 
     */
    public function testEmailConfiguration()
    {
        try {
            $config = [
                'mail_driver' => config('mail.default'),
                'mail_host' => config('mail.mailers.smtp.host'),
                'mail_port' => config('mail.mailers.smtp.port'),
                'mail_username' => config('mail.mailers.smtp.username'),
                'mail_encryption' => config('mail.mailers.smtp.encryption'),
                'mail_from_address' => config('mail.from.address'),
            ];

            Mail::raw('This is a test email from Sami Store', function ($message) {
                $message->to(Auth::user()->email)
                       ->subject('Test Email Configuration')
                       ->from(config('mail.from.address', 'noreply@samistore.com'), 
                              config('mail.from.name', 'Sami Store'));
            });

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully to ' . Auth::user()->email,
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

    /**
     * تنظيف التوكنز المنتهية الصلاحية
     */
    public function cleanupExpiredTokens()
    {
        $deleted = DB::table('password_reset_tokens')
            ->where('created_at', '<', now()->subHours(1))
            ->delete();

        Log::info("Cleaned up {$deleted} expired password reset tokens");
        
        return response()->json([
            'success' => true,
            'deleted_tokens' => $deleted
        ]);
    }
}