NiceException!
=============

Requirements
---------------------
PHP 5.3.3+ (uses polyfills)
PHP 5.4+

Configuration
---------------------
```php
<?php
	$niceException = new \NiceException\NiceException(array(
		/**
		 * Error Mode: Development or Production
		 */
		'mode' => 'development',

		/**
		 * If you know your application will create a buffer you could
		 * disable this to save abit of time
		 */
		'obStart' => true,

		/**
		 * Should NiceException register a shutdown function
		 * to attempt to catch(fake catch) fatal errors
		 */
		'register_shutdown_function' => true, // @todo <----

		/**
		 * Should NiceException restore the error handler?
		 * This will override anything set from other frameworks
		 */
		'restore_error_handler' => true,

		/**
		 * Should NiceException set the errors as on (-1)
		 */
		'error_reporting' => true,

		// Should NiceException set a error handler
		'set_error_handler' => true,
	));

	$niceException->run();
?>
```