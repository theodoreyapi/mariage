<?php

use App\Http\Controllers\ImportUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', [ImportUserController::class, 'index'])->name('import.index');
Route::post('/import-users', [ImportUserController::class, 'store'])->name('import.store');

Route::get('/import/links', function(Request $request) {
    $users = App\Models\User::all();
    $message = urldecode($request->message);

    return view('import.links', compact('users', 'message'));
})->name('import.links');

Route::delete('/users/{user}', [ImportUserController::class, 'destroy'])->name('users.destroy');
Route::get('/', [ImportUserController::class, 'index'])->name('home');
