<?php
require_once __DIR__ . '/../config/config.php';
$title = 'Pendaftaran'; $hideCta = true;
$programs = db()->query('SELECT id,name,level_label FROM programs')->fetchAll();
$batches = db()->query('SELECT * FROM batches')->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['reg'] = [
        'full_name' => trim($_POST['full_name'] ?? ''), 'email' => trim($_POST['email'] ?? ''),
        'whatsapp' => trim($_POST['whatsapp'] ?? ''), 'address' => trim($_POST['address'] ?? ''),
        'program_id' => (int)($_POST['program_id'] ?? 0), 'batch_id' => (int)($_POST['batch_id'] ?? 0),
    ];
    header('Location: ' . url('pages/konfirmasi.php')); exit;
}
$sel = (int)($_GET['program'] ?? 0);
include ROOT . '/includes/header.php';
?>
<main class="form-wrap">
  <div class="steps"><b>1. DATA DIRI</b><span>2. KONFIRMASI</span><span>3. PEMBAYARAN</span></div>
  <form method="post" class="card p-3 shadow-sm">
    <h2>Form Pendaftaran</h2><p>Silakan lengkapi data Anda untuk mendaftar program.</p>
    <h3>Informasi Pribadi</h3>
    <label>Nama Lengkap<input class="form-control" name="full_name" placeholder="Masukkan nama sesuai KTP" required></label>
    <label>Email<input class="form-control" type="email" name="email" placeholder="example@mail.com" required></label>
    <label>Nomor WhatsApp<input class="form-control" name="whatsapp" placeholder="0812xxxx" required></label>
    <label>Alamat Lengkap<textarea class="form-control" rows="3" name="address" placeholder="Alamat rumah saat ini" required></textarea></label>
    <h3>Program &amp; Jadwal</h3>
    <label>Program yang Dipilih<select class="form-select" name="program_id" required>
      <?php foreach ($programs as $p): ?><option value="<?= $p['id'] ?>" <?= $sel==$p['id']?'selected':'' ?>><?= e($p['name'].' ('.$p['level_label'].')') ?></option><?php endforeach; ?></select></label>
    <p>Pilih Batch / Gelombang</p>
    <?php foreach ($batches as $i => $b): ?>
      <label class="radio"><input type="radio" name="batch_id" value="<?= $b['id'] ?>" <?= $i===0?'checked':'' ?>> <b><?= e($b['name']) ?></b> <small><?= e($b['status']) ?></small></label>
    <?php endforeach; ?>
    <label class="radio"><input type="checkbox" required> Saya menyetujui syarat dan ketentuan pendaftaran serta kebijakan privasi Skilvara English Center.</label>
    <button class="btn btn-dark w-100 py-2" type="submit">Lanjut ke Konfirmasi</button>
    <small>Data Anda terjamin kerahasiaannya dan hanya digunakan untuk keperluan administrasi.</small>
  </form>
</main>
<?php include ROOT . '/includes/footer.php'; ?>
