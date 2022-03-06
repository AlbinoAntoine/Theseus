<?= $this->extend('\Modules\Welcome\Views\layout') ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <h1>Mot de passe oublié</h1>
        <div class="row">
            <div class="col-3">
                <p class="text-heading fw-bold"><strong class="fw-bolder">Vous avez oublié vos codes d'accès ? Merci de remplir le formulaire ci-contre le plus précisément possible. Nous vous enverrons vos codes par e-mail.</strong></p>
                <p><em>Les champs marqués d'un * sont&nbsp;obligatoires.</em></p>
            </div>
            <div class="col-9">
                <?= form_open('', 'novalidate') ?>
                <div class="row mb-2">
                    <label class="col-4 col-form-label text-end" for="name">Nom et prénom *</label>
                    <div class="col-8">
                        <?php echo form_input('name', set_value('name', '', FALSE), 'id="contact-name" class="form-control' . ($validation->getError('name') ? ' is-invalid' : '') . '" placeholder=""'); ?>
                        <div class="invalid-feedback"><?php echo $validation->getError('name') ?></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-4 col-form-label text-end" for="mail">E-mail *</label>
                    <div class="col-8">
                        <?php echo form_input('mail', set_value('mail', '', FALSE), 'id="contact-mail" class="form-control' . ($validation->getError('mail') ? ' is-invalid' : '') . '" placeholder=""', 'email'); ?>
                        <div class="invalid-feedback"><?php echo $validation->getError('mail') ?></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-4 col-form-label text-end" for="phone">Téléphone</label>
                    <div class="col-8">
                        <?php echo form_input('phone', set_value('phone', '', FALSE), 'id="contact-phone" class="form-control' . ($validation->getError('phone') ? ' is-invalid' : '') . '" placeholder=""'); ?>
                        <div class="invalid-feedback"><?php echo $validation->getError('phone') ?></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-4 col-form-label text-end" for="codeclient">Code client *</label>
                    <div class="col-8">
                        <?php echo form_input('codeclient', set_value('codeclient', '', FALSE), 'id="contact-codeclient" class="form-control' . ($validation->getError('codeclient') ? ' is-invalid' : '') . '" placeholder=""'); ?>
                        <div class="invalid-feedback"><?php echo $validation->getError('codeclient') ?></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-4 col-form-label text-end" for="organisation">Organisme *</label>
                    <div class="col-8">
                        <?php echo form_input('organisation', set_value('organisation', '', FALSE), 'id="contact-organisation" class="form-control' . ($validation->getError('organisation') ? ' is-invalid' : '') . '" placeholder=""'); ?>
                        <div class="invalid-feedback"><?php echo $validation->getError('organisation') ?></div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="offset-4 col-8">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

</main>
<?= $this->endSection() ?>