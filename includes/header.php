<?php
/**
 * Header + Navbar (dipakai semua halaman).
 * Variabel yang bisa di-set sebelum include: $pageTitle, $activeNav, $hideCta
 */
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? 'Skilvara English Center';
$activeNav = $activeNav ?? '';
$hideCta   = $hideCta ?? false;

$nav = [
    'home'    => ['Home',    'index.php'],
    'profil'  => ['Profil',  'pages/profil.php'],
    'program' => ['Program', 'pages/program.php'],
    'contact' => ['Contact', 'pages/contact.php'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | Skilvara English Center</title>
    <meta name="description" content="Skilvara English Center - Upgrade Skill, Upgrade Life. Kursus bahasa Inggris untuk anak, remaja, dan dewasa di Palopo.">
    <link rel="icon" type="image/png" href="<?= asset('images/logo/favicon.png') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= base_url('index.php') ?>" aria-label="Skilvara - Beranda">
            <img src="<?= asset('images/logo/logo-skilvara.png') ?>" alt="Skilvara - Upgrade Skill, Upgrade Life">
        </a>

        <button class="nav-toggle" type="button" aria-label="Buka menu" aria-expanded="false" data-nav-toggle>
            <span></span><span></span><span></span>
        </button>

        <nav class="main-nav" data-nav>
            <ul>
                <?php foreach ($nav as $key => [$label, $href]): ?>
                    <li><a href="<?= base_url($href) ?>" class="<?= $activeNav === $key ? 'active' : '' ?>"><?= e($label) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php if (!$hideCta): ?>
                <a class="btn btn-orange nav-cta-mobile" href="<?= base_url('pages/daftar.php') ?>">Daftar Sekarang</a>
            <?php endif; ?>
        </nav>

        <?php if (!$hideCta): ?>
            <a class="btn btn-orange header-cta" href="<?= base_url('pages/daftar.php') ?>">Daftar Sekarang</a>
        <?php endif; ?>
    </div>
</header>
<main>
