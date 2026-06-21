<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskOverdueMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Task $task)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Peringatan: Tugas "' . $task->title . '" sudah melewati batas waktu',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tasks.overdue',
            with: [
                'taskName' => $this->task->title,
                'deadline' => $this->task->due_date,
            ],
        );
    }
}
