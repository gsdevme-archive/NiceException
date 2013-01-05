<?php

	/**
	* Ensures this interface exists on platforms with <PHP 5.4
	*
	* @category   NiceException
	* @package    NiceException
	* @version    1
	* @link       https://packagist.org/packages/niceexception/niceexception
	* @since      1
	* @author     Gavin Staniforth, @gsphpdev, Github: gsdevme
	*/

	interface JsonSerializable
	{

		public function jsonSerialize();
	}