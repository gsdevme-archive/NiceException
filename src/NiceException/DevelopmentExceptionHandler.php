<?php

	namespace NiceException;

	class DevelopmentExceptionHandler extends Handlers\Exception
	{

		public function run(\Exception $exception)
		{
			$exceptionCollection = $this->handle($exception);

			echo '<pre>' . print_r($exceptionCollection, true) . '</pre>';
		}
	}