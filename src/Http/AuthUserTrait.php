<?php

namespace Zeroone\Authserver\Http;

/**
 * Trait AuthUserTrait
 * @author Martin Osusky
 */
trait AuthUserTrait
{
    protected $profileUrl = "/api/v1/area/user";

    /**
     * @return self
     * @author Martin Osusky
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
     * @author Martin Osusky
     */
    public function updateProfile()
    {
        // todo
    }

    /**
     * @return mixed
     * @author Martin Osusky
     */
    protected function accessToken()
    {
        return auth_server()->accessToken();
    }
}