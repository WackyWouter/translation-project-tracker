<?php

namespace App\Models;

use CodeIgniter\Model;

class CalendarsModel extends Model
{
    protected $table = 'calendars';

    function insertCalendar($data)
    {
        $result = $this->db->table($this->table)->insert($data);
        return $result;
    }

    function updateCalendar($calendarUuid, $userUuid, $data)
    {
        $result = $this->db->table($this->table)
            ->where('uuid', $calendarUuid)
            ->where('user_uuid', $userUuid)
            ->update($data);
        return $result;
    }

    function deleteCalendar($calendarUuid, $userUuid)
    {
        $result = $this->db->table($this->table)
            ->where('uuid =', $calendarUuid)
            ->where('user_uuid =', $userUuid)
            ->delete();
        return $result;
    }

    function getCalendarsByUserUuid($userUuid)
    {
        $query = $this->db->table($this->table)
            ->select('uuid, name, color, bg_color, drag_bg_color, border_color')
            ->where('user_uuid =', $userUuid)
            ->get();

        return $query->getResultArray();
    }

    function getCalendarByUuid($calendarUuid, $userUuid)
    {
        $query = $this->db->table($this->table)
            ->select('uuid, name, color, bg_color, drag_bg_color, border_color')
            ->where('uuid =', $calendarUuid)
            ->where('user_uuid =', $userUuid)
            ->get(1);

        return $query->getRowArray();
    }
}
