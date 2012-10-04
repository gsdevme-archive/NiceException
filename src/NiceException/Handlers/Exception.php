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

			//echo '<pre>' . print_r($niceException, true) . '</pre>';

			echo '<pre>' . print_r((string)$niceException, true) . '</pre>';

			// Rebuild exception into a nice structure
			/*array_push($this->_outputArray, ( object ) array(
					'class' => substr(get_class($this->_exception), strrpos(get_class($this->_exception), '\\')),
					'message' => $this->_exception->getMessage(),
					'line' => $this->_exception->getLine(),
					'file' => $this->_exception->getFile(),
					'trace' => $this->_exception->getTrace(),
					'htmlFile' => $this->_getPHPLines($this->_exception->getFile(), $this->_exception->getLine()),
			));*/



			/*if ($this->_exception->getPrevious() !== null) {
				array_push($this->_outputArray, ( object ) array(
						'class' => substr(get_class($this->_exception), strrpos(get_class($this->_exception), '\\')),
						'message' => $this->_exception->getPrevious()->getMessage(),
						'line' => $this->_exception->getPrevious()->getLine(),
						'file' => $this->_exception->getPrevious()->getFile(),
						'trace' => $this->_exception->getPrevious()->getTrace(),
						'htmlFile' => $this->_getPHPLines($this->_exception->getPrevious()->getFile(), $this->_exception->getPrevious()->getLine()),
				));
			}

			// Build trace
			if ($this->_exception->getTrace() !== null) {
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