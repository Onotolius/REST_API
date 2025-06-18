<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Route;
use App\Controller;
use App\Router;

Route::get('/tasks', [Controller::class, 'index']);
Route::post('/tasks', [Controller::class, 'store']);
Route::get('/tasks/{id}', [Controller::class, 'show']);
Route::delete('/tasks/{id}', [Controller::class, 'destroy']);
Route::put('/tasks/{id}/edit', [Controller::class, 'edit']);

$router = new Router(Route::getRoutes());
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
// Запуск
$router->dispatch($uri, $method);