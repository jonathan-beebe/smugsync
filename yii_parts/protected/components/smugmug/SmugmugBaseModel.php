<?php

/**
 * A base class for all SmugMug api models.
 * Heavily influenced by Yii's CActiveRecord
 */
abstract class SmugmugBaseModel extends BaseModel {

	private $_account;

	private $_attributes = array();

	public function __construct(SmugmugAccount $account) {
		$this->_account = $account;

		// init the private attributes array
		foreach($this->attributeNames() as $name) {
			$this->_attributes[$name] = null;
		}
	}

	/**
	 * Get the Smugmug Account object.
	 * @return SmugmugAccount
	 */
	public function getAccount() {
		return $this->_account;
	}

	/**
	 * A convenience getter for the id attribute of smugmug entities.
	 * Smugmug returns a lowercase id from their api. This allows for an
	 * uppercase getter for consistency accross all other attributes.
	 * @return int
	 */
	public function getId() {
		return $this->_getAttribute('id');
	}

	/**
	 * A convenience setter for the id attribute of smugmug entities.
	 * Smugmug returns a lowercase id from their api. This allows for an
	 * uppercase setter for consistency accross all other attributes.
	 * @param int $id
	 */
	public function setId($id) {
		$this->_setAttribute('id', $id);
	}

	/**
	 * PHP getter magic method.
	 * This method is overridden so that AR attributes can be accessed like properties.
	 * @param string $name property name
	 * @return mixed property value
	 * @see getAttribute
	 */
	public function __get($name)
	{
		if(array_key_exists($name, $this->_attributes))
			return $this->_attributes[$name];
		else
			return parent::__get($name);
	}

	/**
	 * PHP setter magic method.
	 * This method is overridden so that AR attributes can be accessed like properties.
	 * @param string $name property name
	 * @param mixed $value property value
	 */
	public function __set($name,$value)
	{
		if($this->setAttribute($name,$value)===false)
		{
			parent::__set($name,$value);
		}
	}
	
	/**
	 * Returns the named attribute value.
	 * If this is a new record and the attribute is not set before,
	 * the default column value will be returned.
	 * If this record is the result of a query and the attribute is not loaded,
	 * null will be returned.
	 * You may also use $this->AttributeName to obtain the attribute value.
	 * @param string $name the attribute name
	 * @return mixed the attribute value. Null if the attribute is not set or does not exist.
	 * @see hasAttribute
	 */
	public function getAttribute($name)
	{
		if(property_exists($this,$name))
			return $this->$name;
		else if(isset($this->_attributes[$name]))
			return $this->_attributes[$name];
	}

	/**
	 * Sets the named attribute value.
	 * You may also use $this->AttributeName to set the attribute value.
	 * @param string $name the attribute name
	 * @param mixed $value the attribute value.
	 * @return boolean whether the attribute exists and the assignment is conducted successfully
	 * @see hasAttribute
	 */
	public function setAttribute($name,$value)
	{
		if(property_exists($this,$name))
			$this->$name=$value;
		else if(method_exists($this, 'set' . ucfirst($name)))
			call_user_func(array($this, 'set' . ucfirst($name)), $value);	
		else if(array_key_exists($name, $this->_attributes))
			$this->_attributes[$name]=$value;
		else
			return false;
		return true;
	}

	protected function _setAttribute($name, $value) {
		if(array_key_exists($name, $this->_attributes)) {
			$this->_attributes[$name]=$value;
		}
	}

	protected function _getAttribute($name) {
		if(array_key_exists($name, $this->_attributes)) {
			return $this->_attributes[$name];
		}
	}

}
