<?php echo $header; ?>

<body>
    <div class="container-scroller">

        <div style="width:100%" class="container-fluid page-body-wrapper">
            <?php echo $navbar ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Calendar Details</h4>
                                    <form id="calendarForm" method="post" action="/calendar/saveCalendar">
                                        <input type="hidden" id="calendarUuid" name="calendarUuid" class="form-control" value="<?php echo isset($calendar['uuid']) ? $calendar['uuid'] : ''; ?>">
                                        <?php echo csrf_field() ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row titleField">
                                                    <label class="col-sm-4 col-form-label">Title<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="calendarTitle" name="calendarTitle" class="form-control" onkeyup="setPresetTitle(event)" value="<?php echo isset($calendar['name']) ? $calendar['name'] : ''; ?>" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row colorField">
                                                    <label class="col-sm-4 col-form-label">Text Colour<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="calendarColor" data-coloris name="calendarColor" class="form-control" value="<?php echo isset($calendar['color']) ? $calendar['color'] : ''; ?>" />
                                                        <span class="invalid-feedback d-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row bgColorField">
                                                    <label class="col-sm-4 col-form-label">Background Colour<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="calendarBgColor" data-coloris name="calendarBgColor" class="form-control" value="<?php echo isset($calendar['bg_color']) ? $calendar['bg_color'] : ''; ?>" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row dragBgColorField">
                                                    <label class="col-sm-4 col-form-label">Drag Background Colour<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="calendarDragBgColor" data-coloris name="calendarDragBgColor" class="form-control" value="<?php echo isset($calendar['drag_bg_color']) ? $calendar['drag_bg_color'] : ''; ?>" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row borderColorField">
                                                    <label class="col-sm-4 col-form-label">Border Colour<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="calendarBorderColor" data-coloris name="calendarBorderColor" class="form-control" value="<?php echo isset($calendar['border_color']) ? $calendar['border_color'] : ''; ?>" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row suggestedColoursCon">
                                                    <label class="col-sm-4 col-form-label" for="">Colour Presets</label>
                                                    <div class="col-sm-8">
                                                        <div class="colour-column">
                                                            <button type="button" class="color-btn suggestedColour blue" onclick="setSuggestedColour('#ffffff', '#0090e7', '#0054e7', '#000000')"> Calendar 1</button>
                                                            <button type="button" class="color-btn suggestedColour green" onclick="setSuggestedColour('#ffffff', '#00d25b', '#00965b', '#000000')"> Calendar 1</button>
                                                            <button type="button" class="color-btn suggestedColour purple" onclick="setSuggestedColour('#ffffff', '#8f5fe8', '#8f23e8', '#000000')"> Calendar 1</button>
                                                            <button type="button" class="color-btn suggestedColour red" onclick="setSuggestedColour('#ffffff', '#fc424a', '#fc014a', '#000000')"> Calendar 1</button>
                                                            <button type="button" class="color-btn suggestedColour yellow" onclick="setSuggestedColour('#ffffff', '#ffab00', '#ff6f00', '#000000')"> Calendar 1</button>
                                                            <button type="button" class="color-btn suggestedColour pink" onclick="setSuggestedColour('#ffffff', '#ec0868', '#D00948', '#000000')"> Calendar 1</button>
                                                        </div>
                                                        <small class="text-muted d-block mt-2">
                                                            To select a preset click on one of the options above.
                                                        </small>
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
                                            <div class="col-12 text-end">
                                                <div class="flex-buttons-row">
                                                    <button type="button" onclick="history.back();" class="btn btn-outline-danger btn-fw">Cancel</button>
                                                    <button type="button" onclick="saveCalendar()" class="btn btn-outline-primary btn-fw">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
    <script language="javascript" src="<?php echo base_url(); ?>/assets/vendors/Coloris/src/coloris.js?token=<?php echo CONF_asset_version; ?>"></script>
    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/edit-calendar.js?token=<?php echo CONF_asset_version; ?>"></script>

</body>