<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group([

], function () {
    Route::group([
        'middleware' => ['auth:admin', 'role:super admin|admin'],
        'namespace'=>'\App\Http\Livewire\Admin',
        'prefix'=>'admin',
        'as'=>'admin.'

    ], function () {
        Route::get('dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('administrators', Administrators::class)->name('admins');
        Route::get('users', Users::class)->name('users');
        Route::get('roles', Roles::class)->name('roles');
    });
});

require __DIR__ . '/auth.php';
