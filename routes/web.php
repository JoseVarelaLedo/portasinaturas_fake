<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitanteController;
use App\Http\Controllers\SolicitudeController;
use App\Http\Controllers\EntidadeController;
use App\Http\Controllers\UsuarioAdministrativoController;
use App\Http\Controllers\UsuarioTecnicoController;
use App\Http\Controllers\EmendaController;
use App\Http\Controllers\RemesaController;


Route::view('/','index')->name('index');

Route::get('/solicitante/crear', [SolicitanteController::class, 'create'])->name('solicitante.crear');
Route::get('/solicitante/listado', [SolicitanteController::class, 'index'])->name('solicitante.listado');
Route::post('/solicitante/store', [SolicitanteController::class, 'store'])->name('solicitante.store');
Route::get('/entidade/crear', [EntidadeController::class, 'create'])->name('entidade.crear');
Route::get('/entidade/listado', [EntidadeController::class, 'index'])->name('entidade.listado');
Route::get('/usuario_admin/crear', [UsuarioAdministrativoController::class,'create'])->name('usuario_administrativo.crear');
Route::get('/usuario_admin/listado', [UsuarioAdministrativoController::class,'index'])->name('usuario_administrativo.listado');
Route::get('/usuario_tecnico/crear', [UsuarioTecnicoController::class,'create'])->name('usuario_tecnico.crear');
Route::get('/usuario_tecnico/listado', [UsuarioTecnicoController::class,'index'])->name('usuario_tecnico.listado');
Route::get('/solicitude/crear',[SolicitudeController::class,'create'])->name('solicitude.crear');
Route::get('/solicitude/listado', [SolicitudeController::class,'index'])->name('solicitude.listado');
Route::get('/emenda/listado', [EmendaController::class,'index'])->name('emenda.listado');
Route::get('/emenda/crear', [EmendaController::class,'create'])->name('emenda.crear');
Route::get('/remesa/listado', [RemesaController::class, 'index'])->name('remesa.listado');
Route::get('/remesa/crear', [RemesaController::class, 'create'])->name('remesa.crear');



