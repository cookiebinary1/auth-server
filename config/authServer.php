<?php

/**
 * @author Cookie
 */
return [
    'url'              => env('AUTH_SERVER_URL'),
    'login_url'        => env('AUTH_SERVER_URL') . "/signin",
    'registration_url' => env('AUTH_SERVER_URL') . "/registration",
    'api_key'          => env('AUTH_SERVER_API_KEY'),
    'secret_key'       => env('AUTH_SERVER_SECRET_KEY'),
    'cert_file'        => base_path(env('AUTH_SERVER_CERT_FILE', "pub.crt")),
];