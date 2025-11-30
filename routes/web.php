<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PokemonController;


Route::get('/Pokemon', [PokemonController::class,'index']);