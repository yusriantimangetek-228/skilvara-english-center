<?php
$pageTitle = 'Profil';
$activeNav = 'profil';
require_once __DIR__ . '/../includes/header.php';

$stats = db()->query("SELECT stat_value, stat_label FROM site_stats WHERE page = 'profil' ORDER BY sort_order")->fetchAll();
?>

<section class="hero hero-small">
    <div class="container hero-inner">
        <div class="hero-text">
            <h1>Membangun Jembatan<br>Komunikasi Global</h1>
            <p>Skilvara English Center adalah lembaga pendidikan bahasa Inggris yang berfokus pada pengembangan kompetensi praktis untuk kebutuhan akademik dan profesional.</p>
        </div>
        <div class="hero-image">
            <img src="<?= asset('images/about/profil-host.png') ?>" alt="Perwakilan Skilvara English Center">
        </div>
    </div>
</section>

<section class="section">
    <div class="container grid grid-2">
        <article class="card card-mint">
            <h2 class="card-title">VISI</h2>
            <p class="lead">To become a leading English course center that helps students communicate confidently in real life.</p>
        </article>
        <article class="card card-mint">
            <h2 class="card-title">MISI</h2>
            <ul class="bullets">
                <li>Provide practical and communicative English learning</li>
                <li>Create a fun and supportive learning environment</li>
                <li>Help students improve speaking, grammar, and confidence</li>
                <li>Prepare students for academic and professional needs</li>
            </ul>
        </article>
    </div>
</section>

<section class="section section-cyan">
    <div class="container about-grid">
        <div class="about-image about-image-wide">
            <img src="<?= asset('images/about/perjalanan-ilustrasi.png') ?>" alt="Ilustrasi perjalanan belajar bahasa Inggris di Skilvara">
        </div>
        <div>
            <h2>Perjalanan Skilvara Sejak 2024</h2>
            <p>Skilvara English Center adalah lembaga kursus bahasa Inggris yang berfokus pada pengembangan kemampuan komunikasi siswa secara praktis dan percaya diri. Kami menyediakan program pembelajaran untuk anak-anak, remaja, dan dewasa dengan metode yang interaktif, efektif, dan menyenangkan.</p>
            <p>Skilvara lahir dengan misi sederhana: membuat belajar bahasa Inggris menjadi lebih mudah dan terjangkau tanpa mengorbankan kualitas.</p>
            <dl class="stats stats-2">
                <?php foreach ($stats as $s): ?>
                    <div>
                        <dt><?= e($s['stat_value']) ?></dt>
                        <dd><?= e($s['stat_label']) ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
