<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Kategori;
use App\Models\Petugas;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Create sample categories if they don't exist
        $kategoriPendidikan = Kategori::firstOrCreate(['nama_kategori' => 'Pendidikan']);
        $kategoriKegiatan = Kategori::firstOrCreate(['nama_kategori' => 'Kegiatan Sekolah']);
        $kategoriPrestasi = Kategori::firstOrCreate(['nama_kategori' => 'Prestasi']);

        // Create sample petugas if doesn't exist
        $petugas = Petugas::firstOrCreate([
            'username' => 'admin',
            'email' => 'admin@elunora.com',
            'password' => bcrypt('password')
        ]);

        // Create sample posts with proper content
        $posts = [
            [
                'judul' => 'Kegiatan Pembelajaran Inovatif di Era Digital',
                'isi' => '<p>Sekolah kami terus berinovasi dalam metode pembelajaran untuk menghadapi tantangan era digital. Dengan mengintegrasikan teknologi dalam proses belajar mengajar, siswa-siswi dapat lebih mudah memahami materi pelajaran.</p>

<p>Program pembelajaran digital ini meliputi:</p>
<ul>
<li>Penggunaan tablet dan laptop dalam kelas</li>
<li>Akses ke perpustakaan digital</li>
<li>Platform e-learning interaktif</li>
<li>Video pembelajaran yang menarik</li>
</ul>

<p>Dengan dukungan teknologi ini, diharapkan kualitas pendidikan di sekolah kami semakin meningkat dan siswa lebih siap menghadapi masa depan.</p>',
                'kategori_id' => $kategoriPendidikan->id,
                'petugas_id' => $petugas->id,
                'status' => 'published'
            ],
            [
                'judul' => 'Festival Seni dan Budaya Tahunan 2024',
                'isi' => '<p>Festival Seni dan Budaya tahunan sekolah kami telah berlangsung dengan meriah. Acara ini menampilkan berbagai pertunjukan dari siswa-siswi yang berbakat di bidang seni dan budaya.</p>

<p>Pertunjukan yang ditampilkan antara lain:</p>
<ul>
<li>Tarian tradisional dari berbagai daerah</li>
<li>Pentas musik dan vokal</li>
<li>Pameran karya seni rupa</li>
<li>Drama dan teater</li>
<li>Fashion show dengan tema budaya Indonesia</li>
</ul>

<p>Acara ini tidak hanya menghibur, tetapi juga menjadi ajang untuk melestarikan budaya Indonesia dan mengembangkan bakat siswa di bidang seni.</p>',
                'kategori_id' => $kategoriKegiatan->id,
                'petugas_id' => $petugas->id,
                'status' => 'published'
            ],
            [
                'judul' => 'Prestasi Gemilang Tim Olimpiade Matematika',
                'isi' => '<p>Tim Olimpiade Matematika sekolah kami berhasil meraih prestasi gemilang dalam kompetisi tingkat provinsi. Pencapaian ini merupakan hasil kerja keras siswa dan pembimbing.</p>

<p>Prestasi yang diraih:</p>
<ul>
<li>Juara 1 Olimpiade Matematika Tingkat Provinsi</li>
<li>3 siswa lolos ke tingkat nasional</li>
<li>Penghargaan sekolah terbaik dalam pembinaan olimpiade</li>
</ul>

<p>Keberhasilan ini tidak lepas dari dukungan sekolah dalam menyediakan fasilitas pembelajaran yang memadai dan pembimbing yang kompeten. Kami bangga dengan pencapaian siswa-siswi kami.</p>

<p>Semoga prestasi ini dapat memotivasi siswa lain untuk terus berprestasi di bidang akademik maupun non-akademik.</p>',
                'kategori_id' => $kategoriPrestasi->id,
                'petugas_id' => $petugas->id,
                'status' => 'published'
            ]
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }
    }
}
