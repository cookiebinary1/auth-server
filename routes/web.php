<?php

/*
 |-----------------------------------------------------
 | AuthServer Routes
 |-----------------------------------------------------
 | 
 | Here is where AuthServer package routes.
 | 
 */ 

Route::get('authServer','\01people\AuthServer\Http\Controllers\WelcomeController@index');
