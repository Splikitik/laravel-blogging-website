<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RequestController;

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



// Route::get('/dashboard', [BlogController::class, 'show'])->name('dashboard');
Route::get('/index', [ChirpController::class, 'show'])->name('index');
Route::get('/myBlogs', [ChirpController::class, 'myBlogs'])->name('myBlogs');
Route::get('admin.dashboard', [BlogController::class, 'adminshow'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/profile', [ProfileController::class, 'admindestroy'])->name('profile.admindestroy');
Route::post('/profile', [ProfileController::class, 'roleChange'])->name('admin.roleChange');

Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy', 'create'])
    ->middleware(['auth', 'verified']);

Route::post('statusUpdate', [ChirpController::class, 'statusUpdate'])->name('chirps.statusUpdate');

Route::post('comment.store', [CommentController::class, 'store'])->name('comments.store');
Route::post('comment.update', [CommentController::class, 'update'])->name('comments.update');
Route::get('comment/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::delete('comment.destroy', [CommentController::class, 'destroy'])->name('comments.destroy');


Route::prefix('chirps')->group(function(){
    Route::get('/{chirp}/view', [ChirpController::class, 'view'])->name('chirps.view');
    Route::post('/search', [ChirpController::class, 'indexSearch'])->name('chirps.search');
});



Route::post('admin.accept', [RequestController::class, 'accept'])->name('admin.accept');
Route::get('admin/dashboard/blogs', [BlogController::class, 'blogShow'])->name('admin.blogs');
Route::get('admin/dashboard/requests', [BlogController::class, 'requestShow'])->name('admin.requests');
Route::get('admin/dashboard/users', [BlogController::class, 'userShow'])->name('admin.users');
Route::post('admin.reject', [RequestController::class, 'reject'])->name('admin.reject');
Route::get('admin.store', [RequestController::class, 'store'])->name('admin.store');
Route::post('admin.delete', [RequestController::class, 'destroy'])
    ->name('admin.delete')
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
