<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return 'This is Home page';
});

Route::get('/about', function () {
    return view('about');
});

// Categories routes
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])
    ->name('categories.store');
Route::get('/categories/{category}', [CategoryController::class, 'edit'])
    ->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])
    ->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'delete'])
    ->name('categories.delete');
Route::get('/categories/restore/{category}', [CategoryController::class, 'restore'])
    ->name('categories.restore');
Route::get('/categories/destroy/{category}', [CategoryController::class, 'destroy'])
    ->name('categories.destroy');

// Brands routes
Route::get('/brands', [BrandController::class, 'index'])
    ->name('brands.index');
Route::post('/brands', [BrandController::class, 'store'])
    ->name('brands.store');
Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])
    ->name('brands.edit');
Route::patch('/brands/{brand}', [BrandController::class, 'update'])
    ->name('brands.update');


Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::all();
    $users = DB::table('users')->get();
    return view('dashboard', compact('users'));
})->name('dashboard');
