<?php

namespace App\Actions\Calendar;

use App\Models\Task;
use App\Services\GoogleCalendarService;

class DeleteTaskFromCalendarAction
{
    public function execute(Task $task)
    {
        $user = $task->user;
        if (!$user || !$user->google_calendar_token || !$task->calendar_event_id) {
            return;
        }

        $calendarService = new GoogleCalendarService($user);
        $calendarService->deleteEvent($task->calendar_event_id);
    }
}
