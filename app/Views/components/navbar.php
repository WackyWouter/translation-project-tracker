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
            <li class="nav-item nav-settings d-none d-xs-block border-left ">
                <a href="/calendar" class="nav-link underline <?php echo (isset($activeNav) && $activeNav == 'calendar') ? 'active' : '' ?>">Calendar</a>
            </li>
            <li class="nav-item nav-settings d-none d-xs-block border-left ">
                <a href="/dashboard/home" class="nav-link underline <?php echo (isset($activeNav) && $activeNav == 'dashboard') ? 'active' : '' ?>">Dashboard</a>
            </li>
            <li class="nav-item nav-settings d-none d-xs-block border-left">
                <a href="/dashboard/allProjects" class="nav-link underline <?php echo (isset($activeNav) && $activeNav == 'all projects') ? 'active' : '' ?>">All Projects</a>
            </li>

            <li class="nav-item dropdown border-left">
                <a href="" id="profileDropdown" class="nav-link underline <?php echo (isset($activeNav) && $activeNav == 'profile') ? 'active' : '' ?>" data-bs-toggle="dropdown">
                    <div class="navbar-profile">
                        <div class="preview-icon bg-dark rounded-circle">
                            <i class="mdi mdi-account d-none d-sm-block text-primary"></i>
                        </div>
                        <p class="mb-0 d-none d-sm-block navbar-profile-name">
                            <?php echo $username ?>
                        </p>
                        <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                    <a href="/account/profile" class="dropdown-item preview-item">
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
                    <a id="logout" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">
                                Log out
                            </p>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>