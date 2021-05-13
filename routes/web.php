<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnlistController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [StoryController::class, 'index'])->name('home');
Route::get('top-stories', [StoryController::class, 'topStories'])->name('top_stories');

Route::prefix('story')->group(function () {
    Route::get('/', [StoryController::class, 'index'])->name('story.home');
    Route::get('create', [StoryController::class, 'create'])->name('story.create')->middleware(['auth']);
    Route::post('create', [StoryController::class, 'store'])->name('story.store')->middleware(['auth']);
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

Route::prefix('author')->name('author.')->group(function () {
    Route::get('{author:slug}', [AuthorController::class, 'show'])->name('show');
});

require __DIR__.'/auth.php';
