<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificatioController extends Controller
{
   public function addComment(Request $request) {
        
       //T3MER BASE DE DONNEE

       $notification = new Notification();
      
       $notification->id_etu= $request->get('id_etu');
      
       $notification->user_id= auth()->user()->id;
      
       $notification->text_message= $request->get('notification');

       $notification->save();

       //return redirect()->view('Dashboards.dashboard');
    
       
    }
}
