<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AboutController;
use App\Http\Controllers\API\SkillController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\BlogPostController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\EducationController;
use App\Http\Controllers\API\ExperienceController;
use App\Http\Controllers\API\TestimonialController;

Route::prefix('guest')->group(function () {
    Route::get('/about', [AboutController::class, 'index']);
    Route::get('/skills', [SkillController::class, 'index']);
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/projects', [ProjectController::class, 'index']); 
    Route::get('/categories', [ProjectController::class, 'index']); 
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::post('/contacts', [ContactController::class, 'store']);
});



Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum','admin'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('about', AboutController::class);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('educations', EducationController::class);
    Route::apiResource('experiences', ExperienceController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('testimonials', TestimonialController::class);
    Route::apiResource('contacts', ContactController::class);
}); 