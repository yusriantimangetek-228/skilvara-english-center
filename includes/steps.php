<?php
/** Indikator langkah pendaftaran. Set $step = 1 | 2 | 3 sebelum include. */
$step = $step ?? 1;
$labels = [1 => 'Data Diri', 2 => 'Konfirmasi', 3 => 'Pembayaran'];
?>
<ol class="stepper" aria-label="Langkah pendaftaran">
    <?php foreach ($labels as $n => $label): ?>
        <li class="<?= $n < $step ? 'done' : '' ?> <?= $n === $step ? 'current' : '' ?>">
            <span class="n"><?= $n < $step ? '&#10003;' : $n ?></span>
            <span class="t"><?= e($label) ?></span>
        </li>
    <?php endforeach; ?>
</ol>
