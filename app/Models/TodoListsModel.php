<?php

namespace App\Models;

use CodeIgniter\Model;

class TodoListsModel extends Model
{
    protected $table = 'todo_lists';


    function insertTodoList($data)
    {
        $this->db->table($this->table)->insert($data);
        return $this->db->insertID();
    }

    function updateTodoList($uuid, $data)
    {
        $this->db->table($this->table)
            ->where('uuid', $uuid)
            ->update($data);
    }

    function deleteTodo($uuid, $userUuid)
    {
        $this->db->table($this->table)
            ->where('uuid =', $uuid)
            ->where('user_uuid =', $userUuid)
            ->delete();
    }

    function getTodoListsByDate($date, $userUuid)
    {
        $query = $this->db->table($this->table)
            ->select('uuid, name, done')
            ->where('user_uuid =', $userUuid)
            ->where('date =', $date)
            ->orderBy('sort ASC')
            ->get();

        return $query->getResultArray();
    }
}
