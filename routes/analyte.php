<?php

use App\Http\Controllers\AnalyteController;
use App\Http\Controllers\CaraliAnalyte;
use App\Http\Controllers\EsteAnalyte;
use App\Http\Controllers\HospitalAnalyte;
use App\Http\Controllers\SalleAnalyte;
use App\Http\Controllers\YaritaguaAnalyte;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {    

    Route::get('analyte/principal', [AnalyteController::class, 'principal'])->name('analyte.principal');

    Route::get('analyte/carali', [CaraliAnalyte::class, 'carali'])->name('analyte.carali');
    Route::get('analyte/este', [EsteAnalyte::class, 'este'])->name('analyte.este');
    Route::get('analyte/hospital', [HospitalAnalyte::class, 'hospital'])->name('analyte.hospital');
    Route::get('analyte/salle', [SalleAnalyte::class, 'salle'])->name('analyte.salle');
    Route::get('analyte/yaritagua', [YaritaguaAnalyte::class, 'yaritagua'])->name('analyte.yaritagua'); 
   
    Route::post('analyte/carali/import', [CaraliAnalyte::class, 'store'])->name('analyte.carali.import');
    Route::post('analyte/salle/import', [SalleAnalyte::class, 'store'])->name('analyte.salle.import');
    Route::post('analyte/hospital/import', [HospitalAnalyte::class, 'store'])->name('analyte.hospital.import');
    Route::post('analyte/yaritagua/import', [YaritaguaAnalyte::class, 'store'])->name('analyte.yaritagua.import');
    Route::post('analyte/este/import', [EsteAnalyte::class, 'store'])->name('analyte.este.import');

    Route::post('analyte/carali/export', [App\Http\Controllers\ExportCaraliController::class, 'export'])->name('analyte.carali.export');
});