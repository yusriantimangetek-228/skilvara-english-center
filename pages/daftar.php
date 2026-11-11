<?php
require_once __DIR__ . '/../includes/functions.php';

$programs = get_programs();
$batches  = db()->query('SELECT * FROM batches WHERE is_open = 1 ORDER BY start_date')->fetchAll();

$old = $_SESSION['reg'] ?? [];
$selectedSlug = $_GET['program'] ?? '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid()) {
        $errors[] = 'Sesi formulir tidak valid. Silakan muat ulang halaman.';
    }

    $data = [
        'nama'       => trim($_POST['nama'] ?? ''),
        'email'      => trim($_POST['email'] ?? ''),
        'whatsapp'   => preg_replace('/[^\d+]/', '', $_POST['whatsapp'] ?? ''),
        'alamat'     => trim($_POST['alamat'] ?? ''),
        'program_id' => (int) ($_POST['program_id'] ?? 0),
        'batch_id'   => (int) ($_POST['batch_id'] ?? 0),
    ];

    if (mb_strlen($data['nama']) < 3)                          $errors[] = 'Nama lengkap minimal 3 karakter.';
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))    $errors[] = 'Format email tidak valid.';
    if (!preg_match('/^(\+62|62|0)8\d{7,12}$/', $data['whatsapp'])) $errors[] = 'Nomor WhatsApp tidak valid (contoh: 0812xxxxxxx).';
    if (mb_strlen($data['alamat']) < 5)                        $errors[] = 'Alamat lengkap wajib diisi.';
    if (!get_program_by_id($data['program_id']))               $errors[] = 'Silakan pilih program.';
    if (!get_batch_by_id($data['batch_id']))                   $errors[] = 'Silakan pilih batch / gelombang.';
    if (empty($_POST['setuju']))                               $errors[] = 'Anda harus menyetujui syarat dan ketentuan.';

    if (!$errors) {
        $_SESSION['reg'] = $data;
        redirect('pages/konfirmasi.php');
    }
    $old = $data;
}

// Tentukan program terpilih awal (dari form lama atau dari ?program=slug)
$selectedId = (int) ($old['program_id'] ?? 0);
if (!$selectedId && $selectedSlug) {
    foreach ($programs as $p) {
        if ($p['slug'] === $selectedSlug) { $selectedId = (int) $p['id']; }
    }
}

$pageTitle = 'Form Pendaftaran';
$activeNav = '';
$hideCta   = true;
require_once __DIR__ . '/../includes/header.php';
$step = 1;
$heroTitle = 'Daftar Program Belajar';
$heroSub = 'Isi data diri dan pilih program. Hanya butuh 2 menit.';
?>

<section class="form-page">
    <div class="container">
        <?php include __DIR__ . '/../includes/reg-hero.php'; ?>

        <div class="reg-layout">
            <form class="card form-card" method="post" action="" novalidate>
                <?= csrf_field() ?>

                <?php if ($errors): ?>
                    <div class="alert alert-error" role="alert">
                        <strong>Mohon periksa kembali:</strong>
                        <ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
                    </div>
                <?php endif; ?>

                <h2 class="form-section"><span class="num">1</span> Informasi Pribadi</h2>

                <label class="field">
                    <span>Nama Lengkap</span>
                    <input type="text" name="nama" placeholder="Masukkan nama sesuai KTP" value="<?= e($old['nama'] ?? '') ?>" required>
                </label>

                <div class="field-row">
                    <label class="field">
                        <span>Email</span>
                        <input type="email" name="email" placeholder="example@mail.com" value="<?= e($old['email'] ?? '') ?>" required>
                    </label>
                    <label class="field">
                        <span>Nomor WhatsApp</span>
                        <input type="tel" name="whatsapp" placeholder="0812xxxx" value="<?= e($old['whatsapp'] ?? '') ?>" required>
                    </label>
                </div>

                <label class="field">
                    <span>Alamat Lengkap</span>
                    <textarea name="alamat" rows="3" placeholder="Alamat rumah saat ini" required><?= e($old['alamat'] ?? '') ?></textarea>
                </label>

                <h2 class="form-section"><span class="num">2</span> Pilih Program</h2>
                <div class="program-cards">
                    <?php foreach ($programs as $p): ?>
                        <label class="program-opt">
                            <input type="radio" name="program_id" value="<?= (int) $p['id'] ?>" <?= $selectedId === (int) $p['id'] ? 'checked' : '' ?> required>
                            <span class="opt-body">
                                <img src="<?= asset('images/programs/' . $p['image']) ?>" alt="">
                                <strong><?= e($p['name']) ?></strong>
                                <em><?= rupiah($p['price']) ?><small>/bulan</small></em>
                                <small><?= (int) $p['total_sessions'] ?> sesi &bull; Modul fisik &bull; Try out</small>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <h2 class="form-section"><span class="num">3</span> Batch / Gelombang</h2>
                <div class="radio-cards">
                    <?php foreach ($batches as $b): ?>
                        <label class="radio-card">
                            <input type="radio" name="batch_id" value="<?= (int) $b['id'] ?>" <?= (int) ($old['batch_id'] ?? 0) === (int) $b['id'] ? 'checked' : '' ?> required>
                            <span>
                                <strong><?= e($b['name']) ?></strong>
                                <small><?= e($b['note']) ?></small>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <label class="check">
                    <input type="checkbox" name="setuju" value="1" <?= !empty($_POST['setuju']) ? 'checked' : '' ?> required>
                    <span>Saya menyetujui syarat dan ketentuan pendaftaran serta kebijakan privasi Skilvara English Center.</span>
                </label>

                <button class="btn btn-gradient btn-block" type="submit">Lanjut ke Konfirmasi &nbsp;&rarr;</button>
                <p class="form-note">&#128274; Data Anda terjamin kerahasiaannya dan hanya digunakan untuk keperluan administrasi.</p>
            </form>

            <aside class="side">
                <div class="card side-card side-brand">
                    <img src="<?= asset('images/logo/logo-icon.png') ?>" alt="">
                    <h3>Kenapa belajar di Skilvara?</h3>
                    <ul class="tick-list">
                        <li>Metode interaktif &amp; menyenangkan</li>
                        <li>Fokus speaking &amp; percaya diri</li>
                        <li>Modul fisik &amp; try out tersedia</li>
                        <li>Kelas untuk anak, remaja, dan dewasa</li>
                    </ul>
                </div>
                <div class="card side-card">
                    <h3>Butuh bantuan?</h3>
                    <p class="muted">Tim kami siap membantu memilih program yang tepat.</p>
                    <a class="btn btn-green btn-block mt" href="https://wa.me/<?= e(preg_replace('/\D+/', '', get_setting('whatsapp', '6282272979021'))) ?>" target="_blank" rel="noopener">Chat WhatsApp</a>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
