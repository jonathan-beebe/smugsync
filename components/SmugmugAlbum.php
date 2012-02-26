<?php

class SmugmugAlbum extends SmugmugBaseComponent {

	protected $_m = array(
		'id',
		'Key',
		'Category',
		'Title'
	);

	public static function initWithJson(SmugmugAccount $account, $json, $class = __class__) {
		$o = new $class($account);
		$o->setAttributes($json);
		return $o;
	}

	public function getId() {
		return $this->__getAttribute('id');
	}

	public function setAttributes($a) {
		foreach($this->_m as $attr) {
			if(isset($a[$attr])) {
				$this->$attr = $a[$attr];
			}
		}
	}

	public function setCategory($category) {
		$this->_v['Category'] = $category;
	}

	public function getCategory() {
		return $this->_v['Category'];
	}

	public function getImages() {
		return $this->getAccount()->getApi()->getImages($this);
	}
	
}
