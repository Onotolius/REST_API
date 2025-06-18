<?php

namespace App;

class Controller
{
    private string $dataPath;

    public function __construct()
    {
        $this->dataPath = __DIR__ .  "/../data/tasks.json";
        header('Content-type: application/json');
    }
    public function index()
    {
        $tasks = json_decode(file_get_contents($this->dataPath), true);
        echo json_encode($tasks, JSON_PRETTY_PRINT);
    }
    public function store()
    {
        $input = file_get_contents('php://input');
        $jsonData = json_decode($input, true);
        $tasks = json_decode(file_get_contents($this->dataPath), true);
        if (!isset($jsonData['title'], $jsonData['description'])) {
            http_response_code(422);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }
        $newTask = [
            'id' => $this->generateNextId($tasks),
            'title' => $jsonData['title'],
            'description' => $jsonData['description'],
            'created_at' => date('c')
        ];
        $tasks[] = $newTask;
        file_put_contents($this->dataPath, json_encode($tasks, JSON_PRETTY_PRINT));
        echo json_encode(['message' => 'Task added', 'task' => $newTask]);
    }
    public function show(int $id)
    {
        $tasks = json_decode(file_get_contents($this->dataPath), true);
        foreach ($tasks as $task) {
            if ($task['id'] == $id) {
                echo json_encode($task, JSON_PRETTY_PRINT);
                return;
            }
        }
        $this->notFound();
    }
    public function edit(int $id)
    {
        $input = file_get_contents('php://input');
        $jsonData = json_decode($input, true);
        if (!isset($jsonData['title'], $jsonData['description'])) {
            http_response_code(422);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }
        $tasks = json_decode(file_get_contents($this->dataPath), true);
        foreach ($tasks as $index => $task) {
            if ($task['id'] == $id) {
                $tasks[$index] = [
                    'id' => $id,
                    'title' => $jsonData['title'],
                    'description' => $jsonData['description'],
                ];
                file_put_contents($this->dataPath, json_encode($tasks, JSON_PRETTY_PRINT));
                echo json_encode(['message' => 'Task updated', 'task' => $tasks[$index]]);
                return;
            }
        }
        $this->notFound();
    }
    public function destroy(int $id)
    {
        $tasks = json_decode(file_get_contents($this->dataPath), true);
        foreach ($tasks as $index => $task) {
            if ($task['id'] == $id) {
                $deletedTask = $task;
                unset($tasks[$index]);
                file_put_contents($this->dataPath, json_encode($tasks, JSON_PRETTY_PRINT));
                echo json_encode(['message' => 'Task deleted', 'task' => $deletedTask]);
                return;
            }
        }
        $this->notFound();
    }
    public function notFound()
    {
        http_response_code(404);
        echo json_encode([
            'error' => 'Resource not found',
            'code' => 404
        ]);
    }
    public function generateNextId(array $tasks)
    {
        if (empty($tasks)) {
            return 1;
        }
        $ids = array_column($tasks, 'id');
        return max($ids) + 1;
    }
}