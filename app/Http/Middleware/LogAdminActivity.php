<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class LogAdminActivity
{
    protected $except = [
        'admin/activity-logs*',
    ];

    public function handle(Request $request, Closure $next)
    {
        // Handle response to log after the request is processed
        $response = $next($request);

        // Skip logging for excluded routes
        if ($this->shouldLog($request)) {
            $this->logRequest($request, $response);
        }

        return $response;
    }

    protected function shouldLog($request)
    {
        // Only log admin routes
        if (!str_starts_with($request->path(), 'admin')) {
            return false;
        }

        // Skip excluded routes
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return false;
            }
        }

        // Always log POST, PUT, PATCH, DELETE requests
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return true;
        }

        // For GET requests, only log specific routes
        if ($request->isMethod('get')) {
            $routeName = Route::currentRouteName();
            $loggableGetRoutes = [
                'admin.dashboard',
                'admin.users.*',
                'admin.roles.*',
                'admin.permissions.*',
            ];

            foreach ($loggableGetRoutes as $route) {
                if (str_contains((string) $routeName, $route)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function logRequest($request, $response = null)
    {
        $action = $this->getActionName($request);
        $description = $this->getDescription($request);
        
        // Get the model being acted upon if available
        $model = null;
        $oldData = null;
        $newData = null;
        
        // For resource controllers, try to get the model from route parameters
        if ($request->route()) {
            $parameters = $request->route()->parameters();
            
            // Check for model in route model binding
            foreach ($parameters as $parameter) {
                if (is_object($parameter) && method_exists($parameter, 'getKey')) {
                    $model = $parameter;
                    
                    // For updates, get the original data before changes
                    if (in_array($action, ['update', 'delete']) && method_exists($model, 'getOriginal')) {
                        $oldData = $model->getOriginal();
                    }
                    
                    // For creates, the new data is in the request
                    if ($action === 'create') {
                        $newData = $request->except(['_token', '_method', 'password', 'password_confirmation']);
                    }
                    
                    break;
                }
            }
            
            // If no model found but this is a store/create request, use the request data
            if (!$model && in_array($action, ['create', 'store'])) {
                $newData = $request->except(['_token', '_method', 'password', 'password_confirmation']);
            }
        }
        
        // For login/logout events
        if ($request->is('admin/login') || $request->is('admin/logout')) {
            $model = null;
        }

        // Log the activity
        ActivityLogService::log(
            $action,
            $description,
            $model,
            $oldData,
            $newData
        );
    }

    protected function getActionName($request)
    {
        $method = $request->method();
        $path = $request->path();

        // Handle login/logout specifically
        if ($path === 'admin/login' && $method === 'POST') {
            return 'login';
        }
        
        if ($path === 'admin/logout' && $method === 'POST') {
            return 'logout';
        }

        // Handle CRUD operations
        return match(strtolower($method)) {
            'post' => 'create',
            'put', 'patch' => 'update',
            'delete' => 'delete',
            default => 'view',
        };
    }

    protected function getDescription($request)
    {
        $route = $request->route();
        $action = $route ? $route->getActionName() : '';
        $method = $request->method();
        $path = $request->path();

        // Handle login/logout
        if ($path === 'admin/login' && $method === 'POST') {
            return 'User logged in';
        }
        
        if ($path === 'admin/logout' && $method === 'POST') {
            return 'User logged out';
        }

        // Get route name if available
        $routeName = $route ? ($route->getName() ?: $path) : $path;

        // Get the controller and method
        $controller = '';
        $methodName = '';
        
        if (is_string($action) && str_contains($action, '@')) {
            $actionParts = explode('@', $action);
            $controller = class_basename($actionParts[0] ?? '');
            $methodName = $actionParts[1] ?? '';
        }

        return sprintf(
            '%s %s [%s@%s]',
            strtoupper($method),
            $routeName,
            $controller,
            $methodName
        );
    }
}