<?php

	namespace NiceException\Handlers;

	use \NiceException\Models\NiceException;
	use \NiceException\Collections\NiceExceptions;
	use \SplFileObject;
	use \SplQueue;
	use \SplDoublyLinkedList;

	abstract class ExceptionAbstract
	{

		protected function handle(\Exception $exception)
		{
			$exceptionCollection = new NiceExceptions();

			$exceptionCollection->pushNiceException($this->_constructExceptionModel($exception));

			if($exception->getPrevious() !== null){
				$previous = $exception->getPrevious();

				$exceptionCollection->pushNiceException($this->_constructExceptionModel($previous));
				unset($niceException);
			}

			if ($exception->getTrace() !== null) {
				foreach ((array)$exception->getTrace() as $trace) {
					if (isset($trace['line'], $trace['file'], $trace['args'], $trace['class'], $trace['function'])) {
						$niceException = new NiceException();
						$niceException->setClass(substr($trace['class'], strrpos($trace['class'], '\\')));
						$niceException->setMessage($trace['function'] . $this->_buildParameters($trace['args']));
						$niceException->setLine($trace['line']);
						$niceException->setFile(new SplFileObject($trace['file'], 'r'));

						$exceptionCollection->pushNiceException($niceException);
						unset($niceException);
					}
				}
			}

			return $exceptionCollection;
		}

		private function _buildParameters($args)
		{
			array_walk($args, function(&$value, $key) {
					switch (gettype($value)) {
						case 'object':
							$value = get_class($value) . ' Object';
							break;
						case 'array':
							$value = var_export($value, true);
							break;
						case 'NULL':
							$value = 'null';
							break;
						case 'boolean':
							$value = ($value) ? 'true' : 'false';
							break;
						case 'string':
							$value = '"' . $value . '"';
							break;
						default:
							$value = '';
							break;
					}
				});

			return '( ' . implode(', ', $args) . ' )';
		}

		private function _constructExceptionModel(\Exception $exception)
		{
			$niceException = new NiceException();
			$niceException->setClass(substr(get_class($exception), strrpos(get_class($exception), '\\')));
			$niceException->setMessage($exception->getMessage());
			$niceException->setLine($exception->getLine());
			$niceException->setFile(new SplFileObject($exception->getFile(), 'r'));

			return $niceException;
		}
	}