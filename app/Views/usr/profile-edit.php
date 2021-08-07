<?= $this->extend('usr/layouts/pg_home') ?>
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
                <label for="name">Full name</label>
                <input class="form-control mt-2" type="text" id="name" name="name" placeholder="full name" value="<?= session()->name; ?>" />
            </div>
            <div class="form-group mt-2">
                <label for="username">Username</label>
                <input class="form-control mt-2" type="text" id="username" name="username" placeholder="username" value="<?= session()->username; ?>" />
            </div>
            <button class="btn btn-purp-light mt-2" type="submit" id="submit" value="submit">Save</button>
        </form>
    </div>
</div>

<!-- end of card -->
<?= $this->endSection() ?>