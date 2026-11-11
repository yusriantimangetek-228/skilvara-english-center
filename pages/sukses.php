<?php
require_once __DIR__ . '/../includes/functions.php';

$code = $_SESSION['last_code'] ?? '';

$pageTitle = 'Pembayaran Berhasil';
$activeNav = '';
$hideCta   = true;
require_once __DIR__ . '/../includes/header.php';
?>

<section class="success-band">
    <div class="container center">
        <div class="check-circle" aria-hidden="true">&#10003;</div>
        <h1>Pembayaran Berhasil</h1>
        <p>Terima kasih! Pembayaran Anda telah berhasil diproses. Kami akan segera menghubungi Anda untuk informasi selanjutnya.</p>
        <?php if ($code): ?>
            <p class="reg-code">Kode pendaftaran Anda: <strong><?= e($code) ?></strong></p>
        <?php endif; ?>
        <a class="btn btn-green-strong" href="<?= base_url('index.php') ?>">Back Home</a>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
