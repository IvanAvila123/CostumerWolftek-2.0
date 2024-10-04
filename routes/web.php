<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/clientes', function () {
        return view('clientes');
    })->name('clientes');
});

Route::middleware(['auth', 'super.admin'])->group(function () {
    Route::middleware('permission:ver-usuario')->get('/usuarios', function () {
        return view('usuarios');
    })->name('usuarios');

    Route::middleware('permission:ver-permiso')->get('/permisos', function () {
        return view('permisos');
    })->name('permisos');

    Route::middleware('permission:ver-roles')->get('/rol', function () {
        return view('rol');
    })->name('rol');

    Route::middleware('permission:ver-distribuidor')->get('/distribuidor', function () {
        return view('distribuidor');
    })->name('distribuidor');

    Route::middleware('permission:ver-oportunidad')->get('/oportunidades', function () {
        return view('oportunidades');
    })->name('oportunidades');

    Route::get('/renovaciones', function () {
        return view('renovaciones');
    })->name('renovaciones');
});
