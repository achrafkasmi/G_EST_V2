<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\User;
use App\Models\Stage;
use App\Models\Retrait;
use App\Models\Laureat;
use App\Models\Attendance;
use App\Models\EtudiantEtape;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function uploadProfilePicture(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,HEIC,heic|max:10000'
            ]);

            $user = auth()->user();

            $etudiant = Etudiant::where('user_id', $user->id)->first();
            $currentYear = date('Y');

            if ($user->image) {
                Storage::delete($user->image);
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            if ($etudiant) {
                $filename = $etudiant->apogee . '.' . $extension;
                $directory = 'public/avatars/' . $currentYear;
            } else {
                $filename = str_replace(' ', '', $user->name) . '.' . $extension;
                $directory = 'public/avatars/personnel/' . $currentYear;
            }

            $imagePath = $request->file('image')->storeAs($directory, $filename);

            $user->image = $imagePath;
            $user->save();

            return redirect()->back()->with('success', 'Image uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to set the avatar: ' . $e->getMessage());
        }
    }

    public function usercard($id_etu)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'card';
    
        $etudiant = Etudiant::find($id_etu);
        $user = User::find($etudiant->user_id);
        $stages = Stage::where('id_etu', $etudiant->id)->get();
        $retrait = Retrait::where('id_etu', $etudiant->id)
            ->latest('created_at')
            ->get();
            
        $latest_retrait = $retrait->first();
        $laureat = Laureat::where('id_etu', $etudiant->id)->first();
        $attendance = Attendance::where('id_etu', $etudiant->id)->first();
        $etudiantEtape = EtudiantEtape::where('id_etu', $etudiant->id)->first();
    
        // Aggregate stage upload statuses
        $is_uploaded_initiation = $stages->contains('is_uploaded_initiation', 1);
        $is_uploaded_technique = $stages->contains('is_uploaded_technique', 1);
        $is_uploaded_pfe = $stages->contains('is_uploaded_pfe', 1);
        $is_uploaded_professionelle = $stages->contains('is_uploaded_professionelle', 1);
    
        return view('usercard', compact(
            'etudiant', 'user', 'stages', 'retrait', 'latest_retrait', 
            'laureat', 'attendance', 'etudiantEtape', 'active_tab',
            'is_uploaded_initiation', 'is_uploaded_technique', 
            'is_uploaded_pfe', 'is_uploaded_professionelle'
        ));
    }
    
}
