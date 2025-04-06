<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.users.index')->middleware('role:admin');
Route::put('/admin/{user}', [AdminController::class, 'update'])->name('admin.users.update')->middleware('role:admin');
Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy')->middleware('role:admin');
Route::post('/admin/{user}/password', [AdminController::class, 'changePassword'])->name('admin.users.password')->middleware('role:admin');

Route::middleware(['auth'])->group(function () {
    Route::get('/game', [GameController::class, 'index'])->name('game.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::put('/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
        Route::get('/{task}/history', [TaskController::class, 'history'])->name('tasks.history');
    });


    Route::prefix('articles')->name('articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('.index');
        Route::get('/create', [ArticleController::class, 'create'])->name('.create');
        Route::post('/', [ArticleController::class, 'store'])->name('.store');
        Route::get('/{article}', [ArticleController::class, 'show'])->name('.show');
        Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('.edit');
        Route::put('/{article}', [ArticleController::class, 'update'])->name('.update');
        Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('.destroy');
        Route::get('/history/list', [ArticleController::class, 'history'])->name('.history');
        Route::put('/{id}/restore', [ArticleController::class, 'restore'])->name('.restore');
    });
});
