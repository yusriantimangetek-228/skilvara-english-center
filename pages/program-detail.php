<?php
require_once __DIR__ . '/../includes/functions.php';

$program = get_program_by_slug($_GET['slug'] ?? '');
if (!$program) {
    http_response_code(404);
    $pageTitle = 'Program tidak ditemukan';
    $activeNav = 'program';
    require_once __DIR__ . '/../includes/header.php';
    echo '<section class="section"><div class="container center"><h1>Program tidak ditemukan</h1>'
        . '<p><a class="btn btn-green" href="' . base_url('pages/program.php') . '">Kembali ke Program</a></p></div></section>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$pageTitle = $program['name'];
$activeNav = 'program';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="section detail">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= base_url('pages/program.php') ?>">Program</a> &gt; <span><?= e($program['short_name']) ?></span>
        </nav>

        <h1 class="detail-title"><?= e($program['short_name']) ?></h1>

        <div class="detail-grid">
            <div>
                <img class="detail-photo" src="<?= asset('images/programs/' . $program['image']) ?>" alt="<?= e($program['name']) ?>">

                <h2 class="h3">Deskripsi Program:</h2>
                <p class="justify"><?= e($program['description']) ?></p>

                <h2 class="h3 mt-lg">Manfaat Belajar</h2>
                <div class="benefits">
                    <?php foreach ($program['benefits'] as $b): ?>
                        <div>
                            <h4><?= e($b['title']) ?></h4>
                            <p><?= e($b['description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <aside class="card price-card">
                <small>Harga Program</small>
                <p class="price"><?= rupiah($program['price']) ?><span>/Month</span></p>
                <dl class="spec">
                    <dt>Total Sesi :</dt><dd><?= (int) $program['total_sessions'] ?> Sesi</dd>
                    <dt>Modul Fisik :</dt><dd><?= $program['has_module'] ? 'Tersedia' : 'Tidak tersedia' ?></dd>
                    <dt>Try Out :</dt><dd><?= $program['tryout_count'] > 0 ? (int) $program['tryout_count'] . 'x Tersedia' : 'Tidak tersedia' ?></dd>
                </dl>
                <a class="btn btn-green btn-block" href="<?= base_url('pages/daftar.php?program=' . urlencode($program['slug'])) ?>">Daftar Sekarang</a>
            </aside>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
