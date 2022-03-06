<?= $this->extend('Modules\Commun\Views\layouts\general_public') ?>

<?= $this->section('content') ?>

<section class="homeSection">

    <div class="home-content">
        <h1>The perfect <br>
            Project Management <br>
            Toolbox </h1>
        <p style="font-size: 2.5vw"><i>Theseus provides you with simple tools for carry out your projects.</i></p>

        <a class="btn btn-theseus" href="<?=site_url('login')?>">Let's start now !</a>
    </div>
    <img src="<?=base_url('assets/images/presentation.png')?>">
</section>


<?= $this->endSection() ?>
