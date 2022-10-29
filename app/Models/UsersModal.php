<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModal extends Model
{
    protected $table = 'users';


    function insertUser($data)
    {
        $query = $this->db->table($this->table)->insert($data);
        return $query;
    }

    // function isUsernameUnique($username)
    // {
    //     $query = $this->db->table($this->table)
    //         ->asArray()
    //         ->where(['username' => $username])
    //         ->get();
    //     return $query->getNumRows();
    // }
}
