<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\Etudiant;
use App\Models\User;

class LogCrudOperations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
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

            if ($operation && !$this->shouldSkipLogging($request, $operation)) {
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
     * Determine if logging should be skipped for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $operation
     * @return bool
     */
    protected function shouldSkipLogging(Request $request, $operation)
    {
        // List of controller actions to skip logging
        $skipLoggingActions = [
            'App\Http\Controllers\DashboardController@index',
            'App\Http\Controllers\DocumentController@griddocindex',
            'App\Http\Controllers\DocumentController@index',
            'App\Http\Controllers\AuthenticationController@addUserForm',
            'App\Http\Controllers\TerminalController@index',
            'App\Http\Controllers\libraryController@index',
            'App\Http\Controllers\DocumentController@managedocuments',
            'App\Http\Controllers\libraryController@fetchlibrary',
            'App\Http\Controllers\StudentController@index',
            'App\Http\Controllers\Diplome@index',
            'App\Http\Controllers\LogController@index',
        ];

        $route = $request->route();
        $controllerAction = $route->getAction('controller');

        // Skip logging if the current action is in the list
        return in_array($controllerAction, $skipLoggingActions);
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
            return $this->getReadDetails($request);
        }

        return $request->all();
    }

    /**
     * Get the details of a read operation.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function getReadDetails(Request $request)
    {
        $route = $request->route();
        $controllerAction = $route->getAction('controller');
        $parameters = $route->parameters();

        // Add custom logic to capture specific details based on controller and action
        if ($controllerAction == 'App\Http\Controllers\ProfileController@usercard') {
            $etudiant = Etudiant::find($parameters['id_etu']);
            $user = User::find($etudiant->user_id);
            return [
                'action' => 'Reading user card',
                'etudiant_id' => $etudiant->id,
                'etudiant_name' => $etudiant->name,
                'user_id' => $user->id,
                'user_name' => $user->name,
                // Add more details as needed
            ];
        }

        return ['query' => $request->query()]; // Default case: log query parameters
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
