<?php

namespace Zeroone\Authserver;

use App\User;
use Firebase\JWT\JWT;
use Zeroone\Authserver\Http\AccessToken;

/**
 * Class AuthServer
 * @package App\Src
 * @author  Martin Osusky
 */
class AuthServer
{
    const
        SESSION_PREFIX = "auth",
        ACCESS_TOKEN = "accessToken",
        REFRESH_TOKEN = "refreshToken",
        UID = "uid";

    const UPDATE_COLUMNS = [
        "title",
        "first_name",
        "last_name",
        "middle_name",
        "state",
        "country",
        "city",
        "address",
        "post_code",
        "username",
        "date_of_birth",
        "phone_number",
        "email",
    ];

    protected
        $profileUrl = "/api/v1/area/user";

    /**
     * @param $encryptedData
     * @return object
     * @author Martin Osusky
     */
    public function conclusion($encryptedData)
    {
        $data = json_decode($this->decrypt($encryptedData, config("authServer.secret_key")));

        $this->setToken($data->accessToken, $data->refreshToken);

        $key = file_get_contents(config("authServer.cert_file"));

        $decoded = JWT::decode($data->accessToken, $key, ['RS256']);

        // save token
        AccessToken::create([
            'data'          => json_encode($decoded),
            'uid'           => $decoded->uid,
            'refresh_token' => $data->refreshToken,
            'exp'           => $decoded->exp,
        ]);

        return $decoded;
    }

    /**
     * @param $encryptedData
     * @return User
     * @author Martin Osusky
     */
    public function userCreateOrUpdate($encryptedData)
    {
        $data = $this->conclusion($encryptedData);

        //dd($this->getProfile());

        // check if user exists
        if ($user = User::whereUid($data->uid)->first()) {
            // user exists
            // check profile checksum

            if ($user->csm != $data->csm) {
                // update user profile
                if (is_array($profile = $this->getProfile())) {
                    $user->update($profile);
                }
            }

        } else {
            // user first time login
            // create user
            $user = User::createFromProfile();
        }

        return $user;
    }

    /**
     * @param User $user
     * @author Martin Osusky
     */
    public function userUpdate(User $user)
    {
        $url = config("authServer.url") . $this->profileUrl;

        $accessToken = $this->accessToken();

        $curl = curl_init();

        $dataJson = json_encode($user->only(self::UPDATE_COLUMNS));

        $headers = [
            'api_key:' . config("authServer.api_key"),
            "Authorization: Bearer $accessToken",
            'Content-Type: application/json',
            'Content-Length: ' . strlen($dataJson),
        ];

        curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_URL            => $url,
                CURLOPT_POST           => 0,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_CUSTOMREQUEST  => "PUT",
                CURLOPT_POSTFIELDS     => $dataJson,
            ]
        );

        $response = curl_exec($curl);

        curl_close($curl);

        // @todo response validity check
        $response = json_decode($response, true);

        return $response;
    }

    /**
     * @param null $accessToken
     * @param null $refreshToken
     * @author Martin Osusky
     */
    public function setToken($accessToken = null, $refreshToken = null)
    {
        session([
            self::SESSION_PREFIX . ":" . self::ACCESS_TOKEN  => $accessToken,
            self::SESSION_PREFIX . ":" . self::REFRESH_TOKEN => $refreshToken,
        ]);
    }

    /**
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     * @author Martin Osusky
     */
    public function accessToken()
    {
//        $dt = new \DateTime("now", new \DateTimeZone('Europe/Bratislava'));
//        dd($dt->format('U'));
//        dd ($this->accessTokenJWT(), time(), date("H:i:s"));
        return session(self::SESSION_PREFIX . ":" . self::ACCESS_TOKEN);
    }

    /**
     * @return mixed
     * @author Martin Osusky
     */
    public function accessTokenJWT()
    {
        return JWT::decode(
            session(self::SESSION_PREFIX . ":" . self::ACCESS_TOKEN),
            $this->publicKey(),
            ['RS256']
        );
    }

    /**
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     * @author Martin Osusky
     */
    public function refreshToken()
    {
        return session(self::SESSION_PREFIX . ":" . self::REFRESH_TOKEN);
    }

    /**
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     * @author Martin Osusky
     */
    public function uid()
    {
        return $this->accessTokenJWT()->uid;
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     * @author Martin Osusky
     */
    public function secretKey()
    {
        return config("authServer.secret_key");
    }

    /**
     * @return bool|string
     * @author Martin Osusky
     */
    public function publicKey()
    {
        return file_get_contents(config("authServer.cert_file"));
    }


    /**
     * @return mixed
     * @author Martin Osusky
     */
    public function getProfile()
    {
        $url = config("authServer.url") . $this->profileUrl;

        $accessToken = $this->accessToken();

        $curl = curl_init();

        $headers = [
            'api_key:' . config("authServer.api_key"),
            "Authorization: Bearer $accessToken",
        ];

        curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL            => $url,
                CURLOPT_POST           => 0,
                CURLOPT_HTTPHEADER     => $headers,
            ]
        );

        $response = curl_exec($curl);

        curl_close($curl);

        // @todo validity check
        $response = json_decode($response, true);

        return $response;
    }

    /**
     * @param        $ciphertext
     * @param        $password
     * @param string $salt
     * @return string
     * @author Martin Osusky
     */
    public function decrypt($ciphertext, $password, $salt = '')
    {
        $ciphertext = base64_decode($ciphertext, true);
        $ciphertext = hex2bin($ciphertext);
        $keyAndIV = $this->evpKDF($password, $salt);

        $plaintext = openssl_decrypt($ciphertext, 'aes-256-ctr', $keyAndIV["key"], OPENSSL_RAW_DATA, $keyAndIV["iv"]);

        return $plaintext;
    }

    /**
     * @param        $password
     * @param        $salt
     * @param int    $keySize
     * @param int    $ivSize
     * @param int    $iterations
     * @param string $hashAlgorithm
     * @return array
     * @author Martin Osusky
     */
    public function evpKDF($password, $salt, $keySize = 8, $ivSize = 4, $iterations = 1, $hashAlgorithm = "md5")
    {
        $targetKeySize = $keySize + $ivSize;
        $derivedBytes = "";

        $numberOfDerivedWords = 0;
        $block = NULL;
        $hasher = hash_init($hashAlgorithm);

        while ($numberOfDerivedWords < $targetKeySize) {
            if ($block != NULL) {
                hash_update($hasher, $block);
            }

            hash_update($hasher, $password);
            hash_update($hasher, $salt);

            $block = hash_final($hasher, TRUE);
            $hasher = hash_init($hashAlgorithm);

            // Iterations
            for ($i = 1; $i < $iterations; $i++) {
                hash_update($hasher, $block);
                $block = hash_final($hasher, TRUE);
                $hasher = hash_init($hashAlgorithm);
            }

            $derivedBytes .= substr($block, 0, min(strlen($block), ($targetKeySize - $numberOfDerivedWords) * 4));

            $numberOfDerivedWords += strlen($block) / 4;
        }

        return array(
            "key" => substr($derivedBytes, 0, $keySize * 4),
            "iv"  => substr($derivedBytes, $keySize * 4, $ivSize * 4)
        );
    }
}

