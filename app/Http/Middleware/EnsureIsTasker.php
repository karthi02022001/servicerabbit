<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsTasker
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
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You must be a tasker to access this area.',
                ], 403);
            }

            return redirect()->route('become-tasker')
                ->with('info', 'You need to become a tasker to access this area.');
        }

        return $next($request);
    }
}
