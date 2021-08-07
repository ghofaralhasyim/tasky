<!-- card -->
<?= $this->extend('usr/layouts/pg_home') ?>
<?= $this->section('content') ?>
<div class="request-join-card">
    <div class="title">Request to join project</div>
    <form class="request-join-form" action="" method="POST" enctype="multipart/form-data" id="search_project">
        <div class="form-group">
            <input class="form-control" placeholder="Insert Project Id" name="IDproject" id="IDproject" type="text" value="<?= set_value('IDproject');?>" />
        </div>
        <div class="form-group">
            <button class="btn btn-purp-light" type="submit" id="submit">Search</button>
        </div>
    </form>
    <?php if(session()->getFlashdata('nfn')) : ?>
        <div class="alert alert-danger" role="alert" id="flashdata">
            <?php echo session()->getflashdata('nfn'); ?>
        </div>
    <?php endif; ?>
    <?php if (is_array($search_result) && count($search_result) > 0) {
        echo view('usr/layouts/search_project_result');
    }
    ?>
    <?php if (is_array($request) && count($request) > 0) {
        echo view('usr/layouts/request_join_list');
    }
    ?>

</div>
<!-- end of card -->
<?= $this->endSection() ?>