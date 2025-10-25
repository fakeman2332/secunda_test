<?php

use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\CompanyGeoController;
use Illuminate\Support\Facades\Route;

Route::prefix('companies/search')->name('companies.search.')->group(function () {
    Route::get('/name', [CompanyController::class, 'getCompanyByName'])->name('by-name');
    Route::post('/radius', [CompanyGeoController::class, 'getCompanyInRadius'])->name('radius');
    Route::post('/bounds', [CompanyGeoController::class, 'getCompanyInBounds'])->name('bounds');
});

Route::get('/companies/{company}', [CompanyController::class, 'getCompanyById'])
    ->name('companies.show');

Route::get('/buildings/{building}/companies', [CompanyGeoController::class, 'getCompaniesInBuilding'])
    ->name('buildings.companies');

Route::prefix('activities/{activity}')->name('activities.')->group(function () {
    Route::get('/companies', [CompanyController::class, 'getCompaniesByActivity'])->name('companies');
    Route::get('/companies/filter', [CompanyController::class, 'getCompaniesByActivityFilter'])->name('companies.filter');
});
