<?= $this->extend('Modules\Commun\Views\layouts\general_public') ?>

<?= $this->section('content') ?>

<main class="container">

    <h1 class="mt-4">Settings</h1>
    <form action="" method="post" id="formSettings">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="darkmode" value="1" role="switch" id="darkMode" <?php if(!empty($_SESSION['Session_User']['Dark_Mode']))echo 'checked'?>>
            <label class="form-check-label" for="darkMode">Dark mode</label>
        </div>
    </form>

</main>


<?= $this->endSection() ?>
