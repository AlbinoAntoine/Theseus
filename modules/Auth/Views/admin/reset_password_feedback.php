<?= $this->extend('\Modules\Welcome\Views\layout') ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <h1>Mot de passe mis à jour</h1>
        <a href="<?= site_url('coladm')?>">Retour au formulaire de connexion</a>
    </div>
</main>
<?= $this->endSection() ?>