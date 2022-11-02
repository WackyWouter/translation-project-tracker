<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';


    function insertUser($data)
    {
        $result = $this->db->table($this->table)->insert($data);
        return $result;
    }

    function isUsernameUnique($username)
    {
        $result = $this->db->table($this->table)
            ->where(['username' => $username])
            ->countAllResults();

        return $result == 0;
    }

    function isEmailUnique($email)
    {
        $result = $this->db->table($this->table)
            ->where(['email' => $email])
            ->countAllResults();
        return $result == 0;
    }

    function findUser($username)
    {
        $query = $this->db->table($this->table)
            ->where(['username' => $username])
            ->get(1);

        return $query->getRowArray();
    }
}
