<?php

/**
 * @category Riskle
 * @package Riskle_Pattern
 * @copyright 2007 (c) Geoffrey Bachelet <geoffrey+ip@zubrowka.org>
 */

/**
 * Riskle_Pattern_Proxy_Exception
 */

require_once 'Riskle/Pattern/Proxy/Exception.php';

/**
 * Riskl_Pattern_Proxy
 */

class Riskle_Pattern_Proxy {

	/**
	 * Holds the subject object
	 * @var object
	 */

	protected $_subject;

	/**
	 * Forwards any non-existent function call to the subject object
	 */

	public function __call($method, $args) {
		if (is_callable(array($this->_subject, $method))) {
			return call_user_func_array(array($this->_subject, $method), $args);
		}
		throw new Riskle_Pattern_Proxy_Exception(sprintf('Call to non-existent method \'%s\'', $method));
	}

	/**
	 * Forwards any access to a non-existent property to the subject object
	 */

	public function __get($name) {
		if (isset($this->_subject->{$name})) {
			return $this->_subject->{$name};
		}
	}

	/**
	 * Forwards any access to a non-existent property to the subject object
	 */

	public function __set($name, $value) {
		if (isset($this->_subject->{$name})) {
			return $this->_subject->{$name} = $value;
		}
	}
}
