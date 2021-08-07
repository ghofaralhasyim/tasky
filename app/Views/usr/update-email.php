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
        <form action="<?= base_url('/update-email') ?>" method="POST">
            <div class="form-group mt-2">
                <label for="email">New email</label>
                <input class="form-control mt-2" type="email" id="email" name="email" />
            </div>
            <button class="btn btn-purp-light mt-2" type="submit" id="submit" value="submit">Confirm</button>
        </form>
    </div>
</div>

<!-- end of card -->
<?= $this->endSection() ?>