// Llamada para obtener las tareas al cargar la página
document.addEventListener('DOMContentLoaded', fetchTasks);

async function fetchTasks() {
    const response = await fetch('/api/tasks');
    const tasks = await response.json();
    renderTasks(tasks);
}

function renderTasks(tasks) {
    const tbody = document.querySelector('tbody');
    tbody.innerHTML = ''; // Limpiar el contenido existente
    tasks.forEach((task, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <th scope="row">${index + 1}</th>
            <td>${task.name}</td>
            <td>${task.description}</td>
            <td>${task.process}</td>
            <td class="d-flex justify-content-center align-items-center">
                <button onclick="editTask('${task.task_id}')" class="btn btn-warning btn-lg mx-1" data-bs-toggle="modal" data-bs-target="#modalañadir">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button onclick="deleteTask('${task.task_id}')" class="btn btn-danger btn-lg mx-1">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

window.prepareModalForCreate = function () {
    document.getElementById('exampleModalLabel').textContent = 'AÑADIR NUEVA TAREA';
    document.getElementById('taskId').value = ''; // Limpiar el ID para creación
    document.getElementById('taskName').value = '';
    document.getElementById('taskDescription').value = '';
    document.getElementById('taskProcess').value = '';
    document.getElementById('saveTaskButton').onclick = createTask;
};

window.createTask = async function () {
    const taskId = document.getElementById('taskId').value;
    const name = document.getElementById('taskName').value;
    const description = document.getElementById('taskDescription').value;
    const process = document.getElementById('taskProcess').value;

    if (taskId) {
        // Si taskId tiene un valor, estamos editando una tarea existente
        await fetch(`/api/tasks/${taskId}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, description, process })
        });
        showAlert("Tarea actualizada exitosamente", "warning"); // Mensaje de edición
    } else {
        // Si taskId está vacío, estamos creando una nueva tarea
        await fetch('/api/tasks', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, description, process })
        });
        showAlert("Tarea creada exitosamente", "success"); // Mensaje de creación
    }

    fetchTasks(); // Recargar la lista de tareas

    // Limpiar el formulario y cerrar el modal
    document.getElementById('taskId').value = ''; // Resetea el ID de tarea
    document.getElementById('taskName').value = '';
    document.getElementById('taskDescription').value = '';
    document.getElementById('taskProcess').value = '';
    document.getElementById('modalañadir').querySelector('.btn-close').click();

    // Restaura el título del modal a "Añadir Nueva Tarea"
    document.getElementById('exampleModalLabel').textContent = 'AÑADIR NUEVA TAREA';
};

window.deleteTask = async function (taskId) {
    // Confirmación de eliminación
    const confirmation = confirm("¿Estás seguro de que deseas eliminar esta tarea?");
    if (!confirmation) return;

    // Realizar la solicitud DELETE
    await fetch(`/api/tasks/${taskId}`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' }
    });

    // Recargar la lista de tareas después de eliminar
    fetchTasks();
    showAlert("Tarea eliminada exitosamente", "danger"); // Mensaje de eliminación
};

window.editTask = async function (taskId) {
    document.getElementById('exampleModalLabel').textContent = 'EDITAR TAREA';
    document.getElementById('saveTaskButton').onclick = createTask;
    document.getElementById('taskId').value = taskId;

    try {
        const response = await fetch(`/api/tasks/${taskId}`);
        const task = await response.json();

        document.getElementById('taskName').value = task.name;
        document.getElementById('taskDescription').value = task.description;
        document.getElementById('taskProcess').value = task.process;
    } catch (error) {
        console.error('Error al obtener la tarea:', error);
    }
};

function showAlert(message, type = "success") {
    const alertContainer = document.getElementById('alertContainer');
    alertContainer.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    // Ocultar el mensaje automáticamente después de 3 segundos
    setTimeout(() => {
        alertContainer.innerHTML = '';
    }, 3000);
}
