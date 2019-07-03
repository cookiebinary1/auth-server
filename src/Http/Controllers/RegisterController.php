<?php

namespace Zeroone\Authserver\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 * @author  Martin Osusky
 */
class RegisterController extends Controller
{
    /**
     * @author Martin Osusky
     */
    public function getRegister()
    {
        return redirect(config("authServer.registration_url"));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @author odziomkovak
     */
    public function createUser(Request $request)
    {
        try {
            $data = json_decode($this->decrypt($request->get('token'), config("authServer.secret_key")), true);

            if (!$data) {
                return $this->jsonResponseFalse('Invalid data in request.');
            }

            // check if user exists
            if ($user = User::whereUid($data['uid'])->first()) {
                // user exists
                return $this->jsonResponseFalse('User already exists.');
            } else {
                // create user
                $data['password'] = "n/a";

                $user = User::create($data);
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());

            return $this->jsonResponseFalse('There was an error.');
        }

        $user->update([
            'status' => User::STATUS_UNVERIFIED,
        ]);

        return $this->jsonResponseTrue('User successfully created.');
    }

    /**
     * @param Request $request
     * @param         $userId
     * @return JsonResponse
     * @author odziomkovak
     */
    public function verifyUser(Request $request)
    {
        try {
            $data = json_decode($this->decrypt($request->get('token'), config("authServer.secret_key")), true);

            if (!$data) {
                return $this->jsonResponseFalse('Invalid data in request.');
            }

            if (!$data['email_verification']) {
                return $this->jsonResponseFalse('Cannot verify unverified user.');
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());

            return $this->jsonResponseFalse('There was an error.');
        }

        if (($user = User::whereUid($data['uid'])->first())) {
            if ($user->isVerified()) {
                return $this->jsonResponseFalse('User already verified.');
            }

            $user->update(array_merge(
                [
                    'status' => User::STATUS_VERIFIED,
                ],
                $data
            ));

            return $this->jsonResponseTrue('User successfully verified.');
        }

        return $this->jsonResponseFalse('User doesn\'t exist.');
    }

    /**
     * @param bool $result
     * @param null $message
     * @return JsonResponse
     * @author Adam Ondrejkovic
     */
    public function jsonResponse($result = false, $message = null)
    {
        return response()->json([
            'result'  => $result,
            'message' => $message,
        ]);
    }

    /**
     * @param null $message
     * @return JsonResponse
     * @author Adam Ondrejkovic
     */
    public function jsonResponseFalse($message = null)
    {
        return $this->jsonResponse(false, $message);
    }

    /**
     * @param null $message
     * @return JsonResponse
     * @author Adam Ondrejkovic
     */
    public function jsonResponseTrue($message = null)
    {
        return $this->jsonResponse(true, $message);
    }

    /**
     * @param $ciphertext
     * @param $password
     * @return string
     * @author odziomkovak
     */
    function decrypt($ciphertext, $password)
    {
        $iv = mb_substr($ciphertext, 0, 32);
        $ciphertext = mb_substr($ciphertext, 32);

        $ciphertext = hex2bin($ciphertext);
        $iv = hex2bin($iv);

        $plaintext = openssl_decrypt($ciphertext, 'aes-256-cbc', $password, OPENSSL_RAW_DATA, $iv);

        return $plaintext;
    }
}
