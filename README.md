# Skilvara English Center

Website company profile dan pendaftaran kursus **Skilvara English Center** (*Upgrade Skill, Upgrade Life*), Kota Palopo.

- **Mitra** : Skilvara English Center
- **Pengembang** : Yusrianti Mangetek
- **Mata Kuliah** : Project Mandiri (Tugas 6 - Project Directory Architecture & Environment Setup)

## Tech Stack

| Bagian        | Teknologi                              |
|---------------|----------------------------------------|
| Frontend      | HTML5, CSS3 (tanpa framework), JavaScript vanilla |
| Backend       | PHP 8+ native (PDO, prepared statement)|
| Database      | MySQL / MariaDB                        |
| Environment   | Laragon (Apache + MySQL)               |
| Font          | Inter (lokal di `assets/fonts`)        |

## Struktur Folder

```
skilvara-english-center/
├── index.php                  # Halaman Home
├── pages/                     # Halaman lain (Views)
│   ├── profil.php
│   ├── program.php
│   ├── program-detail.php
│   ├── contact.php
│   ├── faq.php
│   ├── daftar.php             # Langkah 1: data diri
│   ├── konfirmasi.php         # Langkah 2: review
│   ├── pembayaran.php         # Langkah 3: pembayaran
│   └── sukses.php
├── includes/                  # Bagian berulang (Header, Footer, Navbar)
│   ├── header.php
│   ├── footer.php
│   ├── social.php
│   ├── steps.php
│   ├── reg-hero.php
│   └── functions.php
├── config/
│   └── database.php           # Koneksi database (PDO)
├── database/
│   └── skilvara.sql           # Skema + data awal
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   ├── fonts/                 # Inter (woff2)
│   └── images/
│       ├── logo/              # Logo & favicon
│       ├── hero/              # Foto hero
│       ├── about/             # Foto/ilustrasi profil
│       ├── programs/          # Foto Kids/Teen/Adult Class
│       ├── map/               # Peta lokasi
│       └── icons/             # Ikon TikTok, Instagram, Facebook, kontak, dll
├── docs/
│   └── PANDUAN_SETUP_LARAGON.md
└── README.md
```

## Cara Menjalankan di Lokal (Laragon)

1. **Salin** folder `skilvara-english-center` ke `C:\laragon\www\`
2. Buka **Laragon** -> klik **Start All** (Apache + MySQL berwarna hijau).
3. **Import database**: Laragon -> klik kanan -> *MySQL* -> **phpMyAdmin** (atau tombol **Database** / HeidiSQL) -> tab **Import** -> pilih `database/skilvara.sql` -> **Go**.
   Database `skilvara_db` otomatis dibuat.
4. Cek `config/database.php` (default Laragon sudah sesuai: user `root`, password kosong).
5. Buka browser: **http://localhost/skilvara-english-center/**
   (atau `http://skilvara-english-center.test` bila *Auto Virtual Hosts* aktif: Laragon -> Menu -> Apache -> Reload).

Panduan lengkap dengan troubleshooting: lihat [`docs/PANDUAN_SETUP_LARAGON.md`](docs/PANDUAN_SETUP_LARAGON.md).

## Alur Pendaftaran

`daftar.php` -> `konfirmasi.php` -> `pembayaran.php` -> `sukses.php`
Data tersimpan di tabel `registrations` dan `payments`.

## Database

Tabel: `programs`, `program_benefits`, `batches`, `registrations`, `payments`, `faq_categories`, `faqs`, `site_settings`, `site_stats`.

## Yang Perlu Diisi / Disesuaikan

- Link akun TikTok/Instagram/Facebook asli -> tabel `site_settings` (`tiktok_url`, `instagram_url`, `facebook_url`).
- Rekening & QR pembayaran: tabel `site_settings` (`bank_name`, `bank_account_no`, `bank_account_name`); QR ada di `assets/images/icons/qr-rekening-bri.png`.
- Jawaban FAQ (selain nomor 1) dan biaya pendaftaran (`registration_fee`) adalah contoh; sesuaikan dengan data mitra.
