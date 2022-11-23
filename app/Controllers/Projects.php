<?php

namespace App\Controllers;

use App\Models\ProjectsModel;
use App\Models\StatusModel;

class Projects extends BaseController
{

    function __construct()
    {
        $this->view_data["username"] = session()->get('username');
        $this->view_data["userUuid"] = session()->get('id');
    }

    public function index()
    {
        $this->view_data['activeNav'] = 'all projects';
        $this->view_data["title"] = 'All Projects';

        $projectsModel = model(ProjectsModel::class);
        $uncompletedProjects = $projectsModel->getAllUncompletedProjects($this->view_data["userUuid"]);
        $completedProjects = $projectsModel->getAllCompletedProjects($this->view_data["userUuid"]);

        $statusModel = model(StatusModel::class);
        $statusses = $statusModel->getAllStatuses();

        $this->view_data['statusses'] = $statusses;
        $this->view_data['uncompletedProjects'] = $uncompletedProjects;
        $this->view_data['completedProjects'] = $completedProjects;

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('all-projects', $this->view_data);
    }

    public function newProject()
    {
        $this->view_data['activeNav'] = '';
        $this->view_data["title"] = 'New Project';

        $statusModel = model(StatusModel::class);
        $statusses = $statusModel->getAllStatuses();

        $prevPage = $this->request->getGet('prevPage');
        $dateInput = $this->request->getGet('dateInput');

        $this->view_data['statusses'] = $statusses;
        $this->view_data['prevPage'] = $prevPage;
        $this->view_data['dateInput'] = $dateInput;

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('project', $this->view_data);
    }

    public function editProject($projectUuid)
    {
        $this->view_data['activeNav'] = '';
        $this->view_data["title"] = 'Edit Project';

        $statusModel = model(StatusModel::class);
        $projectsModel = model(ProjectsModel::class);

        $statusses = $statusModel->getAllStatuses();
        $project = $projectsModel->getProjectByUuid($projectUuid, $this->view_data["userUuid"]);

        $prevPage = $this->request->getGet('prevPage');
        $dateInput = $this->request->getGet('dateInput');

        $this->view_data['statusses'] = $statusses;
        $this->view_data['project'] = $project;
        $this->view_data['prevPage'] = $prevPage;
        $this->view_data['dateInput'] = $dateInput;

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('project', $this->view_data);
    }

    public function saveProject()
    {
        $projectUuid = $this->request->getPost('projectUuid');
        $projectTitle = trim($this->request->getPost('projectTitle'));
        $status = $this->request->getPost('status');
        $sourceLang = trim($this->request->getPost('sourceLang'));
        $targetLang = trim($this->request->getPost('targetLang'));
        $startDate = trim($this->request->getPost('startDate'));
        $startTime = $this->request->getPost('startTime');
        $dueDate = trim($this->request->getPost('dueDate'));
        $dueTime = $this->request->getPost('dueTime');
        $wordCount = $this->request->getPost('wordCount');
        $plannedDate = trim($this->request->getPost('plannedDate'));
        $plannedTime = $this->request->getPost('plannedTime');

        // Formulate date strings
        $startTime = $startTime == '' ? '00:00' : $startTime;
        $dueTime = $dueTime == '' ? '00:00' : $dueTime;
        $plannedTime = $plannedTime == '' ? '00:00' : $plannedTime;

        $start = date('Y-m-d H:i:s', strtotime($startDate . ' ' . $startTime));
        $due = date('Y-m-d H:i:s', strtotime($dueDate . ' ' . $dueTime));
        $planned = date('Y-m-d H:i:s', strtotime($plannedDate . ' ' . $plannedTime));

        $errorFound = false;
        $errors = [];

        // Check that title is not empty
        if (strlen($projectTitle) == 0) {
            $errorFound = true;
            $errors['.titleField'] = 'Title can not be empty.';
        }

        // Check that a status is selected
        if ($status == 0) {
            $errorFound = true;
            $errors['.statusField'] = 'A status needs to be selected.';
        }

        // Check that Source Language is not empty
        if (strlen($sourceLang) == 0) {
            $errorFound = true;
            $errors['.sourceLangField'] = 'Source Language can not be empty.';
        }

        // Check that Target Language is not empty
        if (strlen($targetLang) == 0) {
            $errorFound = true;
            $errors['.targetLangField'] = 'Target Language can not be empty.';
        }

        // Check that word count is a number
        if (!is_numeric($wordCount) || $wordCount < 0) {
            $errorFound = true;
            $errors['.wordCountField'] = 'Word count needs to be a positive number.';
        }

        // Check that the date is in a valid format
        if (!$this->validateDate($startDate)) {
            $errorFound = true;
            $errors['.startDateField'] = 'Start Date needs to be in dd-mm-yyyy format.';
        }  // Check time is formatted properly
        else if (!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $startTime)) {
            $errorFound = true;
            $errors['.startDateField'] = 'Start Time needs to be in HH:MM format.';
        }

        // Check that the date is in a valid format
        if (!$this->validateDate($dueDate)) {
            $errorFound = true;
            $errors['.dueDateField'] = 'Due Date needs to be in dd-mm-yyyy format.';
        }  // Check time is formatted properly
        else  if (!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $dueTime)) {
            $errorFound = true;
            $errors['.dueDateField'] = 'Due Time needs to be in HH:MM format.';
        }

        // Check that due date is not before Start date
        if (strtotime($start) > strtotime($due)) {
            $errorFound = true;
            $errors['.dueDateField'] = 'Due Date needs to be after Start Date.';
        }

        // Check that the date is in a valid format
        if (!$this->validateDate($plannedDate)) {
            $errorFound = true;
            $errors['.plannedDateField'] = 'Planned Date needs to be in dd-mm-yyyy format.';
        }  // Check time is formatted properly
        else if (!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $plannedTime)) {
            $errorFound = true;
            $errors['.plannedDateField'] = 'Planned Time needs to be in HH:MM format.';
        }

        if ($errorFound) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok', 'errors' => $errors]);
        } else {

            // if no id is present then is a new project
            if (strlen($projectUuid) == 0) {
                helper('usefull');

                $projectsModel = model(ProjectsModel::class);
                $projectsModel->insertProject([
                    'uuid'              => generateUuid(), // Can be found in Helpers/usefull_helper
                    'user_uuid'         => $this->view_data["userUuid"],
                    'title'             => $projectTitle,
                    'source_language'   => $sourceLang,
                    'target_language'   => $targetLang,
                    'planned_date'      => $planned,
                    'start_date'        => $start,
                    'due_date'          => $due,
                    'word_count'        => $wordCount,
                    'project_status'    => $status
                ]);
            } else {

                $projectsModel = model(ProjectsModel::class);
                $projectsModel->updateProject($projectUuid, $this->view_data["userUuid"], [
                    'title'             => $projectTitle,
                    'source_language'   => $sourceLang,
                    'target_language'   => $targetLang,
                    'planned_date'      => $planned,
                    'start_date'        => $start,
                    'due_date'          => $due,
                    'word_count'        => $wordCount,
                    'project_status'    => $status
                ]);
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'ok']);
        }
    }

    public function updateStatus()
    {
        $projectUuid = $this->request->getGet('projectUuid');
        $statusId = $this->request->getGet('statusId');

        $projectsModel = model(ProjectsModel::class);
        $statusModel = model(StatusModel::class);

        if ($statusModel->doesIdExist($statusId)) {
            $projectsModel->updateProject($projectUuid, $this->view_data["userUuid"], [
                'project_status'    => $statusId
            ]);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'ok']);
        } else {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok']);
        }
    }

    public function deleteProject()
    {
        $projectId = $this->request->getGet('projectId');
        $projectsModel = model(ProjectsModel::class);
        $projectsModel->deleteProject($projectId, $this->view_data["userUuid"]);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'ok']);
    }

    private function validateDate($date)
    {
        $dateSplit = explode('-', $date);
        if (count($dateSplit) == 3) {
            if (checkdate($dateSplit[1], $dateSplit[0], $dateSplit[2])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
