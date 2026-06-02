<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-task-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for tasks that are due soon (today or tomorrow)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Finding tasks due today or tomorrow...');

        // Find pending tasks due today or tomorrow
        $tasks = \App\Models\Task::with('user')
            ->where('status', 'pending')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [now()->startOfDay(), now()->addDay()->endOfDay()])
            ->get();

        $count = 0;
        foreach ($tasks as $task) {
            // Check if reminder already sent today
            $alreadySent = \App\Models\ReminderLog::where('task_id', $task->id)
                ->where('type', 'email')
                ->whereDate('sent_at', now()->startOfDay())
                ->exists();

            if (!$alreadySent && $task->user) {
                \App\Jobs\SendReminderEmail::dispatch($task->user, $task);
                $count++;
            }
        }

        $this->info("Dispatched {$count} reminder emails.");
    }
}
