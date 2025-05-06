<?php

use App\Exports\BooksExport;
use App\Http\Controllers\Admin\IssueBookController;
use App\Http\Controllers\Admin\SendMailController;
use Illuminate\Http\Request;

use App\Models\CourseCategory;
use Illuminate\Types\Relations\Role;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HodController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseCategoryController;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{id}', [BookController::class, 'show']);
    Route::post('books', [BookController::class, 'store']);
    Route::put('books/{id}', [BookController::class, 'update']);
    Route::delete('books/{id}', [BookController::class, 'destroy']);
    Route::get('/export-books', function () {
        return Excel::download(new BooksExport, 'books.xlsx');
    });
    Route::post('/books/import', [BookController::class, 'import']);
    
});

Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']); // Add new user
Route::put('users/{user}', [UserController::class, 'update']); // Update user
Route::delete('users/{user}', [UserController::class, 'destroy']); // Delete user
Route::get('/export-users', [UserController::class, 'export']);

Route::get('student', [StudentController::class, 'index']);
Route::post('student', [StudentController::class, 'store']);
Route::post('student/{id}', [StudentController::class, 'update']);
Route::delete('student/{id}', [StudentController::class, 'destroy']);
Route::get('roles/{roleId}/users', [UserController::class, 'getUsersByRole']);

Route::get('marks', [MarksController::class, 'index']);

Route::get('marks/{id}', [MarksController::class, 'show']);
Route::post('marks', [MarksController::class, 'store']);
Route::post('marks/{id}', [MarksController::class, 'update']);
Route::post('marks/import', [MarksController::class, 'import'])->name('import');
Route::delete('marks/{id}', [MarksController::class, 'destroy']);
// Assign role to user
Route::post('/assign-role', [AuthController::class, 'assignRole']);


Route::get('/notices', [NoticeController::class, 'index']);
Route::post('/notices', [NoticeController::class, 'store']);
Route::get('/notices/{id}/download', [NoticeController::class, 'download']);
Route::delete('/notices/{id}', [NoticeController::class, 'deleteNotice']);
Route::post('/notices/{notice}', [NoticeController::class, 'update']);


Route::get('role', [RoleController::class, 'index']);
Route::get('year', [YearController::class, 'index']);
Route::get('semester', [SemesterController::class, 'index']);

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']); // Get all courses
    Route::post('/', [CourseController::class, 'store']); // Add a course
    Route::get('/{id}', [CourseController::class, 'show']); // Get a single course
    Route::put('/{id}', [CourseController::class, 'update']); // Update a course
    Route::delete('/{id}', [CourseController::class, 'destroy']); // Delete a course
});

Route::get('courseCate', [CourseCategoryController::class, 'index']);
Route::get('/courseCate/{category_id}', [CourseCategoryController::class, 'show']);
Route::get('/download/{filename}', function ($filename) {
    $path = storage_path("app/public/notices/" . $filename);

    if (!file_exists($path)) {
        return response()->json(["error" => "File not found"], 404);
    }

    return Response::download($path);
});
Route::get('/export-notices', [NoticeController::class, 'exportNotices']);

Route::prefix('issue-book')->group(function () {
    Route::get('/', [IssueBookController::class, 'index']);
    Route::post('/', [IssueBookController::class, 'addingBookIssue']);
    Route::get('/{id}', [IssueBookController::class, 'show']);
    Route::post('/{id}', [IssueBookController::class, 'update']);
    Route::delete('/{id}', [IssueBookController::class, 'destroy']);
});
Route::get('/check-status', [IssueBookController::class, 'checkAddingStatus']);
Route::get('/check-student', [IssueBookController::class, 'findStudent']);

Route::post('/send-email', [SendMailController::class, 'sendEmail']);

Route::apiResource('attendances', AttendanceController::class);

Route::prefix('subjects')->group(function () {
    Route::get('/', [SubjectController::class, 'index']);        // Get all subjects
    Route::post('/', [SubjectController::class, 'store']);       // Create a new subject
    Route::get('/{id}', [SubjectController::class, 'show']);     // Get a single subject
    Route::put('/{id}', [SubjectController::class, 'update']);   // Update a subject
    Route::delete('/{id}', [SubjectController::class, 'destroy']);// Delete a subject
});
