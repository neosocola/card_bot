<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Log;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::with('chat')->latest()->paginate(20);
        return view('logs.index', compact('logs'));
    }

}
