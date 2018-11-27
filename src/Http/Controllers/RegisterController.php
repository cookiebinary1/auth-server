<?php

namespace Zeroone\AuthServer\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 * @author  Cookie
 */
class RegisterController extends Controller
{
    /**
     * @author Cookie
     */
    public function getRegister()
    {
        return redirect(config("authServer.registration_url"));
    }
}
