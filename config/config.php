<?php

/*
 |-------------------------------------------------------------------------
 | "AuthServer" config for scaffolding.
 |-------------------------------------------------------------------------
 |
 | You can replace this conf file with config/amranidev/config.php
 | to let scaffold-interface interact with "AuthServer".
 |
 */
return [

		'env' => [
        	'local',
    	],

		'package' => 'AuthServer',

		'model' => base_path() . '/01people/AuthServer/src',

        'views' => base_path() . '/01people/AuthServer/resources/views',

        'controller' => base_path() . '/01people/AuthServer/src/Http/Controllers',

        'migration' => base_path() . '/01people/AuthServer/database/migrations',

		'database' => '/01people/AuthServer/database/migrations',

	   	'routes' => base_path() . '/01people/AuthServer/routes/web.php',

	   	'controllerNameSpace' => '01people\AuthServer\\Http\\Controllers',

	   	'modelNameSpace' => '01people\AuthServer',

		'loadViews' => 'AuthServer',

	   ];
