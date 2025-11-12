<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.settings.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'theme' => 'nullable|in:light,dark,system',
            'language' => 'nullable|in:id,en',
            'notifications_email' => 'boolean',
            'notifications_system' => 'boolean',
            'timezone' => 'nullable|timezone',
        ]);

        // Update settings (simpan sebagai JSON di database)
        $settings = $user->settings ?? [];
        $settings = array_merge($settings, [
            'theme' => $request->theme,
            'language' => $request->language,
            'notifications' => [
                'email' => $request->boolean('notifications_email'),
                'system' => $request->boolean('notifications_system'),
            ],
            'timezone' => $request->timezone,
        ]);

        $user->settings = $settings;
        $user->save();

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Pengaturan berhasil diperbarui');
    }
}
