<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    /**
     * Aksi 1 (Baru): Menampilkan halaman form kontak.
     */
    public function index()
    {
        // Cukup kembalikan view 'contact.index'
        // Kita akan buat file ini di Aksi 3
        return view('contact.index');
    }

    /**
     * Aksi 2 (Lama): Menyimpan pesan kontak baru dari form.
     */
    public function store(Request $request)
    {
        // 1. Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // 2. Simpan ke database
        ContactMessage::create($validated);

        // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Pesan Anda telah terkirim! Terima kasih.');
    }
}
