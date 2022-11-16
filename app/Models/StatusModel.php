<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusModel extends Model
{
    protected $table = 'project_statusses';

    function getAllStatuses()
    {
        $query = $this->db->table($this->table)
            ->orderBy('sort ASC')
            ->get();

        return $query->getResultArray();
    }

    function doesIdExist($id)
    {
        $result = $this->db->table($this->table)
            ->where(['id' => $id])
            ->countAllResults();

        return $result > 0;
    }
}
