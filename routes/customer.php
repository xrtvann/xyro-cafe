<?php

use Illuminate\Support\Facades\Route;

Route::get('/story', function () {
    return view('customer.story');
})->name('customer.story');

Route::get('/menu', function () {
    return view('customer.catalog');
})->name('customer.catalog');

Route::get('/faq', function () {
    return view('customer.faq');
})->name('customer.faq');
