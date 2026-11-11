<?php
/** Judul + stepper di atas halaman alur pendaftaran. Set $heroTitle, $heroSub, $step. */
?>
<div class="reg-hero">
    <span class="badge">Pendaftaran Siswa Baru</span>
    <h1><?= e($heroTitle ?? 'Pendaftaran') ?></h1>
    <p><?= e($heroSub ?? '') ?></p>
    <?php include __DIR__ . '/steps.php'; ?>
</div>
