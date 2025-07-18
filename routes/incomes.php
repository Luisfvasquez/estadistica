<?php

use App\Http\Controllers\CaraliIncome;
use App\Http\Controllers\EsteIncome;
use App\Http\Controllers\HospitalIncome;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\SalleIncome;
use App\Http\Controllers\YaritaguaIncome;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    
    Route::get('facture/principal', [IncomeController::class, 'principal'])->name('facture.principal');
   
    Route::get('facture/carali', [CaraliIncome::class, 'carali'])->name('facture.carali');
    Route::get('facture/este', [EsteIncome::class, 'este'])->name('facture.este');
    Route::get('facture/hospital', [HospitalIncome::class, 'hospital'])->name('facture.hospital');
    Route::get('facture/salle', [SalleIncome::class, 'salle'])->name('facture.salle');
    Route::get('facture/yaritagua', [YaritaguaIncome::class, 'yaritagua'])->name('facture.yaritagua');

   
    Route::post('facture/carali/import', [CaraliIncome::class, 'store'])->name('facture.carali.import');
    Route::post('facture/este/imports', [EsteIncome::class, 'stores'])->name('facture.este.imports');
    Route::post('facture/hospital/imports', [HospitalIncome::class, 'stores'])->name('facture.hospital.imports');
    Route::post('facture/salle/imports', [SalleIncome::class, 'stores'])->name('facture.salle.imports');
    Route::post('facture/yaritagua/imports', [YaritaguaIncome::class, 'stores'])->name('facture.yaritagua.imports');
});