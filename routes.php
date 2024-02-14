<?php

use App\Controllers\AdminController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\PostController;
use App\Controllers\RegisterController;
use MVC\Route;
use App\Middlewares\Auth;
use App\Middlewares\Guest;
use App\Middlewares\Admin;

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
    Route::get ('/compte', [HomeController::class, 'index']) -> middleware (Auth::class),
    Route::get ('/compte/admin', [HomeController::class, 'index']) -> middleware (Auth::class),
    Route::get ('/deconnexion', [HomeController::class, 'index']) -> middleware (Auth::class),
    Route::post('/inscription', [HomeController::class, 'index']),
    Route::post('/connexion', [HomeController::class, 'index']),
    Route::get ('/inscription', [HomeController::class, 'index']) -> middleware (Guest::class),
    Route::get ('/connexion', [HomeController::class, 'index']) -> middleware (Guest::class),
    Route::get ('/compte/admin', [HomeController::class, 'index']) -> middleware (Admin::class),
    Route::post('/articles/{slug}/comment',[PostController::class, 'comment']),
];
