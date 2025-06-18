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
        $json = file_get_contents($this->dataPath);
        var_dump($json);
    }
    public function store()
    {
        $input = file_get_contents('php://input');
        $jsonData = json_decode($input, true);
        $tasks = json_decode(file_get_contents($this->dataPath, true));
        $newTask = [
            'id' => $this->generateNextId($tasks),
            'title' => $jsonData['title'],
            'description' => $jsonData['description'],
            'created_at' => date('c')
        ];
        $tasks[] = $newTask;
        file_put_contents($this->dataPath, json_decode($tasks, JSON_PRETTY_PRINT));
        echo json_encode(['message' => 'Task added', 'task' => $newTask]);
    }
    public function show(int $id) {}
    public function edit(int $id) {}
    public function destroy(int $id) {}


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