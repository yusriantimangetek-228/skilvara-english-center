<?php
// Konfigurasi umum. Sesuaikan BASE_URL dengan nama folder di htdocs.
if (session_status() === PHP_SESSION_NONE) session_start();
define('BASE_URL', '/skilvara');
define('ROOT', dirname(__DIR__));
define('BIAYA_PENDAFTARAN', 150000);
require_once __DIR__ . '/database.php';

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rupiah($n) { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }
function url($path = '') { return BASE_URL . '/' . ltrim($path, '/'); }
