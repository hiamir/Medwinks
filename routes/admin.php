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
    'namespace' => '\App\Http\Livewire\Admin',
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::group([
        'middleware' => ['auth:admin', 'role:super-admin|admin'],
    ], function () {

    });

    Route::group([
        'middleware' => ['auth:admin', 'role:super-admin'],
    ], function () {

    });

    Route::group([
//        'middleware' => ['auth:admin', 'has-any-role:admin'],
        'middleware' => ['auth:admin', 'role:super-admin|admin'],
    ], function () {
        Route::get('dashboard', \App\Http\Livewire\Admin\Dashboard\Controller::class)->name('dashboard');
        Route::get('administrators', \App\Http\Livewire\Admin\Administrators\Controller::class)->name('admins');
        Route::get('users', \App\Http\Livewire\Admin\Users\Controller::class)->name('users');
        Route::get('gender', \App\Http\Livewire\Admin\Gender\Controller::class)->name('gender');
        Route::get('profile', \App\Http\Livewire\Admin\Profile\Controller::class)->name('profile');
        Route::get('roles', \App\Http\Livewire\Admin\Roles\Controller::class)->name('roles');
        Route::get('permissions', \App\Http\Livewire\Admin\Permissions\Controller::class)->name('permissions');
        Route::get('menu', \App\Http\Livewire\Admin\Menu\Controller::class)->name('menu');
        Route::get('menu-items', \App\Http\Livewire\Admin\MenuItems\Controller::class)->name('menu-items');
        Route::get('countries', \App\Http\Livewire\Admin\Countries\Controller::class)->name('countries');
        Route::get('country-region', \App\Http\Livewire\Admin\Countries\Regions\Controller::class)->name('country-regions');
    });
});

require __DIR__ . '/auth.php';
