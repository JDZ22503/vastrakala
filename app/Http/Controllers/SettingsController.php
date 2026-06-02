<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $allInputs = $request->except('_token');

        $data = [];

        foreach ($allInputs as $key => $value) {
            $data[] = [
                'key' => $key,
                'value' => $value,
            ];
        }

        Setting::upsert(
            $data,
            ['key'],      // Unique column
            ['value']     // Columns to update
        );

        return back()->with('success', 'Settings updated successfully!');
    }
}
