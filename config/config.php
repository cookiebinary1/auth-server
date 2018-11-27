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

		'model' => base_path() . '/zeroone/AuthServer/src',

        'views' => base_path() . '/zeroone/AuthServer/resources/views',

        'controller' => base_path() . '/zeroone/AuthServer/src/Http/Controllers',

        'migration' => base_path() . '/zeroone/AuthServer/database/migrations',

		'database' => '/01people/AuthServer/database/migrations',

	   	'routes' => base_path() . '/zeroone/AuthServer/routes/web.php',

	   	'controllerNameSpace' => 'zeroone\AuthServer\\Http\\Controllers',

	   	'modelNameSpace' => 'zeroone\AuthServer',

		'loadViews' => 'AuthServer',

	   ];
