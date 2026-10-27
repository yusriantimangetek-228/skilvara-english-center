<?php
require_once __DIR__ . '/../config/config.php';
if (empty($_SESSION['reg'])) { header('Location: ' . url('pages/pendaftaran.php')); exit; }
$r = $_SESSION['reg'];
$p = db()->prepare('SELECT * FROM programs WHERE id=?'); $p->execute([$r['program_id']]); $p = $p->fetch();
$b = db()->prepare('SELECT * FROM batches WHERE id=?'); $b->execute([$r['batch_id']]); $b = $b->fetch();
$biaya = (int)$p['price']; $daftar = BIAYA_PENDAFTARAN; $promo = 0; $total = $biaya + $daftar - $promo;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ins = db()->prepare('INSERT INTO registrations (full_name,email,whatsapp,address,program_id,batch_id,course_fee,registration_fee,discount,total_amount) VALUES (?,?,?,?,?,?,?,?,?,?)');
    $ins->execute([$r['full_name'],$r['email'],$r['whatsapp'],$r['address'],$p['id'],$b['id'],$biaya,$daftar,$promo,$total]);
    $_SESSION['reg_id'] = db()->lastInsertId();
    header('Location: ' . url('pages/pembayaran.php')); exit;
}
$title = 'Konfirmasi'; $hideCta = true;
include ROOT . '/includes/header.php';
?>
<main class="form-wrap">
  <div class="steps"><span>1. DATA DIRI</span><b>2. KONFIRMASI</b><span>3. PEMBAYARAN</span></div>
  <div class="card p-3 shadow-sm"><h2>Review Pendaftaran Anda</h2><p>Mohon periksa kembali data Anda sebelum lanjut ke pembayaran.</p>
    <h3>Informasi Pribadi <a href="<?= url('pages/pendaftaran.php') ?>">Ubah</a></h3>
    <p>Nama: <b><?= e($r['full_name']) ?></b><br>Email: <b><?= e($r['email']) ?></b><br>WhatsApp: <b><?= e($r['whatsapp']) ?></b><br>Alamat: <b><?= e($r['address']) ?></b></p>
    <h3>Program Terpilih <a href="<?= url('pages/pendaftaran.php') ?>">Ubah</a></h3>
    <p><b><?= e($p['name']) ?></b> — <?= rupiah($biaya) ?><br>Batch: <?= e($b['name']) ?> · <?= (int)$p['total_sessions'] ?> SESI</p>
    <div class="summary"><p>Biaya Kursus <span><?= rupiah($biaya) ?></span></p><p>Pendaftaran <span><?= rupiah($daftar) ?></span></p>
      <p>Potongan Promo <span>- <?= rupiah($promo) ?></span></p><h3>Total Pembayaran <span><?= rupiah($total) ?></span></h3></div>
    <form method="post"><button class="btn btn-dark w-100 py-2">Lanjut ke Pembayaran</button></form>
    <small>Dengan mengklik tombol di atas, Anda akan mendapatkan instruksi rekening pembayaran.</small>
  </div>
</main>
<?php include ROOT . '/includes/footer.php'; ?>
