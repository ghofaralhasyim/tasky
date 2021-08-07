<?= $this->extend('usr/layouts/pg_home') ?>
<?= $this->section('content') ?>
<div class="project-card">
    <a href="/new-project" class="project-item">
        <div class="add-new-project">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Create new project
        </div>
    </a>
</div>

<?php foreach ($project as $project) : ?>
<div class="project-card">
    <a href="<?= base_url('/dasboard').'/'.$project['IDproject']; ?>" class="project-item">
        <div class="project-header">
            <span class="project-title"><?= $project['name'] ?></span>
        </div>
        <div class="project-update">
            <?php 
                if(count($history) > 0){
                    echo 'Last update :<br>';
                    foreach ($history as $hist){
                        if($hist->IDproject == $project['IDproject'])
                        {
                            if($hist->activity == 'create'){
                                $temp = $hist->name.' '.$hist->activity.' task '.$hist->title;
                                echo '<p class="history-item">'.substr($temp,0,35).'...</p>';
                            }elseif($hist->activity == 'update_desc'){
                                $temp = $hist->name.' memperbarui deskripsi '.$hist->title;
                                echo '<p class="history-item">'.substr($temp,0,35).'...</p>';
                            }elseif($hist->activity == 'delete'){
                                $temp = $hist->name.' menghapus '.$hist->description;
                                echo '<p class="history-item">'.substr($temp,0,35).'...</p>';
                            }else{
                                $temp = $hist->name.' adding '.$hist->activity.' in '.$hist->title;
                                echo '<p class="history-item">'.substr($temp,0,35).'...</p>';
                            }
                        }
                    }
                }else{
                    echo '<br/><center><p class="history-item">No update to this project</p></center>';
                }
            ?>
        </div>
    </a>
</div>
<?php endforeach ?>
<!-- end of card -->
<?= $this->endSection() ?>