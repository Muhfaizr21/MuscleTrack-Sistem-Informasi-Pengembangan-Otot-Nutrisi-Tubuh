<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Tampilkan 100% "List Pesan"
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.contact.index', compact('messages'));
    }

    /**
     * Tampilkan 100% "Detail Pesan" (dan 100% tandai "dibaca")
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);

        // "Jurus Ciamik": 100% Tandai "dibaca" saat dibuka
        if (!$message->read_status) {
            $message->update(['read_status' => true]);
        }

        return view('admin.contact.show', compact('message'));
    }

    /**
     * 100% Hapus Pesan
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Pesan telah dihapus.');
    }
}
