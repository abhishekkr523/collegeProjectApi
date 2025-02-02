<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Admin routes
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    // Route::post('/assign-role', [AuthController::class, 'assignRole']);
});

// HOD routes (accessible by hod and librarian)
Route::middleware(['auth:sanctum', 'role:HOD'])->group(function () {});

// Teacher routes (accessible by teacher and librarian)
Route::middleware(['auth:sanctum', 'role:Teacher'])->group(function () {});

// Librarian routes
Route::middleware(['auth:sanctum', 'role:Librarian'])->group(function () {});

Route::middleware(['auth:sanctum', 'role:User'])->group(function () {});


Route::get('books', [BookController::class, 'index']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::post('books', [BookController::class, 'store']);
Route::put('books/{id}', [BookController::class, 'update']);
Route::delete('books/{id}', [BookController::class, 'destroy']);


Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']); // Add new user
Route::put('users/{user}', [UserController::class, 'update']); // Update user
Route::delete('users/{user}', [UserController::class, 'destroy']); // Delete user
     
Route::get('student', [StudentController::class, 'index']);
Route::post('student', [StudentController::class, 'store']); 
Route::post('student/{id}', [StudentController::class, 'update']); 
Route::delete('student/{id}', [StudentController::class, 'destroy']); 
Route::get('roles/{roleId}/users', [UserController::class, 'getUsersByRole']);

Route::get('marks', [MarksController::class, 'index']);
Route::get('marks/{id}', [MarksController::class, 'show']);
Route::post('marks', [MarksController::class, 'store']); 
Route::post('marks/{id}', [MarksController::class, 'update']); 
Route::delete('marks/{id}', [MarksController::class, 'destroy']); 
     // Assign role to user
 Route::post('/assign-role', [AuthController::class, 'assignRole']);
