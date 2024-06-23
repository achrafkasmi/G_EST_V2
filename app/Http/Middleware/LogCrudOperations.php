<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class LogCrudOperations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete'))) {
            $operation = $request->isMethod('post') ? 'create' : ($request->isMethod('put') ? 'update' : 'delete');
            $model = $this->getControllerName($request); // Get controller name

            $details = $request->all();
            if ($request->isMethod('delete')) {
                $details = ['id' => $request->route('Log')]; // Assuming the ID is in the route parameters
            }

            Log::create([
                'user_id' => Auth::id(),
                'operation' => $operation,
                'model' => $model,
                'details' => json_encode($details),
            ]);
        }

        return $response;
    }

    /**
     * Get the name of the controller handling the current request.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function getControllerName(Request $request)
    {
        $route = $request->route();
        $controllerAction = $route->getAction('controller');

        if ($controllerAction) {
            return class_basename($controllerAction);
        }

        return 'Unknown'; // Default to Unknown if controller name cannot be determined
    }
}
