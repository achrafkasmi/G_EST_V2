<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function uploadProfilePicture(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,HEIC,heic|max:10000'
            ]);

            $user = auth()->user();

            if ($user->image) {
                Storage::delete($user->image);
            }
            
            $imagePath = $request->file('image')->store('public/avatars');
            $user->image = $imagePath;
            $user->save();

            return redirect()->back()->with('success', ' image uploaded successfully!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'unable to set the avatar');
        }
    }
}
