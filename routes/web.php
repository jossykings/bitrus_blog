<?php

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

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\authController;
use App\Http\Controllers\postController;

Route::get('/', [authController::class, 'welcome'])->name('welcome');
Route::get('/blog', [postController::class, 'blog'])->name('blog');
Route::post('/comment/{id}', [postController::class, 'comment'])->name('comment');
Route::get('register', [authController::class, 'register'])->name('register')->middleware('guest');
Route::get('post/{id}', [postController::class, 'postsingle'])->name('showsinglepost');
Route::post('register', [authController::class, 'userstore'])->name('userstore');
Route::get('login', [authController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [authController::class, 'loginuser'])->name('userlogin');
Route::post('logout', [authController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('post/{id}/like', [postController::class, 'likes'])->name('like')->middleware('auth');
Route::delete('post/{id}/like', [postController::class, 'delete'])->name('deletelike')->middleware('auth');

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/create', [authController::class, 'create'])->name('create');
    Route::post('/{id}', [authController::class, 'addtoadmin'])->name('addtoadmin');
    Route::post('/{id}/admindel', [authController::class, 'removeadmin'])->name('removeadmin');
    Route::delete('/delete/{id}', [authController::class, 'deleteuser'])->name('deleteuser');
    Route::get('/edit/{id}', [postController::class, 'editshow'])->name('editshow');
    Route::post('/edit/{id}', [postController::class, 'edit'])->name('edit');
    Route::delete('/post/{id}', [postController::class, 'deletepost'])->name('deletepost');
    Route::get('/dashboard', [authController::class, 'admindashboard'])->name('dashboard');
    Route::post('/create', [postController::class, 'createstore'])->name('createstore');
});
