<?php
require_once __DIR__ . '/../config/config.php';
$title = 'Profil'; $active = 'profil';
include ROOT . '/includes/header.php';
?>
<section class="hero"><div><h1>Membangun Jembatan Komunikasi Global</h1>
  <p>Skilvara English Center adalah lembaga pendidikan bahasa Inggris yang berfokus pada pengembangan kompetensi praktis untuk kebutuhan akademik dan profesional.</p></div>
  <img src="<?= url('assets/images/profil.png') ?>" alt=""></section>
<section class="container py-5 cards two">
  <div class="card p-3 shadow-sm green"><h2>VISI</h2><p>To become a leading English course center that helps students communicate confidently in real life.</p></div>
  <div class="card p-3 shadow-sm green"><h2>MISI</h2><ul>
    <li>Provide practical and communicative English learning</li>
    <li>Create a fun and supportive learning environment</li>
    <li>Help students improve speaking, grammar, and confidence</li>
    <li>Prepare students for academic and professional needs</li></ul></div>
</section>
<section class="container py-5 about">
  <img src="<?= url('assets/images/journey.png') ?>" alt="">
  <div><h2>Perjalanan Skilvara Sejak 2024</h2>
    <p>Skilvara English Center adalah lembaga kursus bahasa Inggris yang berfokus pada pengembangan kemampuan komunikasi siswa secara praktis dan percaya diri. Kami menyediakan program pembelajaran untuk anak-anak, remaja, dan dewasa dengan metode yang interaktif, efektif, dan menyenangkan.</p>
    <p>Skilvara lahir dengan misi sederhana: membuat belajar bahasa Inggris menjadi lebih mudah dan terjangkau tanpa mengorbankan kualitas.</p>
    <div class="stats"><div><b>200+</b>Siswa Terdaftar</div><div><b>98%</b>Kepuasan Alumni</div></div></div>
</section>
<?php include ROOT . '/includes/footer.php'; ?>
