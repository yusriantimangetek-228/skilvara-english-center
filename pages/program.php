<?php
$pageTitle = 'Program';
$activeNav = 'program';
require_once __DIR__ . '/../includes/header.php';

$programs = get_programs();
?>

<section class="hero hero-small hero-left-image">
    <div class="container hero-inner">
        <div class="hero-image">
            <img src="<?= asset('images/hero/hero-team.png') ?>" alt="Tim Skilvara English Center">
        </div>
        <div class="hero-text">
            <h1>Program Belajar Kami</h1>
            <p>Daftar lengkap program pelatihan bahasa Inggris yang dirancang secara sistematis untuk berbagai tingkat kemahiran.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Semua Program</h2>

        <div class="grid grid-3">
            <?php foreach ($programs as $p): ?>
                <article class="card program-card">
                    <img class="program-photo" src="<?= asset('images/programs/' . $p['image']) ?>" alt="<?= e($p['name']) ?>">
                    <div class="program-body">
                        <p class="price-tag"><?= rupiah($p['price']) ?>/Month</p>
                        <h3><?= e($p['name']) ?></h3>
                        <p class="muted justify"><?= e($p['short_description']) ?></p>
                        <div class="materi">
                            <strong>Materi Utama :</strong>
                            <ul class="checks">
                                <?php foreach ($p['benefits'] as $b): if (empty($b['highlight_text'])) continue; ?>
                                    <li><?= e($b['highlight_text']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <a class="btn btn-green btn-block" href="<?= base_url('pages/program-detail.php?slug=' . urlencode($p['slug'])) ?>">Detail Program</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
