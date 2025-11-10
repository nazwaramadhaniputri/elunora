<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    public function run()
    {
        $fasilitas = [
            [
                'nama' => 'Perpustakaan Digital',
                'deskripsi' => 'Perpustakaan modern dengan koleksi buku digital dan fisik terlengkap',
                'foto' => 'perpus.jpg',
                'urutan' => 1,
                'status' => true
            ],
            [
                'nama' => 'Laboratorium Komputer',
                'deskripsi' => 'Dilengkapi dengan perangkat komputer terbaru dan koneksi internet cepat',
                'foto' => 'lab_komputer.jpg',
                'urutan' => 2,
                'status' => true
            ],
            [
                'nama' => 'Laboratorium IPA',
                'deskripsi' => 'Lengkap dengan peralatan praktikum sains terstandar',
                'foto' => 'lab_ipa.jpg',
                'urutan' => 3,
                'status' => true
            ],
            [
                'nama' => 'Lapangan Olahraga',
                'deskripsi' => 'Lapangan serbaguna untuk basket, futsal, dan olahraga lainnya',
                'foto' => 'lapangan.jpg',
                'urutan' => 4,
                'status' => true
            ],
            [
                'nama' => 'Ruang Audio Visual',
                'deskripsi' => 'Dilengkapi dengan peralatan multimedia untuk pembelajaran interaktif',
                'foto' => 'ruang_av.jpg',
                'urutan' => 5,
                'status' => true
            ],
            [
                'nama' => 'Kantin Sehat',
                'deskripsi' => 'Menyediakan makanan dan minuman sehat dengan harga terjangkau',
                'foto' => 'kantin.jpg',
                'urutan' => 6,
                'status' => true
            ]
        ];

        foreach ($fasilitas as $item) {
            Fasilitas::updateOrCreate(
                ['nama' => $item['nama']],
                $item
            );
        }
    }
}
