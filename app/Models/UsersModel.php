<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';


    function insertUser($data)
    {
        $this->db->table($this->table)->insert($data);
    }

    function updateUser($uuid, $data)
    {
        $this->db->table($this->table)
            ->where('uuid', $uuid)
            ->update($data);
    }

    function isUsernameUnique($username, $uuid = '')
    {
        $result = $this->db->table($this->table)
            ->where(['username' => $username]);

        if (strlen($uuid) > 0) {
            $result = $result->where('uuid !=', $uuid);
        }
        // var_dump($username, $uuid, $result);
        // exit;

        $result = $result->countAllResults();
        return $result == 0;
    }

    function isEmailUnique($email, $uuid = '')
    {
        $result = $this->db->table($this->table)
            ->where(['email' => $email]);

        if (strlen($uuid) > 0) {
            $result = $result->where('uuid !=', $uuid);
        }

        $result = $result->countAllResults();
        return $result == 0;
    }

    function findUser($username)
    {
        $query = $this->db->table($this->table)
            ->where(['username' => $username])
            ->get(1);

        return $query->getRowArray();
    }

    function getUserById($uuid)
    {
        $query = $this->db->table($this->table)
            ->where(['uuid' => $uuid])
            ->get(1);

        return $query->getRowArray();
    }
}
