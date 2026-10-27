<?php
require_once __DIR__ . '/config/config.php';
$title = 'Home'; $active = 'home';
$programs = db()->query('SELECT * FROM programs ORDER BY id')->fetchAll();
include ROOT . '/includes/header.php';
?>
<section class="hero">
  <div>
    <span class="badge-skil">Skilvara English Center</span>
    <h1>Kuasai Bahasa Inggris dengan Skilvara</h1>
    <p>Program belajar intensif dan terukur untuk membantu Anda mencapai target kemampuan berbahasa Inggris secara profesional.</p>
    <a href="<?= url('pages/program.php') ?>" class="btn btn-success text-white">Lihat Program Kami</a>
    <a href="<?= url('pages/contact.php') ?>" class="btn btn-light border">Konsultasi Gratis</a>
  </div>
  <img src="<?= url('assets/images/hero.png') ?>" alt="Siswa Skilvara">
</section>
<section class="container py-5 center">
  <h2>Program Unggulan</h2>
  <p>Pilih program yang sesuai dengan tingkat kemampuan dan tujuan belajar Anda.</p>
  <div class="row g-4 cards">
    <?php foreach ($programs as $p): ?>
      <div class="card p-3 shadow-sm"><h3><?= e($p['name']) ?> (<?= e($p['level_label']) ?>)</h3>
        <ul><?php foreach (explode('|', $p['main_materials']) as $m): ?><li><?= e($m) ?></li><?php endforeach; ?></ul></div>
    <?php endforeach; ?>
  </div>
  <a href="<?= url('pages/program.php') ?>">Lihat Detail Program &gt;</a>
</section>
<section class="container py-5 about">
  <img src="<?= url('assets/images/logo-large.png') ?>" alt="Skilvara">
  <div>
    <h2>Tentang Skilvara English Center</h2>
    <p>Kami adalah pusat pelatihan bahasa Inggris yang berdedikasi untuk memberikan kualitas pendidikan terbaik dengan metode belajar yang modern dan interaktif.</p>
    <div class="stats"><div><b>3+</b>Tahun Pengalaman</div><div><b>100+</b>Alumni Berhasil</div>
      <div><b>2+</b>Instruktur Profesional</div><div><b>10+</b>Partner Institusi</div></div>
    <a href="<?= url('pages/profil.php') ?>" class="btn btn-success text-white">Baca Profil Selengkapnya</a>
  </div>
</section>
<?php include ROOT . '/includes/footer.php'; ?>
