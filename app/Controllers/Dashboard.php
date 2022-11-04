<?php

namespace App\Controllers;

use App\Models\ProjectsModel;

class Dashboard extends BaseController
{

    function __construct()
    {
        $this->view_data["username"] = session()->get('username');
        $this->view_data["userUuid"] = session()->get('id');
    }

    public function index()
    {
        $this->view_data['activeNav'] = 'dashboard';
        $this->view_data["title"] = 'Dashboard';

        $date = isset($_GET['dateInput']) && strlen(trim($_GET['dateInput'])) > 0 ? date("Y-m-d", strtotime($_GET['dateInput'])) : date("Y-m-d");
        $projectsModel = model(ProjectsModel::class);
        $uncompletedProjects = $projectsModel->getProjectsByDate($this->view_data["userUuid"], $date, false);
        $completedProjects = $projectsModel->getProjectsByDate($this->view_data["userUuid"], $date, true);

        $projects = array_merge($uncompletedProjects, $completedProjects);


        $totalWordCount = 0;
        $jobsDueToday = 0;
        $totalJobs = count($projects);
        $languages = [];
        $languagePercentage = [];

        foreach ($projects as $project) {
            $totalWordCount += $project['word_count'] ?? 0;

            if (date('Y-m-d', strtotime($project['due_date']) == $date)) {
                $jobsDueToday++;

                if (!isset($languages[$project['source_language']])) {
                    $languages[$project['source_language']] = 1;
                } else {
                    $languages[$project['source_language']] += 1;
                }
            }
        }

        foreach ($languages as $language => $jobs) {
            $percentage = round((100 * $jobs) / $totalJobs, 1);
            $languagePercentage[] = "<span class='text-primary'>$language</span> ($percentage%)";
        }

        $this->view_data['uncompletedProjects'] = $uncompletedProjects;
        $this->view_data['completedProjects'] = $completedProjects;
        $this->view_data['date'] = $date;
        $this->view_data['totalWordCount'] = $totalWordCount;
        $this->view_data['jobsDueToday'] = $jobsDueToday;
        $this->view_data['totalJobs'] = $totalJobs;
        $this->view_data['langPercentage'] = implode(', ', $languagePercentage);

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('dashboard', $this->view_data);
    }

    public function allProjects()
    {
        $this->view_data['activeNav'] = 'all projects';
        $this->view_data["title"] = 'All Projects';

        $projectsModel = model(ProjectsModel::class);
        $uncompletedProjects = $projectsModel->getAllUncompletedProjects($this->view_data["userUuid"]);
        $completedProjects = $projectsModel->getAllCompletedProjects($this->view_data["userUuid"]);

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
}
