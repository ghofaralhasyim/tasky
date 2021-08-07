<?= $this->extend('usr/layouts/pg_home') ?>
<?= $this->section('content') ?>
<!-- card -->
<div class="profile-card">
    <div class="profile-info">
        <?php if (session()->getFlashdata('scs')) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo session()->getflashdata('scs'); ?>
            </div>
        <?php endif; ?>
        <div class="profile-header">
            <div class="profile-picture"><img src="<?= base_url('assets/images/default.jpg') ?>" /></div>
            <div class="profile-name"><?= $profile['name']; ?>&nbsp;
            <?php if(session()->username == $profile['username']): ?>
                    <a href="<?= base_url('edit-profile'); ?>"><i class="fa fa-pencil-square-o" style="font-size:small;" aria-hidden="true"></i></a>
            <?php endif; ?>
            </div>
        </div>
        <div class="profile-content">
            <table>
                <tr>
                    <td><?= $profile['email']; ?></td>
                </tr>
                <?php if ($profile['IDuser'] == session()->IDuser) { ?>
                    <tr>
                        <td><a href="<?= base_url('/reset-password'); ?>" class="btn btn-purp-light" style="font-size:small;">Change password</a></td>
                        <td><a href="<?= base_url('/update-email/form'); ?>" class="btn btn-purp-light" style="font-size:small;">Change email</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="profile-banner-card">
        <div class="profile-banner-item">
            <?php if (count($project) > 0) {
                echo '<div class="sub-title"> Project</div>'; ?>
                <?php foreach ($project as $project) : ?>
                    - <?= $project->name; ?><br>
                <?php endforeach; ?>
            <?php } else {
                echo ' <div class="sub-title"> No project join</div>';
            } ?>
        </div>
    </div>
</div>
<!-- end of card -->
<?= $this->endSection() ?>