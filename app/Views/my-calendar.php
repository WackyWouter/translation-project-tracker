<?php echo $header; ?>

<body>
    <div class="container-scroller">

        <div style="width:100%" class="container-fluid page-body-wrapper">
            <?php echo $navbar ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">My Calendars</h3>
                        <a href="/myCalendars/newCalendar" id="newCalendar" class="btn btn-outline-success btn-fw">New Calendar</a>
                    </div>
                    <div class="row">
                        <!-- CSRF token -->
                        <input type="hidden" class="txt_csrfname" name="<?php echo csrf_token() ?>" value="<?php echo csrf_hash() ?>" />
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="gallery">
                                <?php foreach ($calendars as $calendar) : ?>
                                    <div class="card">
                                        <div class="card-body calendar-card-body" style="border-left: 5px solid <?php echo $calendar['bg_color']; ?>">
                                            <h4 class="card-title"><?php echo  $calendar['name']; ?></h4>
                                            <div class="calendar-colors">
                                                <div class="calendar-color" style="background-color: <?php echo $calendar['bg_color']; ?>"></div>
                                                <div class="calendar-color" style="background-color: <?php echo $calendar['color']; ?>"></div>
                                                <div class="calendar-color" style="background-color: <?php echo $calendar['drag_bg_color']; ?>"></div>
                                                <div class="calendar-color" style="background-color: <?php echo $calendar['border_color']; ?>"></div>
                                            </div>
                                            <div class="calendar-buttons">
                                                <button type="button" onclick="deleteCalendar('<?php echo $calendar['uuid']; ?>')" class="btn btn-outline-danger custom-icon-btn">
                                                    <i class="mdi mdi-delete text-danger"></i>
                                                </button>
                                                <a href="/myCalendars/editCalendar/<?php echo $calendar['uuid']; ?>" class="btn btn-outline-info custom-icon-btn">
                                                    <i class="mdi mdi-pencil text-info"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $footerBar ?>
            </div>
        </div>
    </div>
    <?php echo $footer ?>
    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/my-calendar.js?token=<?php echo CONF_asset_version; ?>"></script>

</body>