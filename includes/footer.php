<?php
/**
 * Footer (dipakai semua halaman).
 */
require_once __DIR__ . '/functions.php';

$footerPrograms = db()->query('SELECT name, slug FROM programs WHERE is_active = 1 ORDER BY sort_order, id')->fetchAll();
$address = get_setting('address', 'Ruko Cluster Permata, Jl. Kelapa, Lagaligo, Kec. Wara, Kota Palopo');
$phone   = get_setting('phone', '+62 822-7297-9021');
$email   = get_setting('email', '@skilvaraenglishcenter.com');
?>
</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <a class="brand" href="<?= base_url('index.php') ?>">
                <img src="<?= asset('images/logo/logo-skilvara.png') ?>" alt="Skilvara - Upgrade Skill, Upgrade Life">
            </a>
            <p>Pusat pelatihan bahasa Inggris terdepan dengan fokus pada hasil dan kompetensi global.</p>
            <?php include __DIR__ . '/social.php'; ?>
        </div>

        <div>
            <h4>Our Program</h4>
            <ul>
                <?php foreach ($footerPrograms as $fp): ?>
                    <li><a href="<?= base_url('pages/program-detail.php?slug=' . urlencode($fp['slug'])) ?>"><?= e($fp['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div>
            <h4>Navigasi</h4>
            <ul>
                <li><a href="<?= base_url('index.php') ?>">Home</a></li>
                <li><a href="<?= base_url('pages/profil.php') ?>">Profile</a></li>
                <li><a href="<?= base_url('pages/program.php') ?>">Program</a></li>
                <li><a href="<?= base_url('pages/contact.php') ?>">Contact</a></li>
            </ul>
        </div>

        <div>
            <h4>Hubungi Kami</h4>
            <ul class="contact-list">
                <li><img src="<?= asset('images/icons/pin.svg') ?>" alt="" aria-hidden="true"><span><?= e($address) ?></span></li>
                <li><img src="<?= asset('images/icons/phone.svg') ?>" alt="" aria-hidden="true"><span><?= e($phone) ?></span></li>
                <li><img src="<?= asset('images/icons/mail.svg') ?>" alt="" aria-hidden="true"><span><?= e($email) ?></span></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy;<?= date('Y') ?> Yusrianti Mangetek. Seluruh Hak Cipta Dilindungi</p>
    </div>
</footer>

<script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
