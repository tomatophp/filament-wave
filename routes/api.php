<?php

use Illuminate\Support\Facades\Route;

Route::post('login', '\Wave\Http\Controllers\API\AuthController@login');
Route::post('register', '\Wave\Http\Controllers\API\AuthController@register');
Route::post('logout', '\Wave\Http\Controllers\API\AuthController@logout');
Route::post('refresh', '\Wave\Http\Controllers\API\AuthController@refresh');
Route::post('token', '\Wave\Http\Controllers\API\AuthController@token');

// Posts Example API Route
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/posts', '\Wave\Http\Controllers\Api\ApiController@posts');
});
