<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\ListCompanies;
use App\Http\Livewire\ListProjects;
use App\Http\Livewire\ListRequirements;
use App\Http\Livewire\ListEndProducts;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\EndProductsController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/attachment', function () {
    return view('attachment.form',['title' =>'herşey yanlış']);
});

Route::get('/login', function () {
    return view('attachment.form',['title' =>'herşey yanlış']);
})->name('login');

Route::get('/register', function () {
    return view('attachment.form',['title' =>'herşey yanlış']);
})->name('register');




// Route::middleware(['auth'])->group(function () {





    // Companies
    Route::get('/companies', ListCompanies::class);
    Route::get('/companies/view/{id}', [CompanyController::class, 'view']);
    Route::get('/companies/form/{id?}', [CompanyController::class, 'form']);
    Route::post('/companies/store/{id?}', [CompanyController::class, 'store']);
    Route::get('/companies/delete/{id}', [CompanyController::class, 'delete']);



    // Projects
    Route::get('/projects', ListProjects::class);
    Route::get('/projects/view/{id}', [ProjectController::class, 'view']);
    Route::get('/projects/form/{id?}', [ProjectController::class, 'form']);
    Route::post('/projects/store/{id?}', [ProjectController::class, 'store']);
    Route::get('/projects/delete/{id}', [ProjectController::class, 'delete']);


    // End Products
    Route::get('/endproducts', ListEndProducts::class);
    Route::get('/endproducts/view/{id}', [EndProductsController::class, 'view']);
    Route::get('/endproducts/form/{id?}', [EndProductsController::class, 'form']);
    Route::post('/endproducts/store/{id?}', [EndProductsController::class, 'store']);
    Route::get('/endproducts/delete/{id}', [EndProductsController::class, 'delete']);



    // Requirements
    Route::get('/requirements', ListRequirements::class);
    Route::get('/requirements/view/{id}', [RequirementController::class, 'view']);
    Route::get('/requirements/form/{id?}', [RequirementController::class, 'form']);
    Route::post('/requirements/store/{id?}', [RequirementController::class, 'store']);
    Route::get('/requirements/delete/{id}', [RequirementController::class, 'delete']);


    // Route::get('/projects', function () {
    //     return view('attachment.form',['title' =>'herşey yanlış']);
    // })->name('register');

// });

