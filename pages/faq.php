<?php
$pageTitle = 'FAQ';
$activeNav = 'contact';
require_once __DIR__ . '/../includes/header.php';

$categories = db()->query('SELECT id, name, slug FROM faq_categories ORDER BY sort_order, id')->fetchAll();
$faqs = db()->query('SELECT f.question, f.answer, c.slug AS cat FROM faqs f JOIN faq_categories c ON c.id = f.category_id WHERE f.is_active = 1 ORDER BY f.sort_order, f.id')->fetchAll();
$wa = preg_replace('/\D+/', '', get_setting('whatsapp', '6282272979021'));
?>

<section class="hero hero-small hero-center">
    <div class="container">
        <h1>Pertanyaan Populer (FAQ)</h1>
        <p>Temukan jawaban cepat untuk pertanyaan yang sering ditanyakan mengenai program, pendaftaran, dan fasilitas kami.</p>
    </div>
</section>

<section class="section">
    <div class="container faq-wrap">
        <div class="tabs" role="tablist" data-faq-tabs>
            <?php foreach ($categories as $i => $c): ?>
                <button type="button" role="tab" class="tab <?= $i === 0 ? 'active' : '' ?>" data-cat="<?= e($c['slug']) ?>"><?= e($c['name']) ?></button>
            <?php endforeach; ?>
        </div>

        <div class="faq-list" data-faq-list>
            <?php foreach ($faqs as $f): ?>
                <details class="faq-item" data-cat="<?= e($f['cat']) ?>">
                    <summary><?= e($f['question']) ?></summary>
                    <p><?= e($f['answer']) ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-dark">
    <div class="container center">
        <h2>Punya Pertanyaan ?</h2>
        <p>Jika Anda tidak menemukan jawaban yang Anda cari, jangan ragu untuk menghubungi tim bantuan kami secara langsung</p>
        <div class="btn-row center-row">
            <a class="btn btn-grey" href="<?= base_url('pages/contact.php') ?>">Hubungi CS</a>
            <a class="btn btn-green" href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener">Chat WhatsApp</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
