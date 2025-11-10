<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run()
    {
        $guru = [
            [
                'nip' => '1965123121988031001',
                'nama' => 'Dr. Budi Santoso, M.Pd',
                'jabatan' => 'Kepala Sekolah',
                'mata_pelajaran' => 'Pendidikan Kewarganegaraan',
                'pendidikan' => 'S2 Pendidikan Kewarganegaraan',
                'foto' => 'guru-1.jpg',
                'urutan' => 1,
                'status' => true
            ],
            [
                'nip' => '197003151997021001',
                'nama' => 'Drs. Agus Setiawan, M.Pd',
                'jabatan' => 'Wakil Kepala Sekolah',
                'mata_pelajaran' => 'Matematika',
                'pendidikan' => 'S2 Pendidikan Matematika',
                'foto' => 'guru-2.jpg',
                'urutan' => 2,
                'status' => true
            ],
            [
                'nip' => '197105102001122001',
                'nama' => 'Siti Rahayu, S.Pd',
                'jabatan' => 'Guru Matematika',
                'mata_pelajaran' => 'Matematika',
                'pendidikan' => 'S1 Pendidikan Matematika',
                'foto' => 'guru-3.jpg',
                'urutan' => 3,
                'status' => true
            ],
            [
                'nip' => '197208152003122002',
                'nama' => 'Dewi Kurniawati, S.Pd',
                'jabatan' => 'Guru Bahasa Indonesia',
                'mata_pelajaran' => 'Bahasa Indonesia',
                'pendidikan' => 'S1 Pendidikan Bahasa Indonesia',
                'foto' => 'guru-4.jpg',
                'urutan' => 4,
                'status' => true
            ],
            [
                'nip' => '197503202006042001',
                'nama' => 'Rina Wijayanti, M.Pd',
                'jabatan' => 'Guru Bahasa Inggris',
                'mata_pelajaran' => 'Bahasa Inggris',
                'pendidikan' => 'S2 Pendidikan Bahasa Inggris',
                'foto' => 'guru-5.jpg',
                'urutan' => 5,
                'status' => true
            ],
            [
                'nip' => '198004102009011001',
                'nama' => 'Ahmad Fauzi, S.Pd',
                'jabatan' => 'Guru IPA',
                'mata_pelajaran' => 'Ilmu Pengetahuan Alam',
                'pendidikan' => 'S1 Pendidikan IPA',
                'foto' => 'guru-6.jpg',
                'urutan' => 6,
                'status' => true
            ]
        ];

        foreach ($guru as $data) {
            Guru::updateOrCreate(
                ['nip' => $data['nip']],
                $data
            );
        }
    }
}
