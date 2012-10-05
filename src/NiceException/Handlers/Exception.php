<?php

	namespace NiceException\Handlers;

	use \NiceException\Models\NiceException;
	use \SplFileObject;

	abstract class Exception
	{

		protected function handle(\Exception $exception)
		{
			$exceptionCollection = array();

			$niceException = new NiceException();
			$niceException->setClass(substr(get_class($exception), strrpos(get_class($exception), '\\')));
			$niceException->setMessage($exception->getMessage());
			$niceException->setLine($exception->getLine());
			$niceException->setFile(new SplFileObject($exception->getFile(), 'r'));

			$exceptionCollection[] = $niceException;

			if($exception->getPrevious() !== null){
				$previous = $exception->getPrevious();

				$niceException = new NiceException();
				$niceException->setClass(substr(get_class($previous), strrpos(get_class($previous), '\\')));
				$niceException->setMessage($previous->getMessage());
				$niceException->setLine($previous->getLine());
				$niceException->setFile(new SplFileObject($previous->getFile(), 'r'));

				$exceptionCollection[] = $niceException;
			}

			if ($exception->getTrace() !== null) {
				foreach ($exception->getTrace() as $trace) {
					if (isset($trace['line'], $trace['file'], $trace['args'], $trace['class'], $trace['function'])) {
						$niceException = new NiceException();
						$niceException->setClass(substr($trace['class'], strrpos($trace['class'], '\\')));
						$niceException->setMessage($trace['function'] . $this->_buildParameters($trace['args']));
						$niceException->setLine($trace['line']);
						$niceException->setFile(new SplFileObject($trace['file'], 'r'));

						$exceptionCollection[] = $niceException;
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
	}