<?= $this->extend('public/layouts/public_layout') ?>
<?= $this->section('content') ?>

<section class="login-section">
    <div class="login-card">
        <div class="section-title">
            Create your Steplane Account
            <hr class="hr-white" />
        </div>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo session()->getflashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('succ')) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo session()->getflashdata('succ'); ?>. Please <a href="/sign-in">Login here</a>
            </div>
        <?php endif; ?>
        <div class="form-login">
            <form action="" method="POST">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="fname">First Name</label>
                            <input class="form-control" type="text" id="fname" name="fname" placeholder="First name" value="<?php echo set_value('fname'); ?>" />
                        </div>
                        <div class="col">
                            <label for="lname">Last Name</label>
                            <input class="form-control" type="text" id="lname" name="lname" placeholder="Last name" value="<?php echo set_value('fname'); ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" id="email" name="email" placeholder="youremail@mail.com" value="<?php echo set_value('email'); ?>"/>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="password"  value="<?php echo set_value('password'); ?>"/>
                        </div>
                        <div class="col">
                            <label for="passconf">Confirm</label>
                            <input class="form-control" type="password" id="passconf" name="passconf" placeholder="Retype your password"  value="<?php echo set_value('passconf'); ?>" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6LeDQA4bAAAAAOt2iz6ZFa2r1SBgBAUs3sAIeaxq" style="margin-bottom:0.5rem; margin-top:0.5rem;"></div> 
                </div>
                <button type="submit" class="btn btn-purp-light">Sign up</button>
            </form>
        </div>
    </div>
</section>


<?= $this->endSection() ?>