<?= $this->extend('usr/layouts/pg_project') ?>
<?= $this->section('content') ?>

<?php if ($role['role'] == 'leader' || $role['role'] == 'editor') : ?>
    <a href="/new-task/<?= $project['IDproject']; ?>" class="timeline-item">
        <div class="timeline-card">
            <div class="add-task">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Add new task
            </div>
        </div>
    </a>
<?php endif; ?>

<?php if ($role['role'] == 'team' && count($task) < 1) {
    echo '<div>No task added</div>';
} ?>

<?php $count = 1;
foreach ($task as $task) : ?>
    <a href="/task-details/<?= $task['IDproject']; ?>/<?= $task['IDtask'] ?>" class="timeline-item">
        <div class="timeline-card">
            <div class="timeline-indicator done">
                <?= $count ?>
            </div>
            <div class="timeline-thumbnail">
                <div class="timeline-title"><?= $task['title'] ?></div>
                <div class="new-news">
                    <?php if (count($history) > 0) foreach ($history as $hist) {
                        if ($hist->IDtask == $task['IDtask']) {
                            echo 'Last update :<br/>';
                            if ($hist->activity == 'update_desc') {
                                $temp = $hist->name . ' update description ';
                                echo substr($temp, 0, 25) . '...<br>';
                            } elseif ($hist->activity == 'create') {
                                $temp = $hist->name . ' create task ';
                                echo substr($temp, 0, 25) . '...<br>';
                            } else {
                                $temp = $hist->name . ' adding ' . $hist->activity;
                                echo substr($temp, 0, 25) . '...<br>';
                            }
                        } else {
                            echo 'Nothing changed<br/><br/>';
                        }
                    }
                    else {
                        echo 'Update : </br> Nothing changed';
                    }
                    ?>
                </div>
            </div>
        </div>
    </a>
<?php $count++;
endforeach ?>

<?= $this->endSection() ?>