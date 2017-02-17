<?php

class Hello {
	var $message;
	
	function __construct() {
		$this->message= "Hello, World!";
	}
	
	/**
	 * Function that prints the value of the instance variable
	 * $message
	 */
	function prntMessage() {
		echo $this->message;
	}
}

?>