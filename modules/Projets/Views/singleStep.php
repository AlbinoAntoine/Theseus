<?= $this->extend('Modules\Commun\Views\layouts\general') ?>

<?= $this->section('content') ?>
<div class="container content">
    <div class="allAbout-task">
        <div class="general-task">
            <div class="row">

                <div class="modifiable col-6">
                    <form id="update-title-step">
                        <i class="fas fa-edit"></i>
                        <input id="title-step" required value="<?= $step->Name ?>">
                    </form>
                </div>
                <div class="col-6 text-end">
                    <a class="btn btn-theseus" href="<?=site_url('project/'.$projet->Id_Projet)?>"><i class="fas fa-arrow-left"></i> Back to project</a>
                </div>
            </div>
                <div class="pourcentage">
                <div class="progress">
                    <div class="progress-bar" id="progress" role="progressbar"
                         style="width: <?= $pourcentage ?>" aria-valuenow="25"
                         aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div id="val-progress"><?= $pourcentage ?></div>
            </div>
            <div class="task-content me-3">
                <div class="list-task">
                    <strong>To do :</strong>
                    <div id="task-toDo" class="me-3">
                        <?php foreach ($listTasks as $task) { ?>
                            <?php if (!$task->Validate) { ?>
                        <div class="card task mb-1" id="<?= $task->Id_Task ?>">
                            <input class="form-check-input validate-task" type="checkbox" name="validate-task"
                                   value="validate">
                            <div class="card-body select-task body-task">
                                    <?= $task->Titre ?>
                            </div>
                            <?php if ($task->Id_User != 0){ ?>
                            <a href="<?=site_url('profile/'.$task->Id_User)?>" class="profile-picture task-pp" title="<?=findUser_name($task->Id_User)?>">
                                <?= get_ppUser($task->Id_User) ?>
                            </a>
                            <?php } ?>
                            <div class="priority_task">
                                <?php if ($task->Priority != 0 || $task->Priority != null){
                                    echo '#'.$task->Priority;
                                } ?>
                            </div>
                        </div>
                            <?php } else {
                                $tabTaskFinished[] = $task;
                            }
                        } ?>
                    </div>
                    <div id="task-Finished" class="me-3">
                        <b class="finishedTilte" <?php if (empty($tabTaskFinished)){ echo 'style="display:none"'; $nbrTask=0;} else $nbrTask = count($tabTaskFinished) ?>>Finished (<span id="countTask" ><?= $nbrTask ?></span>) :</b>
                        <?php if (!empty($tabTaskFinished)) { ?>
                            <?php foreach ($tabTaskFinished as $taskFinished) { ?>
                                <div class="card task mb-1" id="<?= $taskFinished->Id_Task ?>">
                                    <input class="form-check-input validate-task" type="checkbox" name="validate-task" checked
                                           value="validate">
                                    <div class="card-body select-task"><?= $taskFinished->Titre ?></div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
                <div class="mt-3">
                    <form method="post" id="add-task" action="<?= site_url('action/add_task') ?>">
                        <div class="input-group mb-3">
                            <input class="form-control add-task" type="text" name="titleTask" value=""
                                   placeholder="Ajoutez une tâche" autocomplete="off">
                            <input id="idStep" type="hidden" name="idStep" value="<?= $step->Id_Step ?>">
                            <input id="idProject" type="hidden" name="idProject" value="<?= $step->Id_Projet ?>">
                            <button class="btn btn-theseus" type="submit" id="button-add-task">Add Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <div class="detail-task">
                <form id="modifTask" method="post">
                    <div class="text-end">
                        <button type="button" class="btn-close" id="close-detail-task" aria-label="Close" ></button>
                    </div>
                    <div id="container-detail-task">

                    </div>
                </form>
            </div>
    </div>
</div>


    <?= $this->endSection() ?>
