<?php

namespace App\Controllers;

use App\Models\CalendarsModel;
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

        $footerBar = view('components/footer-bar', $this->view_data);
        $this->view_data['footerBar'] = $footerBar;

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

        $calendarModel = model(CalendarsModel::class);
        $calendars = $calendarModel->getCalendarsByUserUuid($this->view_data["userUuid"]);

        $this->view_data['calendars'] = $calendars;
        $this->view_data['statusses'] = $statusses;
        $this->view_data['prevPage'] = $prevPage;
        $this->view_data['dateInput'] = $dateInput;

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        $footerBar = view('components/footer-bar', $this->view_data);
        $this->view_data['footerBar'] = $footerBar;

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
        $calendarModel = model(CalendarsModel::class);
        $calendars = $calendarModel->getCalendarsByUserUuid($this->view_data["userUuid"]);
        $eventsCalendar = model(EventsModel::class);
        $event = $eventsCalendar->getEventByProjectUuid($projectUuid, $this->view_data["userUuid"]);

        $prevPage = $this->request->getGet('prevPage');
        $dateInput = $this->request->getGet('dateInput');

        $this->view_data['statusses'] = $statusses;
        $this->view_data['project'] = $project;
        $this->view_data['calendars'] = $calendars;
        $this->view_data['prevPage'] = $prevPage;
        $this->view_data['dateInput'] = $dateInput;
        $this->view_data['event'] = $event;

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        $footerBar = view('components/footer-bar', $this->view_data);
        $this->view_data['footerBar'] = $footerBar;

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
        $startHour = $this->request->getPost('startHour');
        $startMin = $this->request->getPost('startMin');
        $dueDate = trim($this->request->getPost('dueDate'));
        $dueHour = $this->request->getPost('dueHour');
        $dueMin = $this->request->getPost('dueMin');
        $wordCount = $this->request->getPost('wordCount');
        $plannedDate = trim($this->request->getPost('plannedDate'));

        $calendarEventCheck = trim($this->request->getPost('calendarEventCheck')) == 'on';
        $eventTitle = trim($this->request->getPost('eventTitle'));
        $eventLocation = trim($this->request->getPost('eventLocation'));
        $eventId = $this->request->getPost('eventId');
        $startEvent = trim($this->request->getPost('startEvent'));
        $startEventHour = $this->request->getPost('startEventHour');
        $startEventMin = $this->request->getPost('startEventMin');
        $endEvent = trim($this->request->getPost('endEvent'));
        $endEventHour = $this->request->getPost('endEventHour');
        $endEventMin = $this->request->getPost('endEventMin');
        $eventCalendarId = $this->request->getPost('eventCalendar');
        $eventAllDay = $this->request->getPost('allDayCheck') == 'on';

        // Formulate date strings
        $startHour = $startHour == '' ? '07' : $startHour;
        $startMin = $startMin == '' ? '00' : $startMin;
        $dueHour = $dueHour == '' ? '17' : $dueHour;
        $dueMin = $dueMin == '' ? '30' : $dueMin;
        $startEventHour = $startEventHour == '' ? '07' : $startEventHour;
        $startEventMin = $startEventMin == '' ? '00' : $startEventMin;
        $endEventHour = $endEventHour == '' ? '17' : $endEventHour;
        $endEventMin = $endEventMin == '' ? '30' : $endEventMin;

        if ($eventAllDay) {
            $startEventHour = '00';
            $startEventMin = '00';
            $endEventHour = '00';
            $endEventMin = '00';
        }

        $start = date('Y-m-d H:i:s', strtotime($startDate . ' ' . $startHour . ':' . $startMin));
        $due = date('Y-m-d H:i:s', strtotime($dueDate . ' ' . $dueHour . ':' . $dueMin));
        $startEventYmd = date('Y-m-d H:i:s', strtotime($startEvent . ' ' . $startEventHour . ':' . $startEventMin));
        $endEventYmd = date('Y-m-d H:i:s', strtotime($endEvent . ' ' . $endEventHour . ':' . $endEventMin));
        $planned = date('Y-m-d H:i:s', strtotime($plannedDate));

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
        else if (!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $startHour . ':' . $startMin)) {
            $errorFound = true;
            $errors['.startDateField'] = 'Start Time needs to be in HH:MM format.';
        }

        // Check that the date is in a valid format
        if (!$this->validateDate($dueDate)) {
            $errorFound = true;
            $errors['.dueDateField'] = 'Due Date needs to be in dd-mm-yyyy format.';
        }  // Check time is formatted properly
        else  if (!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $dueHour . ':' . $dueMin)) {
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
        }

        // Do event validation if calendar event is checked
        if ($calendarEventCheck) {
            // Check that event title is not empty
            if (strlen($eventTitle) == 0) {
                $errorFound = true;
                $errors['.eventTitleField'] = 'Event Title can not be empty.';
            }

            // Check that the date is in a valid format
            if (!$this->validateDate($startEvent)) {
                $errorFound = true;
                $errors['.startEventField'] = 'Start Event needs to be in dd-mm-yyyy format.';
            }  // Check time is formatted properly
            else if (!preg_match("/^(?:2[0-4]|[01][0-9]|10):([0-5][0-9])$/", $startEventHour . ':' . $startEventMin)) {
                $errorFound = true;
                $errors['.startEventField'] = 'Start Event Time needs to be in HH:MM format.';
            }

            // Check that the date is in a valid format
            if (!$this->validateDate($endEvent)) {
                $errorFound = true;
                $errors['.endEventField'] = 'End Event needs to be in dd-mm-yyyy format.';
            }  // Check time is formatted properly
            else  if (!preg_match("/^(?:2[0-4]|[01][0-9]|10):([0-5][0-9])$/", $endEventHour . ':' . $endEventMin)) {
                $errorFound = true;
                $errors['.endEventField'] = 'End Event Time needs to be in HH:MM format.';
            }

            if (!$eventCalendarId) {
                $errorFound = true;
                $errors['.eventCalendarField'] = 'A Calendar needs to be selected.';
            }

            $calendarsModel = model(CalendarsModel::class);
            $calendar = $calendarsModel->getCalendarByUuid($eventCalendarId, $this->view_data["userUuid"]);

            // Check if the calendar exists
            if (!$calendar) {
                $errorFound = true;
                $errors['.eventCalendarField'] = 'Selected calendar does not exist.';
            }
        }



        if ($errorFound) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok', 'errors' => $errors]);
        } else {
            helper('usefull');

            // if no id is present then is a new project
            if (strlen($projectUuid) == 0) {
                $action = 'save';

                $projectsModel = model(ProjectsModel::class);
                $projectUuid = generateUuid(); // Can be found in Helpers/usefull_helper
                $projectsModel->insertProject([
                    'uuid'              => $projectUuid,
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
                $action = 'edit';

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
            $eventsModel = model(EventsModel::class);
            if ($calendarEventCheck) {


                // UPDATE EVENT
                if ($eventId) {
                    $result = $eventsModel->updateEvent($eventId, $this->view_data["userUuid"], [
                        'calendar_uuid' => $eventCalendarId,
                        'title' => $eventTitle,
                        // 'body' => $event->body,
                        'is_all_day' => $eventAllDay,
                        'start' => $startEventYmd,
                        'END' => $endEventYmd,
                        'location' => $eventLocation,
                        'state' => 'Busy',
                        'is_private' => 0,
                        'project_uuid' => $projectUuid
                    ]);
                } // SAVE EVENT
                else {
                    $result = $eventsModel->insertEvent([
                        'uuid' => generateUuid(),
                        'user_uuid' => $this->view_data["userUuid"],
                        'calendar_uuid' => $eventCalendarId,
                        'title' => $eventTitle,
                        // 'body' => $event->body,
                        'is_all_day' => $eventAllDay,
                        'start' => $startEventYmd,
                        'END' => $endEventYmd,
                        'location' => $eventLocation,
                        'state' => 'Busy',
                        'is_private' => 0,
                        'project_uuid' => $projectUuid
                    ]);
                }

                header('Content-Type: application/json; charset=utf-8');
                if ($result) {
                    echo json_encode(['status' => 'ok', 'action' => $action, 'projectName' => $projectTitle]);
                } else {
                    echo json_encode(['status' => 'nok']);
                }
            } else {
                // Check if there was previously a event for this project which needs to be deleted now
                header('Content-Type: application/json; charset=utf-8');
                if ($eventId) {
                    $result = $eventsModel->deleteEvent($eventId, $this->view_data["userUuid"]);
                    if ($result) {
                        echo json_encode(['status' => 'ok', 'action' => $action, 'projectName' => $projectTitle]);
                    } else {
                        echo json_encode(['status' => 'nok']);
                    }
                } else {
                    echo json_encode(['status' => 'ok', 'action' => $action, 'projectName' => $projectTitle]);
                }
            }
        }
    }

    public function updateStatus()
    {
        $projectUuid = $this->request->getGet('projectUuid');
        $statusId = $this->request->getGet('statusId');

        $projectsModel = model(ProjectsModel::class);
        $statusModel = model(StatusModel::class);

        if ($statusModel->doesIdExist($statusId)) {

            $project = $projectsModel->getProjectByUuid($projectUuid, $this->view_data["userUuid"]);

            $today = date('Y-m-d');
            $plannedDate = date('Y-m-d', strtotime($project['planned_date']));
            $dueDate = date('Y-m-d', strtotime($project['due_date']));

            // if set to complete and if planned date and due date are in the future change planned_date to today
            if (($statusId == 4) && (strtotime($today) < strtotime($plannedDate)) && (strtotime($today) < strtotime($dueDate))) {
                $projectsModel->updateProject($projectUuid, $this->view_data["userUuid"], [
                    'project_status'    => $statusId,
                    'planned_date'      => $today
                ]);
            } else {
                $projectsModel->updateProject($projectUuid, $this->view_data["userUuid"], [
                    'project_status'    => $statusId
                ]);
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'ok', 'projectName' => $project['title']]);
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
