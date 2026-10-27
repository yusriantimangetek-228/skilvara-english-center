<?php /* Variabel: $title, $active, $hideCta */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? 'Skilvara English Center') ?> | Skilvara</title>
  <link rel="stylesheet" href="<?= url('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body>
<?php include ROOT . '/includes/navbar.php'; ?>
