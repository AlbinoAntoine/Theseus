<?= $this->extend('\Modules\Welcome\Views\layout') ?>

<?= $this->section('content') ?>
    <main>
        <div class="container">
            <h1>Réinitialisation mot de passe compte administrateur</h1>
            <div class="row">
                <div class="col-3">
                    <p class="text-heading fw-bold"><strong class="fw-bolder">Vous avez oublié vos codes d'accès ? Merci de remplir le formulaire ci-contre. Nous vous enverrons vos codes par e-mail.</strong></p>
                    <p><em>Les champs marqués d'un * sont&nbsp;obligatoires.</em></p>
                </div>

                <div class="col-9">
                    <?= form_open('', 'novalidate') ?>
                    <p>Le nouveau mot de passe doit contenir au moins une majuscule, un symbole (!@#$&*-), un chiffre et doit faire plus de 8 caractères</p>
                    <div class="row mb-2">
                        <label class="col-4 col-form-label text-end" for="new_password">Nouveau mot de passe *</label>
                        <div class="col-8">
                            <?php echo form_input('new_password', '', 'id="new_password" class="form-control" pattern="^(?=.*[A-Z])(?=.*[!@#$&*-])(?=.*[0-9]).{8,}$" autocomplete = "off"','password'); ?>
                            <div class="invalid-feedback"><?php echo $validation->getError('new_password') ?></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-4 col-form-label text-end" for="confirm_password">Confirmez le mot de passe *</label>
                        <div class="col-8">
                            <?php echo form_input('confirm_password', '', 'id="confirm_password"  class="form-control"','password'); ?>
                            <div class="invalid-feedback"><?php echo $validation->getError('confirm_password') ?></div>
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