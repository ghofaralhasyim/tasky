<?= $this->extend('usr/layouts/pg_project') ?>
<?= $this->section('content') ?>
<!-- card -->
<div class="container-world">
    <div class="world-card">
        <div class="world-header">
            <div class="title-project">
                <?= $project['name']; ?>
            </div>
            <div class="action-project">
                <?php if($role['role'] == 'leader' || $role['role'] == 'editor'): ?>
                <a href="<?= base_url('/edit-project') . '/' . $project['IDproject']; ?>">Edit project</a>
                <?php endif; ?>
            </div>
        </div>

        <?php if($role['role'] == 'leader' || $role['role'] == 'editor'): ?>
        <div class="world-content">
            <div class="world-item">
                <form action="<?= base_url('/post'); ?>" method="POST">
                <input type="hidden" value="<?= $project['IDproject']; ?>" id="IDproject" name="IDproject"/>
                    <div class="form-group">
                        <label for="post mb-2">Add post :</label>
                        <textarea id="post" name="post" rows="1" style="font-size: 14px;" spellcheck="false" class="form-control form-area mt-2" required></textarea>
                    </div>
                    <button id="submit" type="submit" class="btn btn-purp-light mt-2" style="font-size: 12px;">POST</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($project['description'] != null) : ?>
            <div class="world-content">
                <div class="world-item">
                    <div class="world-item-header">
                        <div class="profile">Project Description</div>
                    </div>
                    <div class="world-item-body">
                        <p>
                            <?= $project['description']; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (count($post) > 0) : ?>
            <?php foreach ($post as $post) : ?>
                <div class="world-content">
                    <div class="world-item">
                        <div class="world-item-header">
                            <div class="profile"><?= $post['name']; ?></div>
                        </div>
                        <div class="world-item-body">
                            <p>
                                <?= $post['content']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="banner-right">
        <div class="banner-item">
            <div class="sub-title">
                History
            </div>
            <div class="font-12">
                <?php foreach ($history as $hist) : ?>
                    <i class="fa fa-circle" style="font-size: 12px; color:#63cf77;" aria-hidden="true"></i>&nbsp; <?= $hist['time']; ?> <br>
                    <?php
                    if ($hist['activity'] == 'create') {
                        $temp = $hist['name'] . ' ' . $hist['activity'] . ' task ' . $hist['description'];
                        echo '<p class="history-item">' . substr($temp, 0, 35) . '...</p>';
                    } elseif ($hist['activity'] == 'update_desc') {
                        $temp = $hist['name'] . ' memperbarui deskripsi ' . $hist['description'];
                        echo '<p class="history-item">' . substr($temp, 0, 35) . '...</p>';
                    } elseif ($hist['activity'] == 'file') {
                        $temp = $hist['name'] . ' submiting file ' . $hist['description'];
                        echo '<p class="history-item">' . substr($temp, 0, 35) . '...</p>';
                    } elseif ($hist['activity'] == 'delete') {
                        $temp = $hist['name'] . ' delete ' . $hist['description'];
                        echo '<p class="history-item">' . substr($temp, 0, 35) . '...</p>';
                    }
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- end of card -->
<?= $this->endSection() ?>