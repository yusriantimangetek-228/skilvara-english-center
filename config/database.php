<?php
/**
 * Konfigurasi & koneksi database (PDO) - Skilvara English Center
 * Default Laragon: user = root, password = kosong, host = localhost.
 */

const DB_HOST = '127.0.0.1';
const DB_PORT = 3306;
const DB_NAME = 'skilvara_db';
const DB_USER = 'root';
const DB_PASS = '';

/**
 * Mengembalikan satu koneksi PDO (dibuat sekali lalu dipakai ulang).
 */
function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME);
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            exit('<h2>Koneksi database gagal</h2>'
                . '<p>Pastikan MySQL di Laragon sudah <b>Start</b> dan database <code>' . DB_NAME . '</code> sudah di-import '
                . '(lihat README.md).</p><pre>' . htmlspecialchars($e->getMessage()) . '</pre>');
        }
    }

    return $pdo;
}
