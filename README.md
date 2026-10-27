# Skilvara English Center — Website Kursus Bahasa Inggris

Website profil & pendaftaran online untuk **Skilvara English Center** (Palopo, Sulawesi Selatan).

- **Nama Mitra:** Skilvara English Center
- **Pengembang:** Yusrianti Mangetek

## Tech Stack
- PHP 8 (native, PDO) · MySQL/MariaDB (XAMPP)
- HTML5, CSS3, JavaScript (vanilla)
- Git & GitHub

## Struktur Folder
```
skilvara/
├── index.php            # Halaman Home
├── pages/               # profil, program, program-detail, contact, faq, pendaftaran, konfirmasi, pembayaran, sukses
├── includes/            # header.php, navbar.php, footer.php
├── config/              # config.php, database.php (koneksi)
├── database/            # skilvara.sql (schema + data awal)
├── assets/              # css/, js/, images/, icons/, fonts/
└── uploads/             # bukti pembayaran
```

## Cara Install & Jalankan di Lokal (XAMPP)
1. Install XAMPP, lalu start **Apache** dan **MySQL**.
2. Salin folder `skilvara` ke `C:\xampp\htdocs\`.
3. Buka `http://localhost/phpmyadmin` → tab **Import** → pilih `database/skilvara.sql` → **Go**.
   (Atau: `mysql -u root < database/skilvara.sql`)
4. Cek `config/database.php` (default: user `root`, password kosong) dan `BASE_URL` di `config/config.php`.
5. Buka **http://localhost/skilvara/**

## Alur Pendaftaran
Data Diri → Konfirmasi → Pembayaran → Sukses (data tersimpan di tabel `registrations` & `payments`).

## Bootstrap
Bootstrap 5.3.3 dipasang **lokal** (`assets/css/bootstrap.min.css`, `assets/js/bootstrap.bundle.min.js`), sehingga tetap berjalan tanpa internet. Gaya tambahan ada di `assets/css/style.css`.
Gambar di `assets/images/` masih berupa placeholder; ganti dengan gambar asli (nama file sama).

## Git & GitHub
```bash
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/USERNAME/skilvara-english-center.git
git push -u origin main
```
