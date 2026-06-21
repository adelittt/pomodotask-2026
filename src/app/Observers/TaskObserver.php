<?php

namespace App\Observers;

use App\Models\Task;
use App\Actions\Calendar\SyncTaskToCalendarAction;
use App\Actions\Calendar\DeleteTaskFromCalendarAction;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        if ($task->due_date) {
            app(SyncTaskToCalendarAction::class)->execute($task);
        }
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->wasChanged('title') || $task->wasChanged('due_date')) {
            if ($task->due_date) {
                app(SyncTaskToCalendarAction::class)->execute($task);
            } elseif (!$task->due_date && $task->calendar_event_id) {
                // Deadline removed, so delete from calendar
                app(DeleteTaskFromCalendarAction::class)->execute($task);
                \Illuminate\Support\Facades\DB::table('tasks')->where('id', $task->id)->update(['calendar_event_id' => null]);
            }
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        if ($task->calendar_event_id) {
            app(DeleteTaskFromCalendarAction::class)->execute($task);
        }
    }
}
