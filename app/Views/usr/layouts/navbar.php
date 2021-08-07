<nav class="navbar navbar-expand-lg bg-purp border-bottom">
    <div class="container-fluid">
        <a class="icon-toggler"><i class="fa fa-th-list clr-white" id="sidebarToggle" aria-hidden="true"></i></a>
        <button class="navbar-toggler clr-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i> Menu
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link" href="/project">Project List</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item disabled" href="#!">Hi, <?php echo session()->name; ?>!</a>
                        <a class="dropdown-item" href="<?php echo base_url('/steplane-profile').'/'.session()->username; ?>">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/sign-out">Log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>