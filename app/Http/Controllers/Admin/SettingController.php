<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Setting;

class SettingController extends Controller
{

    public function edit(): View
    {
        $settings = Setting::first();
        return view('settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'start' => 'required|string',
            'fallback' => 'required|string',
        ]);

        $settings = Setting::first();
        $settings->fill($validated);
        $settings->update();

        return back()->with('status', 'updated');
    }
}
