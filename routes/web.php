<?php

/*
 |-----------------------------------------------------
 | AuthServer Routes
 |-----------------------------------------------------
 | 
 | Here is where AuthServer package routes.
 | 
 */ 

//Route::get('authServer','\01people\AuthServer\Http\Controllers\WelcomeController@index');


Route::get("login", "Zeroone\LoginController@getLogin")->name("login");

// temporary!!!
//Route::get("login/conclusion", "Auth\LoginController@conclusion")->name("login.conclusion");

Route::post("login/conclusion/{data?}", "Zeroone\LoginController@conclusion")->name("login.conclusion");

Route::get("register", "Zeroone\RegisterController@getRegister")->name("register");
