<?php

namespace App\Http\Middleware;

use App\Events\LockoutAccountEvent;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ThrottleVerifyTfaToken extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param int|string $maxAttempts
     * @param float|int $decayMinutes
     * @param string $prefix
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Http\Exceptions\ThrottleRequestsException
     */
    public function handle($request, Closure $next, $maxAttempts = 120, $decayMinutes = 1, $prefix = '')
    {
        if (is_string($maxAttempts)
            && func_num_args() === 3
            && !is_null($limiter = $this->limiter->limiter($maxAttempts))) {
            return $this->handleRequestUsingNamedLimiter($request, $next, $maxAttempts, $limiter);
        }

        return $this->handleRequest(
            $request,
            $next,
            [
                (object)[
                    'key' => $prefix . $this->resolveRequestSignature($request),
                    'maxAttempts' => $this->resolveMaxAttempts($request, $maxAttempts),
                    'decayMinutes' => $decayMinutes,
                    'responseCallback' => null,
                ],
            ]
        );
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array $limits
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Http\Exceptions\ThrottleRequestsException
     */
    protected function handleRequest($request, Closure $next, array $limits)
    {
        foreach ($limits as $limit) {
            // 1分あたりの最大アクセス数 (THROTTLES_VERIFY_CODE_MAX_ATTEMPTS) を超えた場合、アカウントをロックする
            if ($this->limiter->tooManyAttempts($limit->key, $limit->maxAttempts)) {
                $routeName = Route::currentRouteName();
                $model = 'member';
                if (Str::contains($routeName, 'admin')) {
                    $model = 'admin';
                }
                // custom handle when send wrong tokens > 3 times
                // lockout user + logout user
                event(new LockoutAccountEvent($request->email, $model));
                Auth::guard($model)->logout();

                // if request is api
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too Many Attempts.',
                        'data' => [],
                    ], JsonResponse::HTTP_TOO_MANY_REQUESTS);
                }

                // make invalid session
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                // if request is not api
                return redirect()->route('admin.auth.show_account_lockout');
            }

            $this->limiter->hit($limit->key, $limit->decayMinutes * 60);
        }
        $response = $next($request);

        foreach ($limits as $limit) {
            $response = $this->addHeaders(
                $response,
                $limit->maxAttempts,
                $this->calculateRemainingAttempts($limit->key, $limit->maxAttempts)
            );
        }

        return $response;
    }
}
