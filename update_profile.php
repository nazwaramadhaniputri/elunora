<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update profile description
$profile = App\Models\Profile::first();
if ($profile) {
    $profile->deskripsi = 'Elunora School merupakan lembaga pendidikan yang berlandaskan pada filosofi Art of School, yakni perpaduan antara ilmu pengetahuan, seni, dan pembentukan karakter. Dengan komitmen mencetak generasi unggul, Elunora School menghadirkan suasana belajar yang tidak hanya berfokus pada aspek akademik, tetapi juga pada pengembangan kreativitas, kepribadian, dan nilai-nilai kemanusiaan.

Didukung oleh tenaga pendidik profesional serta lingkungan yang inspiratif, Elunora School menjadi wadah bagi siswa untuk menemukan dan mengasah potensi terbaiknya. Melalui program pembelajaran yang inovatif, kegiatan seni dan budaya, serta pendidikan karakter yang kuat, Elunora School bertekad melahirkan generasi yang berwawasan luas, berjiwa kreatif, dan siap menghadapi tantangan global.';
    $profile->save();
    echo "Profile description updated successfully!\n";
} else {
    echo "No profile found in database.\n";
}
?>
