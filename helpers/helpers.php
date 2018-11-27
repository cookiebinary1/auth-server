<?php

dd(123);
if (!function_exists("auth_server")) {
    /**
     * @return AuthServer
     * @author Cookie
     */
    function auth_server()
    {
        return app(\Zeroone\Authserver\AuthServer::class);
    }
}
