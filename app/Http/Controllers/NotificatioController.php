<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class NotificatioController extends Controller
{
    /*public function addComment(Request $request) {
        
       //T3MER BASE DE DONNEE

       $notification = new Notification();
      
       $notification->id_etu= $request->get('id_etu');
      
       $notification->user_id= auth()->user()->id;
      
       $notification->text_message= $request->get('notification');

       $notification->save();

       //return redirect()->view('Dashboards.dashboard');
    
       
    }*/
    //FHAD L CODE ZEDT L ABILITY TO MODIFY TEXT NOTIFICATION 
    /*public function addComment(Request $request)
    {
        // Retrieve the authenticated user's ID
        $userId = auth()->user()->id;

        // Retrieve the id_etu from the request
        $idEtu = $request->get('id_etu');

        // Retrieve the notification text from the request
        $textMessage = $request->get('notification');

        // Check if a notification already exists for the given user and id_etu
        $notification = Notification::where('user_id', $userId)
            ->where('id_etu', $idEtu)
            ->first();

        if ($notification) {
            // If the notification exists, update its text_message
            $notification->text_message = $textMessage;
            $notification->save();
        } else {
            // If the notification doesn't exist, create a new one
            $notification = new Notification();
            $notification->user_id = $userId;
            $notification->id_etu = $idEtu;
            $notification->text_message = $textMessage;
            $notification->save();
        }

        // Optionally, you can return a response or redirect the user
    }*/

    /* tahadi it works walakin not totally 
    public function addComment(Request $request)
    {
        // Retrieve the authenticated user's ID
        $userId = auth()->user()->id;
    
        // Retrieve the id_etu from the request
        $idEtu = $request->get('id_etu');
    
        // Retrieve the notification text from the request
        $textMessage = $request->get('notification');
    
        // Check if a notification already exists for the given user and id_etu
        $notification = Notification::where('user_id', $userId)
            ->where('id_etu', $idEtu)
            ->first();
    
        try {
            if ($notification) {
                // If the notification exists, update its text_message
                $notification->text_message = $textMessage;
    
                // Handle voice message upload
                if ($request->hasFile('voice_message')) {
                    $file = $request->file('voice_message');
                    $fileName = $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName);
                    $notification->voice_message_url = $fileName;
                }
    
                $notification->save();
            } else {
                // If the notification doesn't exist, create a new one
                $notification = new Notification();
                $notification->user_id = $userId;
                $notification->id_etu = $idEtu;
                $notification->text_message = $textMessage;
    
                if ($request->hasFile('voice_message')) {
                    $file = $request->file('voice_message');
                    $fileName = $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName);
                    $notification->voice_message_url = $fileName; // Store file path in database
                }
                
                $notification->save();
            }
    
            // Return success response
            return response()->json(['success' => true, 'message' => 'Comment added successfully']);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['success' => false, 'message' => 'Error occurred while adding comment. Please try again.']);
        }
    }*/
    public function addComment(Request $request)
{
    $userId = auth()->user()->id;

    $idEtu = $request->get('id_etu');

    // Validate the request data
    $request->validate([
        'notification' => 'required_without:voice_message|string',
    ]);

   

    $textMessage = $request->get('notification');

    $notification = new Notification();
    $notification->user_id = $userId;
    $notification->id_etu = $idEtu;

    $notification->text_message = $textMessage;

    if ($request->hasFile('voice_message')) {
        $file = $request->file('voice_message');

        $fileName = 'audio_' . time() . '.wav';

        $path = $file->storeAs('public/audios', $fileName);

        $audioUrl = env('APP_URL') . Storage::url($path);

        $notification->voice_message_url = $audioUrl;
    }

    $notification->save();

    return redirect()->back()->with('success', 'Notification added successfully.');
}

    
    public function markAsSeen(Notification $notification)
{
    $notification->update(['is_seen' => true]);

    return redirect()->back();
}

}
