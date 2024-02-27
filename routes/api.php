<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Recruitments\experience_levelController;
use App\Http\Controllers\Api\Recruitments\FormofworkController;
use App\Http\Controllers\Api\Recruitments\job_descriptionController;
use App\Http\Controllers\Api\Recruitments\job_requirementsController;
use App\Http\Controllers\Api\Recruitments\RecruitmentsController;
use App\Http\Controllers\Api\Recruitments\skills_requiredController;
use App\Http\Controllers\Api\Resume\AboutmeController;
use App\Http\Controllers\Api\Resume\AwardsController;
use App\Http\Controllers\Api\Resume\CertificatesController;
use App\Http\Controllers\Api\Resume\EducationController;
use App\Http\Controllers\Api\Resume\ExperiencesController;
use App\Http\Controllers\Api\Resume\GetResumeController;
use App\Http\Controllers\Api\Resume\profilesController;
use App\Http\Controllers\Api\Resume\ProjectController;
use App\Http\Controllers\Api\Resume\ProjectsController;
use App\Http\Controllers\Api\Resume\ResponsibilitiesController;
use App\Http\Controllers\Api\Resume\skillsController;
use App\Http\Controllers\Api\Resume\StackController;
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
    Route::apiResource('educations', EducationController::class);
    Route::apiResource('skills', skillsController::class);
    Route::resource('aboutme', AboutmeController::class);
    Route::resource('certificates', CertificatesController::class);
    Route::resource('awards', AwardsController::class);
    Route::resource('projects', ProjectsController::class);
    Route::resource('getresume', GetResumeController::class);

    Route::apiResource('experiences', ExperiencesController::class);
    Route::resource('stacks', StackController::class);
    Route::apiResource('responsibilities', ResponsibilitiesController::class);

    Route::prefix('profiles')->group(function () {
        Route::resource('projects', ProjectController::class);

        Route::prefix('projects')->group(function () {

        });


    });

    Route::apiResource('recruitments', RecruitmentsController::class);
    Route::prefix('recruitments')->group(function () {
        Route::apiResource('skills_recruitments', skills_requiredController::class);
        Route::apiResource('experience_level', experience_levelController::class);
        Route::apiResource('formofwork', FormofworkController::class);
        Route::apiResource('job_description', job_descriptionController::class);
        Route::apiResource('job_requirements', job_requirementsController::class);
    });
});
