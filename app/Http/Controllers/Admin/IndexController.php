<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chat;
use App\CardRequest;

class IndexController extends Controller
{
    public function index()
    {
        $CardRequests = CardRequest::latest()->take(5)->get();
        $chats = Chat::latest()->take(5)->get();
        $chats_total = Chat::count();
        return view('index', compact('CardRequests', 'chats', 'chats_total'));
    }
}
