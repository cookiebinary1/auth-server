<?php

/**
 * @author Cookie
 */
Route::group(['middleware' => ['web']], function () {
    Route::get("login", "\Zeroone\Authserver\Http\Controllers\LoginController@getLogin")->name("login");
    Route::post("login/conclusion/{data?}", "\Zeroone\Authserver\Http\Controllers\LoginController@conclusion")->name("login.conclusion");
    Route::get("register", "\Zeroone\AuthServer\Http\Controllers\RegisterController@getRegister")->name("register");
});