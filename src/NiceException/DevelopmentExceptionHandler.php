<?php

	namespace NiceException;

	class DevelopmentExceptionHandler extends Handlers\Exception
	{

		public function run(\Exception $exception)
		{
			parent::run($exception);
		}
	}