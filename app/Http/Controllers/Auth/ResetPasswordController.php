<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /**
     * Show the form for the admin to reset a user's password.
     */
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'stumana';
        // Fetch students and personnel data
        $students = DB::table('t_etudiant')
            ->join('users', 't_etudiant.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 't_etudiant.apogee', 't_etudiant.nom_fr', 't_etudiant.prenom_fr')
            ->get();

        $personnel = DB::table('t_personnel')
            ->join('users', 't_personnel.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.updated_at', 't_personnel.code_personnel')
            ->get();

        return view('auth.passwords.reset', compact('students', 'personnel', 'active_tab'));
    }

    /**
     * Reset the specified user's password.
     */
    public function reset(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
        

        // Validate the request data
        $request->validate([
            'id' => 'required|exists:users,id',
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',  // 'confirmed' ensures password_confirmation is present and matches 'password'
        ]);

        $user = User::find($request->id);

        // Verify that the old password matches the current password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'The provided password does not match your current password.'], 400);
        }

        // Hash and update the new password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password reset successfully.']);
    }
}
