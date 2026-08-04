<?php

use App\Http\Controllers\Admin\EducationLevelController as AdminEducationLevelController;
use App\Http\Controllers\Admin\LogoutController;
use App\Http\Controllers\EducationLevelController;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\EducationLevels\Form;
use App\Livewire\Admin\EducationLevels\Index;
use App\Livewire\Admin\HeroSlides\Manager;
use App\Models\HeroSlide;
use App\Models\SchoolSetting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'slides' => HeroSlide::orderBy('order')->get(),
        'setting' => SchoolSetting::current(),
    ]);
})->name('home');

Route::group(['prefix' => 'levels', 'as' => 'levels.'], function () {
    Route::get('/', [EducationLevelController::class, 'index'])->name('index');
    Route::get('{educationLevel:slug}', [EducationLevelController::class, 'show'])->name('show');
});

Route::get('/admin/login', Login::class)->name('admin.login');

Route::middleware('auth')->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::prefix('education-levels')->as('education-levels.')->group(function () {
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{educationLevel}/edit', [AdminEducationLevelController::class, 'edit'])->name('edit');
    });

    Route::get('/hero-slides', Manager::class)->name('hero-slides.index');

    Route::get('/academic-years', App\Livewire\Admin\AcademicYears\Manager::class)->name('academic-years.index');

    Route::get('/settings', App\Livewire\Admin\Settings\Manager::class)->name('settings');

    Route::get('/account', App\Livewire\Admin\Account\Manager::class)->name('account');
});
