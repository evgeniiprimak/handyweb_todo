<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::paginate(5);
        return view('tasks.index', compact('tasks'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'title' => $request->title,
        ]);

        return response()->json($task);
    }

    public function update(Task $task)
    {
        $task->is_completed = !$task->is_completed;
        $task->save();

        return response()->json($task);
    }

    public function remove(Task $task)
    {
        $task->delete();
        return response()->json(['success' => true]);
    }
}
