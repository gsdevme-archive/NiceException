<?php

	namespace NiceException\Handlers;

	abstract class Response
	{

		public function __construct()
		{
			// Gav: Do we need to clear the buffer?
			$status = ob_get_status(true);

			if (!empty($status)) {
				// Just incase for some reason is doesn't clean
				try {ob_end_clean();} catch (\Exception $e) { }
			}
		}
	}