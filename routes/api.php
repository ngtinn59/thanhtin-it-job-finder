<?php

use App\Http\Controllers\Api\Admin\CountriesController;
use App\Http\Controllers\Api\Admin\LocationsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Companies\CompaniesController;
use App\Http\Controllers\Api\Companies\CompanyLocationsController;
use App\Http\Controllers\Api\Companies\Job_skillsController;
use App\Http\Controllers\Api\Companies\Job_typesController;
use App\Http\Controllers\Api\Companies\JobsController;
use App\Http\Controllers\Api\Employer\EmployerRegisterController;
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
use App\Http\Controllers\Api\Resume\ProjectsController;
use App\Http\Controllers\Api\Resume\skillsController;
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

Route::get('/', [JobsController::class, 'index']);

Route::post('employer/register', [EmployerRegisterController::class, 'employerRegister']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group( function () {
    //ế
    Route::apiResource('profiles', profilesController::class);
    Route::apiResource('educations', EducationController::class);
    Route::apiResource('skills', skillsController::class);
    Route::resource('aboutme', AboutmeController::class);
    Route::resource('certificates', CertificatesController::class);
    Route::resource('awards', AwardsController::class);
    Route::resource('projects', ProjectsController::class);
    Route::resource('getresume', GetResumeController::class);


    //Company
    Route::resource('companies', CompaniesController::class);
    Route::resource('locations', LocationsController::class);
    Route::resource('country', CountriesController::class);
    Route::apiResource('experiences', ExperiencesController::class);
    Route::resource('companies/location', CompanyLocationsController::class);
    Route::post('/companies/logo', [CompaniesController::class, 'logo'])->name('logo');

    //Jobs
    Route::resource('job/job_types', Job_typesController::class);
    Route::resource('job', JobsController::class);
    Route::resource('job/skill', Job_skillsController::class);


    Route::post('logout', [AuthController::class, 'logout']);
});
