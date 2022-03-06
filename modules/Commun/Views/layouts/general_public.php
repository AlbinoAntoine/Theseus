<?= $this->extend('Modules\Commun\Views\partials\htmlTemplate') ?>

<?= $this->section('layout') ?>
<?= $this->include('Modules\Commun\Views\partials\header') ?>
<?= $this->renderSection('content') ?>
<?= $this->include('Modules\Commun\Views\partials\footer') ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    <!-- some css -->
<?= $this->renderSection('css') ?>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
    <!-- some js -->
<?= $this->renderSection('js') ?>
<?= $this->endSection() ?>