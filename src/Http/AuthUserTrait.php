<?php

namespace Zeroone\Authserver\Http;

/**
 * Trait AuthUserTrait
 * @author Cookie
 */
trait AuthUserTrait
{
    protected $profileUrl = "/api/v1/area/user";

    /**
     * @return self
     * @author Cookie
     */
    public static function createFromProfile()
    {
        $data = auth_server()->getProfile();
        $jwt = auth_server()->accessTokenJWT();
        
        $data['password'] = "n/a";
        $data['uid'] = $jwt->uid;
        $data['csm'] = $jwt->csm;
        $data['auv'] = $jwt->auv;
        $data['mro'] = $jwt->mro;

        return self::create($data);
    }

    /**
     * @author Cookie
     */
    public function updateProfile()
    {
        // todo
    }

    /**
     * @return mixed
     * @author Cookie
     */
    protected function accessToken()
    {
        return auth_server()->accessToken();
    }
}