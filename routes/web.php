<?php

use Illuminate\Support\Facades\Route;

// Rota para a página inicial - web
Route::get('/', function () {
    return view('home');
})->name('home');


