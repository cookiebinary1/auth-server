<?php

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
