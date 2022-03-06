<?= $this->extend('Modules\Commun\Views\layouts\general') ?>

<?= $this->section('content') ?>
<div class="container content profile m-auto">
    <div class="mt-5 m-auto">
        <form action="" method="POST" class="text-center" enctype="multipart/form-data">
            <?php if (!empty($validation)){
                foreach ($validation->getErrors() as $error) {
                    echo '<p class="bg-danger">'.$error.'</p>';
                }
            }?>
            <label for="formFile" class="form-label">Import your new profile picture <i>(only jpg accepted, max size : 1,5Mbits)</i>
            <input class="form-control" type="file" name="pp_user" id="formFile" required>
            </label>
            <div>
                <input class="mb-3 btn btn-theseus" type="submit" value="Add new profile picture">
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
