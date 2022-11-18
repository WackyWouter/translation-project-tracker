<?php echo $header; ?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-5 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">Reset Password</h3>
                            <form id="resetPWForm">
                                <input type="hidden" id="token" name="token" value="<?php echo $token ?>">
                                <?php echo csrf_field() ?>
                                <div class="form-group pwdField">
                                    <label>New Password<span style="color:red">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control p_input">
                                    <small class="text-muted">Atleast 9 characters, one number and one letter.</small>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group confPwdField">
                                    <label>Confirm New Password<span style="color:red">*</span></label>
                                    <input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control p_input last-new-pw-input">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <p class="main-error invalid-feedback"></p>
                                <div class="text-center">
                                    <button type="button" onclick="updatePassword()" class="btn btn-primary btn-block enter-btn">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $footer ?>
    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/auth.js?token=<?php echo CONF_asset_version; ?>"></script>

</body>