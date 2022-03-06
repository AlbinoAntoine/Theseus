<!doctype html>
<html lang="fr">
<head>
    <title><?= $title ?? "Theseus" ?></title>
    <meta charset="utf-8">
    <meta name="description" content="<?= esc($description ??'', 'attr') ?>">
    <meta name="viewport" content="width=device-width">
    <!--    <link rel="manifest" href="--><?//=base_url('site.webmanifest')?><!--">-->
    <script src="https://kit.fontawesome.com/3b408982be.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="<?= base_url('assets/css/bootstrap.css') ?>" rel="stylesheet"><link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600&display=swap" rel="stylesheet">
    <script src="<?= base_url('assets/js/front.js') ?>" type="text/javascript" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    <link href="<?= base_url('assets/css/front.css') ?>" rel="stylesheet">
    <?= $this->renderSection('css') ?>
</head>
<body class="<?=$page_name ?? ''?> <?=check_darkmode($_SESSION['Session_User']['Dark_Mode'] ?? 0); ?>">
<?php // var_dump($_SESSION['Session_User']['Dark_Mode'])?>
<?= $this->renderSection('layout') ?>
<script>
    var siteUrl = '<?=site_url()?>';
    var getUrl = window.location;
    var baseUrl = '<?=base_url()?>';
</script>

<?= $this->renderSection('js') ?>
</body>
</html>