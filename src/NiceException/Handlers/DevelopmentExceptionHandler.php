<?php

	namespace NiceException\Handlers;

	class DevelopmentExceptionHandler extends ExceptionAbstract
	{

		public function run(\Exception $exception)
		{
			$data = $this->handle($exception);

			if(substr(PHP_SAPI, 0, 3) === 'cli'){
				$response = new Responses\Cli($data->exceptionCollection);
				return;
			}

			$response = new Responses\Browser();
			return $response->render($data->exceptionCollection);
		}
	}