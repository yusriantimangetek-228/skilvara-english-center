<?php
/**
 * Ikon media sosial (TikTok, Instagram, Facebook).
 * Ganti nilai '#' dengan link akun asli Skilvara bila sudah ada.
 */
require_once __DIR__ . '/functions.php';

$socials = [
    ['TikTok',    'tiktok.svg',    get_setting('tiktok_url', '#')],
    ['Instagram', 'instagram.svg', get_setting('instagram_url', '#')],
    ['Facebook',  'facebook.svg',  get_setting('facebook_url', '#')],
];
?>
<ul class="social-list">
    <?php foreach ($socials as [$name, $icon, $url]): ?>
        <li>
            <a href="<?= e($url) ?>" target="_blank" rel="noopener" aria-label="<?= e($name) ?> Skilvara">
                <img src="<?= asset('images/icons/' . $icon) ?>" alt="<?= e($name) ?>">
            </a>
        </li>
    <?php endforeach; ?>
</ul>
