<?php echo $header; ?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-5 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">Error</h3>
                            <p>The Password reset token has expired or is invalid.</p>
                            <div class="text-center">
                                <a href="/" class="btn btn-primary btn-block enter-btn">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $footer ?>
    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/auth.js?token=<?php echo CONF_asset_version; ?>"></script>
</body>