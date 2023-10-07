<?php echo $header; ?>

<body>
    <div class="container-scroller">

        <div style="width:100%" class="container-fluid page-body-wrapper">
            <?php echo $navbar ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <input type="hidden" id="calendars" value="<?php echo $calendarsJson; ?>">
                                <input type="hidden" id="events" value="<?php echo $eventsJson; ?>">
                                <!-- CSRF token -->
                                <input type="hidden" class="txt_csrfname" name="<?php echo csrf_token() ?>" value="<?php echo csrf_hash() ?>" />

                                <div class="card-body">
                                    <div class="page-header calendar-page-header">
                                        <div class="flex-con">
                                            <div class="date-buttons">
                                                <button class="btn btn-outline-warning custom-icon-btn changesCalendar" id="prev">
                                                    <i class="mdi mdi-chevron-left text-warning"></i>
                                                </button>
                                                <button class="btn btn-warning btn-fw changesCalendar" id="today">
                                                    <span>Today</span>
                                                </button>
                                                <button class="btn btn-outline-warning custom-icon-btn changesCalendar" id="next">
                                                    <i class="mdi mdi-chevron-right text-warning"></i>
                                                </button>
                                            </div>
                                            <div class="flex-align-center">
                                                <h3 id="monthDisplay"></h3>
                                            </div>
                                        </div>

                                        <div class="date-buttons">
                                            <button class="btn btn-outline-info btn-fw changeView changesCalendar" id="day">
                                                <span>Day</span>
                                            </button>
                                            <button class="btn btn-info btn-fw changeView changesCalendar" id="week">
                                                <span>Week</span>
                                            </button>
                                            <button class="btn btn-outline-info btn-fw changeView changesCalendar" id="month">
                                                <span>Month</span>
                                            </button>
                                        </div>

                                    </div>
                                    <div id="calendar" style="height: 800px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $footerBar ?>
            </div>
        </div>
    </div>
    <?php echo $footer ?>
    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/calendar.js?token=<?php echo CONF_asset_version; ?>"></script>

</body>