<?php

	namespace NiceException\Handlers\Responses;

	class Browser
	{

		// This is used to protect against an endless while.. if you have more then 15 buffers your mad!
		CONST MAX_BUFFER_LIMIT = 15;

		public function __construct()
		{
			// Gav: Do we need to clear the buffer?
			$ob = ob_get_status(true);
			$status = (bool)(!empty($ob));
			$buffers = 0;

			// The application might have multiple buffers... we need to ensure we clean them all!
			while($status === true){
				$buffers++;

				// Just incase for some reason is doesn't clean
				try {ob_end_clean();} catch (\Exception $e) { }

				$ob = ob_get_status(true);
				$status = (bool)(!empty($ob));

				// Endless loop protection
				if($buffers > self::MAX_BUFFER_LIMIT){
					die('We have now cleaned ' . self::MAX_BUFFER_LIMIT . 'buffers.. its possible theres a problem with the
						setup.. we have broken out of a loop to prevent further problems');
				}
			}

			echo 'test';
		}
	}