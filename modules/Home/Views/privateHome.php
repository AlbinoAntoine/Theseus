<?= $this->extend('Modules\Commun\Views\layouts\general') ?>

<?= $this->section('content') ?>
<div class="container-fluid content">
    <div class="row">
        <div class="col-2 d-none d-lg-block sidebar-projet">
            <h3>Projects I created</h3>
            <ul class="sidebar-list">
                <?php foreach ($listProjets as $projet) { ?>
                    <li><a class="btn btn-sidebar"
                           href="<?= site_url('project/' . $projet->Id_Projet) ?>"><?= $projet->Name ?></a></li>
                <?php } ?>
            </ul>
            <?php if(!empty($memberProjets)){ ?>
            <hr>
            <h3>Projects when I am member</h3>
            <ul class="sidebar-list">
                <?php foreach ($memberProjets as $memberProjet) { ?>
                    <li><a class="btn btn-sidebar"
                           href="<?= site_url('project/' . $memberProjet->Id_Projet) ?>"><?= $memberProjet->Name ?></a></li>
                <?php } ?>
            </ul>
            <?php } ?>
        </div>
        <div class="col-12 col-lg-10 m-md-auto">
            <h3>Projects I created <button class="btn btn-theseus ms-3" id="createProject"><i class="fas fa-plus"></i> New Project</button></h3>
            <div class="listeProjets">
                <?php foreach ($listProjets as $projet) { ?>
                    <div>
                        <div class="card" style="width: 18rem; height: 300px" id="<?=$projet->Id_Projet?>">
                            <div class="card-img-top">
                                <img style="max-width: 90%; max-height: 90%" src="<?=base_url('assets/images/logo_theseus_white.png')?>" class=" m-auto mt-3" alt="thumbnail <?= $projet->Name ?>">
                            </div>
                            <div class="card-body projet-card">
                                <h5 class="card-title">
                                    <a href="<?=site_url('project/'. $projet->Id_Projet)?>"><?= $projet->Name ?></a>
                                    <div class="dropdown" style="float: right">
                                        <button class="btn project-option dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item modifyProject" href="javascript:">Modify Project</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item deleteProject" href="<?=site_url('delete_project/'.$projet->Id_Projet)?>" style="color: red" >Delete Project</a></li>
                                        </ul>
                                    </div>
                                </h5>

                                <p class="card-text"><?= limitString($projet->Description, 100) ?></p>

                            </div>
                            <div class="card-footer">
                                <p>
                                    <?php if ($projet->CreatedBy == $_SESSION['Session_User']['Id_User']) { ?>
                                        Created by <?= findUser_name($projet->CreatedBy) ?> <br>
                                    <?php } else { ?>
                                        Created by <?= $projet->CreatedBy ?><br>
                                    <?php } ?>
                                    Modified on <?= $projet->Date_Update ?><br>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php }
                if (empty($listProjets)) {
                    echo "<p>Your created projects will appear here</p>";
                } ?>
            </div>
            <h3>Projects of which I am a member </h3>
            <div class="listeProjets">
                <?php foreach ($memberProjets as $memberProjet) { ?>
                    <div>
                        <div class="card" style="width: 18rem; height: 300px" id="<?=$memberProjet->Id_Projet?>">
                            <div class="card-img-top">
                                <img style="max-width: 90%; max-height: 90%" src="<?=base_url('assets/images/logo_theseus_white.png')?>" class=" m-auto mt-3" alt="thumbnail <?= $memberProjet->Name ?>">
                            </div>
                            <div class="card-body projet-card">
                                <h5 class="card-title">
                                    <a href="<?=site_url('project/'. $memberProjet->Id_Projet)?>"><?= $memberProjet->Name ?></a>
                                    <div class="dropdown" style="float: right">
                                        <button class="btn project-option dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item deleteProject" href="<?=site_url('leave_project/'.$memberProjet->Id_Projet)?>" style="color: red" >Leave this project</a></li>
                                        </ul>
                                    </div>
                                </h5>

                                <p class="card-text"><?= limitString($memberProjet->Description, 100) ?></p>

                            </div>
                            <div class="card-footer">
                                <p>
                                    <?php if ($memberProjet->CreatedBy == $_SESSION['Session_User']['Id_User']) { ?>
                                        Created by <?= findUser_name($memberProjet->CreatedBy) ?> <br>
                                    <?php } else { ?>
                                        Created by <?= $memberProjet->CreatedBy ?><br>
                                    <?php } ?>
                                    Modified on <?= $memberProjet->Date_Update ?><br>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php }
                if (empty($memberProjets)) {
                    echo "<p>The projects you are a member of will appear here</p>";
                } ?>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
