# AuthServer SDK (Laravel 5+ implementation)

## Instalation

It's easy as ususal..

1. Require this package with composer using the following command:
   
   ```bash
   composer require zeroone/auth-server
   ```
   
2. Add the service provider to the `providers` array in `config/app.php`

   ```php
   Zeroone\Authserver\AuthServerServiceProvider::class,
   ```
   
3. Add some settings to your `.env` file 
    
   ```env
   AUTH_SERVER_URL=<https://auth.example.com> # auth server url
   AUTH_SERVER_API_KEY=<your_api_key> 
   AUTH_SERVER_SECRET_KEY=<your_secret_key>
   AUTH_SERVER_CERT_FILE=<pub.crt> # certificate path
   AUTH_SERVER_SUCCESS_URL=/success # url, could be absolute
   ```

4. Use trait in `User` eloquent

    ```php
    use \Zeroone\Authserver\Http\AuthUserTrait;
    ```

5. Run migration 

   ```bash
   php artisan migrate

   ```
    
   It upgrades your `users` table; some needed fields will be added.
   
   
## Usage
   
New routes will be created automaticaly:

- /login
- /login/conclusion
- /register


```php
Route::get("login", "\Zeroone\Authserver\Http\Controllers\LoginController@getLogin")->name("login");
Route::post("login/conclusion/{data?}", "\Zeroone\Authserver\Http\Controllers\LoginController@conclusion")->name("login.conclusion");
Route::get("register", "\Zeroone\AuthServer\Http\Controllers\RegisterController@getRegister")->name("register");
```

If you need you can use helper function to get an `AuthServer` instance

```php
$authServer = auth_server();
```

There are some useful methods, try & enjoy ..
