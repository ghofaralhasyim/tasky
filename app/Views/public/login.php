<?= $this->extend('public/layouts/public_layout') ?>
<?= $this->section('content') ?>

<section class="login-section">
    <div class="login-card">
        <div class="section-title">
            Sign In
            <hr class="hr-white" />
        </div>
        <div style="margin-bottom: 1rem;">*<a href="/sign-up">Sign up here</a> if you dont have account.</div>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo session()->getflashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="form-login">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" id="email" name="email" placeholder="youremail@mail.com" required <?php echo set_value('email'); ?>/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" id="password" name="password" placeholder="password" required/>
                </div>
                <button type="submit" class="btn btn-purp-light">Login</button>
            </form>
        </div>
    </div>
</section>


<?= $this->endSection() ?>