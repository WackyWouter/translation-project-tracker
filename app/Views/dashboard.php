<?php echo $header; ?>

<body>
    <div class="container-scroller">

        <div style="width:100%" class="container-fluid page-body-wrapper">
            <?php echo $navbar ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <div class="date-buttons">
                            <button class="btn btn-outline-warning custom-icon-btn" onclick="moveOneDay('backward')">
                                <i class="mdi mdi-chevron-left text-warning"></i>
                            </button>
                            <h3 class="page-title"><?php echo $date == date('Y-m-d') ? 'Today' : date('l, jS F Y', strtotime($date)) ?></h3>
                            <button class="btn btn-outline-warning custom-icon-btn" onclick="moveOneDay('forward')">
                                <i class="mdi mdi-chevron-right text-warning"></i>
                            </button>
                        </div>
                        <a href="/dashboard/newProject?prevPage=dashboard" id="newProject" class="btn btn-outline-info btn-fw">New Project</a>

                    </div>

                    <div class="row">
                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Statistics</h4>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <p>Word count: <span class="text-primary"><?php echo $totalWordCount ?></span></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <p>Job count: <span class="text-primary"><?php echo $totalJobs ?></span></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <p>Jobs due: <span class="text-primary"><?php echo $jobsDueToday ?></span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>Language Percentage: <span><?php echo $langPercentage ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <form action="/dashboard/home" method="get" id="dateForm">
                                        <h4 class="card-title">Date</h4>
                                        <div class="d-flex">
                                            <input type="hidden" id="oldDate" name="oldDate" class="form-control" value="<?php echo date('Y-m-d', strtotime($date)) ?>">

                                            <div id="datepicker-popup" class="input-group date datepicker">
                                                <input type="text" id="dateInput" name="dateInput" class="form-control">
                                                <span class=" input-group-addon input-group-append border-left">
                                                    <span class="mdi mdi-calendar input-group-text"></span>
                                                </span>

                                            </div>
                                            <button type="submit" id="dateSearch" class="btn btn-outline-success btn-fw">Search</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Uncompleted Projects</h4>
                                    <div class="table-responsive">
                                        <table id="uncompletedProjects" class="table table-white projects-datatable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Source</th>
                                                    <th>Target</th>
                                                    <th>Start Date</th>
                                                    <th>Due Date</th>
                                                    <th>Word Count</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($uncompletedProjects) && count($uncompletedProjects)) : ?>

                                                    <?php foreach ($uncompletedProjects as $index => $project) : ?>
                                                        <tr>
                                                            <td><?php echo ($index + 1); ?></td>
                                                            <td><?php echo $project['title']; ?></td>
                                                            <td><?php echo $project['source_language']; ?></td>
                                                            <td><?php echo $project['target_language']; ?></td>
                                                            <td><?php echo date('d-m-Y H:i', strtotime($project['start_date'])); ?></td>
                                                            <td><?php echo date('d-m-Y H:i', strtotime($project['due_date'])); ?></td>
                                                            <td><?php echo $project['word_count']; ?></td>
                                                            <td>
                                                                <button class="btn btn-outline-<?php echo $project['class']; ?> btn-fw dropdown-toggle" type="button" id="dd<?php echo $project['uuid']; ?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo $project['name']; ?> </button>
                                                                <div class="dropdown-menu" aria-labelledby="dd<?php echo $project['uuid']; ?>">
                                                                    <?php foreach ($statusses as $status) : ?>
                                                                        <?php if ($project['project_status'] == $status['id']) : ?>
                                                                            <a class="dropdown-item text-<?php echo $project['class']; ?>" onclick="updateStatus('<?php echo $project['uuid'] ?>', <?php echo $status['id']; ?> )" href="#"><b><?php echo $status['name']; ?></b></a>
                                                                        <?php else : ?>
                                                                            <a class="dropdown-item" onclick="updateStatus('<?php echo $project['uuid'] ?>', <?php echo $status['id']; ?> )" href="#"><?php echo $status['name']; ?></a>
                                                                        <?php endif ?>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-danger custom-icon-btn" onclick="deleteProject('<?php echo $project['uuid']; ?>')">
                                                                    <i class="mdi mdi-delete text-danger"></i>
                                                                </button>
                                                                <a class="btn btn-outline-info custom-icon-btn ml-1-5" href="/dashboard/editProject/<?php echo $project['uuid']; ?>?prevPage=dashboard&dateInput=<?php echo date('d-m-Y', strtotime($date)) ?>">
                                                                    <i class="mdi mdi-pencil text-info"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Completed Projects</h4>
                                    <div class="table-responsive">
                                        <table id="completedProjects" class="table table-white projects-datatable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Source</th>
                                                    <th>Target</th>
                                                    <th>Start Date</th>
                                                    <th>Due Date</th>
                                                    <th>Word Count</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($completedProjects) && count($completedProjects)) : ?>

                                                    <?php foreach ($completedProjects as $index => $project) : ?>
                                                        <tr>
                                                            <td><?php echo ($index + 1); ?></td>
                                                            <td><?php echo $project['title']; ?></td>
                                                            <td><?php echo $project['source_language']; ?></td>
                                                            <td><?php echo $project['target_language']; ?></td>
                                                            <td><?php echo date('d-m-Y H:i', strtotime($project['start_date'])); ?></td>
                                                            <td><?php echo date('d-m-Y H:i', strtotime($project['due_date'])); ?></td>
                                                            <td><?php echo $project['word_count']; ?></td>
                                                            <td>
                                                                <button class="btn btn-outline-<?php echo $project['class']; ?> btn-fw dropdown-toggle" type="button" id="dd<?php echo $project['uuid']; ?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo $project['name']; ?> </button>
                                                                <div class="dropdown-menu" aria-labelledby="dd<?php echo $project['uuid']; ?>">
                                                                    <?php foreach ($statusses as $status) : ?>
                                                                        <?php if ($project['project_status'] == $status['id']) : ?>
                                                                            <a class="dropdown-item text-<?php echo $project['class']; ?>" onclick="updateStatus('<?php echo $project['uuid'] ?>', <?php echo $status['id']; ?> )" href="#"><b><?php echo $status['name']; ?></b></a>
                                                                        <?php else : ?>
                                                                            <a class="dropdown-item" onclick="updateStatus('<?php echo $project['uuid'] ?>', <?php echo $status['id']; ?> )" href="#"><?php echo $status['name']; ?></a>
                                                                        <?php endif ?>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-danger custom-icon-btn" onclick="deleteProject('<?php echo $project['uuid']; ?>')">
                                                                    <i class="mdi mdi-delete text-danger"></i>
                                                                </button>
                                                                <a class="btn btn-outline-info custom-icon-btn ml-1-5" href="/dashboard/editProject/<?php echo $project['uuid']; ?>?prevPage=dashboard&dateInput=<?php echo date('d-m-Y', strtotime($date)) ?>">
                                                                    <i class="mdi mdi-pencil text-info"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
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
    <script language="javascript" src="<?php echo base_url(); ?>/assets/js/dashboard.js?token=<?php echo CONF_asset_version; ?>"></script>

</body>