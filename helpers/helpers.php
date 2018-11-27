<?php

if (!function_exists("auth_server")) {
    /**
     * @return \Zeroone\Authserver\AuthServer
     * @author Martin Osusky
     */
    function auth_server()
    {
        return app(\Zeroone\Authserver\AuthServer::class);
    }
}
