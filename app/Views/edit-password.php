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
                                <form id="changePwForm">
                                    <?php echo csrf_field() ?>
                                    <div class="card-body">
                                        <h4 class="card-title">Change Password</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row passwordField">
                                                    <label class="col-sm-4 col-form-label">New Password</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" id="password" name="password" class="form-control" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row confPasswordField">
                                                    <label class="col-sm-4 col-form-label">Confirm New Password</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" id="confPassword" name="confPassword" class="form-control" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row oldPasswordField">
                                                    <label class="col-sm-4 col-form-label">Old Password</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" id="oldPassword" name="oldPassword" class="form-control" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="main-error"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-end mt-4">
                                                <button type="button" onclick="changePassword()" class="btn btn-outline-primary btn-fw">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php echo $footer ?>

    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/account.js?token=<?php echo CONF_asset_version; ?>"></script>


</body>