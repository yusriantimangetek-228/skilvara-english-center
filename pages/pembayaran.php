<?php
require_once __DIR__ . '/../config/config.php';
if (empty($_SESSION['reg_id'])) { header('Location: ' . url('pages/pendaftaran.php')); exit; }
$st = db()->prepare('SELECT r.*, p.name pname, b.name bname FROM registrations r JOIN programs p ON p.id=r.program_id JOIN batches b ON b.id=r.batch_id WHERE r.id=?');
$st->execute([$_SESSION['reg_id']]); $r = $st->fetch();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = null;
    if (!empty($_FILES['proof']['name']) && $_FILES['proof']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['proof']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png'])) {
            $file = 'proof_' . $r['id'] . '_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['proof']['tmp_name'], ROOT . '/uploads/' . $file);
        }
    }
    $method = ($_POST['method'] ?? '') === 'transfer' ? 'transfer' : 'qris';
    db()->prepare('INSERT INTO payments (registration_id,method,proof_file) VALUES (?,?,?)')->execute([$r['id'],$method,$file]);
    unset($_SESSION['reg'], $_SESSION['reg_id']);
    header('Location: ' . url('pages/sukses.php')); exit;
}
$title = 'Pembayaran'; $hideCta = true;
include ROOT . '/includes/header.php';
?>
<main class="form-wrap">
  <div class="steps"><span>1. DATA DIRI</span><span>2. KONFIRMASI</span><b>3. PEMBAYARAN</b></div>
  <form method="post" enctype="multipart/form-data" class="pay">
    <div class="card p-3 shadow-sm"><h2>Metode Pembayaran</h2>
      <label class="radio"><input type="radio" name="method" value="qris" checked> QRIS (Gopay, OVO, Dana, LinkAja)</label>
      <img src="<?= url('assets/images/qris.png') ?>" alt="QRIS" width="200"><small>Silakan scan kode QR di atas untuk membayar</small>
      <label class="radio"><input type="radio" name="method" value="transfer"> Transfer Bank Manual (BCA, Mandiri)</label>
      <div class="cta-dark"><b>Wajib Kirim Bukti Bayar</b><p>Setelah berhasil melakukan pembayaran, unggah screenshot bukti (JPG/PNG).</p>
        <input type="file" name="proof" accept=".jpg,.jpeg,.png"></div>
      <h3>Instruksi Pembayaran</h3><ol><li>Lakukan transfer sesuai nominal total.</li><li>Simpan bukti transfer dalam format JPG/PNG.</li>
        <li>Unggah bukti transfer atau kirim via WhatsApp.</li><li>Tunggu konfirmasi admin (maksimal 1×24 jam).</li></ol></div>
    <aside class="card p-3 shadow-sm"><h3>Ringkasan Pesanan</h3>
      <p>Program: <b><?= e($r['pname']) ?></b><br>Gelombang: <b><?= e($r['bname']) ?></b></p>
      <p>Biaya Kursus <?= rupiah($r['course_fee']) ?><br>Pendaftaran <?= rupiah($r['registration_fee']) ?><br>Diskon Promo - <?= rupiah($r['discount']) ?></p>
      <h3>Total Bayar <?= rupiah($r['total_amount']) ?></h3>
      <button class="btn btn-dark w-100 py-2">Konfirmasi Bayar</button>
      <p><a href="https://wa.me/6282272979021">Hubungi WhatsApp Admin</a></p></aside>
  </form>
</main>
<?php include ROOT . '/includes/footer.php'; ?>
