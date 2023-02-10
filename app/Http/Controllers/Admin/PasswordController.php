<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{

    public function edit(): View
    {
        return view('password');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ( ! (Hash::check($request->input('current_password'), $user->password)) ) {
            return redirect()->back()->with('error', 'current-password-invalid');
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ( $validated['current_password'] == $validated['password'] ) {
            return redirect()->back()->with('error', 'no-new-password');
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
