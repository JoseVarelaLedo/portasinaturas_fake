<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitanteController;
use App\Http\Controllers\SolicitudeController;
use App\Http\Controllers\EntidadeController;
use App\Http\Controllers\UsuarioAdministrativoController;
use App\Http\Controllers\UsuarioTecnicoController;
use App\Http\Controllers\EmendaController;
use App\Http\Controllers\RemesaController;
use App\Http\Controllers\PDFController;


Route::view('/','layouts.principal')->name('index');

//TODO: Agrupar rutas con Middleware

Route::get('/solicitante/crear', [SolicitanteController::class, 'create'])->name('solicitante.crear');
Route::get('/solicitante/listado', [SolicitanteController::class, 'index'])->name('solicitante.listado');
Route::post('/solicitante/store', [SolicitanteController::class, 'store'])->name('solicitante.store');
Route::get('/entidade/crear', [EntidadeController::class, 'create'])->name('entidade.crear');
Route::post('/entidade/store', [EntidadeController::class, 'store'])->name('entidade.store');
Route::get('/entidade/listado', [EntidadeController::class, 'index'])->name('entidade.listado');
Route::get('/usuario_admin/crear', [UsuarioAdministrativoController::class,'create'])->name('usuario_administrativo.crear');
Route::get('/usuario_admin/listado', [UsuarioAdministrativoController::class,'index'])->name('usuario_administrativo.listado');
Route::get('/usuario_tecnico/crear', [UsuarioTecnicoController::class,'create'])->name('usuario_tecnico.crear');
Route::get('/usuario_tecnico/listado', [UsuarioTecnicoController::class,'index'])->name('usuario_tecnico.listado');
Route::get('/solicitude/crear',[SolicitudeController::class,'create'])->name('solicitude.crear');
Route::get('/solicitude/listado', [SolicitudeController::class,'index'])->name('solicitude.listado');
Route::post('/solicitude/store', [SolicitudeController::class, 'store'])->name('solicitude.store');
Route::post('/solicitude/{solicitude}/usuarios', [SolicitudeController::class, 'updateUsuarios'])->name('solicitude.usuarios.update');
Route::post('/solicitude/{solicitude}/estado', [SolicitudeController::class, 'updateEstado'])->name('solicitude.estado.update');
Route::post('/solicitude/{solicitude}/documentacion', [SolicitudeController::class, 'updateDocumentacion'])->name('solicitude.documentacion.update');
Route::get('/solicitude/tarxeta/{solicitude}', [SolicitudeController::class, 'tarxeta'])->name('solicitude.tarxeta');
Route::get('/emenda/listado', [EmendaController::class,'index'])->name('emenda.listado');
Route::post('/emenda/store', [EmendaController::class,'store'])->name('emenda.store');
Route::get('/remesa/listado', [RemesaController::class, 'index'])->name('remesa.listado');
Route::post('/remesa/store', [RemesaController::class, 'store'])->name('remesa.store');

Route::get('/emenda/{emenda}/pdf', [PDFController::class, 'xerarPDF'])->name('emenda.xerarPDF');



