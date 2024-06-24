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
        // Process the request and get the response
        $response = $next($request);

        // Check if the user is authenticated and the request method is either POST, PUT, or DELETE
        if (Auth::check() && ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete'))) {
            $operation = $request->isMethod('post') ? 'create' : ($request->isMethod('put') ? 'update' : 'delete');
            $modelName = $this->getModelName($request);

            // Determine the details of the changes
            $details = $this->getChangeDetails($request, $operation);

            // Create a new log entry
            Log::create([
                'user_id' => Auth::id(),
                'operation' => $operation,
                'model' => $modelName,
                'details' => json_encode($details),
            ]);
        }

        return $response;
    }

    /**
     * Get the name of the model handling the current request.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function getModelName(Request $request)
    {
        $route = $request->route();
        $controllerAction = $route->getAction('controller');

        if ($controllerAction) {
            return class_basename($controllerAction);
        }

        return 'Unknown'; // Default to Unknown if model name cannot be determined
    }

    /**
     * Get the details of the changes made during the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $operation
     * @return array
     */
    protected function getChangeDetails(Request $request, $operation)
    {
        if ($operation === 'delete') {
            return ['id' => $request->route('id')]; // Assuming the ID is in the route parameters
        }

        $model = $this->getModelInstance($request);

        if ($operation === 'update') {
            return $this->getUpdatedFields($model, $request->all());
        }

        return $request->all();
    }

    /**
     * Get the model instance associated with the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected function getModelInstance(Request $request)
    {
        $route = $request->route();
        $modelClass = $route->getAction('model');

        if ($modelClass) {
            $modelId = $route->parameter('id');
            return $modelClass::find($modelId);
        }

        return null;
    }

    /**
     * Get the updated fields by comparing the original and new values.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $newValues
     * @return array
     */
    protected function getUpdatedFields($model, $newValues)
    {
        $original = $model->getOriginal();
        return array_diff_assoc($newValues, $original);
    }
}
