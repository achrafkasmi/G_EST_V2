<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        return view('Dashboards.dashboard');
    }

    public function dashteacher(){
        $users=User::where('is_uploaded',true)->get();
        return view('Dashboards.dashteacher')->with(['users'=>$users]);
    }   
 }
