<?php echo $header; ?>

<body>
    <div class="container-scroller">

        <div style="width:100%" class="container-fluid page-body-wrapper">
            <?php echo $navbar ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">New Project</h3>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form id="newProjectForm" method="post" action="/dashboard/saveProject">
                                        <?php echo csrf_field() ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row titleField">
                                                    <label class="col-sm-4 col-form-label">Project Title<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="projectTitle" name="projectTitle" class="form-control" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row statusField">
                                                    <label class="col-sm-4 col-form-label">Status<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <select name="status" id="status" class="form-control">
                                                            <?php foreach ($statusses as $status) : ?>
                                                                <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row sourceLangField">
                                                    <label class="col-sm-4 col-form-label">Source Language<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="sourceLang" name="sourceLang" class="form-control" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row targetLangField">
                                                    <label class="col-sm-4 col-form-label">Target Language<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="targetLang" name="targetLang" class="form-control" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row startDateField">
                                                    <label class="col-sm-4 col-form-label">Start Date<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <div id="start-datepicker-popup" class="input-group date datepicker no-padding">
                                                            <input type="text" id="startDate" name="startDate" class="form-control">
                                                            <span class=" input-group-addon input-group-append border-left">
                                                                <span class="mdi mdi-calendar input-group-text"></span>
                                                            </span>

                                                        </div>
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row dueDateField">
                                                    <label class="col-sm-4 col-form-label">Due Date<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <div id="due-datepicker-popup" class="input-group date datepicker no-padding">
                                                            <input type="text" id="dueDate" name="dueDate" class="form-control">
                                                            <span class=" input-group-addon input-group-append border-left">
                                                                <span class="mdi mdi-calendar input-group-text"></span>
                                                            </span>
                                                        </div>
                                                        <span class="invalid-feedback"></span>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row wordCountField">
                                                    <label class="col-sm-4 col-form-label">Word count<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="number" id="wordCount" name="wordCount" class="form-control" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row plannedDateField">
                                                    <label class="col-sm-4 col-form-label">Planned Date<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <div id="planned-datepicker-popup" class="input-group date datepicker no-padding">
                                                            <input type="text" id="plannedDate" name="plannedDate" class="form-control">
                                                            <span class=" input-group-addon input-group-append border-left">
                                                                <span class="mdi mdi-calendar input-group-text"></span>
                                                            </span>
                                                        </div>
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
                                            <div class="col-12 text-end">
                                                <button type="button" onclick="saveProject()" class="btn btn-outline-primary btn-fw">Save</button>
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
    </div>
    <?php echo $footer ?>

    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/project.js?token=<?php echo CONF_asset_version; ?>"></script>

</body>