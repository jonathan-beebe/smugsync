<?php

/**
 * A base class for all models.
 */
abstract class BaseModel extends CModel {

	private $_memoized = array();

	/**
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
