<?= $this->extend('usr/layouts/pg_project') ?>
<?= $this->section('content') ?>
<!-- card -->
<div class="notif-card">
    <div class="notif-card-item">
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo session()->getflashdata('error'); ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group mt-2">
                <label for="name">Project name</label>
                <input class="form-control mt-2" type="text" id="name" name="name" placeholder="project name" value="<?= $project['name']; ?>" />
            </div>
            <div class="form-group mt-2">
              <label for="desc mb-2" id="label-description">Description :</label>
              <textarea id="desc" name="desc" rows="1" spellcheck="false" class="form-control form-area mt-2"><?= $project['description']; ?></textarea>
            </div>
            <button class="btn btn-purp-light mt-2" type="submit" id="submit" value="submit">Save</button>
            <a href="<?= base_url('/dasboard').'/'.$project['IDproject']; ?>" class="btn btn-border-purp mt-2">Cancel</a>
            <a onclick="deleteConfirm('<?= base_url('/delete-project').'/'.$project['IDproject']; ?>')" href="#!" data-bs-toggle="modal" data-bs-target="#delete_project" class="btn btn-outline-danger mt-2">Delete project</a>
        </form>
    </div>
</div>
<!-- end of card -->
<?= $this->endSection() ?>