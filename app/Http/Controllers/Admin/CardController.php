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

        $validated = $request->validate([
            'filename' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable',
            'page' => 'nullable|numeric',
        ]);

        $image = $request->file('filename');
        $image_new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('files/images'), $image_new_name);
        //$card->storeAs('public/files/cards', $fileName);
        $card = new Card;
        $card->filename = $image_new_name;
        $card->description = $validated['description'];
        $card->save();

        return redirect()->route('cards.index', [ 'page' => $validated['page'] ])->with('success', 'Карта успешно добавлена');
    }

    public function edit($id)
    {
        $card = Card::find($id);
        return view('cards.edit', compact('card'));
    }

    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'description' => 'nullable',
            'page' => 'nullable|numeric',
        ]);
        $card->fill($validated);
        $card->save();
        return redirect()->route('cards.index', [ 'page' => $validated['page'] ]);
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
            $card = Card::find($id);
            $card->delete();
            return redirect()->route('cards.index');
        }
    }
}
