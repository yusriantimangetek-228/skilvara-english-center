<?php
require_once __DIR__ . '/../includes/functions.php';

$regId = (int) ($_SESSION['reg_id'] ?? 0);
if (!$regId) {
    redirect('pages/daftar.php');
}

$stmt = db()->prepare(
    'SELECT r.*, p.name AS program_name, b.name AS batch_name
       FROM registrations r
       JOIN programs p ON p.id = r.program_id
       JOIN batches  b ON b.id = r.batch_id
      WHERE r.id = ?'
);
$stmt->execute([$regId]);
$order = $stmt->fetch();
if (!$order) {
    unset($_SESSION['reg_id']);
    redirect('pages/daftar.php');
}

$wa = preg_replace('/\D+/', '', get_setting('whatsapp', '6282272979021'));
$bankName   = get_setting('bank_name', 'Bank BRI');
$bankNo     = get_setting('bank_account_no', '040301045884508');
$bankHolder = get_setting('bank_account_name', 'MUH. RINALDY');
$waText = rawurlencode("Halo Admin Skilvara, saya sudah melakukan pembayaran.\nKode: {$order['reg_code']}\nNama: {$order['full_name']}\nProgram: {$order['program_name']}\nTotal: " . rupiah($order['total_amount']));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_valid()) {
    $method = ($_POST['method'] ?? 'qris') === 'transfer' ? 'transfer_bank' : 'qris';

    $ins = db()->prepare('INSERT INTO payments (registration_id, method, amount, status) VALUES (?,?,?,"menunggu_verifikasi")');
    $ins->execute([$order['id'], $method, $order['total_amount']]);
    db()->prepare('UPDATE registrations SET status = "menunggu_verifikasi" WHERE id = ?')->execute([$order['id']]);

    $_SESSION['last_code'] = $order['reg_code'];
    unset($_SESSION['reg'], $_SESSION['reg_id']);
    redirect('pages/sukses.php');
}

$pageTitle = 'Pembayaran';
$activeNav = '';
$hideCta   = true;
require_once __DIR__ . '/../includes/header.php';
$step = 3;
$heroTitle = 'Pembayaran';
$heroSub = 'Pilih metode pembayaran dan selesaikan pendaftaran Anda.';
?>

<section class="form-page">
    <div class="container">
        <?php include __DIR__ . '/../includes/reg-hero.php'; ?>

        <form class="pay-grid" method="post" action="">
            <?= csrf_field() ?>

            <div>
                <div class="card form-card">
                    <h1 class="h2">Metode Pembayaran</h1>

                    <label class="method active" data-method>
                        <input type="radio" name="method" value="qris" checked>
                        <span class="method-head"><span class="tag">QR</span> Scan QR Rekening <?= e($bankName) ?></span>
                        <span class="qr-box">
                            <img src="<?= asset('images/icons/qr-rekening-bri.png') ?>" alt="QR rekening <?= e($bankName) ?> <?= e($bankNo) ?>">
                            <small>Scan untuk menyalin data rekening, lalu transfer melalui aplikasi bank Anda</small>
                            <span class="bank-info">
                                <b><?= e($bankName) ?></b>
                                <span class="acc-no"><?= e($bankNo) ?></span>
                                <span>a.n. <?= e($bankHolder) ?></span>
                            </span>
                        </span>
                    </label>

                    <label class="method" data-method>
                        <input type="radio" name="method" value="transfer">
                        <span class="method-head"><span class="tag tag-light">BANK</span> Transfer Bank Manual (<?= e($bankName) ?>)</span>
                        <span class="qr-box">
                            <span class="bank-info">
                                <b><?= e($bankName) ?></b>
                                <span class="acc-no"><?= e($bankNo) ?></span>
                                <span>a.n. <?= e($bankHolder) ?></span>
                            </span>
                            <small>Transfer sesuai total pembayaran, lalu kirim bukti ke WhatsApp Admin</small>
                        </span>
                    </label>

                    <div class="proof-box">
                        <img src="<?= asset('images/icons/whatsapp.svg') ?>" alt="" aria-hidden="true">
                        <div>
                            <h3>Wajib Kirim Bukti Bayar</h3>
                            <p>Setelah berhasil melakukan pembayaran, harap screenshot bukti pembayaran Anda dan kirimkan ke WhatsApp Admin untuk aktivasi program secara instan.</p>
                            <a class="btn btn-white btn-block" href="https://wa.me/<?= e($wa) ?>?text=<?= $waText ?>" target="_blank" rel="noopener">Kirim Bukti ke WA Admin</a>
                        </div>
                    </div>
                </div>

                <div class="card form-card mt">
                    <h2 class="h4">Instruksi Pembayaran</h2>
                    <ol class="instructions">
                        <li>Lakukan transfer sesuai nominal total (termasuk kode unik jika ada).</li>
                        <li>Simpan bukti transfer dalam format JPG/PNG.</li>
                        <li>Unggah bukti transfer melalui tombol di bawah atau kirim via WhatsApp.</li>
                        <li>Tunggu konfirmasi admin (maksimal 1&times;24 jam).</li>
                    </ol>
                </div>
            </div>

            <aside class="card form-card summary">
                <h2 class="h4">Ringkasan Pesanan</h2>
                <dl>
                    <div><dt>Kode:</dt><dd><?= e($order['reg_code']) ?></dd></div>
                    <div><dt>Program:</dt><dd><?= e($order['program_name']) ?></dd></div>
                    <div><dt>Gelombang:</dt><dd><?= e($order['batch_name']) ?></dd></div>
                </dl>
                <dl>
                    <div><dt>Biaya Kursus</dt><dd><?= rupiah($order['course_fee']) ?></dd></div>
                    <?php if ($order['registration_fee'] > 0): ?>
                        <div><dt>Pendaftaran</dt><dd><?= rupiah($order['registration_fee']) ?></dd></div>
                    <?php endif; ?>
                    <?php if ($order['discount'] > 0): ?>
                        <div><dt><em>Diskon Promo</em></dt><dd>- <?= rupiah($order['discount']) ?></dd></div>
                    <?php endif; ?>
                </dl>
                <p class="total-line"><span>Total Bayar</span> <strong><?= rupiah($order['total_amount']) ?></strong></p>
                <button class="btn btn-gradient btn-block" type="submit">Konfirmasi Bayar</button>
                <p class="help">BUTUH BANTUAN?</p>
                <a class="help-link" href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener">Hubungi WhatsApp Admin</a>
            </aside>
        </form>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
