<?php

class Basecomponent extends CComponent {

	private $_memoized = array();

	/**
	 * 
	 * Memoizer
	 * 
	 * @param string $property
	 * @param callback $callback
	 * @param boolean $force
	 * @return multitype:
	 */
	public function getMemoized($property, $callback, $force = false)
	{

		if (!array_key_exists($property, $this->_memoized) || $force == true) {
			$this->_memoized[$property] = call_user_func($callback, $this);
		}

		return $this->_memoized[$property];

	}

}
