<?php

use App\Http\Controllers\Admin\EducationLevelController as AdminEducationLevelController;
use App\Http\Controllers\Admin\LogoutController;
use App\Http\Controllers\EducationLevelController;
use App\Livewire\Admin\Auth\Login;
use App\Models\HeroSlide;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'slides' => HeroSlide::orderBy('order')->get(),
    ]);
})->name('home');

Route::group(['prefix' => 'levels', 'as' => 'levels.'], function () {
    Route::get('/', [EducationLevelController::class, 'index'])->name('index');
    Route::get('{educationLevel:slug}', [EducationLevelController::class, 'show'])->name('show');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', Login::class)->name('admin.login');
});

Route::middleware('auth')->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::prefix('education-levels')->as('education-levels.')->group(function () {
        Route::get('/', \App\Livewire\Admin\EducationLevels\Index::class)->name('index');
        Route::get('/create', \App\Livewire\Admin\EducationLevels\Form::class)->name('create');
        Route::get('/{educationLevel}/edit', [AdminEducationLevelController::class, 'edit'])->name('edit');
    });

    Route::get('/hero-slides', \App\Livewire\Admin\HeroSlides\Manager::class)->name('hero-slides.index');

    Route::get('/account', \App\Livewire\Admin\Account\Manager::class)->name('account');
});
