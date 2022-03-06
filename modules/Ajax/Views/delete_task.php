<div class="modal fade" id="deleteTask" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProjectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProjectLabel">Delete the task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>" <?=$Task->Titre ?> " will be permanently deleted</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?=site_url('delete_task/'. $Task->Id_Task).'?lastUrl='.base64_encode($lastUrl)?>" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>