<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelpSupportController extends Controller
{
    public function index()
    {
        return view('admin.help-support.index');
    }

    public function sendSupportRequest(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high',
        ]);

        // TODO: Implement email sending or ticket system
        // For now, just return success message

        return back()->with('success', 'Permintaan bantuan telah dikirim. Tim support akan menghubungi Anda segera.');
    }
}
