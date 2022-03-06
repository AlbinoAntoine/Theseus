<div class="modal fade" id="updateProject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProjectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProjectLabel">Modify the project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?=site_url('update_project')?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="idProject" value="<?=$project->Id_Projet?>">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="tilte" name="title" placeholder="" value="<?=$project->Name?>" required>
                        <label for="tilte">Project title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="" id="description" name="description" style="height: 100px"><?=$project->Description?></textarea>
                        <label for="description">Description</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-theseus">Modify</button>
                </div>
            </form>
        </div>
    </div>
</div>