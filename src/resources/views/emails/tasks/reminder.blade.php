<x-mail::message>
# Halo {{ $user->name }},

Ini adalah pengingat untuk tugasmu yang mendekati tenggat waktu!

**Tugas:** {{ $task->title }}  
**Deskripsi:** {{ $task->description ?? '-' }}  
**Tenggat Waktu:** {{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}  
**Prioritas:** {{ ucfirst($task->priority) }}

<x-mail::button :url="config('app.url') . '/dashboard'">
Lihat Tugas
</x-mail::button>

Semoga harimu produktif,
{{ config('app.name') }}
</x-mail::message>
