<?php

use App\Controllers\AdminController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\PostController;
use App\Controllers\RegisterController;
use MVC\Route;

return [
    Route::get('/', [PostController::class, 'index']),
    Route::get('/articles/{slug}', [PostController::class, 'show']),
    Route::get('/connexion', [LoginController::class, 'showLoginForm']),
    Route::post('/connexion', [LoginController::class, 'login']),
    Route::get('/inscription', [RegisterController::class, 'showRegisterForm']),
    Route::post('/inscription', [RegisterController::class, 'register']),
    Route::get('/compte', [HomeController::class, 'index']),
    Route::get('/compte/admin', [AdminController::class, 'index']),
    Route::post('/deconnexion', [LogoutController::class, 'logout']),
];
