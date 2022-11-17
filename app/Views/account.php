<?php echo $header; ?>

<body>
    <div class="container-scroller">

        <div style="width:100%" class="container-fluid page-body-wrapper">
            <?php echo $navbar ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Account</h3>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Account Details</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Username</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="username" disabled name="username" class="form-control" value="<?php echo $username ?>" />
                                                    <span class="invalid-feedback"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Email</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="email" disabled name="email" class="form-control" value="<?php echo $email ?>" />
                                                    <span class="invalid-feedback"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-end mt-sm-4">
                                            <a href="/account/edit" class="btn btn-outline-warning btn-fw me-3">Edit Account</a>
                                            <a href="/account/changePassword" onclick="" class="btn btn-outline-danger btn-fw">Change Password</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php echo $footer ?>

</body>