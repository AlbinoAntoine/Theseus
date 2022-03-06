<?= $this->extend('Modules\Commun\Views\layouts\general') ?>

<?= $this->section('content') ?>
<div class="container content profile">
    <div class="row mt-5">
        <div class="col-2">
            <div class="profile-picture">
                <?php if($myProfile){ ?>
                    <a class="update_pp" href="<?=site_url('profile/'.$profile->Id_User.'/update_image')?>">
                        <div class="edit-pp">
                            <i class="fas fa-camera"></i>
                        </div>
                <?php } ?>
                <?= get_ppUser($profile->Id_User) ?>
                <?php if ($myProfile){ ?>
                    </a>
                <?php } ?>
            </div>
        </div>
        <div class="col-8">
            <h1><?= $profile->Nom .' '.$profile->Prenom ?></h1>
            <div class="linkOnProfile">
                <?php //TODO : Ajouter base de donné link ?>
            </div>
            <div>
                <?php if($profile->Id_User == $_SESSION["Session_User"]["Id_User"]){ ?>
                    <label for="bio"><b>Bio :</b></label>
                    <textarea style="width: 100%; max-width: 800px; min-height: 150px; display: block"  placeholder="Describe yourself..." id="bio" name="note" ><?= $profile->Bio ?? '' ?></textarea>
                    <button class="btn btn-theseus mt-2" disabled>Update </button>
                <?php }else{ ?>
                    <div> <p><?=$profile->Bio ?? ''?></p></div>
                <?php } ?>
            </div>
        </div>
        <div class="col-2">
<!--            <a class="btn btn-theseus" disabled href="--><?php //site_url('message/'.$profile->Id_User)?><!--">Contact</a>-->
            <button class="btn btn-theseus" disabled>Contact</button>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
