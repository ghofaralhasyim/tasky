<?= $this->extend('usr/layouts/pg_home') ?>
<?= $this->section('content') ?>
<!-- card -->
<div class="notif-card">
    <div class="notif-card-item">
        <?php if (session()->getFlashdata('scs')) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo session()->getflashdata('scs'); ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group mt-2">
                <label for="code">Verification code</label>
                <input class="form-control mt-2" type="text" id="code" name="code" placeholder="4 Digits verifycation code"/>
                <small>*If you do not see the email in your inbox, please check in spam folder too.</small>
            </div>
            <button class="btn btn-purp-light mt-2" type="submit" id="submit" value="submit">Verify</button>
        </form>
    </div>
</div>
<!-- end of card -->
<?= $this->endSection() ?>