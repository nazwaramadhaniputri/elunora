<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::latest()->paginate(10);
        return view('admin.gallery-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.gallery-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:gallery_categories,name',
                'description' => 'nullable|string',
                'status' => 'required|in:0,1',
            ], [
                'name.required' => 'Nama kategori harus diisi',
                'name.unique' => 'Nama kategori sudah digunakan',
                'status.required' => 'Status harus dipilih',
            ]);

            $category = GalleryCategory::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'] ?? null,
                'status' => (bool)$validated['status']
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori galeri berhasil ditambahkan',
                    'data' => $category
                ], 201);
            }

            return redirect()->route('admin.gallery-categories.index')
                ->with('success', 'Kategori galeri berhasil ditambahkan');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => 'Validasi gagal'
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Error creating gallery category: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()->with('error', 'Gagal menambahkan kategori. Silakan coba lagi.');
        }
    }

    public function edit(GalleryCategory $galleryCategory)
    {
        return view('admin.gallery-categories.edit', compact('galleryCategory'));
    }

    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $galleryCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'Kategori galeri berhasil diperbarui');
    }

    /**
     * Get categories as JSON for AJAX requests
     */
    public function getCategoriesJson(Request $request)
    {
        try {
            $categories = GalleryCategory::where('status', true)
                ->orderBy('name')
                ->get(['id', 'name']);
                
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching categories: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kategori. Silakan coba lagi.'
            ], 500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryCategory $galleryCategory)
    {
        try {
            // Check if category is being used by any galleries
            if ($galleryCategory->galleries()->exists()) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak dapat menghapus kategori karena masih digunakan oleh beberapa galeri.'
                    ], 422);
                }
                return back()->with('error', 'Tidak dapat menghapus kategori karena masih digunakan oleh beberapa galeri.');
            }
            
            $galleryCategory->delete();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil dihapus.'
                ]);
            }
            
            return redirect()->route('admin.gallery-categories.index')
                ->with('success', 'Kategori berhasil dihapus');
                
        } catch (\Exception $e) {
            \Log::error('Error deleting category: ' . $e->getMessage());
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus kategori. Silakan coba lagi.'
                ], 500);
            }
            
            return back()->with('error', 'Gagal menghapus kategori. Silakan coba lagi.');
        }

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'Kategori galeri berhasil dihapus');
    }
}