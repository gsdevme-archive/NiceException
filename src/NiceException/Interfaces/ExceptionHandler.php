<?php

	namespace NiceException\Interfaces;

	interface ExceptionHandler
	{

		public function run($exception);
	}