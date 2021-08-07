<?= $this->extend('usr/layouts/pg_project') ?>
<?= $this->section('content') ?>
<div class="task-details-card">
    <div class="task-details">
        <div class="task-details-header">
            <div class="title-section">
                <div class="title" id="task-title"><?= $task['title']; ?></div>
            </div>
            <div class="action">
                <?php if ($role['role'] == 'leader' || $role['role'] == 'editor') : ?>
                    <div class="button-space">
                        <a href="#!" class="action-task-details" id="edt-task"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a onclick="deleteConfirm('<?= base_url('/delete-task') . '/' . $task['IDtask'] . '/' . $project['IDproject']; ?>')" href="#!" data-bs-toggle="modal" data-bs-target="#deleteModal" class="action-task-details" id="delete-task"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="task-description">
            <form action="/update-task" method="POST">
                <input type="hidden" id="IDproject" name="IDproject" value="<?= $task['IDproject']; ?>" />
                <input type="hidden" id="IDtask" name="IDtask" value="<?= $task['IDtask']; ?>" />
                <div class="form-group mb-2 d-none mb-3" id="title-form">
                    <div class="title">Task title</div>
                    <input class="form-control" type="text" name="title" id="title" placeholder="Project name" value="<?= $task['title']; ?>" />
                </div>
                <div class="title">Description</div>
                <div class="form-group">
                    <textarea class="form-control form-area" readonly name="desc" id="desc"><?= $task['description']; ?></textarea>
                </div>
                <div class="title">Deadline</div>
                <div class="form-group">
                    <input class="form-control deadline" type="date" readonly id="date" name="date" value="<?= $task['deadline']; ?>" />
                </div>
                <button class="btn btn-purp-light mt-3 d-none" id="save-task" type="submit" value="submit">save</button>
            </form>
        </div>
        <div class="task-file" id="task-file">
            <div class="title">Submit file</div>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo session()->getflashdata('error'); ?>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('/upload-file'); ?>" name="file_upload" id="file_upload" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <input type="hidden" name="IDtask" value="<?= $task['IDtask']; ?>" />
                <input type="hidden" name="IDproject" value="<?= $task['IDproject']; ?>" />
                <div class="form-group mb-3">
                    <input type="file" name="file" class="form-control" id="file">
                    <small id="emailHelp" class="form-text text-muted">Maximum file size 5Mb. Ekstension allowed : JPG,JPEG,PNG,PDF,PPT,PPTX,DOC,DOCX,ZIP,RAR</small>
                </div>
                <div class="form-group">
                    <button type="submit" id="send_form" class="btn btn-border-purp mb-3">Submit</button>
                </div>
            </form>
            <div class="form-group">
                <div id="progressbr-container">
                    <div id="progress-bar-status-show"> </div>
                </div>
            </div>
            <?php foreach ($file as $file) : ?>
                <div class="file-card">
                    <div class="file-title">
                        <div class="file"><?= $file->file; ?></div>
                    </div>
                    <div class="action">
                        <a href="<?= base_url() . '/download' . '/' . $file->IDsubmission.'/'.$project['IDproject']; ?>"><i class="fa fa-download" aria-hidden="true"></i></a>
                        <a href="<?= base_url() . '/delete-file' . '/' . $file->IDsubmission . '/' . $task['IDproject'] . '/' . $task['IDtask']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="task-history">
        <div class="title">History</div>
        <?php foreach ($taskHistory as $history) : ?>
            <p class="history-item"><span class="time-history"><?= $history->time; ?> </span><br>
                <?php $activity = $history->activity;
                if ($activity == 'file') {
                    echo $history->name . ' menambahkan file ' . $history->description;
                } elseif ($activity == 'note') {
                    echo $history->name . ' menambahkan catatan';
                } elseif ($activity == 'update_desc') {
                    echo $history->name . ' memperbarui deskripsi';
                } elseif ($activity == 'create') {
                    echo $history->name . ' membuat task ' . $history->description;
                } else if ($activity == 'delete') {
                    echo $history->name . ' menghapus ' . $history->description;
                }
                ?></p>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection(); ?>