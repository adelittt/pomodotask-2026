<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PomodoroSession;
use Illuminate\Http\Request;

class PomodoroSessionController extends Controller
{
    /**
     * List all pomodoro sessions for the authenticated user.
     */
    public function index(Request $request)
    {
        return response()->json($request->user()->pomodoroSessions()->get());
    }

    /**
     * Create a new pomodoro session.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'nullable|exists:tasks,id',
            'category' => 'nullable|string|max:255',
            'duration' => 'required|integer|min:1',
            'type' => 'nullable|string|in:work,short_break,long_break',
            'completed_at' => 'nullable|date',
        ]);

        if (isset($validated['task_id'])) {
            $task = $request->user()->tasks()->find($validated['task_id']);
            if (!$task) {
                abort(403, 'Task does not belong to user.');
            }
        }

        $session = $request->user()->pomodoroSessions()->create($validated);

        return response()->json($session, 201);
    }

    /**
     * Retrieve a specific pomodoro session.
     */
    public function show(Request $request, PomodoroSession $pomodoroSession)
    {
        if ($request->user()->id !== $pomodoroSession->user_id) {
            abort(403);
        }
        return response()->json($pomodoroSession);
    }

    /**
     * Update an existing pomodoro session.
     */
    public function update(Request $request, PomodoroSession $pomodoroSession)
    {
        if ($request->user()->id !== $pomodoroSession->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'task_id' => 'nullable|exists:tasks,id',
            'category' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'type' => 'nullable|string|in:work,short_break,long_break',
            'completed_at' => 'nullable|date',
        ]);

        if (isset($validated['task_id'])) {
            $task = $request->user()->tasks()->find($validated['task_id']);
            if (!$task) {
                abort(403, 'Task does not belong to user.');
            }
        }

        $pomodoroSession->update($validated);

        return response()->json($pomodoroSession);
    }

    /**
     * Delete a pomodoro session.
     */
    public function destroy(Request $request, PomodoroSession $pomodoroSession)
    {
        if ($request->user()->id !== $pomodoroSession->user_id) {
            abort(403);
        }

        $pomodoroSession->delete();

        return response()->json(null, 204);
    }
}
