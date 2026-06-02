<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendReminderEmail implements ShouldQueue
{
    use Queueable;

    public $user;
    public $task;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $task)
    {
        $this->user = $user;
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Illuminate\Support\Facades\Mail::to($this->user->email)
            ->send(new \App\Mail\TaskReminderMail($this->user, $this->task));

        \App\Models\ReminderLog::create([
            'user_id' => $this->user->id,
            'task_id' => $this->task->id,
            'type' => 'email',
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }
}
