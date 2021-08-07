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
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body>
    <!-- Top navigation-->
    <nav class="navbar navbar-expand-lg bg-purp">
        <div class="container">
            <a class="navbar-brand navbar-brand-purp" href="<?= base_url('/home'); ?>"><?= SITE_NAME; ?></a>
            <button class="navbar-toggler custom-toggler clr-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon custom-toggler clr-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                    <li class="nav-item active"><a class="nav-link " href="<?= base_url('/home'); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link " href="<?= base_url('/sign-in') ?>">Sign in | Sign up</a></li>
                    <li class="nav-item"><a class="nav-link " href="#about">About us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?= $this->renderSection('content'); ?>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/javascripts/scripts-home.js') ?>"></script>
</body>

</html>