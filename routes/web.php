<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/products', function () {
    $products = \App\Models\Product\Product::get();
    return response()->json($products);
});
