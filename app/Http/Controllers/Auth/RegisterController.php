<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TempUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $verificationCode = rand(100000, 999999);

        // Delete any existing temp user with same email or mobile
        TempUser::where('email', $request->email)
                ->orWhere('mobile', $request->mobile)
                ->delete();

        // Create temp user
        $tempUser = TempUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // Store temp user ID in session
        Session::put('temp_user_id', $tempUser->id);

        // Send verification email
        try {
            Mail::to($tempUser->email)->send(new \App\Mail\EmailVerificationMail($verificationCode));
        } catch (\Exception $e) {
            $tempUser->delete();
            return back()->withErrors(['email' => 'Failed to send verification email. Please try again.']);
        }

        return redirect()->route('verify.form')->with('success', 'Registration successful! Please check your email for the verification code.');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:temp_users'],
            'mobile' => ['required', 'digits:10', 'unique:users', 'unique:temp_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}