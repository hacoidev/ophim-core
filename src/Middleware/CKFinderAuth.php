<?php


namespace Ophim\Core\Middleware;

use Closure;
use Illuminate\Http\Request;

class CKFinderAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        config(['ckfinder.authentication' => function () {
            return true;
        }]);

        return $next($request);
    }
}
