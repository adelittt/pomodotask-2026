<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Traits\AwardsBadges;

class TaskManager extends Component
{
    use AwardsBadges;

    public $title, $description, $progress, $due_date, $task_id;
    public $priority = 'medium';
    public $estimated_pomodoros = 1;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'description' => 'nullable|string',
        'progress' => 'nullable|integer|min:0|max:100',
        'due_date' => 'nullable|date',
        'priority' => 'required|in:low,medium,high',
        'estimated_pomodoros' => 'required|integer|min:1|max:10',
    ];

    public function render()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->latest()
            ->get();
            
        return view('livewire.task-manager', compact('tasks'));
    }

    public function save()
    {
        if ($this->isEditMode) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->validate();
        
        Task::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'progress' => $this->progress ?: 0,
            'due_date' => $this->due_date ?: null,
            'priority' => $this->priority,
            'estimated_pomodoros' => $this->estimated_pomodoros,
            'status' => 'pending',
        ]);

        $this->resetForm();
        session()->flash('message', 'Tugas baru berhasil dibuat! 🎯');
        $this->dispatch('taskUpdated');
    }

    public function edit($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $this->task_id = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->progress = $task->progress;
        $this->due_date = $task->due_date ? $task->due_date->format('Y-m-d') : null;
        $this->priority = $task->priority;
        $this->estimated_pomodoros = $task->estimated_pomodoros;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();
        
        $task = Task::where('user_id', auth()->id())->findOrFail($this->task_id);
        $task->update([
            'title' => $this->title,
            'description' => $this->description,
            'progress' => $this->progress ?: 0,
            'due_date' => $this->due_date ?: null,
            'priority' => $this->priority,
            'estimated_pomodoros' => $this->estimated_pomodoros,
        ]);

        $this->resetForm();
        session()->flash('message', 'Tugas berhasil diperbarui! ✏️');
        $this->dispatch('taskUpdated');
    }

    public function delete($id)
    {
        Task::where('user_id', auth()->id())->findOrFail($id)->delete();
        session()->flash('message', 'Tugas berhasil dihapus! 🗑️');
        $this->dispatch('taskUpdated');
    }

    public function toggleStatus($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $task->status = $task->status === 'completed' ? 'pending' : 'completed';
        $task->save();

        if ($task->status === 'completed') {
            $this->checkAndAwardBadges();
        }

        session()->flash('message', $task->status === 'completed' ? 'Tugas diselesaikan! 🎉' : 'Tugas dibuka kembali.');
        $this->dispatch('taskUpdated');
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->progress = 0;
        $this->due_date = '';
        $this->priority = 'medium';
        $this->estimated_pomodoros = 1;
        $this->task_id = null;
        $this->isEditMode = false;
    }
}