<?php

Route::get("login", "\Zeroone\Authserver\Http\Controllers\LoginController@getLogin")->name("login");

// temporary!!!
//Route::get("login/conclusion", "Auth\LoginController@conclusion")->name("login.conclusion");

Route::post("login/conclusion/{data?}", "\Zeroone\Authserver\Http\Controllers\LoginController@conclusion")->name("login.conclusion");

Route::get("register", "\Zeroone\AuthServer\Http\Controllers\RegisterController@getRegister")->name("register");





