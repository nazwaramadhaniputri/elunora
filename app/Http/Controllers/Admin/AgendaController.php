<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $agenda = Agenda::orderBy('tanggal', 'desc')
                       ->orderBy('waktu_mulai', 'desc')
                       ->paginate(10);
        
        return view('admin.agenda.index', compact('agenda'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:0,1,draft,published',
            'kategori' => 'nullable|string|max:100',
            'catatan' => 'nullable|string'
        ]);

        Agenda::create($request->all());

        return redirect()->route('admin.agenda.index')
                        ->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function show(Agenda $agenda)
    {
        return view('admin.agenda.show', compact('agenda'));
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:0,1,draft,published',
            'kategori' => 'nullable|string|max:100',
            'catatan' => 'nullable|string'
        ]);

        $agenda->update($request->all());

        return redirect()->route('admin.agenda.index')
                        ->with('success', 'Agenda berhasil diperbarui!');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('admin.agenda.index')
                        ->with('success', 'Agenda berhasil dihapus!');
    }

    public function toggleStatus(Agenda $agenda)
    {
        $agenda->update([
            'status' => $agenda->status === 'published' ? 'draft' : 'published'
        ]);

        return redirect()->back()
                        ->with('success', 'Status agenda berhasil diubah!');
    }
}
