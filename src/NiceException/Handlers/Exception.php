<?php

	namespace NiceException\Handlers;

	use \NiceException\Models\NiceException;
	use \SplFileObject;

	abstract class Exception
	{

		protected $exceptionCollection;

		public function run(\Exception $exception)
		{
			$exceptionCollection = array();

			$niceException = new NiceException();
			$niceException->setClass(substr(get_class($exception), strrpos(get_class($exception), '\\')));
			$niceException->setMessage($exception->getMessage());
			$niceException->setLine($exception->getLine());
			$niceException->setFile(new SplFileObject($exception->getFile(), 'r'));

			$exceptionCollection[] = $niceException;

			if ($exception->getPrevious() !== null) {
				$previous = $exception->getPrevious();

				$niceException = new NiceException();
				$niceException->setClass(substr(get_class($previous), strrpos(get_class($previous), '\\')));
				$niceException->setMessage($previous->getMessage());
				$niceException->setLine($previous->getLine());
				$niceException->setFile(new SplFileObject($previous->getFile(), 'r'));

				$exceptionCollection[] = $niceException;
			}

			var_dump($exceptionCollection);

			// Build trace
			/*if ($this->_exception->getTrace() !== null) {
				foreach ($this->_exception->getTrace() as $trace) {
					if (isset($trace['line'], $trace['file'], $trace['args'], $trace['class'], $trace['function'])) {
						array_push($this->_outputArray, ( object ) array(
								'class' => substr($trace['class'], strrpos($trace['class'], '\\')),
								'message' => $trace['function'] . $this->_buildParameters($trace['args']),
								'line' => $trace['line'],
								'file' => $trace['file'],
								'trace' => null,
								'htmlFile' => $this->_getPHPLines($trace['file'], $trace['line']),
						));
					}
				}
			}*/
		}
	}