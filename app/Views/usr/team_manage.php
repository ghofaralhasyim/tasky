<?= $this->extend('usr/layouts/pg_project') ?>
<?= $this->section('content') ?>
<!-- card -->
<div class="team-manage">
    <div class="title"> <?php if (count($team) > 0) {
                            echo $project['name'] . ' team';
                        } else {
                            echo 'Invite your team';
                        } ?></div>
    <div class="id-invite">
        <span>Share ID : <?= $project['IDproject']; ?></span>
    </div>
    <div class="team-list">
        <?php foreach ($team as $team) : ?>
            <div class="team-item">
                    <div class="team-name dropdown-toggle" id="dropdownTeam" data-bs-toggle="dropdown" aria-expanded="false"><?= $team->uname; ?></div>
                    <ul class="dropdown-menu" style="font-size: 12px;" aria-labelledby="dropdownTeam">
                        <li><a class="dropdown-item" href="<?= base_url('/steplane-profile').'/'.$team->username; ?>">Visit profile</a></li>
                        <?php if ($role['role'] == 'leader'): ?>
                            <?php if($team->role == 'editor' || $team->role == 'team'):?>
                                <li><a class="dropdown-item" href="<?= base_url('/role/leader').'/'.$team->IDuser.'/'.$project['IDproject']; ?>">Set as leader</a></li>
                            <?php endif; if($team->role == 'team'):?>
                                <li><a class="dropdown-item" href="<?= base_url('/role/editor').'/'.$team->IDuser.'/'.$project['IDproject']; ?>">Set as editor</a></li>
                            <?php endif; ?>
                            <?php if($team->role == 'editor'):?>
                                <li><a class="dropdown-item" href="<?= base_url('/role/team').'/'.$team->IDuser.'/'.$project['IDproject']; ?>">Set as only member</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" onclick="deleteTeam('<?= base_url('/delete-team') . '/' . $team->IDuser . '/' . $project['IDproject']; ?>')" href="#!" data-bs-toggle="modal" data-bs-target="#delete_team" id="btn-delete">Remove from team</a></li>
                        <?php endif; ?>
                    </ul>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($team == null) {
        echo 'No one added to this project';
    }
    ?>
    <?php if (count($request) > 0) echo '<div class="title">Request to join</div>'; ?>
    <?php foreach ($request as $req) : ?>
        <div class="team-request">
            <div class="team-name"><?= $req->name; ?></div>
            <div class="action">
                <a href="/acc-request/<?= $req->IDuser; ?>/<?= $project['IDproject']; ?>/<?= $req->IDinvite; ?>" class="label-success"><i class="fa fa-check" aria-hidden="true"></i> ACCEPT</a>
                <a href="/reject-request/<?= $project['IDproject']; ?>/<?= $req->IDinvite; ?>"><i class="fa fa-times" aria-hidden="true"></i> REJECT</a>
            </div>
        </div>
    <?php endforeach ?>
</div>
<!-- end of card -->
<?= $this->endSection() ?>