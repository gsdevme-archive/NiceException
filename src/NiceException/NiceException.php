<?php

	namespace NiceException;

	use \NiceException\Handlers\DevelopmentExceptionHandler;
	use  \NiceException\Handlers\ProductionExceptionHandler;

	class NiceException
	{

		private $_config;

		public function __construct(array $config=null)
		{
			$config = (object)array_merge((array)$config, array(
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

			//	If PHP <5.4 this interface wont exist.. therefore we need to create it
			if(!interface_exists('JsonSerializable')){
				require_once __DIR__ . '/Polyfills/JsonSerializable.php';
			}

			$config->mode = strtoupper($config->mode);
			$this->_config = $config;
		}

		public function isDevelopment()
		{
			return (bool)(strtoupper($this->_config->mode) !== 'PRODUCTION');
		}

		public function run()
		{
			$this->_obStart()
				->_setErrorReporting()
				->_setErrorHandler();

			if($this->isDevelopment()){
				set_exception_handler(array(new DevelopmentExceptionHandler(), 'run'));
			}else{
				set_exception_handler(array(new ProductionExceptionHandler(), 'run'));
			}
		}

		private function _obStart()
		{
			if($this->_config->obStart === true){
				ob_start();
			}

			return $this;
		}

		private function _setErrorReporting()
		{
			if($this->_config->error_reporting === true){
				error_reporting(-1);
			}

			return $this;
		}

		private function _setErrorHandler()
		{
			if($this->_config->set_error_handler === true){

				if($this->_config->restore_error_handler === true){
					restore_error_handler();
				}

				set_error_handler(function($errno, $errstr, $errfile, $errline ) {
					throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
				});
			}

			return $this;
		}
	}