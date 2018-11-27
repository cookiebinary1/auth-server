<?php

namespace Zeroone\AuthServer\Http\Controllers;

use AuthServerAppController as Controller;


class WelcomeController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
	public function index()
	{
	    $package = "AuthServer";

		return view('AuthServer::welcome' , compact('package'));
	}
}
