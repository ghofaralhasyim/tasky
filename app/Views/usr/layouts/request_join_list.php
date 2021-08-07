<div class="title-sec">Waiting confirmation
    <hr>
</div>
<?php foreach ($request as $req) : ?>
    <div class="search-result">
        <div class="desc">
            <?php if($req->status == 'waiting'): ?> 
                <p class="status-request label label-success"><?= $req->status; ?></p>
                <p class="project-name"><?= $req->pname; ?></p>
                <p class="author">author : <?= $req->uname; ?></p>
            <?php endif; ?>

            <?php if($req->status == 'reject'): ?> 
                <p class="status-request label status-reject">Rejected</p>
                <p class="project-name"><?= $req->pname; ?></p>
                <p class="author">Author : <?= $req->uname; ?></p>
            <?php endif; ?>
        </div>
        <div class="cnl">
            <?php if($req->status != 'reject') echo '<a href="cancel-join/<?= $req->IDinvite; ?>">Cancel</a>'; ?>
        </div>
    </div>
<?php endforeach ?>