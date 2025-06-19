<?php

use App\Http\Controllers\AnalyteController;
use App\Http\Controllers\CaraliAnalyte;
use App\Http\Controllers\CaraliIncome;
use App\Http\Controllers\EsteAnalyte;
use App\Http\Controllers\EsteIncome;
use App\Http\Controllers\HospitalAnalyte;
use App\Http\Controllers\HospitalIncome;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\SalleAnalyte;
use App\Http\Controllers\SalleIncome;
use App\Http\Controllers\YaritaguaAnalyte;
use App\Http\Controllers\YaritaguaIncome;
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
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');


    Route::get('analyte/principal', [AnalyteController::class, 'principal'])->name('analyte.principal');

    Route::get('analyte/carali', [CaraliAnalyte::class, 'carali'])->name('analyte.carali');
    Route::get('analyte/este', [EsteAnalyte::class, 'este'])->name('analyte.este');
    Route::get('analyte/hospital', [HospitalAnalyte::class, 'hospital'])->name('analyte.hospital');
    Route::get('analyte/salle', [SalleAnalyte::class, 'salle'])->name('analyte.salle');
    Route::get('analyte/yaritagua', [YaritaguaAnalyte::class, 'yaritagua'])->name('analyte.yaritagua'); 
    

    Route::get('facture/principal', [IncomeController::class, 'principal'])->name('facture.principal');

    Route::get('facture/carali', [CaraliIncome::class, 'carali'])->name('facture.carali');
    Route::get('facture/este', [EsteIncome::class, 'este'])->name('facture.este');
    Route::get('facture/hospital', [HospitalIncome::class, 'hospital'])->name('facture.hospital');
    Route::get('facture/salle', [SalleIncome::class, 'salle'])->name('facture.salle');
    Route::get('facture/yaritagua', [YaritaguaIncome::class, 'yaritagua'])->name('facture.yaritagua');

    Route::post('analyte/carali/import', [CaraliAnalyte::class, 'store'])->name('analyte.carali.import');
    Route::post('analyte/salle/import', [SalleAnalyte::class, 'store'])->name('analyte.salle.import');
    Route::post('analyte/hospital/import', [HospitalAnalyte::class, 'store'])->name('analyte.hospital.import');
    Route::post('analyte/yaritagua/import', [YaritaguaAnalyte::class, 'store'])->name('analyte.yaritagua.import');
    Route::post('analyte/este/import', [EsteAnalyte::class, 'store'])->name('analyte.este.import');

    Route::post('facture/carali/import', [CaraliIncome::class, 'store'])->name('facture.carali.import');
    Route::post('facture/este/imports', [EsteIncome::class, 'stores'])->name('facture.este.imports');
    Route::post('facture/hospital/imports', [HospitalIncome::class, 'stores'])->name('facture.hospital.imports');
    Route::post('facture/salle/imports', [SalleIncome::class, 'stores'])->name('facture.salle.imports');
    Route::post('facture/yaritagua/imports', [YaritaguaIncome::class, 'stores'])->name('facture.yaritagua.imports');
});


require __DIR__.'/auth.php';
