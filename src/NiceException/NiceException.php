<?php

	namespace NiceException;

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
				 * Should NiceException registry a shutdown function
				 * to attempt to catch fatal errors
				 */
				'register_shutdown_function' => true,

				/**
				 * Should NiceException restore the error handler?
				 * This will override anything set from other frameworks
				 */
				'restore_error_handler' => true,

				/**
				 * Should NiceException set the errors as on (-1)
				 */
				'error_reporting' => true,

				/**
				 * Should NiceException set an exception handler
				 */
				'set_error_handler' => true,
			));

			$config->mode = strtoupper($config->mode);
			$this->_config = $config;
		}

		public function isDevelopment()
		{
			return (bool)($this->_config->mode !== 'PRODUCTION');
		}

		public function run()
		{
			$this->_setErrorReporting()
				->_setErrorHandler();

			if($this->isDevelopment()){
				//	Do our stuff!
			}

			set_exception_handler(array(new ProductionExceptionHandler(), 'run'));
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