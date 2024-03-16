<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthenticationController extends Controller
{
    public function addUserForm()
    {
        return view('auth.register');
    }

    protected function postUser(Request $data)
    {

        $user = User::create([
            'apogee' => random_int(100000,999999),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

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
}
