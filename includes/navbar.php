<?php $active = $active ?? ''; ?>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?= url('index.php') ?>"><img src="<?= url('assets/images/logo.png') ?>" alt="Skilvara" height="40"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-label="Menu"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav mx-auto gap-lg-4 fw-semibold">
        <li class="nav-item"><a class="nav-link <?= $active==='home'?'active text-decoration-underline':'' ?>" href="<?= url('index.php') ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= $active==='profil'?'active text-decoration-underline':'' ?>" href="<?= url('pages/profil.php') ?>">Profil</a></li>
        <li class="nav-item"><a class="nav-link <?= $active==='program'?'active text-decoration-underline':'' ?>" href="<?= url('pages/program.php') ?>">Program</a></li>
        <li class="nav-item"><a class="nav-link <?= $active==='contact'?'active text-decoration-underline':'' ?>" href="<?= url('pages/contact.php') ?>">Contact</a></li>
      </ul>
      <?php if (empty($hideCta)): ?><a href="<?= url('pages/pendaftaran.php') ?>" class="btn btn-warning text-white fw-semibold">Daftar Sekarang</a><?php endif; ?>
    </div>
  </div>
</nav>
