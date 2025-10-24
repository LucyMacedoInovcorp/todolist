<?php

use Illuminate\Support\Facades\Route;

// Health check route for deployment
Route::get('/health', function () {
    return response()->json(['status' => 'OK', 'timestamp' => now()]);
});

// Rota para a página inicial - web (simplificada para deployment)
Route::get('/', function () {
    return response()->json([
        'message' => 'ToDo List API is running!',
        'status' => 'OK',
        'timestamp' => now(),
        'endpoints' => [
            'health' => '/health',
            'api' => '/api/tarefas'
        ]
    ]);
})->name('home');


