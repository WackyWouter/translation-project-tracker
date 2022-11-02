<nav style="left:0" class="navbar p-0 fixed-top d-flex flex-row">
    <!-- <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">

                </div> -->
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-left">
            <a href="/dashboard/home" class="navbar-brand brand-logo-mini">
                <h1><em>TPT</em></h1>
            </a>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-settings d-none d-lg-block border-left ">
                <a href="/dashboard/home" class="nav-link underline <?php echo (isset($activeNav) && $activeNav == 'dashboard') ? 'active' : '' ?>">Dashboard</a>
            </li>
            <li class="nav-item nav-settings d-none d-lg-block border-left">
                <a href="/dashboard/allProjects" class="nav-link underline <?php echo (isset($activeNav) && $activeNav == 'all projects') ? 'active' : '' ?>">All Projects</a>
            </li>

            <li class="nav-item dropdown border-left">
                <a href="" id="profileDrop" class="nav-link underline <?php echo (isset($activeNav) && $activeNav == 'profile') ? 'active' : '' ?>" data-toggle="dropdown">
                    <div class="navbar-icon-item">
                        <div class="preview-icon bg-dark rounded-circle">
                            <i class="mdi mdi-account d-none d-sm-block text-primary"></i>
                        </div>
                        <p class="mb-0 d-none d-sm-block navbar-icon-item-name">
                            <?php echo $username ?>
                        </p>
                        <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                    <a href="/dashboard/account" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">
                                Account
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p id="logout" class="preview-subject mb-1">
                                <!-- <a href="/logout">Log out</a> -->
                                Log out
                            </p>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>