<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/livewire-conformance-tests/simpleActionAndModel', \App\Livewire\SimpleActionAndModel::class);
Route::get('/livewire-conformance-tests/actionWithRedirect', \App\Livewire\ActionWithRedirect::class);
Route::get('/livewire-conformance-tests/controller', function () {
    return 'Static Content';
});
