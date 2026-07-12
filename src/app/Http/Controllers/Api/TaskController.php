<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * List all tasks for the authenticated user.
     */
    public function index(Request $request)
    {
        return response()->json($request->user()->tasks()->get());
    }

    /**
     * Create a new task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pending,in_progress,completed',
            'priority' => 'nullable|string|in:low,medium,high',
            'due_date' => 'nullable|date',
            'estimated_pomodoros' => 'nullable|integer|min:0',
        ]);

        $task = $request->user()->tasks()->create($validated);

        return response()->json($task, 201);
    }

    /**
     * Retrieve a specific task.
     */
    public function show(Request $request, Task $task)
    {
        if ($request->user()->id !== $task->user_id) {
            abort(403);
        }
        return response()->json($task);
    }

    /**
     * Update an existing task.
     */
    public function update(Request $request, Task $task)
    {
        if ($request->user()->id !== $task->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pending,in_progress,completed',
            'priority' => 'nullable|string|in:low,medium,high',
            'due_date' => 'nullable|date',
            'estimated_pomodoros' => 'nullable|integer|min:0',
            'completed_pomodoros' => 'nullable|integer|min:0',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    /**
     * Delete a task.
     */
    public function destroy(Request $request, Task $task)
    {
        if ($request->user()->id !== $task->user_id) {
            abort(403);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}
