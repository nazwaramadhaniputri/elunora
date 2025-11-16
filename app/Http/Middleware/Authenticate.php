<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Check the guard being used
            $guard = $this->auth->getDefaultDriver();
            
            // Redirect to the appropriate login route based on the guard
            if ($guard === 'petugas') {
                return route('admin.login');
            }
            
            return route('login');
        }
    }
}
