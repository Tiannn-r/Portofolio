<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\ContactMessageController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\EducationController;
use App\Http\Controllers\Api\Admin\ProfileController;
use App\Http\Controllers\Api\Admin\ProjectController;
use App\Http\Controllers\Api\Admin\ServiceController;
use App\Http\Controllers\Api\Admin\SkillController;
use App\Http\Controllers\Api\PublicPortfolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Portfolio Endpoints (Accessible by Visitors & Frontend Vue 3)
|--------------------------------------------------------------------------
*/
Route::prefix('portfolio')->group(function () {
    Route::get('/', [PublicPortfolioController::class, 'all']);
});

Route::get('/profile', [PublicPortfolioController::class, 'profile']);
Route::get('/skills', [PublicPortfolioController::class, 'skills']);
Route::get('/services', [PublicPortfolioController::class, 'services']);
Route::get('/projects', [PublicPortfolioController::class, 'projects']);
Route::get('/projects/{slug}', [PublicPortfolioController::class, 'projectDetail']);
Route::get('/educations', [PublicPortfolioController::class, 'educations']);
Route::post('/contact', [PublicPortfolioController::class, 'sendContactMessage'])->middleware('throttle:10,1');

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/
Route::post('/admin/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Admin CMS Endpoints (Protected by Laravel Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    // Auth & Info
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Dashboard
    Route::get('/stats', [DashboardController::class, 'stats']);

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);

    // Skills CRUD
    Route::apiResource('skills', SkillController::class);

    // Services CRUD
    Route::apiResource('services', ServiceController::class);

    // Projects CRUD
    Route::apiResource('projects', ProjectController::class);
    // Support multipart/form-data for project update with file thumbnail
    Route::post('projects/{project}', [ProjectController::class, 'update']);

    // Educations & Certifications CRUD
    Route::apiResource('educations', EducationController::class);

    // Contact Messages
    Route::get('/messages', [ContactMessageController::class, 'index']);
    Route::get('/messages/{message}', [ContactMessageController::class, 'show']);
    Route::patch('/messages/{message}/read', [ContactMessageController::class, 'toggleRead']);
    Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy']);
});
