# Panduan Setup Skilvara di Laragon (dari Nol sampai Website Terbuka)

## A. Persiapan

1. Pastikan **Laragon** sudah terpasang (disarankan Laragon Full, sudah termasuk Apache, MySQL, PHP 8, phpMyAdmin/HeidiSQL).
2. Pastikan proyek sudah diekstrak. Contoh hasil akhir:
   `C:\laragon\www\skilvara-english-center\index.php`
   > Jangan sampai bertumpuk seperti `www\skilvara-english-center\skilvara-english-center\index.php`. Bila itu terjadi, pindahkan isi folder bagian dalam satu tingkat ke atas.

## B. Menaruh Proyek di Laragon

1. Buka Windows Explorer -> `C:\laragon\www\`
2. Copy seluruh folder `skilvara-english-center` ke sana.
   (Cara cepat: di Laragon klik tombol **Root** untuk membuka folder `www`.)

## C. Menjalankan Server

1. Buka aplikasi **Laragon**.
2. Klik **Start All**.
3. Pastikan tulisan **Apache** dan **MySQL** sudah aktif (tidak ada pesan error port).
   - Bila port 80 bentrok (Skype/IIS/XAMPP): Laragon -> Menu -> Preferences -> Services & Ports -> ganti port Apache (mis. 8080), lalu buka `http://localhost:8080/skilvara-english-center/`.

## D. Import Database

**Cara 1 - phpMyAdmin**
1. Laragon -> klik kanan area Laragon -> **MySQL** -> **phpMyAdmin** (atau buka `http://localhost/phpmyadmin`).
2. Login: user `root`, password **kosong**.
3. Klik menu **Import** (tanpa perlu membuat database dulu).
4. **Choose File** -> pilih `skilvara-english-center\database\skilvara.sql`.
5. Klik **Import/Go**. Di sisi kiri akan muncul database `skilvara_db` berisi 9 tabel.

**Cara 2 - HeidiSQL (bawaan Laragon)**
1. Laragon -> tombol **Database** -> HeidiSQL terbuka dan otomatis terhubung.
2. Menu **File** -> **Run SQL file...** -> pilih `database\skilvara.sql` -> Open.
3. Klik kanan daftar database -> **Refresh** -> `skilvara_db` muncul.

**Cara 3 - Terminal Laragon**
```
cd C:\laragon\www\skilvara-english-center
mysql -u root < database\skilvara.sql
```

## E. Cek Konfigurasi Koneksi

Buka `config/database.php`. Nilai default Laragon:

```php
const DB_HOST = '127.0.0.1';
const DB_NAME = 'skilvara_db';
const DB_USER = 'root';
const DB_PASS = '';
```

Bila MySQL Anda memakai password, isi `DB_PASS`.

## F. Membuka Website

- `http://localhost/skilvara-english-center/`
- atau `http://skilvara-english-center.test` (Auto Virtual Hosts Laragon: klik **Menu -> Apache -> Reload** / Restart Laragon).

Uji alur: Home -> Program -> Detail Program -> **Daftar Sekarang** -> isi form -> Konfirmasi -> Pembayaran -> Sukses.
Cek data masuk: phpMyAdmin -> `skilvara_db` -> tabel `registrations` & `payments`.

## G. Troubleshooting

| Masalah | Solusi |
|---|---|
| "Koneksi database gagal" | MySQL belum Start / `skilvara.sql` belum di-import / user-password di `config/database.php` salah. |
| Halaman tampil tanpa CSS/gambar | Folder proyek tidak berada langsung di `www\skilvara-english-center\` (lihat bagian A). Link dihitung otomatis dari lokasi folder. |
| Error 404 | Nama folder harus persis `skilvara-english-center` di URL. |
| "could not find driver" | Aktifkan ekstensi `pdo_mysql`: Laragon -> Menu -> PHP -> Extensions -> centang `pdo_mysql`. |
| Port 80 dipakai aplikasi lain | Ganti port Apache di Preferences, atau matikan IIS/Skype. |

## H. Menyiapkan Pengumpulan Tugas 6

1. **Screenshot struktur folder**: buka folder proyek di VS Code (`File -> Open Folder`), perluas semua folder di panel *Explorer*, tekan `Win + Shift + S`.
2. **Screenshot SQL**: phpMyAdmin -> `skilvara_db` -> tab *Structure* (daftar tabel) dan/atau tab *Designer* (relasi).
3. **Git repository** (GitHub):
   ```
   cd C:\laragon\www\skilvara-english-center
   git init
   git add .
   git commit -m "Initial project structure Skilvara English Center"
   git branch -M main
   git remote add origin https://github.com/<username>/skilvara-english-center.git
   git push -u origin main
   ```
   (Buat repository kosong dulu di github.com -> *New repository*.)
4. **ZIP ke Google Drive**: klik kanan folder proyek -> *Send to -> Compressed (zipped) folder* -> unggah ke Drive -> *Share -> Anyone with the link (Viewer)*.
5. **Laporan** (5-10 halaman): cover, screenshot struktur folder + penjelasan tiap folder, screenshot tabel/ERD, isi `skilvara.sql` (cuplikan), link Git & Drive, isi README.
6. **Sebelum sesi pemeriksaan Selasa**: buka VS Code di laptop, pastikan Laragon jalan, database sudah ter-import, dan semua halaman terbuka tanpa link rusak.
