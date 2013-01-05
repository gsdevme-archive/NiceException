NiceException!
=============

Requirements
---------------------
PHP 5.3.3+ (uses polyfills)
PHP 5.4+

Using with ZF2
---------------------
Since ZF2 has a try/catch around the Controller dispatch theres no method for NiceException
to function.. however by attaching an event in the Module bootstrap you can rethrow the
exception to restores PHP default behaviour

```php
<?php
class Module
{
	public function onBootstrap(MvcEvent $e)
	{

		// Get Event Manager
		$events = $e->getApplication()->getEventManager();

		// Restore PHPs default behaviour
		$events->attach(MvcEvent::EVENT_DISPATCH_ERROR, function (MvcEvent $e) {
			throw $e->getParam('exception');
		});
	}
```

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