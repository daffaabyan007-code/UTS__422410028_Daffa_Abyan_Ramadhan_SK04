<?php

use App\Http\Controllers\AnalogTapeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tapes.index');
});

Route::resource('tapes', AnalogTapeController::class);
