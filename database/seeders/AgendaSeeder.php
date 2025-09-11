<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agenda;
use Carbon\Carbon;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = [
            [
                'judul' => 'Rapat Koordinasi Guru',
                'deskripsi' => 'Rapat koordinasi bulanan untuk membahas perkembangan akademik siswa dan evaluasi pembelajaran semester ini.',
                'tanggal' => Carbon::today()->addDays(1),
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '10:00',
                'lokasi' => 'Ruang Guru',
                'status' => 'published',
                'kategori' => 'Rapat',
                'catatan' => 'Harap membawa laporan perkembangan siswa masing-masing kelas.'
            ],
            [
                'judul' => 'Ujian Tengah Semester',
                'deskripsi' => 'Pelaksanaan ujian tengah semester untuk seluruh siswa kelas X, XI, dan XII.',
                'tanggal' => Carbon::today()->addDays(7),
                'waktu_mulai' => '07:30',
                'waktu_selesai' => '12:00',
                'lokasi' => 'Ruang Kelas 1-12',
                'status' => 'published',
                'kategori' => 'Ujian',
                'catatan' => 'Siswa wajib membawa alat tulis lengkap dan kartu ujian.'
            ],
            [
                'judul' => 'Workshop Seni Lukis',
                'deskripsi' => 'Workshop seni lukis untuk siswa yang mengikuti ekstrakurikuler seni rupa. Akan dipandu oleh seniman profesional.',
                'tanggal' => Carbon::today()->addDays(3),
                'waktu_mulai' => '14:00',
                'waktu_selesai' => '16:00',
                'lokasi' => 'Studio Seni',
                'status' => 'published',
                'kategori' => 'Ekstrakurikuler',
                'catatan' => 'Peserta dimohon membawa kuas dan cat air sendiri.'
            ],
            [
                'judul' => 'Pameran Karya Siswa',
                'deskripsi' => 'Pameran hasil karya siswa dalam bidang seni rupa, musik, dan tari sebagai apresiasi terhadap kreativitas siswa.',
                'tanggal' => Carbon::today()->addDays(14),
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '15:00',
                'lokasi' => 'Aula Utama',
                'status' => 'published',
                'kategori' => 'Acara Sekolah',
                'catatan' => 'Terbuka untuk umum. Orang tua dan masyarakat diundang untuk hadir.'
            ],
            [
                'judul' => 'Pelatihan Teknologi Digital',
                'deskripsi' => 'Pelatihan penggunaan teknologi digital dalam pembelajaran untuk seluruh guru dan staff.',
                'tanggal' => Carbon::today()->addDays(5),
                'waktu_mulai' => '13:00',
                'waktu_selesai' => '17:00',
                'lokasi' => 'Lab Komputer',
                'status' => 'published',
                'kategori' => 'Akademik',
                'catatan' => 'Wajib diikuti oleh seluruh guru. Sertifikat akan diberikan.'
            ],
            [
                'judul' => 'Lomba Kreativitas Siswa',
                'deskripsi' => 'Lomba kreativitas antar kelas dalam berbagai kategori: musik, tari, drama, dan seni rupa.',
                'tanggal' => Carbon::today()->addDays(21),
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '16:00',
                'lokasi' => 'Aula Utama & Studio',
                'status' => 'draft',
                'kategori' => 'Acara Sekolah',
                'catatan' => 'Pendaftaran dibuka mulai minggu depan.'
            ],
            [
                'judul' => 'Rapat Orang Tua Siswa',
                'deskripsi' => 'Rapat koordinasi dengan orang tua siswa untuk membahas perkembangan akademik dan rencana kegiatan semester depan.',
                'tanggal' => Carbon::today()->addDays(10),
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '11:00',
                'lokasi' => 'Aula Utama',
                'status' => 'published',
                'kategori' => 'Rapat',
                'catatan' => 'Kehadiran orang tua sangat diharapkan.'
            ],
            [
                'judul' => 'Konser Musik Siswa',
                'deskripsi' => 'Konser musik yang menampilkan berbagai penampilan dari siswa-siswa berbakat di bidang musik.',
                'tanggal' => Carbon::today()->addDays(28),
                'waktu_mulai' => '19:00',
                'waktu_selesai' => '21:00',
                'lokasi' => 'Aula Utama',
                'status' => 'published',
                'kategori' => 'Acara Sekolah',
                'catatan' => 'Tiket dapat diperoleh di kantor tata usaha.'
            ]
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }
    }
}
