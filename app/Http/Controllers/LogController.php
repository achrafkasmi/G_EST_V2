<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use DataTables;

class LogController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'checkstage';
        return view('logs', compact('active_tab'));
    }

    public function getData()
    {
        $logs = Log::with('user')->latest();

        return DataTables::of($logs)
            ->addColumn('user_name', function ($log) {
                return $log->user->name;
            })
            ->addColumn('model', function ($log) {
                return class_basename($log->model);
            })
            ->editColumn('created_at', function ($log) {
                return $log->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('formatted_details', function ($log) {
                \Log::info('Log details: ' . $log->formatted_details);
                return $log->formatted_details ?? 'No details available';
            })
            ->toJson();
    }
}