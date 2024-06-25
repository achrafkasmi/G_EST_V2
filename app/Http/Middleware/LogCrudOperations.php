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

        // Check if the user is authenticated
        if (Auth::check()) {
            $operation = $this->getOperation($request);
            $modelName = $this->getModelName($request);

            // Determine the details of the changes
            $details = $this->getChangeDetails($request, $operation);

            if ($operation) {
                // Create a new log entry
                Log::create([
                    'user_id' => Auth::id(),
                    'operation' => $operation,
                    'model' => $modelName,
                    'details' => json_encode($details),
                ]);
            }
        }

        return $response;
    }

    /**
     * Get the operation type.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function getOperation(Request $request)
    {
        if ($request->isMethod('post')) {
            return 'create';
        } elseif ($request->isMethod('put')) {
            return 'update';
        } elseif ($request->isMethod('delete')) {
            return 'delete';
        } elseif ($request->isMethod('get')) {
            return 'read';
        }

        return null;
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
        } elseif ($operation === 'update') {
            $model = $this->getModelInstance($request);
            return $this->getUpdatedFields($model, $request->all());
        } elseif ($operation === 'read') {
            return ['query' => $request->query()]; // Log query parameters for read operations
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
        if ($model) {
            $original = $model->getOriginal();
            return array_diff_assoc($newValues, $original);
        }

        return $newValues;
    }
}
