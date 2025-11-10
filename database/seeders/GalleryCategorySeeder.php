<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;

class GalleryCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Kegiatan Sekolah', 'status' => true],
            ['name' => 'Ekstrakurikuler', 'status' => true],
            ['name' => 'Prestasi', 'status' => true],
            ['name' => 'Kegiatan Belajar Mengajar', 'status' => true],
            ['name' => 'Kegiatan Siswa', 'status' => true],
            ['name' => 'Kegiatan Guru', 'status' => true],
            ['name' => 'Kegiatan Orang Tua', 'status' => true],
            ['name' => 'Lainnya', 'status' => true],
        ];

        foreach ($categories as $category) {
            GalleryCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
