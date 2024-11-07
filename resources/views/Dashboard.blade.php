<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9b5926e450.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="alertContainer" class="container mt-3"></div>

    <h1 class="text-center p-3" style="font-size: 6rem; font-weight: bold;">LABORATORIO 4 - CRUD</h1>

    <!-- Modal Añadir/Editar -->
    <div class="modal fade" id="modalañadir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">AÑADIR NUEVA TAREA</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="taskId"> <!-- ID de tarea oculto -->
                        <div class="mb-3">
                            <label for="taskName" class="form-label">Nombre de Tarea</label>
                            <input type="text" class="form-control" id="taskName">
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Descripción de Tarea</label>
                            <input type="text" class="form-control" id="taskDescription">
                        </div>
                        <div class="mb-3">
                            <label for="taskProcess" class="form-label">Proceso</label>
                            <select class="form-select" id="taskProcess">
                                <option value="">Seleccione el estado</option>
                                <option value="Iniciada">Iniciada</option>
                                <option value="En proceso">En proceso</option>
                                <option value="Terminada">Terminada</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveTaskButton" onclick="createTask()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="p-3">
        <!-- Botón Añadir Tarea -->
        <div class="d-flex mb-4">
            <button data-bs-toggle="modal" data-bs-target="#modalañadir" class="btn btn-success btn-lg" onclick="prepareModalForCreate()">AÑADIR TAREA</button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead class="table-dark text-white">
                    <tr>
                        <th scope="col" class="text-center align-middle">#</th>
                        <th scope="col" class="text-center align-middle">Tarea</th>
                        <th scope="col" class="text-center align-middle">Descripción Tarea</th>
                        <th scope="col" class="text-center align-middle">Proceso</th>
                        <th scope="col" class="text-center align-middle">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                </tbody>
            </table>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
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
                        <button onclick="copyTaskId('${task.task_id}')" class="btn btn-info btn-lg mx-1">
                            <i class="fa-solid fa-clipboard"></i>
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

            // Validar que todos los campos estén llenos
            if (!name || !description || !process) {
                showAlert("Todos los campos son obligatorios", "danger");
                return;
            }

            if (taskId) {
                await fetch(`/api/tasks/${taskId}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, description, process })
                });
                showAlert("Tarea actualizada exitosamente", "warning");
            } else {
                await fetch('/api/tasks', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, description, process })
                });
                showAlert("Tarea creada exitosamente", "success");
            }

            fetchTasks(); // Recargar la lista de tareas
            document.getElementById('taskId').value = ''; // Resetear los campos
            document.getElementById('taskName').value = '';
            document.getElementById('taskDescription').value = '';
            document.getElementById('taskProcess').value = '';
            document.getElementById('modalañadir').querySelector('.btn-close').click();
            document.getElementById('exampleModalLabel').textContent = 'AÑADIR NUEVA TAREA';
        };

        window.deleteTask = async function (taskId) {
            // Confirmación de eliminación
            const confirmation = confirm("¿Estás seguro de que deseas eliminar esta tarea?");
            if (!confirmation) return;

            await fetch(`/api/tasks/${taskId}`, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' }
            });

            fetchTasks();
            showAlert("Tarea eliminada exitosamente", "danger");
        };

        window.editTask = async function (taskId) {
            document.getElementById('exampleModalLabel').textContent = 'EDITAR TAREA';
            document.getElementById('saveTaskButton').onclick = createTask;
            document.getElementById('taskId').value = taskId;

            const response = await fetch(`/api/tasks/${taskId}`);
            const task = await response.json();

            document.getElementById('taskName').value = task.name;
            document.getElementById('taskDescription').value = task.description;
            document.getElementById('taskProcess').value = task.process;
        };

        function showAlert(message, type = "success") {
            const alertContainer = document.getElementById('alertContainer');
            alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 3000);
        }

        window.copyTaskId = function(taskId) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(taskId).then(() => {
                    showAlert("ID de tarea copiado al portapapeles", "info");
                }).catch(err => {
                    console.error('Error al copiar el ID: ', err);
                    showAlert("Error al copiar el ID", "danger");
                });
            } else {
                const tempInput = document.createElement('input');
                tempInput.value = taskId;
                document.body.appendChild(tempInput);
                tempInput.select();
                try {
                    document.execCommand('copy');
                    showAlert("ID de tarea copiado al portapapeles", "info");
                } catch (err) {
                    console.error('Fallback de copia falló: ', err);
                    showAlert("Error al copiar el ID", "danger");
                }
                document.body.removeChild(tempInput);
            }
        }
    </script>
</body>

</html>
