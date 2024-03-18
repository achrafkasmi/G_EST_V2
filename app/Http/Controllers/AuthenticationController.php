<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;


class AuthenticationController extends Controller
{
    use RedirectsUsers, ThrottlesLogins,AuthenticatesUsers;
    
    public function addUserForm()
    {
        if(!auth()->user()->hasRole('admin')) {
          
            abort(403);
        }

        return view('auth.register');
    }

    protected function postUser(Request $data)
    {            // Validate
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        if($data->file('image')){

            $path = "public/avatars/";

            $user->image = Storage::putFile($path, $data->file('image'));

            $user->save();

        };

        $role = $data['role'];

        $user->assignRole($role);
        //$user->assignRole('admin');


        $data->session()->flash('success', 'User added successfully.');

        return redirect()->route('ADD-USER-FORM');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
  
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function username()
    {
        return 'email';
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        sleep(2);
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    public function importUsers(Request $request)
    {        
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
    
        $file = $request->file('excel_file');
        $import = new ExcelImport();
        Excel::import($import, $file);
    
        return redirect()->back()->with('success', 'Excel file imported successfully');
    }
}
