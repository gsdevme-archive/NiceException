<?php

	namespace NiceException;

	class DevelopmentExceptionHandler implements Interfaces\ExceptionHandler
	{

		public function run($exception)
		{
			var_dump($exception);
		}
	}