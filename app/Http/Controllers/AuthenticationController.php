<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\Personnel;
use App\Models\Role;
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

        return view('auth.register')->with(['active_tab' => 'addusers']);
    }

    protected function postUser(Request $data)
{
    $data->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string|in:admin,teacher,student',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    try {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        if ($data->file('image')) {
            $path = "public/avatars/";
            $user->image = Storage::putFile($path, $data->file('image'));
            $user->save();
        }

        $role = $data['role'];
        $user->assignRole($role);

        if ($role === "teacher") {
            $personnel = Personnel::where('user_id', $user->id)->first() ?? new Personnel;
            $personnel->nom_personnel = $user->name;
            $personnel->user_id = $user->id;
            $personnel->save();
        }

        $data->session()->flash('success', 'User added successfully.');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) { // Integrity constraint violation
            $data->session()->flash('error', 'Account already exists with this email.');
        } else {
            $data->session()->flash('error', 'An error occurred while adding the user.');
        }
    }

    return redirect()->route('ADD-USER-FORM');
}

    public function login()
    {
        if(auth()->check()){
            
            return redirect('/dash');
        }

        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
    
            return response()->json(['success' => false, 'message' => 'Too many login attempts.'], 429);
        }
    
        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
    
            return response()->json(['success' => true]);
        }
    
        $this->incrementLoginAttempts($request);
    
        return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 401);
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
        sleep(1);
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
