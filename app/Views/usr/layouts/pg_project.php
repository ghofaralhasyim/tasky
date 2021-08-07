<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= SITE_NAME; ?></title>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?= base_url('assets/stylesheets/styles-home.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <?= $this->include('usr/layouts/project_sidebar') ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <?= $this->include('usr/layouts/navbar') ?>
            <!-- Page content-->
            <div class="container-project">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <?= $this->include('usr/layouts/modal') ?>
</body>
<!-- Bootstrap core JS-->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Core theme JS-->
    <script src="<?= base_url('assets/javascripts/scripts-home.js') ?>"></script>
    <?php 
        if($url == 'task-details'){
            echo $this->include('usr/layouts/task_script'); 
        }else if($url == 'edit-project'){
            echo $this->include('usr/layouts/edit-project-js');
        }else if($url == 'dasboard'){
            echo $this->include('usr/layouts/dasboard-js');
        }
    ?>
    <?php if($url == 'team'): ?>
        <script>
            function deleteTeam(url) {
                $('#btn-delete-team').attr('href', url);
                $('#delete_team').modal();
            }
        </script>
    <?php endif; ?>
</html>