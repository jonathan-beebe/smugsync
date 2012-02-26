<?php

class SmugmugBaseComponent {

	private $_account;

	protected $_m = array();
	protected $_v = array();

	public function __construct(SmugmugAccount $account) {
		$this->_account = $account;
	}

	public function getAccount() {
		return $this->_account;
	}

	public function __set($name, $value) {
		$setter = 'set' . ucfirst($name);
		if(is_callable(array($this, $setter))) {
			call_user_func_array(array($this, $setter), array($value));
		}
		else if(in_array($name, $this->_m)) {
			$this->_v[$name] = $value;
		}
		else {
			parent::__set($name, $value);
		}
	}

	protected function __setAttribute($name, $value) {
		$this->_v[$name] = $value;
	}

	public function hasAttribute($name) {
		return in_array($name, $this->_m);
	}

	public function __get($name) {
		$getter = 'get' . ucfirst($name);
		if(is_callable(array($this, $getter))) {
			return call_user_func(array($this, $getter));
		}
		else {
			$attr = $this->__getAttribute($name);
			if($this->hasAttribute($name) || isset($attr)) {
				return $attr;
			}
		}

		throw new Exception('Entity does not have the property ' . $name);
	}

	protected function __getAttribute($name) {
		if(in_array($name, $this->_m)) {
			$value = isset($this->_v[$name]) ? $this->_v[$name] : null;
			return $value;
		}
	}

	public function toArray() {
		$a = array();
		foreach($this->_m as $key) {
			$a[$key] = null;
			if(array_key_exists($key, $this->_v)) {
				$a[$key] = $this->_v[$key];
			}
		}
		return $a;
	}
}
