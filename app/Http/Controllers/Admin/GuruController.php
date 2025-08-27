<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::orderBy('urutan')->paginate(10);
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'jabatan' => 'required|string|max:255',
            'mata_pelajaran' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        // Create uploads directory if it doesn't exist
        if (!file_exists(public_path('uploads/guru'))) {
            mkdir(public_path('uploads/guru'), 0755, true);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/guru'), $fotoName);
            $fotoPath = 'uploads/guru/' . $fotoName;
        }

        Guru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'mata_pelajaran' => $request->mata_pelajaran,
            'foto' => $fotoPath,
            'urutan' => $request->urutan,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        return view('admin.guru.show', compact('guru'));
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'jabatan' => 'required|string|max:255',
            'mata_pelajaran' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        $guru = Guru::findOrFail($id);
        
        // Create uploads directory if it doesn't exist
        if (!file_exists(public_path('uploads/guru'))) {
            mkdir(public_path('uploads/guru'), 0755, true);
        }
        
        $fotoPath = $guru->foto;
        if ($request->hasFile('foto')) {
            // Delete old image if exists
            if ($guru->foto && file_exists(public_path($guru->foto))) {
                unlink(public_path($guru->foto));
            }
            
            $foto = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/guru'), $fotoName);
            $fotoPath = 'uploads/guru/' . $fotoName;
        }

        $guru->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'mata_pelajaran' => $request->mata_pelajaran,
            'foto' => $fotoPath,
            'urutan' => $request->urutan,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        
        // Delete associated image if exists
        if ($guru->foto && file_exists(public_path($guru->foto))) {
            unlink(public_path($guru->foto));
        }
        
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus');
    }
}
