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
        <input type="text" id="task-title" class="task-input" placeholder="Add a new task" required>
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
            @foreach ($tasks as $task)
                <tr data-id="{{ $task->id }}">
                    <td><input type="checkbox" class="toggle-complete" {{ $task->is_completed ? 'checked' : '' }}></td>
                    <td class="{{ $task->is_completed ? 'completed' : '' }}">{{ $task->title }}</td>
                    <td>
                        <button class="delete-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                fill="none">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M9.1709 4C9.58273 2.83481 10.694 2 12.0002 2C13.3064 2 14.4177 2.83481 14.8295 4"
                                        stroke="#EB5757" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M20.5001 6H3.5" stroke="#EB5757" stroke-width="1.5" stroke-linecap="round" />
                                    <path
                                        d="M18.8332 8.5L18.3732 15.3991C18.1962 18.054 18.1077 19.3815 17.2427 20.1907C16.3777 21 15.0473 21 12.3865 21H11.6132C8.95235 21 7.62195 21 6.75694 20.1907C5.89194 19.3815 5.80344 18.054 5.62644 15.3991L5.1665 8.5"
                                        stroke="#EB5757" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M9.5 11L10 16" stroke="#EB5757" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M14.5 11L14 16" stroke="#EB5757" stroke-width="1.5" stroke-linecap="round" />
                                </g>

                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tasks->links('vendor.pagination.default') }}

    @vite('resources/js/app.js')
</body>

</html>
