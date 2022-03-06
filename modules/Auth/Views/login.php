<?= $this->extend('Modules\Commun\Views\layouts\general_public') ?>

<?= $this->section('content') ?>
<?php helper('form')?>
    <main>
        <div class="container">
            <div class="row connexion">
                <div class="col-md-12 col-lg-6 mb-5 mt-5 m-auto">
                    <div class="card mr-1 p-3">
                        <div class="card-body">
                            <?php if(!empty($validation)) echo $validation->listErrors('my_list'); ?>
                            <?= form_open(site_url('login')) ?>
                            <div class="">
                                <h5 class="card-title text-center">Login</h5>
                                    <div class="form-floating mb-3 mt-4">
                                        <?php echo form_input('email', set_value('email', '', FALSE), 'id="email" class="form-control" placeholder="E-mail"'); ?>
                                        <label for="email">E-mail</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <?php echo form_input('password', set_value('password', '', FALSE), 'id="password" class="form-control" placeholder="Password"', 'password'); ?>
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="form-check mb-1 mt-2">
                                        <?php echo form_input('rememberme', 'true', 'id="rememberme" class="form-check-input" placeholder=""', 'checkbox'); ?>
                                        <label class="ms-2" for="rememberme">Remember me</label>
                                    </div>
                            </div>
                                <div class="text-end mt-3">
                                    <p>You don't have an account ? <a href="<?=site_url('register')?>">Register</a></p>

                                    <button type="submit" class="btn btn-theseus ">Login</button>
                                </div>

                            <?= form_close() ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

<?= $this->endSection() ?>