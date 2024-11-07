<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DynamoDBService;

class TaskController extends Controller
{
    protected $dynamoDBService;

    public function __construct(DynamoDBService $dynamoDBService)
    {
        $this->dynamoDBService = $dynamoDBService;
    }

    public function index()
    {
        $tasks = $this->dynamoDBService->getAllTasks();

        // Transformar los datos para que el JSON solo incluya los valores
        $formattedTasks = array_map(function($task) {
            return [
                'task_id' => $task['task_id']['S'] ?? null,
                'name' => $task['name']['S'] ?? null,
                'description' => $task['description']['S'] ?? null,
                'process' => $task['process']['S'] ?? null,
            ];
        }, $tasks);

        return response()->json($formattedTasks);
    }

    public function show($taskId)
    {
        try {
            $task = $this->dynamoDBService->getTaskById($taskId);
            return response()->json($task);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la tarea: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $taskId = uniqid();
        $taskData = $request->only(['name', 'description', 'process']);
        $this->dynamoDBService->createTask($taskId, $taskData);
        return response()->json(['message' => 'Task created successfully', 'task_id' => $taskId], 201);
    }

    public function update(Request $request, $taskId)
    {
        $taskData = $request->only(['name', 'description', 'process']);

        try {
            $this->dynamoDBService->updateTask($taskId, $taskData);
            return response()->json(['message' => 'Task updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la tarea: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($taskId)
    {
        $this->dynamoDBService->deleteTask($taskId);
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
