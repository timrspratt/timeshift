<?php

use Illuminate\Support\Facades\Route;
use Timrspratt\Timeshift\Http\Controllers\TimeshiftController;

Route::get('timeshift/{shift}', [TimeshiftController::class, 'generateURL'])->name('timeshift.generateURL');
Route::post('timeshift', [TimeshiftController::class, 'remove'])->name('timeshift.remove');
