<?php
require_once __DIR__ . '/../config/config.php';
$title = 'Pembayaran Berhasil'; $hideCta = true;
include ROOT . '/includes/header.php';
?>
<section class="hero center" style="min-height:400px"><div><h1>Pembayaran Berhasil</h1>
  <p>Terima kasih! Pembayaran Anda telah berhasil diproses. Kami akan segera menghubungi Anda untuk informasi selanjutnya.</p>
  <a class="btn btn-success text-white" href="<?= url('index.php') ?>">Back Home</a></div></section>
<?php include ROOT . '/includes/footer.php'; ?>
