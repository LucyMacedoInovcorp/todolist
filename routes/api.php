<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rotas da API para tarefas
Route::get('/tarefas', [TarefaController::class, 'index']);
Route::post('/tarefas', [TarefaController::class, 'store']);
Route::get('/tarefas/{tarefa}', [TarefaController::class, 'show']);
Route::put('/tarefas/{tarefa}', [TarefaController::class, 'update']);
Route::delete('/tarefas/{tarefa}', [TarefaController::class, 'destroy']);
Route::patch('/tarefas/{tarefa}/toggle', [TarefaController::class, 'toggleComplete']);