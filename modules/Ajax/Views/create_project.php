<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?=site_url('create_project')?>" method="post">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="tilte" name="title" placeholder="" value="" required>
                        <label for="tilte">Project title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="" id="description" name="description" style="height: 100px"></textarea>
                        <label for="description">Description</label>
                    </div>
                    <hr>
                    <b>Add member :</b>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="member" name="member" placeholder="" value="">
                        <label for="member">Search member</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-theseus">Create Project</button>
                </div>
            </form>
        </div>
    </div>
</div>