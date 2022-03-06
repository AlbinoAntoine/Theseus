<?= $this->extend('Modules\Commun\Views\layouts\general_public') ?>

<?= $this->section('content') ?>

<main>
    <div class="col-md-12">
        <div class="card m-auto mt-3 mb-5" style="max-width: 800px">
            <div class="card-body">
                <div class="text-center">
                    <h5 class="card-title">Register</h5>
                    <?= form_open(site_url('register')) ?>
                    <div class="form-floating mb-3 mt-4">
                        <?php echo form_input('nom', set_value('nom', '', FALSE), 'id="nom" class="form-control" placeholder=""'); ?>
                        <label for="nom">Last Name</label>
                    </div>
                    <div class="form-floating mb-3 mt-4">
                        <?php echo form_input('prenom', set_value('prenom', '', FALSE), 'id="prenom" class="form-control" placeholder=""'); ?>
                        <label for="nom">First Name</label>
                    </div>
                    <div class="form-floating mb-3 mt-4">
                        <?php echo form_input('email', set_value('email', '', FALSE), 'id="email" class="form-control" placeholder=""'); ?>
                        <label for="nom">E-mail</label>
                    </div>
                    <div class="form-floating mb-1">
                        <?php echo form_input('password', set_value('password', '', FALSE), 'id="password" class="form-control" placeholder=""', 'password'); ?>
                        <label for="password">Password</label>
                    </div>
                    <div class="form-floating mb-1">
                        <?php echo form_input('password2', set_value('password2', '', FALSE), 'id="password2" class="form-control" placeholder=""', 'password'); ?>
                        <label for="password2">Repeat Password</label>
                    </div>
                </div>
                <div class=" mb-1 mt-2">
                    <?php echo form_input('conditions', 'true', 'id="conditions" class="form-check-input" placeholder="" required', 'checkbox'); ?>
                    <label class="ms-2" for="conditions">I accept the <a href="<?=site_url('conditions_of_use')?>">general conditions of use</a></label>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-theseus mt-3 ">Register</button>
                </div>
                <?= form_close() ?>
                </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>