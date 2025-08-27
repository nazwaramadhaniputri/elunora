<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::orderBy('urutan')->paginate(10);
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('admin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        // Create uploads directory if it doesn't exist
        if (!file_exists(public_path('uploads/fasilitas'))) {
            mkdir(public_path('uploads/fasilitas'), 0755, true);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/fasilitas'), $fotoName);
            $fotoPath = 'uploads/fasilitas/' . $fotoName;
        }

        Fasilitas::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'urutan' => $request->urutan,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan');
    }

    public function show($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        return view('admin.fasilitas.show', compact('fasilitas'));
    }

    public function edit($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        $fasilitas = Fasilitas::findOrFail($id);
        
        // Create uploads directory if it doesn't exist
        if (!file_exists(public_path('uploads/fasilitas'))) {
            mkdir(public_path('uploads/fasilitas'), 0755, true);
        }
        
        $fotoPath = $fasilitas->foto;
        if ($request->hasFile('foto')) {
            // Delete old image if exists
            if ($fasilitas->foto && file_exists(public_path($fasilitas->foto))) {
                unlink(public_path($fasilitas->foto));
            }
            
            $foto = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/fasilitas'), $fotoName);
            $fotoPath = 'uploads/fasilitas/' . $fotoName;
        }

        $fasilitas->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'urutan' => $request->urutan,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        
        // Delete associated image if exists
        if ($fasilitas->foto && file_exists(public_path($fasilitas->foto))) {
            unlink(public_path($fasilitas->foto));
        }
        
        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus');
    }
}
