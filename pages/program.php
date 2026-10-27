<?php
require_once __DIR__ . '/../config/config.php';
$title = 'Program'; $active = 'program';
$programs = db()->query('SELECT * FROM programs ORDER BY id')->fetchAll();
include ROOT . '/includes/header.php';
?>
<section class="hero"><img src="<?= url('assets/images/program.png') ?>" alt="">
  <div><h1>Program Belajar Kami</h1>
  <p>Daftar lengkap program pelatihan bahasa Inggris yang dirancang secara sistematis untuk berbagai tingkat kemahiran.</p></div></section>
<section class="container py-5 center"><h2>Semua Program</h2>
  <div class="row g-4 cards">
  <?php foreach ($programs as $p): ?>
    <div class="card p-3 shadow-sm">
      <img src="<?= url('assets/images/' . $p['slug'] . '.jpg') ?>" alt="<?= e($p['name']) ?>">
      <small><?= rupiah($p['price']) ?>/Month</small>
      <h3><?= e($p['name']) ?> (<?= e($p['level_label']) ?>)</h3>
      <p><?= e($p['short_desc']) ?></p>
      <div class="materi"><b>Materi Utama :</b><ul>
        <?php foreach (explode('|', $p['main_materials']) as $m): ?><li>✓ <?= e($m) ?></li><?php endforeach; ?></ul></div>
      <a class="btn btn-success text-white" href="<?= url('pages/program-detail.php?slug=' . $p['slug']) ?>">Detail Program</a>
    </div>
  <?php endforeach; ?></div></section>
<?php include ROOT . '/includes/footer.php'; ?>
