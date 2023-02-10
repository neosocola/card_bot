<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CardRequest;

class CardRequestController extends Controller
{
    public function index()
    {
        $CardRequests = CardRequest::latest()->paginate(20);
        return view('cardrequests.index', compact('CardRequests'));
    }

}
