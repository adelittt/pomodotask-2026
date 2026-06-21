<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class GeminiService
{
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';
    protected string $model = 'gemini-2.5-flash';

    protected function getApiKey(): string
    {
        return config('services.gemini.api_key');
    }

    public function breakdownTask(string $taskTitle): array
    {
        $prompt = "Tolong pecah tugas berikut menjadi beberapa subtugas yang lebih kecil dan actionable. " . 
                  "Tugas: \"{$taskTitle}\". " .
                  "Kembalikan respon hanya dalam format JSON array of strings, tanpa markdown formatting, tanpa penjelasan tambahan. " .
                  "Contoh format: [\"Subtugas 1\", \"Subtugas 2\"]";

        $response = $this->callApi($prompt);

        if ($response) {
            $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? '[]';
            // Remove markdown code blocks if any
            $text = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $text);
            $text = preg_replace('/```\s*(.*?)\s*```/s', '$1', $text);
            
            $subtasks = json_decode(trim($text), true);
            
            if (is_array($subtasks)) {
                return $subtasks;
            }
        }

        return [];
    }

    public function chat(User $user, string $message, array $history = []): string
    {
        // Get user's active tasks for context
        $tasks = $user->tasks()->where('status', 'pending')->get();
        $taskContext = "Berikut adalah daftar tugas saya saat ini:\n";
        foreach ($tasks as $task) {
            $taskContext .= "- {$task->title} (Deadline: {$task->due_date})\n";
        }

        $systemPrompt = "Kamu adalah AI Assistant Produktivitas (Productivity Assistant) di aplikasi PomoTasky. " .
                        "Bantu pengguna mengelola tugas mereka, berikan saran prioritas, dan berikan tips produktivitas (seperti teknik Pomodoro). " .
                        "Selalu berikan respon yang ramah, ringkas, dan memotivasi menggunakan bahasa Indonesia. " .
                        $taskContext;

        $contents = [];
        
        // Add system prompt context as the first user message (since Gemini API might require specific structure)
        if (empty($history)) {
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => $systemPrompt . "\n\nSekarang, jawab pesan berikut: " . $message]]
            ];
        } else {
            foreach ($history as $msg) {
                $contents[] = [
                    'role' => $msg['role'] === 'user' ? 'user' : 'model',
                    'parts' => [['text' => $msg['content']]]
                ];
            }
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => $message]]
            ];
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/{$this->model}:generateContent?key=" . $this->getApiKey(), [
            'contents' => $contents
        ]);

        if ($response->successful()) {
            return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak dapat merespon saat ini.';
        }

        Log::error('Gemini API Error: ' . $response->body());
        return 'Terjadi kesalahan saat menghubungi layanan AI.';
    }

    protected function callApi(string $prompt)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/{$this->model}:generateContent?key=" . $this->getApiKey(), [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Gemini API Error: ' . $response->body());
        return null;
    }
}
