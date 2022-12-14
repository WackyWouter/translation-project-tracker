<?php echo $header; ?>

<body>
    <div class="container-scroller">

        <div style="width:100%" class="container-fluid page-body-wrapper">
            <?php echo $navbar ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">All Projects</h3>
                        <a href="/dashboard/newProject?prevPage=all-projects" id="newProject" class="btn btn-outline-info btn-fw">New Project</a>
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
                                                    <th>Planned Date</th>
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
                                                            <td><?php echo date('d-m-Y', strtotime($project['planned_date'])); ?></td>
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
                                                                <a class="btn btn-outline-info custom-icon-btn ml-1-5" href="/dashboard/editProject/<?php echo $project['uuid']; ?>?prevPage=all-projects">
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
                                                    <th>Planned Date</th>
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
                                                            <td><?php echo date('d-m-Y', strtotime($project['planned_date'])); ?></td>
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
                                                                <a class="btn btn-outline-info custom-icon-btn ml-1-5" href="/dashboard/editProject/<?php echo $project['uuid']; ?>?prevPage=all-projects">
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