<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Chat;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::paginate(20);
        return view('chats.index', compact('chats'));
    }

    public function destroy(Request $request, int $id)
    {
        if ($request->ajax())
        {
            $chat = Chat::find($id);
            $chat->delete();
            return response()->json(['success' => 'Пользователь успешно удалён']);
        }
    }
}
