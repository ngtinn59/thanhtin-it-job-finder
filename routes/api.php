<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecruitmentsController;
use App\Http\Controllers\Api\Resume\EducationController;
use App\Http\Controllers\Api\Resume\ExperiencesController;
use App\Http\Controllers\Api\Resume\profilesController;
use App\Http\Controllers\Api\Resume\ProjectController;
use App\Http\Controllers\Api\Resume\ResponsibilitiesController;
use App\Http\Controllers\Api\Resume\skillsController;
use App\Http\Controllers\Api\Resume\StackController;
use App\Http\Controllers\Developer\DeveloperController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('profiles', profilesController::class);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('me', [DeveloperController::class, 'me']);

    Route::prefix('profiles')->group(function () {
        Route::apiResource('skills', skillsController::class);
        Route::resource('experiences', ExperiencesController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('educations', EducationController::class);
        Route::resource('stacks', StackController::class);
        Route::resource('responsibilities', ResponsibilitiesController::class);
    });

    Route::apiResource('recruitments', RecruitmentsController::class);
});


