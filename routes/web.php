<?php

use App\Http\Livewire\User\Temp;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group([

], function () {
    Route::group([
        'middleware' => ['auth', 'verified','role:manager|user'],
        'as'=>'user.'

    ], function () {
        Route::get('dashboard', \App\Http\Livewire\User\Dashboard\Controller::class)->name('dashboard');
        Route::get('profile', \App\Http\Livewire\User\Profile\Controller::class)->name('profile');
        Route::get('passports', \App\Http\Livewire\User\Passports\Controller::class)->name('passports');
        Route::get('documents', \App\Http\Livewire\User\Documents\Controller::class)->name('documents');
        Route::get('submit-application', \App\Http\Livewire\User\SubmitApplication\Controller::class)->name('submit-application');
        Route::get('applications-submissions', \App\Http\Livewire\User\Applications\Submissions\Controller::class)->name('application-submissions');
        Route::get('applications-all-submissions', \App\Http\Livewire\User\Applications\Submissions\Controller::class)->name('application-all-submissions');
        Route::get('applications-all-documents', \App\Http\Livewire\User\Applications\Documents\Controller::class)->name('application-all-documents');
        Route::get('application/{id}', \App\Http\Livewire\User\Applications\Application\Controller::class)->name('application');
    });
});


Route::group([

], function () {
    Route::group([
        'middleware' => ['auth', 'verified','role:manager'],
        'as'=>'user.'
    ], function () {
        Route::get('clients', \App\Http\Livewire\User\Clients\Controller::class)->name('clients');
        Route::get('/client-details/{user}', \App\Http\Livewire\User\ClientDetails\Controller::class)->name('client-details');
        Route::get('qualifications', \App\Http\Livewire\User\Qualifications\Controller::class)->name('qualifications');
        Route::get('services', \App\Http\Livewire\User\Services\Controller::class)->name('services');
        Route::get('service-requirements', \App\Http\Livewire\User\ServiceRequirements\Controller::class)->name('service-requirements');
        Route::get('universities', \App\Http\Livewire\User\Universities\Controller::class)->name('universities');
    });
});

Route::group([

], function () {
    Route::group([
        'middleware' => ['auth', 'verified','role:user'],
        'as'=>'user.'

    ], function () {
    });
});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
