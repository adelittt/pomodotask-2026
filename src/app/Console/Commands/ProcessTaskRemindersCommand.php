<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Mail\TaskReminderMail;
use App\Mail\TaskOverdueMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ProcessTaskRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-task-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process and send task reminders (H-1 and overdue)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Processing task reminders...');

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // 1. H-1 Reminders
        $tasksDueTomorrow = Task::whereDate('due_date', $tomorrow)
            ->where('status', 'pending')
            ->get();

        foreach ($tasksDueTomorrow as $task) {
            if ($task->user && $task->user->email) {
                Mail::to($task->user->email)->queue(new TaskReminderMail($task));
                $this->info('Queued reminder for task: ' . $task->id);
            }
        }

        // 2. Overdue Reminders (e.g. 1 day overdue)
        $tasksOverdue = Task::whereDate('due_date', '<', $today)
            ->where('status', 'pending')
            // To prevent spamming everyday, we could check if we already sent it using reminder_logs
            // For simplicity, let's just queue for tasks that are exactly 1 day overdue
            ->whereDate('due_date', Carbon::yesterday())
            ->get();

        foreach ($tasksOverdue as $task) {
            if ($task->user && $task->user->email) {
                Mail::to($task->user->email)->queue(new TaskOverdueMail($task));
                $this->info('Queued overdue notice for task: ' . $task->id);
            }
        }

        $this->info('Task reminders processed.');
    }
}
