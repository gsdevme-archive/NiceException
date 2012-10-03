<?php

	namespace NiceException;

	class ProductionExceptionHandler implements Interfaces\ExceptionHandler
	{

		public function run($exception)
		{
			/*if(headers_sent() !== true){
				header('Cache-Control: no-cache, must-revalidate');
				header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
				header('500 Internal Server Error', true, 500);
				exit;
			}*/

			var_dump($exception);
		}
	}