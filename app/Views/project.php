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
                                    <h4 class="card-title">Project Details</h4>
                                    <form id="projectForm" method="post" action="/dashboard/saveProject">
                                        <input type="hidden" id="projectUuid" name="projectUuid" class="form-control" value="<?php echo isset($project['uuid']) ? $project['uuid'] : ''; ?>">
                                        <input type="hidden" id="prevPage" name="prevPage" class="form-control" value="<?php echo $prevPage; ?>">
                                        <input type="hidden" id="dateInput" name="dateInput" class="form-control" value="<?php echo $dateInput; ?>">
                                        <?php echo csrf_field() ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row titleField">
                                                    <label class="col-sm-4 col-form-label">Project Title<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="projectTitle" name="projectTitle" class="form-control" value="<?php echo isset($project['title']) ? $project['title'] : ''; ?>" />
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
                                                                <?php if (isset($project['project_status']) && $project['project_status'] == $status['id']) : ?>
                                                                    <option selected value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                                                                <?php else : ?>
                                                                    <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                                                                <?php endif ?>
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
                                                        <input type="text" id="sourceLang" name="sourceLang" class="form-control" value="<?php echo isset($project['source_language']) ? $project['source_language'] : ''; ?>" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row targetLangField">
                                                    <label class="col-sm-4 col-form-label">Target Language<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="targetLang" name="targetLang" class="form-control" value="<?php echo isset($project['target_language']) ? $project['target_language'] : ''; ?>" />
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
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input type="hidden" id="oldStartDate" name="oldStartDate" class="form-control" value="<?php echo isset($project['start_date']) ? date('Y-m-d', strtotime($project['start_date'])) : ''; ?>">
                                                                <div id="start-datepicker-popup" class="input-group date datepicker no-padding">
                                                                    <input type="text" id="startDate" name="startDate" class="form-control">
                                                                    <span class=" input-group-addon input-group-append border-left">
                                                                        <span class="mdi mdi-calendar input-group-text"></span>
                                                                    </span>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mt-lg-only time-box">

                                                                <?php
                                                                $startHour = isset($project['start_date']) ? date('H', strtotime($project['start_date'])) : '';
                                                                $startMin = isset($project['start_date']) ? date('i', strtotime($project['start_date'])) : '';
                                                                ?>
                                                                <select name="startHour" id="startHour" class="form-control">
                                                                    <option <?php echo $startHour == '07' ? 'selected' : '' ?> value="07">07</option>
                                                                    <option <?php echo $startHour == '08' ? 'selected' : '' ?> value="08">08</option>
                                                                    <option <?php echo $startHour == '09' ? 'selected' : '' ?> value="09">09</option>
                                                                    <option <?php echo $startHour == '10' ? 'selected' : '' ?> value="10">10</option>
                                                                    <option <?php echo $startHour == '11' ? 'selected' : '' ?> value="11">11</option>
                                                                    <option <?php echo $startHour == '12' ? 'selected' : '' ?> value="12">12</option>
                                                                    <option <?php echo $startHour == '13' ? 'selected' : '' ?> value="13">13</option>
                                                                    <option <?php echo $startHour == '14' ? 'selected' : '' ?> value="14">14</option>
                                                                    <option <?php echo $startHour == '15' ? 'selected' : '' ?> value="15">15</option>
                                                                    <option <?php echo $startHour == '16' ? 'selected' : '' ?> value="16">16</option>
                                                                    <option <?php echo $startHour == '17' ? 'selected' : '' ?> value="17">17</option>
                                                                    <option <?php echo $startHour == '18' ? 'selected' : '' ?> value="18">18</option>
                                                                    <option <?php echo $startHour == '19' ? 'selected' : '' ?> value="19">19</option>
                                                                    <option <?php echo $startHour == '20' ? 'selected' : '' ?> value="20">20</option>
                                                                </select>
                                                                :
                                                                <select name="startMin" id="startMin" class="form-control">
                                                                    <option <?php echo $startMin == '00' ? 'selected' : '' ?> value="00">00</option>
                                                                    <option <?php echo $startMin == '15' ? 'selected' : '' ?> value="15">15</option>
                                                                    <option <?php echo $startMin == '30' ? 'selected' : '' ?> value="30">30</option>
                                                                    <option <?php echo $startMin == '45' ? 'selected' : '' ?> value="45">45</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="form-group row dueDateField">
                                                    <label class="col-sm-4 col-form-label">Due Date<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input type="hidden" id="oldDueDate" name="oldDueDate" class="form-control" value="<?php echo isset($project['due_date']) ? date('Y-m-d', strtotime($project['due_date'])) : ''; ?>">
                                                                <div id="due-datepicker-popup" class="input-group date datepicker no-padding">
                                                                    <input type="text" id="dueDate" name="dueDate" class="form-control">
                                                                    <span class=" input-group-addon input-group-append border-left">
                                                                        <span class="mdi mdi-calendar input-group-text"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mt-lg-only time-box">

                                                                <?php
                                                                $dueHour = isset($project['due_date']) ? date('H', strtotime($project['due_date'])) : '';
                                                                $dueMin = isset($project['due_date']) ? date('i', strtotime($project['due_date'])) : '';
                                                                ?>
                                                                <select name="dueHour" id="dueHour" class="form-control">
                                                                    <option <?php echo $dueHour == '07' ? 'selected' : '' ?> value="07">07</option>
                                                                    <option <?php echo $dueHour == '08' ? 'selected' : '' ?> value="08">08</option>
                                                                    <option <?php echo $dueHour == '09' ? 'selected' : '' ?> value="09">09</option>
                                                                    <option <?php echo $dueHour == '10' ? 'selected' : '' ?> value="10">10</option>
                                                                    <option <?php echo $dueHour == '11' ? 'selected' : '' ?> value="11">11</option>
                                                                    <option <?php echo $dueHour == '12' ? 'selected' : '' ?> value="12">12</option>
                                                                    <option <?php echo $dueHour == '13' ? 'selected' : '' ?> value="13">13</option>
                                                                    <option <?php echo $dueHour == '14' ? 'selected' : '' ?> value="14">14</option>
                                                                    <option <?php echo $dueHour == '15' ? 'selected' : '' ?> value="15">15</option>
                                                                    <option <?php echo $dueHour == '16' ? 'selected' : '' ?> value="16">16</option>
                                                                    <option <?php echo $dueHour == '17' ? 'selected' : '' ?> value="17">17</option>
                                                                    <option <?php echo $dueHour == '18' ? 'selected' : '' ?> value="18">18</option>
                                                                    <option <?php echo $dueHour == '19' ? 'selected' : '' ?> value="19">19</option>
                                                                    <option <?php echo $dueHour == '20' ? 'selected' : '' ?> value="20">20</option>
                                                                </select>
                                                                :
                                                                <select name="dueMin" id="dueMin" class="form-control">
                                                                    <option <?php echo $dueMin == '00' ? 'selected' : '' ?> value="00">00</option>
                                                                    <option <?php echo $dueMin == '15' ? 'selected' : '' ?> value="15">15</option>
                                                                    <option <?php echo $dueMin == '30' ? 'selected' : '' ?> value="30">30</option>
                                                                    <option <?php echo $dueMin == '45' ? 'selected' : '' ?> value="45">45</option>
                                                                </select>
                                                            </div>
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
                                                        <input type="number" id="wordCount" name="wordCount" class="form-control" value="<?php echo isset($project['word_count']) ? $project['word_count'] : ''; ?>" />
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row plannedDateField">
                                                    <label class="col-sm-4 col-form-label">Planned Date<span style="color:red">*</span></label>
                                                    <div class="col-sm-8">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="hidden" id="oldPlannedDate" name="oldPlannedDate" class="form-control" value="<?php echo isset($project['planned_date']) ? date('Y-m-d', strtotime($project['planned_date'])) : ''; ?>">
                                                                <div id="planned-datepicker-popup" class="input-group date datepicker no-padding">
                                                                    <input type="text" id="plannedDate" name="plannedDate" class="form-control">
                                                                    <span class=" input-group-addon input-group-append border-left">
                                                                        <span class="mdi mdi-calendar input-group-text"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="invalid-feedback"></span>
                                                        <small class="text-muted">This date determines on which date it shows up on the dashboard.</small>
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

                <?php echo $footerBar ?>
            </div>
        </div>
    </div>
    <?php echo $footer ?>

    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/project.js?token=<?php echo CONF_asset_version; ?>"></script>

</body>