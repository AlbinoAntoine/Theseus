<div class="detail-content" data-task-id="<?= $task->Id_Task ?>">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="tilte" name="title" placeholder="Task title" value="<?= $task->Titre ?? '' ?>">
            <label for="tilte">Task title</label>
        </div>
        <div class="form-floating mb-3">
            <input type="time" class="form-control" id="duration" name="duration" placeholder="Task duration" value="<?= time_to_hm($task->Duration) ?? '01:00' ?>">
            <label for="duration">Estimate the duration</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="" id="note" name="note" style="height: 100px"><?= $task->Note ?? '' ?></textarea>
            <label for="note">Add a note</label>
        </div>
        <div class="form-floating mb-3">
            <?php $options = [0=> 'Not assigned']; ?>
            <?= form_dropdown($name = 'member', $options += $listMembers, $task->Id_User ?? 0, 'class="form-select" id="members"') ?>
            <label for="members">Assign the task to a member</label>
        </div>
        <div class="form-floating mb-3">
            <input type="number" class="form-control" id="priority" name="priority" placeholder="Task Priority" value="<?= $task->Priority?>">
            <label for="priority">Task Priority</label>
        </div>
        <input type="hidden" value="<?= $task->Id_Task ?>" name="id_task">
        <div class="mt-3">
            <button type="submit" class="btn btn-theseus">Update</button>
            <button type="button" class="btn btn-danger btnDeleteTask" style="float: right"><i class="far fa-trash-alt"></i></button>
        </div>
</div>