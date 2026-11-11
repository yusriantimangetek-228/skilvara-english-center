<?php
$pageTitle = 'Home';
$activeNav = 'home';
require_once __DIR__ . '/includes/header.php';

$programs = get_programs();
$stats = db()->query("SELECT stat_value, stat_label FROM site_stats WHERE page = 'home' ORDER BY sort_order")->fetchAll();
?>

<section class="hero">
    <div class="container hero-inner">
        <div class="hero-text">
            <span class="badge">Skilvara English Center</span>
            <h1>Kuasai Bahasa Inggris<br>dengan Skilvara</h1>
            <p>Program belajar intensif dan terukur untuk membantu Anda mencapai target kemampuan berbahasa Inggris secara profesional.</p>
            <div class="btn-row">
                <a class="btn btn-green" href="<?= base_url('pages/program.php') ?>">Lihat Program Kami</a>
                <a class="btn btn-white" href="<?= base_url('pages/contact.php') ?>">Konsultasi Gratis</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="<?= asset('images/hero/hero-team.png') ?>" alt="Tim pengajar Skilvara English Center">
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Program Unggulan</h2>
        <p class="section-sub">Pilih program yang sesuai dengan tingkat kemampuan dan tujuan belajar Anda.</p>

        <div class="grid grid-3">
            <?php foreach ($programs as $p): ?>
                <article class="card feature-card">
                    <span class="dot" aria-hidden="true"></span>
                    <h3><?= e($p['name']) ?></h3>
                    <ul class="bullets">
                        <?php foreach ($p['benefits'] as $b): if (empty($b['highlight_text'])) continue; ?>
                            <li><?= e($b['highlight_text']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endforeach; ?>
        </div>

        <p class="center mt-lg">
            <a class="link-arrow" href="<?= base_url('pages/program.php') ?>">Lihat Detail Program &nbsp;&gt;</a>
        </p>
    </div>
</section>

<section class="section section-cyan">
    <div class="container about-grid">
        <div class="about-image">
            <img src="<?= asset('images/logo/logo-3d.png') ?>" alt="Logo 3D Skilvara English Center">
        </div>
        <div>
            <h2>Tentang Skilvara English Center</h2>
            <p>Kami adalah pusat pelatihan bahasa Inggris yang berdedikasi untuk memberikan kualitas pendidikan terbaik dengan metode belajar yang modern dan interaktif.</p>
            <dl class="stats">
                <?php foreach ($stats as $s): ?>
                    <div>
                        <dt><?= e($s['stat_value']) ?></dt>
                        <dd><?= e($s['stat_label']) ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
            <a class="btn btn-green" href="<?= base_url('pages/profil.php') ?>">Baca Profil Selengkapnya</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
