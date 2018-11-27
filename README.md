# auth-server

Add to your .env:

AUTH_SERVER_URL=https://auth.example.com # auth server url

AUTH_SERVER_API_KEY=

AUTH_SERVER_SECRET_KEY=

AUTH_SERVER_CERT_FILE=pub.crt # certificate path

AUTH_SERVER_SUCCESS_URL=/success # url, could be absolute


Add trait usage to User eloquent:

use \Zeroone\Authserver\Http\AuthUserTrait;


Add         \Zeroone\AuthServer\AuthServerServiceProvider::class
to config/app.php section providers