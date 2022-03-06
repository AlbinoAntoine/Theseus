<?= $this->extend('Modules\Commun\Views\layouts\general') ?>

<?= $this->section('content') ?>
<div class="container content">
    <div class="header-projet">
        <div class="btn-group" role="group" aria-label="Basic outlined example">
            <h1 class="btn btn-theseus"><?= $projet->Name ?></h1>
            <a href="<?= site_url('/user_profile/' . $projet->CreatedBy) ?>" class="btn btn-outline-principal">
                by <strong><?= findUser_name($projet->CreatedBy) ?></strong></a>
            <a href="#members" class="btn btn-outline-principal"> <?= $nbr_members ?? 1 ?> members</a>
            <div class="btn btn-outline-principal">Total estimated time : <b><?=$total['Time']?> h</b></div>
            <div class="btn btn-outline-principal">
                Total estimated cost : <b><?= number_format(round($total['Cost'], 2),2,".", ' ') ?> € </b>
            </div>
        </div>
    </div>
    <h2>Project steps</h2>
    <div class="container-step mb-5">
        <div class="etape-projet">
            <?php foreach ($listSteps as $step) { ?>
                <div class="pe-4">
                    <div class="card step" style="width: 18rem; min-height: 72px">
                        <div class="card-body">
                            <h4 class="step-title">
                                <a href="<?= site_url('/project/' . $projet->Id_Projet . '/step/' . $step->Id_Step) ?>">
                                    <?= $step->Name ?? 'Step'?>
                                </a>
                            </h4>
                            <span class="step-time">estimated time : <?=round($step->Time,1) ?? 0?> h</span>
                            <div class="pourcentage">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?= $pourcentage[$step->Id_Step] ?>"
                                         aria-valuenow="<?= $pourcentage[$step->Id_Step] ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div><?= $pourcentage[$step->Id_Step] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div>
                <div class="card step" style="width: 18rem; height: 72px">
                    <div class="card-body">
                        <h4 class="step-title">
                            <a href="<?= site_url('project/' . $projet->Id_Projet . '/step/new_step') ?>">
                                Create a new step <i class="fas fa-plus"></i>
                            </a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($is_role == 0){ ?>
        <h2 id="members">Members <button style="float: right" class="btn btn-theseus" id="add_member" data-idProject="<?=$projet->Id_Projet?>">Add member</button></h2>
        <div class="accordion mb-5" id="accordionMembers" style=" max-width: 900px">
            <?php foreach ($listMembers as $id_member => $member) { ?>
                <div class="accordion-item">
                    <div class="accordion-header member-card" id="member-<?= $id_member ?>">
                        <a class="link-profile " href="<?= site_url('profile/'.$member['id_user']) ?>">
                            <div class="profile-picture me-3">
                                <?php
                                $creator = '';
                                if ($projet->CreatedBy == $member['id_user']){ echo '<div class="icone_membre"><i class="fas fa-crown"></i></div>'; $creator = 'disabled';}
                                elseif ($member['role']==0) { echo '<div class="icone_membre"><i class="fas fa-star"></i></div>';}?>
                                <?= get_ppUser($member['id_user']) ?>
                            </div>
                            <strong><?= $member['member'] ?></strong>
                        </a>
                        <span>Total estimated time :
                            <span
                                class="fw-bold ms-2"><?= round($member['totalTime'],1) ?> h
                            </span>
                        </span>
                        <span>Total estimated cost :
                            <span class="fw-bold ms-2">
                                <?= number_format(round($member['totalTime'] * $member['salaire'], 2),2,".", ' ') ?> €
                            </span>
                        </span>
                        <?php if ($is_role == 0){ ?>
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#member-<?= $id_member ?>-info" aria-expanded="false"
                                aria-controls="member-<?= $id_member ?>-info"></button>
                        <?php } ?>
                    </div>
                    <?php if ($is_role == 0){ ?>
                    <div id="member-<?= $id_member ?>-info" class="accordion-collapse collapse"
                         aria-labelledby="member-<?= $id_member ?>" data-bs-parent="#accordionMembers">
                        <div class="accordion-body">
                            <form class="form-member">
                                <input id="sa" type="hidden" class="text-end ms-2" name="member_id" value="<?= $id_member ?>">
                                <div>
                                    <label>
                                        <b>Salary : </b>
                                        <input type="number" class="text-end ms-2" name="salary"
                                               value="<?= $member['salaire'] ?? ' ' ?>" style="width: 120px">
                                        €/hour
                                    </label>
                                </div>
                                <div class="mt-3">
                                    <label>
                                        <b>Role : </b>
                                    <?php
                                    helper('form');
                                    $options = [
                                        '0'  => 'Administrator',
                                        '1'    => 'Editor',
                                    ];
                                    echo form_dropdown('role', $options, $member['role'],'id="Role"'.$creator);
                                    ?>
                                    </label>
                                </div>
                                <div class="mt-3 text-end">
                                    <?php if ($member['role']!=0){ ?>
                                        <button type="button" data-idMember="<?= $id_member?>" class="btn btn-danger RemoveThisMember" <?=$creator?>>Remove Member</button>
                                    <?php } ?>
                                    <button type="submit" class="btn btn-theseus ">Update Member</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <h2>Project details</h2>
    <p>
        Created by <a href="<?= site_url('/user_profile/' . $projet->CreatedBy) ?>"><?= findUser_name($projet->CreatedBy) ?></a>
        on <?= date("Y-m-d", strtotime($projet->Date_Creation)); ?>
    </p>
    <div class="part-description">
        <p><?= $projet->Description ?></p>
    </div>
</div>

<?= $this->endSection() ?>
