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
}
