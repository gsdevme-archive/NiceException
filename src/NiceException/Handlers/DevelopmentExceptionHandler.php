<?php

	namespace NiceException\Handlers;

	class DevelopmentExceptionHandler extends ExceptionAbstract
	{

		public function run(\Exception $exception)
		{
			$exceptionCollection = $this->handle($exception);

			if(substr(PHP_SAPI, 0, 3) === 'cli'){
				return new Responses\Cli();
			}else{
				return new Responses\Browser();
			}

			/*foreach($exceptionCollection as $exception){
				var_dump($exception);
			}*/
		}
	}