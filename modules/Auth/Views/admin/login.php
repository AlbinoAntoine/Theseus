<?= $this->extend('\Modules\Coladm\Views\html_template') ?>

<?= $this->section('layout') ?>

    <main>
        <div class="container">
            <div style="text-align: center;margin: 50px">
                <h1>Connexion Admin</h1>
                <p><a href="<?=site_url()?>">← Retour sur Colaco</a></p>
            </div>
            <?= form_open('', 'novalidate') ?>

            <div class="container">
                <div class="row">
                    <div class="col-4 offset-4">

                        <?= $validation->getErrors() ? $validation->listErrors('my_list') : '' ?>

                        <div class="form-floating mb-3">
                            <?php echo form_input('mailadmin', set_value('mailadmin', '', FALSE), 'id="mailadmin" class="form-control" placeholder=""'); ?>
                            <label for="mailadmin">Email administrateur</label>
                        </div>
                        <div class="form-floating mb-1">
                            <?php echo form_input('password', set_value('password', '', FALSE), 'id="password" class="form-control" placeholder=""', 'password'); ?>
                            <label for="password">Mot de passe</label>
                        </div>
                        <div class="mb-2 text-end"><a href="<?= site_url('connexion/admin/mot-de-passe-oublie') ?>">Mot de passe oublié ?</a></div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" name="rememberme" type="checkbox" value="1" id="rememberme"<?= set_checkbox('rememberme', '1', false) ?>>
                            <label class="form-check-label" for="rememberme">
                                Rester connecté pendant 30 jours
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Connexion</button>
                        </div>

                    </div>
                    <?= form_close() ?>
                </div>
    </main>

<?= $this->endSection() ?>