document.addEventListener("DOMContentLoaded", () => {
    const addTaskButton = document.getElementById("add-task");
    const taskList = document.getElementById("task-list");

    function getCurrentPage() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get("page") || 1;
    }

    // Добавление задачи
    addTaskButton.addEventListener("click", () => {
        const title = document.getElementById("task-title").value;

        fetch("/tasks", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ title }),
        })
            .then((response) => response.json())
            .then((data) => {
                updateTaskList(data.tasksHtml, data.paginationHtml);
                document.getElementById("task-title").value = "";

                const newRow = taskList.firstElementChild;
                newRow.classList.add("fade-in");

                setTimeout(() => {
                    newRow.classList.remove("fade-in");
                }, 1800);
            });
    });

    // Обработка нажатий на чекбоксы
    taskList.addEventListener("change", (event) => {
        if (event.target.classList.contains("toggle-complete")) {
            const checkbox = event.target;
            const row = checkbox.closest("tr");
            const taskId = row.dataset.id;
            const currentPage = getCurrentPage();

            fetch(`/tasks/${taskId}?page=${currentPage}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ is_completed: checkbox.checked }),
            })
                .then((response) => response.json())
                .then((data) => {
                    updateTaskList(data.tasksHtml, data.paginationHtml);
                    window.history.pushState({}, "", `?page=${currentPage}`);
                });
        }
    });

    // Обработка нажатий на кнопки удаления
    taskList.addEventListener("click", (event) => {
        if (
            event.target.classList.contains("delete-icon") ||
            event.target.classList.contains("delete-btn")
        ) {
            const button = event.target;
            const row = button.closest("tr");
            const taskId = row.dataset.id;
            const currentPage = getCurrentPage();

            row.classList.add("fade-out");

            setTimeout(() => {
                fetch(`/tasks/${taskId}?page=${currentPage}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        updateTaskList(data.tasksHtml, data.paginationHtml);
                        window.history.pushState(
                            {},
                            "",
                            `?page=${currentPage}`
                        );
                    });
            }, 1000);
        }
    });

    // Обновление задач и пагинации
    function updateTaskList(tasksHtml, paginationHtml) {
        const pagination = document.getElementById("pagination");
        const taskList = document.getElementById("task-list");

        taskList.innerHTML = tasksHtml ?? "";
        pagination.innerHTML = paginationHtml ?? "";
    }
});
