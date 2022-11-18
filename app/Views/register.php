<?php echo $header; ?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-5 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">Register</h3>
                            <form id="registerForm">
                                <?php echo csrf_field() ?>
                                <div class="form-group usernameField">
                                    <label>Username<span style="color:red">*</span></label>
                                    <input type="text" id="username" name="username" class="form-control p_input">
                                    <small class="text-muted">Alphanumeric & longer than or equals 5 chars</small>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group emailField">
                                    <label>Email<span style="color:red">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control p_input">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group pwdField">
                                    <label>Password<span style="color:red">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control p_input">
                                    <small class="text-muted">Atleast 9 characters, one number and one letter.</small>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group confPwdField">
                                    <label>Confirm Password<span style="color:red">*</span></label>
                                    <input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control p_input last-register-input">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <p class="main-error invalid-feedback"></p>
                                <div class="text-center">
                                    <button type="button" onclick="createNewUser()" class="btn btn-primary btn-block mt-4 enter-btn">Register</button>
                                </div>
                                <p class="sign-up text-center">Already have an Account?<a href="/"> Sign Up</a></p>
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