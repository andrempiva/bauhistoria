<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnlistController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('top-historias', [StoryController::class, 'topStories'])->name('top-stories');
Route::view('sobre', 'about')->name('about');

Route::prefix('historias')->group(function () {
    Route::get('/', [StoryController::class, 'index'])->name('story.index');
    Route::get('criar', [StoryController::class, 'create'])->name('story.create')->middleware(['auth', 'unbanned']);
    Route::post('criar', [StoryController::class, 'store'])->name('story.store')->middleware(['auth', 'unbanned']);
    Route::post('{story:slug}/tag/{tag}/rateup', [StoryController::class, 'rateUp'])->name('story.tag.rateup')->middleware(['auth']);
    Route::post('{story:slug}/tag/{tag}/ratedown', [StoryController::class, 'rateDown'])->name('story.tag.ratedown')->middleware(['auth']);
    Route::get('{story:slug}/editar', [StoryController::class, 'edit'])->name('story.edit')->middleware(['auth', 'unbanned']);
    Route::post('{story:slug}/editar', [StoryController::class, 'update'])->name('story.update')->middleware(['auth', 'unbanned']);
    Route::post('{story:slug}/tag', [StoryController::class, 'assignTag'])->name('story.tag.assign')->middleware(['auth', 'unbanned']);
    Route::get('{story:slug}', [StoryController::class, 'show'])->name('story.show');
});

Route::post('profile/update', function () { return back(); })->name('profile.update');
Route::get('profile/{user:name}', [UserController::class, 'profile'])->name('profile');
Route::get('settings', [UserController::class, 'settings'])->name('settings');
Route::post('settings', [UserController::class, 'settingsUpdate'])->name('settings.update');
Route::post('settings/profile', [UserController::class, 'profileUpdate'])->name('settings.profile');
Route::post('settings/password', [UserController::class, 'passwordUpdate'])->name('settings.password');

Route::middleware(['auth'])->prefix('ownlist')->name('ownlist.')->group(function () {
    Route::get('add/{story}', [OwnlistController::class, 'add'])->name('add');
    Route::get('listAs/{story}', [OwnlistController::class, 'listAs'])->name('listAs');
    Route::post('update/{story}', [OwnlistController::class, 'update'])->name('update');
    Route::get('remove/{story}', [OwnlistController::class, 'remove'])->name('remove');
});

Route::prefix('autores')->name('author.')->group(function () {
    Route::get('{author:slug}', [AuthorController::class, 'show'])->name('show');
});

Route::prefix('tags')->middleware(['auth', 'unbanned'])->name('tags.')->group(function () {
    Route::get('create', [TagController::class, 'create'])->name('create');
    Route::post('create', [TagController::class, 'store'])->name('store');
});

Route::prefix('admin')->middleware(['admin'])->name('admin.')->group(function() {
    Route::get('', [AdminController::class, 'index'])->name('home');
    Route::prefix('usuarios')->name('users.')->group(function () {
        Route::get('', [AdminController::class, 'usersIndex'])->name('index');
        Route::get('{user}/edit', [AdminController::class, 'usersEdit'])->name('edit');
        Route::post('{user}/edit', [AdminController::class, 'usersUpdate'])->name('update');
        Route::delete('{user}', [AdminController::class, 'usersDestroy'])->name('destroy');
        Route::get('{user}', [AdminController::class, 'usersShow'])->name('show');
    });
    Route::prefix('historias')->name('stories.')->group(function () {
        Route::get('', [AdminController::class, 'storiesIndex'])->name('index');
        Route::get('{story}/edit', [StoryController::class, 'edit'])->name('edit');
        Route::post('{story}/edit', [StoryController::class, 'update'])->name('update');
        Route::delete('{story}', [AdminController::class, 'storiesDestroy'])->name('destroy');
        // Route::get('{story}', [AdminController::class, 'storiesShow'])->name('show');
    });
    Route::prefix('autores')->name('authors.')->group(function () {
        Route::get('', [AdminController::class, 'authorsIndex'])->name('index');
        Route::get('{author}/edit', [AdminController::class, 'authorsEdit'])->name('edit');
        Route::post('{author}/edit', [AdminController::class, 'authorsUpdate'])->name('update');
        Route::delete('{author}', [AdminController::class, 'authorsDestroy'])->name('destroy');
        Route::get('{author}', [AdminController::class, 'authorsShow'])->name('show');
    });
    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('', [AdminController::class, 'tagsIndex'])->name('index');
        Route::get('{tag}/edit', [AdminController::class, 'tagsEdit'])->name('edit');
        Route::post('{tag}/edit', [AdminController::class, 'tagsUpdate'])->name('update');
        Route::delete('{tag}', [AdminController::class, 'tagsDestroy'])->name('destroy');
        Route::get('{tag}', [AdminController::class, 'tagsShow'])->name('show');
    });
});

require __DIR__.'/auth.php';
