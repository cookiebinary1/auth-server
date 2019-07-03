<?php

/**
 * @author Martin Osusky
 */
Route::group(['middleware' => ['web']], function () {
    Route::get("login", "\Zeroone\Authserver\Http\Controllers\LoginController@getLogin")->name("login");
    Route::post("login/conclusion/{data?}", "\Zeroone\Authserver\Http\Controllers\LoginController@conclusion")->name("login.conclusion");
    Route::get("register", "\Zeroone\Authserver\Http\Controllers\RegisterController@getRegister")->name("register");
});

Route::post('/registration/callback', 'Api\UsersController@createUser')->name('api.createUser');
Route::put('/registration/callback', 'Api\UsersController@verifyUser')->name('api.verifyUser');