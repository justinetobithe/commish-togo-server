<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EducationalAttainmentController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkExperienceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum', 'throttle:60,1')->group(function () {

    Broadcast::routes(['middleware' => 'auth:sanctum']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', MeController::class);

    Route::post('/auth/user', [AuthController::class, 'user']);

    Route::get('/users', [UserController::class, 'index']);
    Route::prefix('/user')->group(function () {
        Route::get('/{user}/notifications', [UserController::class, 'notifications']);
        Route::post('/notifications/mark-as-read/{id}', [UserController::class, 'markAsRead']);

        Route::put('/{id}', [UserController::class, 'update']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });


    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', [MessageController::class, 'index']);
        Route::post('send-message', [MessageController::class, 'send_message']);
    });

    Route::get('/services', [ServiceController::class, 'index']);
    Route::prefix('/service')->group(function () {
        Route::put('/{id}', [ServiceController::class, 'update']);
        Route::post('/', [ServiceController::class, 'store']);
        Route::get('/{user}', [ServiceController::class, 'show']);
        Route::delete('/{user}', [ServiceController::class, 'destroy']);
    });

    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/user-posts', [PostController::class, 'userPosts']);
    Route::prefix('/post')->group(function () {
        Route::put('/{id}', [PostController::class, 'update']);
        Route::post('/', [PostController::class, 'store']);
        Route::get('/{user}', [PostController::class, 'show']);
        Route::delete('/{user}', [PostController::class, 'destroy']);
    });

    Route::get('/job-applications', [JobApplicationController::class, 'index']);
    Route::prefix('/job-application')->group(function () {
        Route::put('/{id}', [JobApplicationController::class, 'update']);
        Route::post('/', [JobApplicationController::class, 'store']);
        Route::get('/{user}', [JobApplicationController::class, 'show']);
        Route::delete('/{user}', [JobApplicationController::class, 'destroy']);
    });

    Route::prefix('/resume')->group(function () {
        Route::post('/', [ResumeController::class, 'store']);
        Route::put('/{resume}', [ResumeController::class, 'update']);
        Route::delete('/{resume}', [ResumeController::class, 'destroy']);

        Route::get('/user', [ResumeController::class, 'getUserResumes']);
    });

    Route::get('/profiles', [ProfileController::class, 'index']);
    Route::prefix('/profile')->group(function () {
        Route::get('/user/{userId}', [ProfileController::class, 'showForUser']);
        Route::post('/', [ProfileController::class, 'store']);
        Route::put('/{id}', [ProfileController::class, 'update']);
    });

    Route::prefix('/work-experience')->group(function () {
        Route::get('/', [WorkExperienceController::class, 'index']);
        Route::post('/', [WorkExperienceController::class, 'store']);
        Route::put('/{id}', [WorkExperienceController::class, 'update']);
        Route::delete('/{id}', [WorkExperienceController::class, 'destroy']);
    });

    Route::prefix('/educational-attainment')->group(function () {
        Route::get('/', [EducationalAttainmentController::class, 'index']);
        Route::post('/', [EducationalAttainmentController::class, 'store']);
        Route::put('/{id}', [EducationalAttainmentController::class, 'update']);
        Route::delete('/{id}', [EducationalAttainmentController::class, 'destroy']);
    });

    // Route::get('/conversations', [ConversationController::class, 'index']);
    // Route::prefix('/conversation')->group(function () {
    //     Route::post('/', [ConversationController::class, 'store']);
    //     Route::get('/{id}', [ConversationController::class, 'show']);
    // });
});
