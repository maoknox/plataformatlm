<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',
	'language'=>'es',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'telemed_ik',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
                    'urlFormat'=>'path',
                    'showScriptName'=>true,
                    'caseSensitive'=>false,        
                    'rules'=>array(
                        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                        '<controller:\w+>/<action:\w+>/<id:\d+>/*'=>'<controller>/<action>',
                        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    ),
		),
		
		// 'db'=>array(
		// 	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		// ),
		// uncomment the following to use a MySQL database//              
		'db'=>array(
			'connectionString' => 'pgsql:host='.getenv("TELEMED_HOST").';dbname='.getenv("TELEMED_DB"),
			// 'emulatePrepare' => true,
			'username' => getenv("TELEMED_UNAME"),
			'password' => getenv("TELEMED_PSSWD"),
			'charset' => 'utf8',
		),
//		'db'=>array(
//			'connectionString' => 'pgsql:host='.getenv("ELEPH_HOST").';port=5432;dbname='.getenv("ELEPH_DB"),
//			// 'emulatePrepare' => true,
//			'username' => getenv("ELEPH_UNAME"),
//			'password' => getenv("ELEPH_PSSWD"),
//			'charset' => 'utf8',
//		),               
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'authManager'=>array(
	        'class'=>'CDbAuthManager',
	        'connectionID'=>'db',
	        'itemTable'=>'authitem', // Tabla que contiene los elementos de autorizacion
			'itemChildTable'=>'authitemchild', // Tabla que contiene los elementos padre-hijo
			'assignmentTable'=>'authassignment',// Tabla que contiene la signacion usuario-autorizacio
	    ),
            'log'=>array(
                    'class'=>'CLogRouter',
                    'routes'=>array(
                            array(
                                    'class'=>'CFileLogRoute',
                                    'levels'=>'error, warning',
                            ),
                            // uncomment the following to show log messages on web pages
                            /*
                            array(
                                    'class'=>'CWebLogRoute',
                            ),
                            */
                    ),
            ),
            'clientScript'=>array(
                    'packages'=>array(
                        'jquery'=>array(
                            'baseUrl'=>'https://telemedagua.herokuapp.com/js/',
                            'js'=>array('jquery-2.2.3.min.js'),
                        )
                    ),
                ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);