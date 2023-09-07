<?php

namespace App\Controllers;

use App\Models\CalendarsModel;
use App\Models\EventsModel;

class Calendar extends BaseController
{

    function __construct()
    {
        $this->view_data["username"] = session()->get('username');
        $this->view_data["userUuid"] = session()->get('id');
    }

    public function index()
    {
        $this->view_data['activeNav'] = 'calendar';
        $this->view_data["title"] = 'Calendar';

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        $footerBar = view('components/footer-bar', $this->view_data);
        $this->view_data['footerBar'] = $footerBar;

        $calendarsModel = model(CalendarsModel::class);
        $calendars = $calendarsModel->getCalendarsByUserUuid($this->view_data["userUuid"]);

        // setup events and calendar arrays
        $calendarFormatted = [];
        $calendarEvents = [];
        $calendarEventsFormatted = [];

        foreach ($calendars as $calendar) {
            // Get the vents 
            $eventsModel =  model(EventsModel::class);
            $events = $eventsModel->getEventsByCalendarUuid($calendar['uuid'], $this->view_data["userUuid"]);
            $calendarEvents = array_merge($calendarEvents, $events);

            // Format the calendars in the way that is required by the tui calendar
            $calendarFormatted[] = [
                'id' => $calendar['uuid'],
                'name' => $calendar['name'],
                'color' => $calendar['color'],
                'backgroundColor' => $calendar['bg_color'],
                'dragBackgroundColor' => $calendar['drag_bg_color'],
                'borderColor' => $calendar['border_color']
            ];
        }

        foreach ($calendarEvents as $calendarEvent) {
            // https://github.com/nhn/tui.calendar/blob/main/docs/en/apis/event-object.md#calendarcalendarid
            $event = [
                'id' => $calendarEvent['uuid'],
                'calendarId' => $calendarEvent['calendar_uuid'],
                'title' => $calendarEvent['title'],
                'body' => $calendarEvent['body'] ?? '',
                'isAllday' => $calendarEvent['is_all_day'] == 1,
                'start' => strtotime($calendarEvent['start']),
                'end' => strtotime($calendarEvent['end']),
                // 'goingDuration' => $calendarEvent['title'],
                // 'comingDuration' => $calendarEvent['title'],
                'location' => $calendarEvent['location'],
                'attendees' => [$this->view_data["username"]],
                'category' => 'time',
                // https://icalendar.org/iCalendar-RFC-5545/3-8-5-3-recurrence-rule.html
                // 'recurrenceRule' => $calendarEvent['title'],
                'state' => $calendarEvent['state'],
                'isVisible' => true,
                'isPending' => false,
                'isFocused' => false,
                'isReadOnly' => $calendarEvent['is_read_only'] == 1,
                'isPrivate' => $calendarEvent['is_private'] == 1,
                'raw' => [   // Arbitrary data for the event. You can leverage the property for your own use cases.
                    'project' => $calendarEvent['project_title']
                ],
            ];

            // Optional properties
            if (isset($calendarEvent['color'])) {
                $event['color'] = $calendarEvent['color'];
            }
            if (isset($calendarEvent['background_color'])) {
                $event['backgroundColor'] = $calendarEvent['background_color'];
            }
            if (isset($calendarEvent['drag_bg_color'])) {
                $event['dragBackgroundColor'] = $calendarEvent['drag_bg_color'];
            }
            if (isset($calendarEvent['border_color'])) {
                $event['borderColor'] = $calendarEvent['border_color'];
            }
            if (isset($calendarEvent['custom_style'])) {
                $event['customStyle'] = $calendarEvent['custom_style'];
            }

            $calendarEventsFormatted[] = $event;
        }

        $this->view_data['calendarsJson'] = htmlspecialchars(json_encode($calendarFormatted));
        $this->view_data['eventsJson'] = htmlspecialchars(json_encode($calendarEventsFormatted));

        return view('calendar', $this->view_data);
    }

    public function createEvent()
    {
        $event = json_decode($this->request->getPost('event'));
        if ($event === null && json_last_error() !== JSON_ERROR_NONE) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok']);
        } else {
            helper('usefull');

            $eventsModel =  model(EventsModel::class);
            $result = $eventsModel->insertEvent([
                'uuid' => generateUuid(),
                'user_uuid' => $this->view_data["userUuid"],
                'calendar_uuid' => $event->calendarId,
                'title' => $event->title,
                // 'body' => $event->body,
                'is_all_day' => $event->isAllday ? 1 : 0,
                'start' => date('Y-m-d H:i:s', strtotime($event->start->d->d)),
                'end' => date('Y-m-d H:i:s', strtotime($event->end->d->d)),
                'location' => $event->location,
                'state' => $event->state,
                'is_private' => $event->isPrivate ? 1 : 0,
            ]);

            header('Content-Type: application/json; charset=utf-8');
            if ($result) {
                echo json_encode(['status' => 'ok', 'attendees' => [$this->view_data["username"]]]);
            } else {
                echo json_encode(['status' => 'nok']);
            }
        }
    }

    public function updateEvent()
    {
        header('Content-Type: application/json; charset=utf-8');
        $eventId = $this->request->getPost('id');
        $changes = json_decode($this->request->getPost('changes'), true);
        if (!$eventId || ($changes === null && json_last_error() !== JSON_ERROR_NONE)) {
            echo json_encode(['status' => 'nok']);
        } else {
            helper('usefull');

            $eventsModel =  model(EventsModel::class);
            $data = [];

            foreach ($changes as $key => $value) {
                switch ($key) {
                    case 'calendarId':
                        $data['calendar_uuid'] = $value;
                        break;
                    case 'isAllday':
                        $data['is_all_day'] = $value ? 1 : 0;
                        break;
                    case 'isPrivate':
                        $data['is_private'] = $value ? 1 : 0;
                        break;
                    case 'start':
                    case 'end':
                        $data[$key] = date('Y-m-d H:i:s', strtotime($value['d']['d']));
                        break;
                    case 'state':
                        $data['state'] = $value != 'Free' ? 'Busy' : 'Free';
                        break;
                    default: //title, location, body
                        $data[$key] = $value;
                }
            }

            if (!empty($data)) {
                $result = $eventsModel->updateEvent($eventId, $this->view_data["userUuid"], $data);

                if ($result) {
                    echo json_encode(['status' => 'ok']);
                } else {
                    echo json_encode(['status' => 'nok']);
                }
            } else {
                echo json_encode(['status' => 'ok']);
            }
        }
    }

    public function deleteEvent()
    {
        $eventId = $this->request->getPost('id');
        if (!$eventId) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok']);
        } else {
            helper('usefull');

            $eventsModel =  model(EventsModel::class);
            $result = $eventsModel->deleteEvent($eventId, $this->view_data["userUuid"]);

            header('Content-Type: application/json; charset=utf-8');
            if ($result) {
                echo json_encode(['status' => 'ok']);
            } else {
                echo json_encode(['status' => 'nok']);
            }
        }
    }
}
