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
    <h1 class="text-center p-3" style="font-size: 6rem; font-weight: bold;">LABORATORIO 4 - CRUD</h1>

    <!-- Modal Añadir -->
    <div class="modal fade" id="modalañadir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">AÑADIR NUEVA TAREA</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
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
                            <input type="text" class="form-control" id="taskProcess">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </div>
    </div>

    <div class="p-3">
        <!-- Botón Añadir Tarea -->
        <div class="d-flex mb-4">
            <button data-bs-toggle="modal" data-bs-target="#modalañadir" class="btn btn-success btn-lg">AÑADIR TAREA</button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead class="table-dark text-white">
                    <tr>
                        <th scope="col" class="text-center align-middle">#</th>
                        <th scope="col" class="text-center align-middle">Tareas</th>
                        <th scope="col" class="text-center align-middle">Descripción Tarea</th>
                        <th scope="col" class="text-center align-middle">Proceso</th>
                        <th scope="col" class="text-center align-middle">Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr>
                        <th scope="row" class="text-center align-middle">1</th>
                        <td class="text-center align-middle">Mark</td>
                        <td class="text-center align-middle">Otto</td>
                        <td class="text-center align-middle">@mdo</td>
                        <td class="d-flex justify-content-center align-items-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning btn-lg mx-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-lg mx-1">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>

                        <!-- Modal Modificar -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">MODIFICAR TAREA</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="modifyTaskName" class="form-label">Nombre de Tarea</label>
                                                <input type="text" class="form-control" id="modifyTaskName">
                                            </div>
                                            <div class="mb-3">
                                                <label for="modifyTaskDescription" class="form-label">Descripción de Tarea</label>
                                                <input type="text" class="form-control" id="modifyTaskDescription">
                                            </div>
                                            <div class="mb-3">
                                                <label for="modifyTaskProcess" class="form-label">Proceso</label>
                                                <input type="text" class="form-control" id="modifyTaskProcess">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Modificar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>