<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(){

        return view('Dashboards.dashboard');
    }

    public function dashteacher(){
        $users=User::where('is_uploaded',true)->get();
        return view('Dashboards.dashteacher')->with(['users'=>$users]);
    }   

    public function myIntern() : View {

        if(!auth()->user()->hasRole('student')) {
          
            abort(403);
        }

        return view('messtages');
    }
 }
