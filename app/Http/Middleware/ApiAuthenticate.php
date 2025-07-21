<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiAuthenticate extends Middleware
{
    public function handle($request, \Closure $next, ...$guards)
    {
        return parent::handle($request, $next, ...$guards);
    }

    protected function unauthenticated($request, array $guards)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Unauthenticated.'
        ], 401));
    }
}
