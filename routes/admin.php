<?php

use Illuminate\Support\Facades\Route;
use Timrspratt\Timeshift\Http\Controllers\TimeshiftController;

Route::get('timeshift', [TimeshiftController::class, 'index'])->name('admin.modules.timeshift.index');
Route::post('timeshift', [TimeshiftController::class, 'set'])->name('admin.modules.timeshift.set');
