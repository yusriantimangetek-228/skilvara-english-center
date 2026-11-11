<?php
require_once __DIR__ . '/../includes/functions.php';

$reg = $_SESSION['reg'] ?? null;
if (!$reg) {
    redirect('pages/daftar.php');
}

$program = get_program_by_id((int) $reg['program_id']);
$batch   = get_batch_by_id((int) $reg['batch_id']);
if (!$program || !$batch) {
    unset($_SESSION['reg']);
    redirect('pages/daftar.php');
}
$costs = calc_costs($program);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_valid()) {
    // Simpan pendaftaran (sekali saja per sesi)
    if (empty($_SESSION['reg_id'])) {
        $code = 'SKV-' . date('ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
        $stmt = db()->prepare(
            'INSERT INTO registrations
                (reg_code, full_name, email, whatsapp, address, program_id, batch_id, course_fee, registration_fee, discount, total_amount, status)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,"menunggu_pembayaran")'
        );
        $stmt->execute([
            $code, $reg['nama'], $reg['email'], $reg['whatsapp'], $reg['alamat'],
            $program['id'], $batch['id'],
            $costs['course'], $costs['reg_fee'], $costs['discount'], $costs['total'],
        ]);
        $_SESSION['reg_id'] = (int) db()->lastInsertId();
    }
    redirect('pages/pembayaran.php');
}

$pageTitle = 'Konfirmasi Pendaftaran';
$activeNav = '';
$hideCta   = true;
require_once __DIR__ . '/../includes/header.php';
$step = 2;
$heroTitle = 'Konfirmasi Pendaftaran';
$heroSub = 'Periksa kembali data Anda sebelum lanjut ke pembayaran.';
?>

<section class="form-page">
    <div class="container">
        <?php include __DIR__ . '/../includes/reg-hero.php'; ?>
        <div class="narrow-col">

        <div class="card form-card">

            <div class="review-head">
                <h2 class="h4">Informasi Pribadi</h2>
                <a class="link-small" href="<?= base_url('pages/daftar.php') ?>">Ubah</a>
            </div>
            <dl class="review-box">
                <div><dt>Nama Lengkap</dt><dd><?= e($reg['nama']) ?></dd></div>
                <div><dt>Email</dt><dd><?= e($reg['email']) ?></dd></div>
                <div><dt>Nomor WhatsApp</dt><dd><?= e($reg['whatsapp']) ?></dd></div>
                <div><dt>Alamat</dt><dd><?= e($reg['alamat']) ?></dd></div>
            </dl>

            <div class="review-head">
                <h2 class="h4">Program Terpilih</h2>
                <a class="link-small" href="<?= base_url('pages/daftar.php') ?>">Ubah</a>
            </div>
            <div class="review-program">
                <img src="<?= asset('images/programs/' . $program['image']) ?>" alt="">
                <div>
                    <strong><?= e($program['name']) ?></strong>
                    <small>Batch: <?= e($batch['name']) ?></small>
                    <span class="pill"><?= (int) $program['total_sessions'] ?> SESI</span>
                </div>
                <strong><?= rupiah($program['price']) ?></strong>
            </div>

            <div class="cost-box">
                <p class="cost-title">RINGKASAN BIAYA</p>
                <dl>
                    <div><dt>Biaya Kursus</dt><dd><?= rupiah($costs['course']) ?></dd></div>
                    <?php if ($costs['reg_fee'] > 0): ?>
                        <div><dt>Pendaftaran</dt><dd><?= rupiah($costs['reg_fee']) ?></dd></div>
                    <?php endif; ?>
                    <?php if ($costs['discount'] > 0): ?>
                        <div><dt><em>Potongan Promo</em></dt><dd>- <?= rupiah($costs['discount']) ?></dd></div>
                    <?php endif; ?>
                    <div class="total"><dt>Total Pembayaran</dt><dd><?= rupiah($costs['total']) ?></dd></div>
                </dl>
            </div>

            <form method="post" action="">
                <?= csrf_field() ?>
                <button class="btn btn-gradient btn-block" type="submit">Lanjut ke Pembayaran &nbsp;&rarr;</button>
            </form>
            <p class="form-note">Dengan mengklik tombol di atas, Anda akan mendapatkan instruksi rekening pembayaran.</p>
        </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
