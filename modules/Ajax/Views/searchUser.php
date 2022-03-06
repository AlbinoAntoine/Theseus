<?php foreach ($members as $member){ ?>
    <div class="researchedUser">
        <a class="link-profile" href="<?=site_url('profile/'.$member->Id_User)?>" target="_blank">
            <div class="profile-picture me-3">
                    <?php if (file_exists(FCPATH . "content/profile_picture/pp_" . $member->Id_User . ".jpg")) {
                        echo "<img src=" . base_url("content/profile_picture/pp_" . $member->Id_User . ".jpg") . ' alt="<?=$member?> profile picture">';
                    } else {
                        echo '<img src=' . base_url("content/profile_picture/pp_default.jpg") . ' alt="Default profile picture">';
                    } ?>
             </div>
             <strong><?= $member->Nom .' '.$member->Prenom ?></strong>
        </a>
        <div>
            <?php if (empty($member->Id_Member)){ ?>
                <button id="<?=$member->Id_User?>" class="btn btn-theseus addThisMember" >Add to this project</button>
            <?php }else{ ?>
                <button class="btn btn-theseus" disabled>Already on this project</button>
            <?php } ?>
        </div>
    </div>
<?php } ?>