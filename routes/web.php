<?php

use App\Http\Controllers\AnalyteController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('analyte/carali', [AnalyteController::class, 'carali'])->name('analyte.carali');
    Route::get('analyte/leones', [AnalyteController::class, 'leones'])->name('analyte.leones');
    Route::get('analyte/hospital', [AnalyteController::class, 'hospital'])->name('analyte.hospital');
    Route::get('analyte/salle', [AnalyteController::class, 'salle'])->name('analyte.salle');
    Route::get('analyte/yaritagua', [AnalyteController::class, 'yaritagua'])->name('analyte.yaritagua');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('facture/carali', [AnalyteController::class, 'carali'])->name('analyte.carali');
    Route::get('facture/leones', [AnalyteController::class, 'leones'])->name('analyte.leones');
    Route::get('facture/hospital', [AnalyteController::class, 'hospital'])->name('analyte.hospital');
    Route::get('facture/salle', [AnalyteController::class, 'salle'])->name('analyte.salle');
    Route::get('facture/yaritagua', [AnalyteController::class, 'yaritagua'])->name('analyte.yaritagua');

    Route::post('analyte/import', [AnalyteController::class, 'store'])->name('analyte.import');
});


require __DIR__.'/auth.php';
