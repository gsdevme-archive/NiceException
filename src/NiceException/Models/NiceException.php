<?php

	namespace NiceException\Models;

	use \SplFileObject;

	class NiceException
	{

		private $_class;
		private $_message;
		private $_line;
		private $_file;

		public function setClass($class)
		{
			$this->_class = $class;
		}

		public function getClass()
		{
			return $this->_class;
		}

		public function setMessage($message)
		{
			$this->_message = $message;
		}

		public function getMessage()
		{
			return $this->_message;
		}

		public function setLine($line)
		{
			$this->_line = $line;
		}

		public function getLine()
		{
			return $this->_line;
		}

		public function setFile(SplFileObject $file)
		{
			$this->_file = $file;
		}

		public function getFile()
		{
			return $this->_file;
		}

		public function toStdClass()
		{
			return (object)array(
				'class' => $this->getClass(),
				'message' => $this->getMessage(),
				'line' => $this->getLine(),
				'file' => $this->getFile()
			);
		}

		public function __toString()
		{
			return json_encode(array(
				'class' => $this->getClass(),
				'message' => $this->getMessage(),
				'line' => $this->getLine(),
				'file' => $this->getFile()->getRealPath()
			), JSON_FORCE_OBJECT);
		}
	}