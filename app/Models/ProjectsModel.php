<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectsModel extends Model
{
    protected $table = 'projects';


    function insertProject($data)
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

    function updateProject($projectUuid, $userUuid, $data)
    {
        $this->db->table($this->table)
            ->where('uuid', $projectUuid)
            ->where('user_uuid', $userUuid)
            ->update($data);
    }

    function deleteProject($projectUuid, $userUuid)
    {
        $this->db->table($this->table)
            ->where('uuid =', $projectUuid)
            ->where('user_uuid =', $userUuid)
            ->delete();
    }

    function getProjectByUuid($projectUuid, $userUuid)
    {
        $query = $this->db->table($this->table)
            ->select('projects.uuid, projects.user_uuid, projects.title, projects.source_language, projects.target_language, projects.planned_date, projects.start_date, projects.due_date, projects.word_count, projects.project_status, project_statusses.name, project_statusses.class')
            ->where('uuid =', $projectUuid)
            ->where('user_uuid =', $userUuid)
            ->join('project_statusses', 'project_statusses.id = projects.project_status')
            ->get(1);

        return $query->getRowArray();
    }

    function getAllUncompletedProjects($userUuid)
    {
        $query = $this->db->table($this->table)
            ->select('projects.uuid, projects.user_uuid, projects.title, projects.source_language, projects.target_language, projects.planned_date, projects.start_date, projects.due_date, projects.word_count, projects.project_status, project_statusses.name, project_statusses.class')
            ->where('user_uuid =', $userUuid)
            ->where('project_status !=', 4)
            ->join('project_statusses', 'project_statusses.id = projects.project_status')
            ->orderBy('projects.due_date ASC')
            ->get();

        return $query->getResultArray();
    }

    function getAllCompletedProjects($userUuid)
    {
        $query = $this->db->table($this->table)
            ->select('projects.uuid, projects.user_uuid, projects.title, projects.source_language, projects.target_language, projects.planned_date, projects.start_date, projects.due_date, projects.word_count, projects.project_status, project_statusses.name, project_statusses.class')
            ->where('user_uuid =', $userUuid)
            ->where('project_status =', 4)
            ->join('project_statusses', 'project_statusses.id = projects.project_status')
            ->orderBy('projects.due_date ASC')
            ->get();

        return $query->getResultArray();
    }

    function getProjectsByDate($userUuid, $date, $completed)
    {
        $beginDay = $date . ' 00:00';
        $endDay = $date . ' 23:59';

        $query = $this->db->table($this->table)
            ->select('projects.uuid, projects.user_uuid, projects.title, projects.source_language, projects.target_language, projects.planned_date, projects.start_date, projects.due_date, projects.word_count, projects.project_status, project_statusses.name, project_statusses.class')
            ->where('user_uuid =', $userUuid)
            ->where('planned_date >=', $beginDay)
            ->where('planned_date <=', $endDay);

        if ($completed) {
            $query->where('project_status =', 4);
        } else {
            $query->where('project_status !=', 4);
        }

        $query = $query->join('project_statusses', 'project_statusses.id = projects.project_status')
            ->orderBy('projects.due_date ASC')
            ->get();

        return $query->getResultArray();
    }

    function getMonthlyWordCount($date, $userUuid)
    {
        $query = $this->db->table($this->table)
            ->select('DATE_FORMAT(planned_date, "%m-%Y") as month, sum(word_count) as total_word_count')
            ->where('user_uuid =',  $userUuid)
            ->where('DATE_FORMAT(planned_date, "%m-%Y") =', date('m-Y', strtotime($date)))
            ->get();

        return $query->getRowArray();
    }
}
