<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:191'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Please contact support.',
                ])->withInput($request->only('email'));
            }

            // Check if email is verified
            if (!$user->email_verified_at) {
                // Generate new OTP and send
                $this->generateAndSendOTP($user);

                return redirect()->route('otp.verify')
                    ->with('info', 'Please verify your email. A new OTP has been sent.');
            }

            // Update last login info
            $user->updateLastLogin($request->ip());

            // Redirect based on user type
            if ($user->is_tasker && $user->isVerifiedTasker()) {
                return redirect()->intended(route('tasker.dashboard'))
                    ->with('success', 'Welcome back, ' . $user->first_name . '!');
            }

            return redirect()->intended(route('user.dashboard'))
                ->with('success', 'Welcome back, ' . $user->first_name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ], [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms.accepted' => 'You must accept the terms and conditions.',
        ]);

        // Generate 6-digit OTP
        $otp = $this->generateOTP();

        $user = User::create([
            'uuid' => Str::uuid(),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'is_tasker' => false,
            'is_active' => true,
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Login the user
        Auth::login($user);

        // Send OTP email
        $emailSent = $this->sendOTPEmail($user, $otp);

        if ($emailSent) {
            return redirect()->route('otp.verify')
                ->with('success', 'Registration successful! Please check your email for the OTP code.');
        } else {
            return redirect()->route('otp.verify')
                ->with('warning', 'Registration successful! OTP: ' . $otp . ' (Email sending failed - showing for testing)');
        }
    }

    /**
     * Show OTP verification form.
     */
    public function showOTPForm(): View
    {
        return view('auth.verify-otp');
    }

    /**
     * Verify OTP.
     */
    public function verifyOTP(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Please login first.']);
        }

        // Check if OTP is correct
        if ($user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        // Check if OTP is expired
        if ($user->otp_expires_at && now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // Mark email as verified
        $user->update([
            'email_verified_at' => now(),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        // Update last login
        $user->updateLastLogin($request->ip());

        return redirect()->route('user.dashboard')
            ->with('success', 'Email verified successfully! Welcome to Service Rabbit.');
    }

    /**
     * Resend OTP.
     */
    public function resendOTP(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Please login first.']);
        }

        if ($user->email_verified_at) {
            return redirect()->route('user.dashboard')
                ->with('info', 'Your email is already verified.');
        }

        // Generate new OTP
        $otp = $this->generateOTP();

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $emailSent = $this->sendOTPEmail($user, $otp);

        if ($emailSent) {
            return back()->with('success', 'A new OTP has been sent to your email.');
        } else {
            return back()->with('warning', 'New OTP: ' . $otp . ' (Email sending failed - showing for testing)');
        }
    }

    /**
     * Generate OTP.
     */
    private function generateOTP(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate and send OTP to user.
     */
    private function generateAndSendOTP(User $user): bool
    {
        $otp = $this->generateOTP();

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        return $this->sendOTPEmail($user, $otp);
    }

    /**
     * Send OTP email.
     */
    private function sendOTPEmail(User $user, string $otp): bool
    {
        try {
            Mail::to($user->email)->send(new OTPMail($user, $otp));
            Log::info('OTP email sent successfully to: ' . $user->email);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email to ' . $user->email . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:191'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'We have emailed your password reset link!')
            : back()->withErrors(['email' => __($status)])->withInput();
    }

    /**
     * Show password reset form.
     */
    public function showResetPasswordForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle password reset request.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email', 'max:191'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Your password has been reset!')
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }
}
