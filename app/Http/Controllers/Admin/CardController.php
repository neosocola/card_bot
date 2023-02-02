<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Card;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::paginate(20);
        return view('cards.index', compact('cards'));
    }

    public function create()
    {
        return view('cards.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'filename' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable',
        ]);

        $image = $request->file('filename');
        $image_new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('files/images'), $image_new_name);
        //$card->storeAs('public/files/cards', $fileName);
        $card = new Card;
        $card->filename = $image_new_name;
        $card->description = $request->input('description');
        $card->save();

        return redirect()->route('cards.index')->with('success', 'Карта успешно добавлена');
    }

    public function show($id)
    {
        $file = File::find($id);
        return view('files.show', compact('file'));
    }

    public function edit($id)
    {
        $file = File::find($id);
        return view('files.edit', compact('file'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:1024',
        ]);

        $file = File::find($id);

        $newFile = $request->file('file');
        $newFileName = time().'.'.$newFile->extension();

        $newFile->storeAs('public/files', $newFileName);

        $file->file_name = $newFileName;
        $file->save();

        return redirect()->route('files.index')->with('success', 'File updated successfully');
    }

    public function destroy(Request $request, int $id)
    {
        if ($request->ajax())
        {
            $card = Card::find($id);
            $card->delete();
            return response()->json(['success' => 'Карта успешно удалена']);
        }
        else
        {
            $file = File::find($id);
            $file->delete();
            return redirect()->route('files.index')->with('success', 'File deleted successfully');
        }
    }
}
