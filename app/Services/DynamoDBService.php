<?php

namespace App\Services;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\Sdk;

class DynamoDBService
{
    protected $dynamoDb;
    protected $tableName = 'Task'; // Nombre de tu tabla en DynamoDB

    public function __construct()
    {
        $sdk = new Sdk([
            'region'   => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'version'  => 'latest',
        ]);

        $this->dynamoDb = $sdk->createDynamoDb();
    }

    public function createTask($taskId, $taskData)
    {
        try {
            $item = [
                'task_id' => ['S' => $taskId],
                'name' => ['S' => $taskData['name']],
                'description' => ['S' => $taskData['description']],
                'process' => ['S' => $taskData['process']],
            ];

            $result = $this->dynamoDb->putItem([
                'TableName' => $this->tableName,
                'Item' => $item,
            ]);

            return $result;
        } catch (DynamoDbException $e) {
            throw new \Exception("Unable to create task: " . $e->getMessage());
        }
    }

    public function getAllTasks()
    {
        try {
            $result = $this->dynamoDb->scan([
                'TableName' => $this->tableName,
            ]);

            return $result['Items'] ?? [];
        } catch (DynamoDbException $e) {
            throw new \Exception("Unable to fetch tasks: " . $e->getMessage());
        }
    }

public function updateTask($taskId, $taskData)
{
    try {
        $key = [
            'task_id' => ['S' => $taskId],
        ];

        $expressionAttributeNames = [
            '#name' => 'name', // Alias para el campo "name"
        ];

        $expressionAttributeValues = [
            ':name' => ['S' => $taskData['name']],
            ':description' => ['S' => $taskData['description']],
            ':process' => ['S' => $taskData['process']],
        ];

        $result = $this->dynamoDb->updateItem([
            'TableName' => $this->tableName,
            'Key' => $key,
            'UpdateExpression' => 'SET #name = :name, description = :description, process = :process',
            'ExpressionAttributeNames' => $expressionAttributeNames,
            'ExpressionAttributeValues' => $expressionAttributeValues,
        ]);

        return $result;
    } catch (DynamoDbException $e) {
        throw new \Exception("Unable to update task: " . $e->getMessage());
    }
}


    public function deleteTask($taskId)
    {
        try {
            $key = [
                'task_id' => ['S' => $taskId],
            ];

            $result = $this->dynamoDb->deleteItem([
                'TableName' => $this->tableName,
                'Key' => $key,
            ]);

            return $result;
        } catch (DynamoDbException $e) {
            throw new \Exception("Unable to delete task: " . $e->getMessage());
        }
    }
}
