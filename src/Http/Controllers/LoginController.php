<?php

namespace Zeroone\Authserver\Http\Controllers;

use App\AccessToken;
use App\Http\Controllers\Controller;
use App\Src\AuthServer;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 * @author  Cookie
 */
class LoginController extends Controller
{
    //use AuthenticatesUsers;

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author Cookie
     */
    public function getLogin()
    {
        return redirect(config('authServer.login_url'));
    }

    /**
     * @param null $data
     * @author Cookie
     */
    public function conclusion($data = null)
    {
        $user = auth_server()->userCreateOrUpdate($data);

        auth()->login($user);

        return redirect(config("authServer.success_redirect_url"));
    }

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
