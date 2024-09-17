<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ToDo List</title>
    @vite('resources/css/normalize.css')
    @vite('resources/css/app.css')
</head>

<body>
    <h1>ToDo List</h1>

    <div class="add-task-form">
        <input type="text" id="task-title" class="task-input" placeholder="Add a new task" maxlength="255" required>
        <button id="add-task">Add Task</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="task-list">
            @include('tasks.partials.tasks', ['tasks' => $tasks])
        </tbody>
    </table>

    @include('tasks.partials.pagination', ['tasks' => $tasks])
    @vite('resources/js/app.js')
</body>

</html>
