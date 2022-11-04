<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectsModel extends Model
{
    protected $table = 'projects';


    function insertProject($data)
    {
        $result = $this->db->table($this->table)->insert($data);
        return $result;
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
        $query = $this->db->table($this->table)
            ->select('projects.uuid, projects.user_uuid, projects.title, projects.source_language, projects.target_language, projects.planned_date, projects.start_date, projects.due_date, projects.word_count, projects.project_status, project_statusses.name, project_statusses.class')
            ->where('user_uuid =', $userUuid)
            ->where('planned_date =', $date);

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
}
