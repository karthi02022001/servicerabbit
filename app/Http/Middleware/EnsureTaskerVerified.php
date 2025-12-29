<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTaskerVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->is_tasker) {
            return redirect()->route('become-tasker');
        }

        $taskerProfile = $user->taskerProfile;

        if (!$taskerProfile) {
            return redirect()->route('tasker.register.step1')
                ->with('info', 'Please complete your tasker registration.');
        }

        if ($taskerProfile->verification_status !== 'approved') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your tasker profile is pending verification.',
                ], 403);
            }

            return redirect()->route('tasker.verification-pending')
                ->with('info', 'Your profile is pending verification. We\'ll notify you once it\'s approved.');
        }

        return $next($request);
    }
}
