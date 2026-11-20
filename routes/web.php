<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LeadCaptureController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/imoveis', [SiteController::class, 'properties'])->name('properties');
Route::get('/imoveis/{slug}', [SiteController::class, 'property'])->name('property');
Route::get('/servicos', [SiteController::class, 'services'])->name('services');
Route::get('/fotografia', [SiteController::class, 'photography'])->name('photography');
Route::get('/sobre', [SiteController::class, 'about'])->name('about');
Route::get('/contato', [SiteController::class, 'contact'])->name('contact');
Route::post('/contato', [LeadCaptureController::class, 'store'])->middleware('throttle:10,1')->name('leads.capture');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::prefix('admin')->name('admin.')->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('properties', PropertyController::class);
        Route::resource('leads', LeadController::class)->except(['create', 'store', 'edit']);
    });
});
