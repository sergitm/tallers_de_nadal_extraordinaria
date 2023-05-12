<?php

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\InformesController;
use App\Http\Controllers\IniciController;
use App\Http\Controllers\LoginLogoutController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\AlumnesController;
use App\Http\Controllers\AdministracioController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

// Recursos de la classe Taller
Route::resource('/taller', TallerController::class);

// Ruta inici
Route::get('/', IniciController::class)->name('home');

// Ruta de la pàgina de login
Route::get('/login', LoginLogoutController::class)->name('login');

// Rutes per gestionar la donada d'alta i baixa dels alumnes als tallers
Route::get('/taller/{taller}/apuntar/{ordre}', 'App\Http\Controllers\TallerController@apuntar')->name('apuntar')->middleware('login');
Route::get('/taller/{taller}/baixa', 'App\Http\Controllers\TallerController@baixa')->name('baixa')->middleware('login');

// Rutes per gestionar informes
Route::get('/informe', InformesController::class)->name('informes')->middleware('admin');
Route::get('/taller/{taller}/informe', 'App\Http\Controllers\InformesController@participants')->name('informes_participants')->middleware('admin');
Route::get('/informe/material', 'App\Http\Controllers\InformesController@material_taller')->name('informes_material_tallers')->middleware('admin');
Route::get('informe/alumne/notaller', 'App\Http\Controllers\InformesController@sense_taller')->name('informes_alumnes_sense_taller')->middleware('admin');
Route::get('informe/taller/alumne', 'App\Http\Controllers\InformesController@tallers_escollits')->name('informes_tallers_escollits')->middleware('admin');

// Rutes per gestionar dades d'alumnes
Route::get('/alumnes/llista', AlumnesController::class)->name('llista_alumnes')->middleware('admin');
Route::post('/administracio/actualitzar/alumnes', 'App\Http\Controllers\AlumnesController@actualitzar')->name('actualitzar_persones')->middleware('admin');
Route::get('alumnes/afegir', 'App\Http\Controllers\AlumnesController@afegirAlumne')->name('afegir_alumnes')->middleware('admin');
Route::post('alumnes/create', 'App\Http\Controllers\AlumnesController@createAlumne')->name('create_alumne')->middleware('admin');
Route::get('alumnes/{alumne}/apuntar', 'App\Http\Controllers\AlumnesController@apuntarAlumne')->name('apuntar_alumne')->middleware('admin');
Route::post('alumnes/{alumne}/apuntartaller', 'App\Http\Controllers\AlumnesController@apuntarTallers')->name('apuntar_tallers')->middleware('admin');

// Rutes per gestionar l'administració
Route::get('/administracio', AdministracioController::class)->name('administracio')->middleware('admin');
Route::post('/administracio/convertir', 'App\Http\Controllers\AdministracioController@fer_admin')->name('fer_admin')->middleware('superadmin');
Route::post('/administracio/config', 'App\Http\Controllers\AdministracioController@config_dates')->name('config')->middleware('admin');


// Rutes pel login de google
Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('redirect');
 
Route::get('/auth/callback', CallbackController::class)->name('callback');