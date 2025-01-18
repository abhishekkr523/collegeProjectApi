<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\TeacherController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Admin routes
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::post('/admin/create-user', [AdminController::class, 'createUser']);
});

// HOD routes (accessible by hod and librarian)
Route::middleware(['auth:sanctum', 'role:HOD'])->group(function () {
    Route::get('/hod/dashboard', [HodController::class, 'dashboard']);
});

// Teacher routes (accessible by teacher and librarian)
Route::middleware(['auth:sanctum', 'role:Teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard']);
});

// Librarian routes
Route::middleware(['auth:sanctum', 'role:Librarian'])->group(function () {

    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{id}', [BookController::class, 'show']);
    Route::post('books', [BookController::class, 'store']);
    Route::put('books/{id}', [BookController::class, 'update']);
    Route::delete('books/{id}', [BookController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:User'])->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']); // Add new user
    Route::put('users/{user}', [UserController::class, 'update']); // Update user
    Route::delete('users/{user}', [UserController::class, 'destroy']); // Delete user
    Route::post('users/{user}/roles', [UserController::class, 'assignRole']); // Assign role to user
});

