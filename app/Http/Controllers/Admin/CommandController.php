<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Command;

class CommandController extends Controller
{
    public function index()
    {
        $commands = Command::paginate(20);
        return view('commands.index', compact('commands'));
    }

    public function create()
    {
        $command = new Command();
        $edit = 0;
        return view('commands.edit', compact('command', 'edit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'command' => 'required|string|min:1|max:50|unique:commands',
            'output' => 'required',
            'active' => 'nullable',
            'page' => 'nullable|numeric'
        ]);
        $command = new Command();
        $command->fill($validated);
        $command->active = $request->input('active') === 'on' ? 1 : 0;
        $command->save();

        return redirect()->route('commands.index', [ 'page' => $validated['page'] ])->with('success', 'Команда успешно добавлена');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $command = Command::find($id);
        $edit = 1;
        return view('commands.edit', compact('command', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Command $command)
    {
        $validated = $request->validate([
            'command' => 'required|string|min:1|max:50|unique:commands,command,' . $command->id,
            'output' => 'required',
            'active' => 'nullable',
            'page' => 'nullable|numeric'
        ]);
        $command->fill($validated);
        $command->active = $request->input('active') === 'on' ? 1 : 0;
        $command->save();

        return redirect()->route('commands.index', [ 'page' => $validated['page'] ]);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax())
        {
            $command = Command::find($id);
            $command->delete();
            return response()->json(['success' => 'Команда успешно удалена']);
        }
    }
}
