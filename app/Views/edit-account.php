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
                                <form id="editAccountForm">
                                    <?php echo csrf_field() ?>
                                    <div class="card-body">
                                        <h4 class="card-title">Account Details</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row usernameField">
                                                    <label class="col-sm-4 col-form-label">Username</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="username" name="username" class="form-control" value="<?php echo $username ?>" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row emailField">
                                                    <label class="col-sm-4 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $email ?>" />
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
                                                <button type="button" onclick="saveAccount()" class="btn btn-outline-primary btn-fw">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <?php echo $footerBar ?>
            </div>
        </div>
    </div>
    <?php echo $footer ?>

    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/account.js?token=<?php echo CONF_asset_version; ?>"></script>


</body>