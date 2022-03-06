<div class="modal fade" id="modal_addMember" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProjectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProjectLabel">Add member to the project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idProject" name="idProject" value="<?=$project->Id_Projet?>">
                <div class="form-floating mb-1">
                    <input type="text" class="form-control" id="searchUser" name="searchUser" placeholder="" value="">
                    <label for="searchUser">Research User</label>
                </div>
                <div style="min-height: 30px">
                    <div id="infoReturn" style="display: none;"></div>
                </div>
                <div class="mt-1" id="listSearchedUser"></div>
            </div>
        </div>
    </div>
</div>