<?php

use App\Http\Controllers\AnalyteController;
use App\Http\Controllers\IncomeController;
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

    Route::get('facture/carali', [IncomeController::class, 'carali'])->name('facture.carali');
    Route::get('facture/leones', [IncomeController::class, 'leones'])->name('facture.leones');
    Route::get('facture/hospital', [IncomeController::class, 'hospital'])->name('facture.hospital');
    Route::get('facture/salle', [IncomeController::class, 'salle'])->name('facture.salle');
    Route::get('facture/yaritagua', [IncomeController::class, 'yaritagua'])->name('facture.yaritagua');

    Route::post('analyte/import', [AnalyteController::class, 'store'])->name('analyte.import');
    Route::post('facture/import', [IncomeController::class, 'store'])->name('facture.import');
});


require __DIR__.'/auth.php';
