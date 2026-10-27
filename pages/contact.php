<?php
require_once __DIR__ . '/../config/config.php';
$title = 'Contact'; $active = 'contact';
include ROOT . '/includes/header.php';
?>
<section class="hero center"><div><h1>Hubungi Kami</h1>
  <p>Punya pertanyaan mengenai program kami atau butuh konsultasi pendidikan? Tim kami siap membantu Anda.</p></div></section>
<section class="container py-5 about">
  <div><h2>Semua Program</h2>
    <p>Ruko Cluster Permata, Jl. Kelapa, Lagaligo, Kec. Wara, Kota Palopo</p>
    <p>+62 822-7297-9021</p><p>@skilvaraenglishcenter.com</p>
    <h2>Ikuti Kami</h2><p>TikTok · Instagram · Facebook</p></div>
  <div><!-- Ganti src dengan embed Google Maps lokasi Skilvara -->
    <iframe src="https://www.google.com/maps?q=Palopo&output=embed" width="100%" height="300" style="border:0;border-radius:16px" loading="lazy"></iframe></div>
</section>
<section class="hero center"><div><h2>Punya Pertanyaan ?</h2>
  <p>Mungkin jawaban yang Anda cari sudah ada di halaman tanya-jawab kami.</p>
  <a href="<?= url('pages/faq.php') ?>">Buka Halaman FAQ &gt;</a></div></section>
<?php include ROOT . '/includes/footer.php'; ?>
