<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contact.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Mark as read if not already
        if ($contact->status == 0) {
            $contact->update(['status' => 1]);
        }
        
        return view('admin.contact.show', compact('contact'));
    }

    public function markAsRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 1]);
        
        return redirect()->route('admin.contact.index')->with('success', 'Pesan berhasil ditandai sebagai sudah dibaca');
    }

    public function markAsUnread($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 0]);
        
        return redirect()->route('admin.contact.index')->with('success', 'Pesan berhasil ditandai sebagai belum dibaca');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Pesan berhasil dihapus');
    }
}
