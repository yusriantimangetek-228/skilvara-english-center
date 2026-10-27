<?php
require_once __DIR__ . '/../config/config.php';
$title = 'FAQ'; $active = 'contact';
$cats = db()->query('SELECT * FROM faq_categories ORDER BY id')->fetchAll();
$faqs = db()->query('SELECT * FROM faqs ORDER BY id')->fetchAll();
include ROOT . '/includes/header.php';
?>
<section class="hero center"><div><h1>Pertanyaan Populer (FAQ)</h1>
  <p>Temukan jawaban cepat untuk pertanyaan yang sering ditanyakan mengenai program, pendaftaran, dan fasilitas kami.</p></div></section>
<section class="container py-5">
  <div class="tabs"><?php foreach ($cats as $i => $c): ?>
    <button class="tab <?= $i===0?'on':'' ?>" data-cat="<?= $c['id'] ?>"><?= e($c['name']) ?></button><?php endforeach; ?></div>
  <?php foreach ($faqs as $f): ?>
    <div class="faq" data-cat="<?= $f['category_id'] ?>">
      <button class="faq-q"><?= e($f['question']) ?></button>
      <div class="faq-a"><?= e($f['answer']) ?></div>
    </div>
  <?php endforeach; ?>
</section>
<section class="cta-dark center"><h2>Punya Pertanyaan ?</h2>
  <p>Jika Anda tidak menemukan jawaban yang Anda cari, jangan ragu untuk menghubungi tim bantuan kami secara langsung</p>
  <a class="btn btn-light border" href="<?= url('pages/contact.php') ?>">Hubungi CS</a>
  <a class="btn btn-success text-white" href="https://wa.me/6282272979021">Chat WhatsApp</a></section>
<?php include ROOT . '/includes/footer.php'; ?>
