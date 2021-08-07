<?= $this->extend('usr/layouts/pg_project') ?>
<?= $this->section('content') ?>
 <!-- card -->
 <div class="new-project-card">
     <div class="title">Create new task</div>
     <?php if(session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo session()->getflashdata('error'); ?>
        </div>
    <?php endif; ?>
     <form action="" method="POST">
         <div class="form-group">
             <label for="title">Title</label>
             <input class="form-control" id="title" name="title" placeholder="Task title" type="text" />
         </div>
         <div class="form-group">
             <label for="date">Deadline</label>
             <input class="form-control" id="date" name="date" placeholder="Task date" type="date" />
         </div>
         <div class="form-group">
             <label for="description">Description</label>
             <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe your task ..."></textarea>
         </div>
         <button type="submit" class="btn btn-purp-light mt-3">Create</button>
     </form>
 </div>
 <!-- end of card -->
 <?= $this->endSection() ?>