<header>
    <?php if (empty($_SESSION['Session_User'])) { ?>
        <nav class="navbar ">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= site_url() ?>">
                    <img src="<?=base_url('assets/images/logo_theseus2.png')?>" alt="logo_theseus">
                </a>
                <div class="d-flex list-menu">
                    <ul class="navbar-nav me-auto mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= site_url() ?>">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('contribute') ?>">Contribute</a>
                        </li>
                    </ul>
                    <a href="<?= site_url('login') ?>" class="btn btn-theseus">Login</a>
                </div>
            </div>
        </nav>
    <?php } else { ?>
        <nav class="navbar navbar-expand-lg bg-white">
            <div class="container-fluid">

                <a class="btn-menu" role="button">
                    <i class="fas fa-bars"></i>
                </a>
                <a class="navbar-brand" href="<?= site_url() ?>">
                    <img src="<?=base_url('assets/images/logo_theseus2.png')?>" alt="logo_theseus">
                </a>
                <span class="T-version">v0.1.1</span>
                <a class="link-profile quickLinkProfile ms-auto" href="<?= site_url('profile/'.$_SESSION["Session_User"]["Id_User"] ) ?>">
                    <strong><?=$_SESSION['Session_User']['Prenom'].' '.$_SESSION['Session_User']['Nom']?></strong>
                    <div class="profile-picture ms-3">
                        <?= get_ppUser($_SESSION['Session_User']["Id_User"]) ?>
                    </div>
                </a>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start sidebar-primary" id="offcanvasPrimary" data-bs-scroll="true"
             aria-labelledby="offcanvasPrimaryLabel" style="width: 300px">
            <div class="offcanvas-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a class="btn" href="<?= site_url('update') ?>"><i class="fas fa-newspaper"></i>
                            Updates and News</a>
                    </li>
                    <li class="list-group-item">
                        <a class="btn" href="<?= site_url('projects') ?>"><i class="fas fa-project-diagram"></i>
                            Project</a>
                    </li>
                    <li class="list-group-item">
                        <a class="btn" href="<?= site_url('profile/'.$_SESSION["Session_User"]["Id_User"]) ?>"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <li class="list-group-item">
                        <a class="btn" href="<?= site_url('settings') ?>"><i class="fas fa-cog"></i> Settings</a>
                    </li>
                    <li class="list-group-item">
                        <a class="btn" href="<?= site_url('legal_statement') ?>"><i class="fas fa-info"></i>
                            Legal statement</a>
                    </li>
                    <li class="list-group-item">
                        <a class="btn" href="<?= site_url('logout') ?>"><i class="fas fa-sign-out-alt"></i>
                            Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    <?php } ?>
</header>