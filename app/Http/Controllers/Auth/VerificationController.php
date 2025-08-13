<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TempUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    /**
     * إضافة middleware للتأكد أن المستخدم غير مسجل دخول
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showVerificationForm()
    {
        $tempUserId = Session::get('temp_user_id');
        
        if (!$tempUserId) {
            return redirect()->route('register')->withErrors(['error' => 'No registration found. Please register first.']);
        }

        $tempUser = TempUser::find($tempUserId);
        if (!$tempUser) {
            Session::forget('temp_user_id');
            return redirect()->route('register')->withErrors(['error' => 'Registration expired. Please register again.']);
        }

        return view('auth.verify', compact('tempUser'));
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $tempUserId = Session::get('temp_user_id');
        if (!$tempUserId) {
            return redirect()->route('register')->withErrors(['error' => 'No registration found. Please register first.']);
        }

        $tempUser = TempUser::where('id', $tempUserId)
                           ->where('verification_code', $request->code)
                           ->first();

        if (!$tempUser) {
            return back()->withErrors(['code' => 'Invalid verification code']);
        }

        // Check if code is expired
        if ($tempUser->isCodeExpired()) {
            return back()->withErrors(['code' => 'Verification code has expired. Please request a new one.']);
        }

        // تحقق من عدم وجود المستخدم في جدول users
        $existingUser = User::where('email', $tempUser->email)->first();
        if ($existingUser) {
            $tempUser->delete();
            Session::forget('temp_user_id');
            return redirect()->route('login')
                ->withErrors(['email' => 'This email is already registered. Please login instead.']);
        }

        // Create the actual user
        $user = User::create([
            'name' => $tempUser->name,
            'email' => $tempUser->email,
            'mobile' => $tempUser->mobile,
            'password' => $tempUser->password, // Already hashed
            'is_verified' => true,
        ]);

        // Clean up
        $tempUser->delete();
        Session::forget('temp_user_id');

        // Log the user in
        Auth::login($user);

        return redirect('/')->with('success', 'Email verified successfully! Welcome to Infinity!');
    }

    public function resendCode(Request $request)
    {
        $tempUserId = Session::get('temp_user_id');
        
        if (!$tempUserId) {
            return response()->json(['success' => false, 'message' => 'No registration found'], 404);
        }

        $tempUser = TempUser::find($tempUserId);
        if (!$tempUser) {
            Session::forget('temp_user_id');
            return response()->json(['success' => false, 'message' => 'Registration not found'], 404);
        }

        // Check if enough time has passed (at least 10 seconds between requests)
        if (!$tempUser->isCodeExpired() && $tempUser->updated_at->diffInSeconds(Carbon::now()) < 10) {
            $remainingSeconds = 10 - $tempUser->updated_at->diffInSeconds(Carbon::now());
            return response()->json([
                'success' => false,
                'message' => 'Please wait before requesting a new code',
                'remaining_seconds' => $remainingSeconds
            ], 429);
        }

        // Generate new code (this will invalidate the old one)
        $verificationCode = $tempUser->generateVerificationCode();

        try {
            Mail::to($tempUser->email)->send(new \App\Mail\EmailVerificationMail($verificationCode));
            return response()->json(['success' => true, 'message' => 'New verification code sent! (Valid for 5 minutes)']);
        } catch (\Exception $e) {
            Log::error('Failed to send verification email: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send email'], 500);
        }
    }

    public function cleanup()
    {
        // Clean up expired temp users (run this via cron job)
        TempUser::where('verification_code_expires_at', '<', Carbon::now())->delete();
    }
}