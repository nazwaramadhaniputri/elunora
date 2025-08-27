<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfilController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        return view('admin.profil.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.profil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'deskripsi' => 'required|string',
        ]);

        Profile::create([
            'nama_sekolah' => $request->nama_sekolah,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.profil.index')->with('success', 'Profil sekolah berhasil ditambahkan');
    }

    public function show($id)
    {
        $profile = Profile::findOrFail($id);
        return view('admin.profil.show', compact('profile'));
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return view('admin.profil.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = Profile::findOrFail($id);
        
        // Create uploads directory if it doesn't exist
        if (!file_exists(public_path('uploads/profil'))) {
            mkdir(public_path('uploads/profil'), 0755, true);
        }
        
        $fotoPath = $profile->foto;
        if ($request->hasFile('foto')) {
            // Delete old image if exists
            if ($profile->foto && file_exists(public_path($profile->foto))) {
                unlink(public_path($profile->foto));
            }
            
            $foto = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/profil'), $fotoName);
            $fotoPath = 'uploads/profil/' . $fotoName;
        }

        $profile->update([
            'nama_sekolah' => $request->nama_sekolah,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.profil.index')->with('success', 'Profil sekolah berhasil diperbarui');
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect()->route('admin.profil.index')->with('success', 'Profil sekolah berhasil dihapus');
    }
}
