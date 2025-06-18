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
    public function store() {}


    public function notFound()
    {
        http_response_code(404);
        echo json_encode([
            'error' => 'Resource not found',
            'code' => 404
        ]);
    }
}