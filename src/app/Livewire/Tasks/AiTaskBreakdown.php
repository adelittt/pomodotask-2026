<?php

namespace App\Livewire\Tasks;

use App\Services\GeminiService;
use Livewire\Component;

class AiTaskBreakdown extends Component
{
    public string $taskTitle = '';
    public array $subtasks = [];
    public bool $isLoading = false;
    public string $errorMessage = '';

    public function generateBreakdown()
    {
        $this->validate([
            'taskTitle' => 'required|string|max:255',
        ]);

        $this->isLoading = true;
        $this->errorMessage = '';
        $this->subtasks = [];

        try {
            $geminiService = app(GeminiService::class);
            $this->subtasks = $geminiService->breakdownTask($this->taskTitle);
            
            if (empty($this->subtasks)) {
                $this->errorMessage = 'AI tidak dapat menghasilkan subtugas untuk tugas ini.';
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'Terjadi kesalahan saat memproses permintaan.';
        }

        $this->isLoading = false;
    }

    public function addSubtaskToForm($subtask)
    {
        // This method will dispatch an event to the main task creation form
        $this->dispatch('subtask-selected', $subtask);
    }

    public function render()
    {
        return view('livewire.tasks.ai-task-breakdown');
    }
}
