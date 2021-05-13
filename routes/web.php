<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    \App\Http\Controllers\HomeController::class,
    'homeView'
])->name('home.get')
    ->middleware(['locale', 'auth']);

Route::get('/language/set/{code}', [
    \App\Http\Controllers\LanguageController::class,
    'setLanguage'
])->name('language.set')
    ->middleware(['locale']);

Route::get('/fetch-records/{domain}/{id}', [
    \App\Http\Controllers\RecordController::class,
    'getNewRecords'
])->name('fetch-records.get')
    ->middleware(['locale', 'auth']);

Route::get('/records/add', [
    \App\Http\Controllers\RecordController::class,
    'getAddRecords'
])->name('records.add')
    ->middleware(['locale', 'auth']);

Route::post('/records/add', [
    \App\Http\Controllers\RecordController::class,
    'postAddRecord'
])->name('records.add')
    ->middleware(['locale', 'auth']);

Route::post('/records/delete', [
    \App\Http\Controllers\RecordController::class,
    'postDeleteRecord'
])->name('records.delete')
    ->middleware(['locale', 'auth']);

Route::post('/records/edit', [
    \App\Http\Controllers\RecordController::class,
    'postEditRecord'
])->name('records.edit')
    ->middleware(['locale', 'auth']);

Route::get('/records/data/{id}', [
    \App\Http\Controllers\RecordController::class,
    'getRecordJSON'
])->name('records.data.json')
    ->middleware(['locale', 'auth']);

Route::get('/domains', [
    \App\Http\Controllers\DomainController::class,
    'getManageDomains'
])->name('domains.get')
    ->middleware(['locale', 'auth']);

Route::post('/domains/add', [
    \App\Http\Controllers\DomainController::class,
    'postAddDomain'
])->name('domains.add')
    ->middleware(['locale', 'auth']);

Route::post('/domains/delete', [
    \App\Http\Controllers\DomainController::class,
    'postDeleteDomain'
])->name('domains.delete')
    ->middleware(['locale', 'auth']);

Route::get('/auth/password/change', [
    \App\Http\Controllers\AuthController::class,
    'getChangePassword'
])->name('auth-password-change.get')
    ->middleware(['locale', 'auth']);

Route::post('/auth/password/change', [
    \App\Http\Controllers\AuthController::class,
    'postChangePassword'
])->name('auth-password-change.post')
    ->middleware(['locale', 'auth']);

Route::get('/auth/logout', [
    \App\Http\Controllers\AuthController::class,
    'getLogout'
])->name('auth-logout.get')
    ->middleware(['locale', 'auth']);

Route::get('/auth/login', [
    \App\Http\Controllers\AuthController::class,
    'getLogin'
])->name('auth-login.get')
    ->middleware(['locale']);

Route::post('/auth/login', [
    \App\Http\Controllers\AuthController::class,
    'postLogin'
])->name('auth-login.post')
    ->middleware(['locale']);
