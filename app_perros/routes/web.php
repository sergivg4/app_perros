<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/perro','PerroController@getData');

Route::post('api/perro/add','PerroController@addData');

Route::post('api/perro/remove','PerroController@removeData');

Route::post('api/perro/edit','PerroController@editData');
