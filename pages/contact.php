<?php
$pageTitle = 'Contact';
$activeNav = 'contact';
require_once __DIR__ . '/../includes/header.php';

$address = get_setting('address', 'Ruko Cluster Permata, Jl. Kelapa, Lagaligo, Kec. Wara, Kota Palopo');
$phone   = get_setting('phone', '+62 822-7297-9021');
$email   = get_setting('email', '@skilvaraenglishcenter.com');
$mapsUrl = get_setting('maps_url', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.3323059681143!2d120.18950877472955!3d-3.004964296971091!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d915f8522f2676f%3A0xea6aeffc876bdea!2sYayasan%20Bina%20Teknologi%20Sawerigading%20-%20Skilvara%20English%20Center!5e0!3m2!1sid!2sid!4v1794360568832!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>');
?>

<section class="hero hero-small hero-center">
    <div class="container">
        <h1>Hubungi Kami</h1>
        <p>Punya pertanyaan mengenai program kami atau butuh konsultasi pendidikan? Tim kami siap membantu Anda.</p>
    </div>
</section>

<section class="section">
    <div class="container contact-grid">
        <div>
            <h2>Informasi Kontak</h2>
            <ul class="contact-list contact-list-lg">
                <li><img src="<?= asset('images/icons/pin.svg') ?>" alt="" aria-hidden="true"><span><?= e($address) ?></span></li>
                <li><img src="<?= asset('images/icons/phone.svg') ?>" alt="" aria-hidden="true"><span><?= e($phone) ?></span></li>
                <li><img src="<?= asset('images/icons/mail.svg') ?>" alt="" aria-hidden="true"><span><?= e($email) ?></span></li>
            </ul>

            <h2 class="mt-lg">Ikuti Kami</h2>
            <?php include __DIR__ . '/../includes/social.php'; ?>
        </div>

        <a class="map-box" href="<?= e($mapsUrl) ?>" target="_blank" rel="noopener" aria-label="Buka lokasi di Google Maps">
            <img src="<?= asset('images/map/peta-lokasi.png') ?>" alt="Peta lokasi Skilvara English Center, Kota Palopo">
        </a>
    </div>
</section>

<section class="section section-cyan center">
    <div class="container">
        <h2>Punya Pertanyaan ?</h2>
        <p>Mungkin jawaban yang Anda cari sudah ada di halaman tanya-jawab kami.</p>
        <p class="mt"><a class="link-arrow" href="<?= base_url('pages/faq.php') ?>">Buka Halaman FAQ &nbsp;&gt;</a></p>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
