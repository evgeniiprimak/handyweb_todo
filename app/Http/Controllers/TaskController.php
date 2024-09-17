<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            $this->getTaskPartialsHtml();
        }

        $tasks = Task::orderBy('created_at', 'desc')->paginate(5);
        return view('tasks.index', compact('tasks'));
    }


    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create([
            'title' => $request->title,
        ]);

        return $this->getTaskPartialsHtml();
    }

    public function update(Task $task)
    {
        $task->is_completed = !$task->is_completed;
        $task->save();

        return $this->getTaskPartialsHtml();
    }

    public function remove(Task $task)
    {
        $task->delete();

        return $this->getTaskPartialsHtml();
    }

    private function getTaskPartialsHtml()
    {
        $tasks = Task::orderBy('created_at', 'desc')->paginate(5);
        $tasksHtml = view('tasks.partials.tasks', compact('tasks'))->render();
        $paginationHtml = view('tasks.partials.pagination', compact('tasks'))->render();

        return response()->json([
            'tasksHtml' => $tasksHtml,
            'paginationHtml' => $paginationHtml,
        ]);
    }
}
