<?php

namespace Zeroone\Authserver\Http;

use App\User;
use Zeroone\Authserver\AuthServer;

/**
 * Trait AuthUserTrait
 * @author Martin Osusky
 */
trait AuthUserTrait
{
    protected $profileUrl = "/api/v1/area/user";

    /**
     * AuthUserTrait constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->makeFillables();
        parent::__construct($attributes);
    }

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
        return auth_server()->userUpdate($this);
    }

    /**
     * @return mixed
     * @author Martin Osusky
     */
    protected function accessToken()
    {
        return auth_server()->accessToken();
    }

    /**
     * @return $this
     * @author Cookie
     */
    public function makeFillables()
    {
        $this->fillable = array_merge($this->fillable, [
            'name',
            'email',
            'password',
            'title',
            'first_name',
            'last_name',
            'middle_name',
            'state',
            'country_id',
            'city',
            'address',
            'post_code',
            'username',
            'date_of_birth',
            'checksum',
            'phone_number',
            'language',
            'lid',
            'user_id',
            'uid',
            'csm',
            'auv',
            'mro',
            "email_verification",
            "country",
            "password",
        ]);

        return $this;
    }
}