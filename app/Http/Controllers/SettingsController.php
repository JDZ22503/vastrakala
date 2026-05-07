<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Simply process all inputs that come from our form
        $allInputs = $request->except('_token');
        
        foreach ($allInputs as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Settings updated successfully! ');
    }
}
