<?= $this->extend('usr/layouts/pg_home') ?>
<?= $this->section('content') ?>
 <!-- card -->
 <div class="new-project-card">
     <div class="title">Create new project</div>
     <?php if(session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo session()->getflashdata('error'); ?>
        </div>
    <?php endif; ?>
     <form action="" method="POST">
         <div class="form-group">
             <label for="name">Project Name</label>
             <input class="form-control" id="name" name="name" placeholder="Project name" type="text" />
         </div>
         <div class="form-group">
             <label for="description">Description</label>
             <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe your project ..."></textarea>
         </div>
         <button type="submit" class="btn btn-purp-light mt-3">Create</button>
     </form>
 </div>
 <!-- end of card -->
 <?= $this->endSection() ?>