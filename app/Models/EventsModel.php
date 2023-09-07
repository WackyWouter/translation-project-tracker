<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model
{
    protected $table = 'events';

    function insertEvent($data)
    {
        $result = $this->db->table($this->table)->insert($data);
        return $result;
    }

    function updateEvent($eventsUuid, $userUuid, $data)
    {
        $result = $this->db->table($this->table)
            ->where('uuid', $eventsUuid)
            ->where('user_uuid', $userUuid)
            ->update($data);
        return $result;
    }

    function deleteEvent($eventsUuid, $userUuid)
    {
        $result = $this->db->table($this->table)
            ->where('uuid =', $eventsUuid)
            ->where('user_uuid =', $userUuid)
            ->delete();
        return $result;
    }

    function getEventsByCalendarUuid($calendarUuid, $userUuid)
    {
        $query = $this->db->table($this->table)
            ->select('events.uuid, events.user_uuid, events.calendar_uuid, events.project_uuid, projects.title AS "project_title", events.title, events.body, events.is_all_day, events.start, events.end, events.location, events.state, events.is_read_only, events.is_private, events.color, events.background_color, events.drag_bg_color, events.border_color, events.custom_style, events.adddate, events.moddate')
            ->where('events.user_uuid =', $userUuid)
            ->where('events.calendar_uuid =', $calendarUuid)
            ->join('projects', 'projects.uuid = events.project_uuid', 'left')
            ->get();

        return $query->getResultArray();
    }

    function getEventByUuid($uuid, $userUuid)
    {
        $query = $this->db->table($this->table)
            ->select('uuid, user_uuid, calendar_uuid, project_uuid, title, body, is_all_day, start, end, location, state, is_read_only, is_private, color, background_color, drag_bg_color, border_color, custom_style, adddate, moddate')
            ->where('user_uuid =', $userUuid)
            ->where('uuid =', $uuid)
            ->get(1);

        return $query->getRowArray();
    }
}
