<?php
/**
 * Fungsi bantu umum: URL dasar, escape, format rupiah, session, CSRF.
 */

require_once __DIR__ . '/../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Folder proyek di disk dan base URL otomatis (aman di localhost/skilvara-english-center maupun skilvara-english-center.test). */
define('ROOT_PATH', dirname(__DIR__));

function base_url(string $path = ''): string
{
    static $base = null;

    if ($base === null) {
        $docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
        $root    = realpath(ROOT_PATH) ?: ROOT_PATH;
        $docRoot = str_replace('\\', '/', $docRoot);
        $root    = str_replace('\\', '/', $root);

        if ($docRoot !== '' && stripos($root, $docRoot) === 0) {
            $base = rtrim(substr($root, strlen($docRoot)), '/');
        } else {
            $base = '';
        }
    }

    return $base . '/' . ltrim($path, '/');
}

/** URL ke file di folder assets/. */
function asset(string $path): string
{
    return base_url('assets/' . ltrim($path, '/'));
}

/** Escape output HTML. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Format angka ke Rupiah, contoh: Rp 350.000 */
function rupiah($angka): string
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}

function redirect(string $path): void
{
    header('Location: ' . base_url($path));
    exit;
}

/** Token CSRF sederhana untuk form POST. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valid(): bool
{
    return isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}

/** Ambil semua program aktif beserta daftar materi utamanya. */
function get_programs(): array
{
    $programs = db()->query('SELECT * FROM programs WHERE is_active = 1 ORDER BY sort_order, id')->fetchAll();
    foreach ($programs as &$p) {
        $stmt = db()->prepare('SELECT title, description, highlight_text FROM program_benefits WHERE program_id = ? ORDER BY sort_order, id');
        $stmt->execute([$p['id']]);
        $p['benefits'] = $stmt->fetchAll();
    }
    return $programs;
}

function get_program_by_slug(string $slug): ?array
{
    $stmt = db()->prepare('SELECT * FROM programs WHERE slug = ? AND is_active = 1 LIMIT 1');
    $stmt->execute([$slug]);
    $p = $stmt->fetch();
    if (!$p) {
        return null;
    }
    $b = db()->prepare('SELECT title, description, highlight_text FROM program_benefits WHERE program_id = ? ORDER BY sort_order, id');
    $b->execute([$p['id']]);
    $p['benefits'] = $b->fetchAll();
    return $p;
}

/** Hitung rincian biaya pendaftaran: biaya kursus + biaya pendaftaran - potongan promo. */
function calc_costs(array $program): array
{
    $course   = (float) $program['price'];
    $regFee   = (float) get_setting('registration_fee', '0');
    $discount = (float) get_setting('promo_discount', '0');

    return [
        'course'   => $course,
        'reg_fee'  => $regFee,
        'discount' => $discount,
        'total'    => max(0, $course + $regFee - $discount),
    ];
}

function get_program_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM programs WHERE id = ? AND is_active = 1 LIMIT 1');
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

function get_batch_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM batches WHERE id = ? AND is_open = 1 LIMIT 1');
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

function get_setting(string $key, string $default = ''): string
{
    static $cache = null;
    if ($cache === null) {
        $cache = db()->query('SELECT setting_key, setting_value FROM site_settings')->fetchAll(PDO::FETCH_KEY_PAIR);
    }
    return $cache[$key] ?? $default;
}
