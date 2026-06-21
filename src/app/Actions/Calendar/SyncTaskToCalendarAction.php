<?php

namespace App\Actions\Calendar;

use App\Models\Task;
use App\Services\GoogleCalendarService;

class SyncTaskToCalendarAction
{
    public function execute(Task $task)
    {
        // Check if user has calendar integrated
        $user = $task->user;
        if (!$user || !$user->google_calendar_token || !$task->due_date) {
            return;
        }

        $calendarService = new GoogleCalendarService($user);
        
        $startDateTime = $task->due_date->format('Y-m-d\TH:i:sP');
        // Let's assume an event duration of 1 hour for a task deadline
        $endDateTime = $task->due_date->copy()->addHour()->format('Y-m-d\TH:i:sP');

        $description = "Tugas PomoTasky: " . $task->title;

        if ($task->calendar_event_id) {
            // Update existing event
            $calendarService->updateEvent(
                $task->calendar_event_id,
                $task->title,
                $startDateTime,
                $endDateTime,
                $description
            );
        } else {
            // Create new event
            $response = $calendarService->createEvent(
                $task->title,
                $startDateTime,
                $endDateTime,
                $description
            );

            if (isset($response['id'])) {
                // We use DB facade to update to prevent triggering model events and infinite loops
                \Illuminate\Support\Facades\DB::table('tasks')
                    ->where('id', $task->id)
                    ->update(['calendar_event_id' => $response['id']]);
            }
        }
    }
}
