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
                                <div class="form-group usernameField">
                                    <label>Username<span style="color:red">*</span></label>
                                    <input type="text" id="username" name="username" class="form-control p_input">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group pwdField">
                                    <label>Password <span style="color:red">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control p_input last-login-input">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input"> Remember me </label>
                                    </div>
                                    <a href="#" class="forgot-pass">Forgot password</a>
                                </div>
                                <p class="main-error invalid-feedback"></p>
                                <div class="text-center">
                                    <button type="button" onclick="login()" class="btn btn-primary btn-block enter-btn">Login</button>
                                </div>
                                <p class="sign-up">Don't have an Account?<a href="/register"> Sign Up</a></p>
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