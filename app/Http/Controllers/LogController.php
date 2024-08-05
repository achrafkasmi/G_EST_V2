<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'checkstage';
        $logs = Log::with('user')->latest()->get(); // Retrieve logs in descending order
        return view('logs', compact('logs', 'active_tab'));
    }
}
