<?php

use App\Http\Controllers\Api\Admin\Company_typesController;
use App\Http\Controllers\Api\Admin\CompanysizesController;
use App\Http\Controllers\Api\Admin\CompanytypesController;
use App\Http\Controllers\Api\Admin\CountriesController;
use App\Http\Controllers\Api\Admin\Job_typesController;
use App\Http\Controllers\Api\Admin\LocationsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Companies\CompaniesController;
use App\Http\Controllers\Api\Companies\CompanyLocationsController;
use App\Http\Controllers\Api\Companies\Job_skillsController;
use App\Http\Controllers\Api\Companies\JobsController;
use App\Http\Controllers\Api\Employer\EmployerRegisterController;
use App\Http\Controllers\Api\Recruitments\experience_levelController;
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

// Jobs
Route::resource('job', JobsController::class)->only([
    'index', 'show'
]);

Route::post('employer/register', [EmployerRegisterController::class, 'employerRegister']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('profile', profilesController::class);
    Route::resource('profiles/educations', EducationController::class);
    Route::resource('profiles/skills', skillsController::class);
    Route::resource('profiles/aboutme', AboutmeController::class);
    Route::resource('profiles/certificates', CertificatesController::class);
    Route::resource('profiles/awards', AwardsController::class);
    Route::resource('profiles/projects', ProjectsController::class);
    Route::resource('profiles/getresume', GetResumeController::class);
    Route::apiResource('profiles/experiences', ExperiencesController::class);


    //Company
    Route::resource('companies', CompaniesController::class);
    Route::resource('companies/location', CompanyLocationsController::class);

    //Jobs
    Route::resource('job/skill', Job_skillsController::class);
    Route::resource('job', JobsController::class);

    //Admin
    Route::resource('Admin/job_types', Job_typesController::class);
    Route::resource('Admin/experience_level', experience_levelController::class);
    Route::resource('Admin/locations', LocationsController::class);
    Route::resource('Admin/country', CountriesController::class);
    Route::resource('Admin/companytype', CompanytypesController::class);
    Route::resource('Admin/companysize', CompanysizesController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});
