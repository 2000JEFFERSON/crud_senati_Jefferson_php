<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PokemonController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/User', [UserController::class,'index']);
Route::get('/User/edit', [UserController::class,'edit']);
Route::post('/User/update', [UserController::class,'update']);
Route::get('/Cursos', [CursoController::class,'index']);

Route::get('/User/create', [UserController::class,'create']);
Route::post('/User/store', [UserController::class,'store']);
Route::get('/User/delete', [UserController::class,'delete']);
Route::get('/Pokemon', [PokemonController::class,'index']);