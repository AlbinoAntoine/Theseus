<?= $this->extend('\Modules\Welcome\Views\layout') ?>

<?= $this->section('content') ?>
    <main>
        <div class="container">
            <h1>Formulaire récupération du mot de passe compte administrateur</h1>
            <div class="row">
                <div class="col-3">
                    <p class="text-heading fw-bold"><strong class="fw-bolder">Vous avez oublié vos codes d'accès ? Merci de remplir le formulaire ci-contre. Nous vous enverrons vos codes par e-mail.</strong></p>
                    <p><em>Les champs marqués d'un * sont&nbsp;obligatoires.</em></p>
                </div>

                <div class="col-9">
                    <?= form_open('', 'novalidate') ?>
                    <div class="row mb-2">
                        <label class="col-4 col-form-label text-end" for="email">Email *</label>
                        <div class="col-8">
                            <?php echo form_input('email', set_value('email', '', FALSE), 'id="contact-name" class="form-control' . ($validation->getError('email') ? ' is-invalid' : '') . '" placeholder=""'); ?>
                            <div class="invalid-feedback"><?php echo $validation->getError('email') ?></div>
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