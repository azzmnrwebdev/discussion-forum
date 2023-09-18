<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CollectionController as DashboardCollectionController;
use App\Http\Controllers\Dashboard\FavoriteController as DashboardFavoriteController;
use App\Http\Controllers\Dashboard\PostController as DashboardPostController;
use App\Http\Controllers\Dashboard\SettingController as DashboardSettingController;
use App\Http\Controllers\Dashboard\User\PostController as UserPostController;
use App\Http\Controllers\Dashboard\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Dashboard\Admin\PostController as AdminPostController;
use App\Http\Controllers\Dashboard\Admin\UserController as AdminUserController;

use App\Http\Controllers\DiskusiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UploadController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('diskusi', [DiskusiController::class, 'index'])->name('diskusi');
Route::get('katalog', [KatalogController::class, 'index'])->name('katalog');
Route::get('kontak', [KontakController::class, 'index'])->name('kontak');

Route::middleware('auth')->group(function () {
    Route::post('like/{post}', [PostController::class, 'like'])->name('post.like');
    Route::post('favorite/{post}', [PostController::class, 'favorite'])->name('post.favorite');

    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
});

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::middleware(['role:admin,user'])->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::resource('collection', DashboardCollectionController::class)->only('index', 'show');
        Route::resource('favorite', DashboardFavoriteController::class)->only('index', 'show');

        Route::prefix('settings-and-privacy')->controller(DashboardSettingController::class)->group(function () {
            Route::prefix('account')->group(function () {
                Route::get('/', 'account')->name('account');
                Route::get('information', 'accountInformation')->name('account.account_information');
                Route::put('information/{id}', 'updateAccount')->name('account.update_account');
            });

            Route::prefix('privacy')->group(function () {
                Route::get('/', 'privacy')->name('privacy');
            });

            Route::prefix('security')->group(function () {
                Route::get('/', 'security')->name('security');
                Route::get('change-password', 'changePassword')->name('security.change_password');
                Route::post('change-password', 'updatePassword')->name('security.update_password');
            });
        });
    });

    // role user
    Route::middleware(['role:user'])->group(function () {
        Route::resource('posts', UserPostController::class)->names([
            'index'   => "user.posts.index",
            'create'  => "user.posts.create",
            'store'   => "user.posts.store",
            'show'    => "user.posts.show",
            'edit'    => "user.posts.edit",
            'update'  => "user.posts.update",
            'destroy' => "user.posts.destroy",
        ]);

        Route::post('uploadImage', [UploadController::class, 'store'])->name('filePond.upload_image');
        Route::delete('deleteImage', [UploadController::class, 'destroy'])->name('filePond.delete_image');
    });

    // role admin
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::resource('users', AdminUserController::class)->except('show');
        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::resource('posts', AdminPostController::class)->only('index', 'destroy')->names([
            'index'   => "admin.posts.index",
            'destroy' => "admin.posts.destroy",
        ]);

        Route::get('posts/@{username}/{post}', [AdminPostController::class, 'show'])->name('admin.posts.show');
    });
});

Route::middleware('guest')->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'register')->name('register');
        Route::post('register', 'registrationProcess')->name('registration_process');
    });

    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'loginProcess')->name('login_process');
    });
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');
