<?php

	namespace NiceException\Models;

	use \SplFileObject;
	use \JsonSerializable;

	class NiceException implements JsonSerializable
	{

		private $_class;
		private $_message;
		private $_line;
		private $_file;

		//	Getters
		public function getClass()		{return $this->_class;}
		public function getMessage()	{return $this->_message;}
		public function getLine()		{return $this->_line;}
		public function getFile()		{return $this->_file;}

		//	Setters
		public function setClass($class)
		{
			$this->_class = $class;
		}

		public function setMessage($message)
		{
			$this->_message = $message;
		}

		public function setLine($line)
		{
			$this->_line = (int)$line;
		}

		public function setFile(SplFileObject $file)
		{
			$this->_file = $file;
		}

		public function jsonSerialize()
		{
			return (object)array(
				'class' => $this->getClass(),
				'message' => $this->getMessage(),
				'line' => $this->getLine(),
				'file' => $this->getFile()
			);
		}
	}