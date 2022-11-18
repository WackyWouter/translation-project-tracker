<?php echo $header; ?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-5 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">Password Forgotten</h3>
                            <form id="forgotPwForm">
                                <?php echo csrf_field() ?>
                                <div class="form-group emailField">
                                    <label>Email<span style="color:red">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control p_input last-reset-pw-input">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <p class="main-error invalid-feedback"></p>
                                <p class="message d-block valid-feedback"></p>
                                <div class="text-center">
                                    <button type="button" onclick="resetPassword()" class="btn btn-primary btn-block enter-btn">Reset Password</button>
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