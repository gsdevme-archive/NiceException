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

			$e = $exception;

			while($e->getPrevious() !== null){
				$exceptionCollection->pushNiceException($this->_constructExceptionModel($e->getPrevious()));

				$e = $e->getPrevious();
			}

			unset($e);

			/*if ($exception->getTrace() !== null) {
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
			}*/

			$stats = new \stdClass();
			$stats->runtime = __NICE_EXCEPTION_TIME;

			return (object)array(
				'exceptionCollection' => $exceptionCollection,
				'stats' => $stats
			);
		}

		private function _constructExceptionModel(\Exception $exception)
		{
			$class = substr(get_class($exception), strrpos(get_class($exception), '\\'));
			$namespace = str_replace($class, null, get_class($exception));

			if(strlen($namespace) === 0){
				$namespace = 'Global';
			}

			$class = str_replace('\\', null, $class);

			$niceException = new NiceException();
			$niceException->setClass($class);
			$niceException->setNamespace($namespace);
			$niceException->setMessage($exception->getMessage());
			$niceException->setLine($exception->getLine());
			$niceException->setFile(new SplFileObject($exception->getFile(), 'r'));
			$niceException->setLines($this->_getLines($niceException->getFile(), $niceException->getLine()));

			return $niceException;
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

		private function _getLines($file, $line)
		{
			$return = null;
			$file = new SplFileObject($file);

			if ($line >= 11) {
				$file->seek($line - 11);
			}

			while (($file->valid()) && ($file->key() <= $line + 9)) {
				if ($file->key() == $line - 1) {
					$return .= '<span style="background:#FF8C69;">' . ($file->key() + 1) . "\t" . htmlspecialchars(htmlentities($file->current(), ENT_QUOTES, 'UTF-8', false), ENT_QUOTES, 'UTF-8', false) . '</span>';
				} else {
					$return .= ($file->key() + 1) . "\t" . htmlspecialchars(htmlentities($file->current(), ENT_QUOTES, 'UTF-8', false), ENT_QUOTES, 'UTF-8', false);
				}


				$file->next();
			}

			return $return;
		}
	}