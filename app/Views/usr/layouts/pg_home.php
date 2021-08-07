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
</head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <?= $this->include('usr/layouts/home_sidebar') ?>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <?= $this->include('usr/layouts/navbar') ?>
                <!-- Page content-->
                <div class="container-project">
                    <!-- card -->
                        <?= $this->renderSection('content') ?>
                    <!-- end of card -->
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="<?= base_url('assets/javascripts/scripts-home.js') ?>"></script>
    </body>
</html>