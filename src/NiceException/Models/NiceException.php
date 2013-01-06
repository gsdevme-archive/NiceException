<?php

	namespace NiceException\Models;

	use \SplFileObject;
	use \JsonSerializable;

	class NiceException implements JsonSerializable
	{

		private $_exceptionId;
		private $_class;
		private $_namespace;
		private $_message;
		private $_line;
		private $_lines;
		private $_file;

		public function __construct()
		{
			$this->_exceptionId = hash('crc32', uniqid());
		}

		//	Getters
		public function getExceptionId(){return $this->_exceptionId;}
		public function getClass()		{return $this->_class;}
		public function getNamespace()	{return $this->_namespace;}
		public function getMessage()	{return $this->_message;}
		public function getLine()		{return $this->_line;}
		public function getLines()		{return $this->_lines;}
		public function getFile()		{return $this->_file;}

		//	Setters
		public function setClass($class)
		{
			$this->_class = $class;
		}

		public function setNamespace($namespace)
		{
			$this->_namespace = $namespace;
		}

		public function setMessage($message)
		{
			$this->_message = $message;
		}

		public function setLine($line)
		{
			$this->_line = (int)$line;
		}

		public function setLines($lines)
		{
			$this->_lines = $lines;
		}

		public function setFile(SplFileObject $file)
		{
			$this->_file = $file;
		}

		public function jsonSerialize()
		{
			return (object)array(
				'exceptionId' => $this->getExceptionId(),
				'class' => $this->getClass(),
				'namespace' => $this->getNamespace(),
				'message' => $this->getMessage(),
				'line' => $this->getLine(),
				'lines' => $this->getLines(),
				'file' => $this->getFile()
			);
		}
	}