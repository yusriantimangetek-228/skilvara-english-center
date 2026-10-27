<?php
require_once __DIR__ . '/../config/config.php';
$st = db()->prepare('SELECT * FROM programs WHERE slug = ?');
$st->execute([$_GET['slug'] ?? '']);
$p = $st->fetch();
if (!$p) { http_response_code(404); exit('Program tidak ditemukan'); }
$b = db()->prepare('SELECT * FROM program_benefits WHERE program_id = ?');
$b->execute([$p['id']]);
$title = $p['name']; $active = 'program';
include ROOT . '/includes/header.php';
?>
<main class="container py-5">
  <p class="crumb">Program &gt; <u><?= e($p['name']) ?></u></p>
  <h1><?= e($p['name']) ?></h1>
  <div class="detail">
    <div>
      <img class="rounded" src="<?= url('assets/images/' . $p['slug'] . '.jpg') ?>" alt="">
      <h3>Deskripsi Program:</h3><p><?= e($p['description']) ?></p>
      <h3>Manfaat Belajar</h3>
      <div class="benefits"><?php foreach ($b as $x): ?>
        <div><b><?= e($x['title']) ?></b><br><small><?= e($x['description']) ?></small></div><?php endforeach; ?></div>
    </div>
    <aside class="card p-3 shadow-sm price">
      <small>Harga Program</small>
      <div class="price-big"><?= rupiah($p['price']) ?><span>/Month</span></div>
      <p>Total Sesi : <b><?= (int)$p['total_sessions'] ?> Sesi</b></p>
      <p>Modul Fisik : <b><?= $p['has_module'] ? 'Tersedia' : '-' ?></b></p>
      <p>Try Out : <b><?= (int)$p['tryout_count'] ?>x Tersedia</b></p>
      <a class="btn btn-success text-white" href="<?= url('pages/pendaftaran.php?program=' . $p['id']) ?>">Daftar Sekarang</a>
    </aside>
  </div>
</main>
<?php include ROOT . '/includes/footer.php'; ?>
