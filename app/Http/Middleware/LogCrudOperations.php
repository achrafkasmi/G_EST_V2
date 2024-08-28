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
        $response = $next($request);

        if (Auth::check()) {
            $operation = $this->getOperation($request);
            $modelName = $this->getModelName($request);

            $details = $this->getChangeDetails($request, $operation);

            if ($operation && !$this->shouldSkipLogging($request, $operation)) {
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
            'App\Http\Controllers\DashboardController@myIntern',
            'App\Http\Controllers\DocumentController@showDocuments',
            'App\Http\Controllers\StudentController@showSelectionForm',
            'App\Http\Controllers\AttendanceController@showAttendanceForm',
            'App\Http\Controllers\Auth\ResetPasswordController@index',

        ];

        $route = $request->route();
        $controllerAction = $route->getAction('controller');

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

        return 'Unknown';
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
            return ['id' => $request->route('id')];
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

        if ($controllerAction == 'App\Http\Controllers\ProfileController@usercard') {
            $etudiant = Etudiant::find($parameters['id_etu']);
            $user = User::find($etudiant->user_id);
            return [
                'action' => 'Reading user card',
                'etudiant_id' => $etudiant->id,
                'etudiant_name' => $etudiant->name,
                'user_id' => $user->id,
                'user_name' => $user->name,
            ];
        }

        return ['query' => $request->query()]; 
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
