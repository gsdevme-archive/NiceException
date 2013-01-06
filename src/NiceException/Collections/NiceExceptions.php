<?php

	/**
	* Short description for file
	*
	* Long description for file (if any)...
	*
	* LICENSE: Some license information
	*
	* @category   NiceException
	* @package    NiceException
	* @version    1
	* @link       https://packagist.org/packages/niceexception/niceexception
	* @since      1
	* @author     Gavin Staniforth, @gsphpdev, Github: gsdevme
	*/

	namespace NiceException\Collections;

	use \SplQueue;
	use \NiceException\Models\NiceException;
	use \SplDoublyLinkedList;

	/**
	* NiceExceptions Collection,
	*
	* Ensures we can push Exception Models into our Queue
	*/
	class NiceExceptions extends SplQueue
	{

		public function __construct()
		{
			$this->setIteratorMode(SplDoublyLinkedList::IT_MODE_DELETE);
		}

		/**
		 * Enforces that its an NiceException object pushed into the Queue
		 *
		 * @param  Exception $exception
		 * @return void
		 */
		public function pushNiceException(NiceException $exception)
		{
			parent::push($exception);
		}

		/**
		 *
		 *
		 * @return Array
		 */
		public function jsonSerialize()
		{
			$json = array();

			foreach($this as $exception){
				if(PHP_VERSION_ID < 50400){
					$json[] = json_encode($exception->jsonSerialize());
				}else{
					$json[] = json_encode($exception);
				}
			}

			return $json;
		}
	}