<?php

	/**
	 * This isnt really an autoloader.. more of a class map with require()..
	 * but i dont really want to override anything frameworks are doing....
	 *
	 * Using Composer is perhaps the best way though
	 */

	$map = array(
		'Polyfills/JsonSerializable',

		'Models/NiceException',
		'Collections/NiceExceptions',

		'Handlers/ExceptionAbstract',
		'Handlers/DevelopmentExceptionHandler',
		'Handlers/ProductionExceptionHandler',

		'Handlers/Responses/Browser',
		'Handlers/Responses/Cli',
		'Handlers/Responses/Email',

		'NiceException'
	);

	$path = __DIR__ . '/';

	foreach($map as $class){
		require_once $path . $class . '.php';
	}
