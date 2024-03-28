<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

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
    }
}
