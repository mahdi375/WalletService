<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('ping', fn() => ['ping' => 'pong'])->name('health');