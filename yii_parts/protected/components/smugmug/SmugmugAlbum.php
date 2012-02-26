<?php

class SmugmugAlbum extends SmugmugBaseModel {

	public function attributeNames () {
		return array(
			'id',
			'Key',
			'Category',
			'Title'
		);
	}

	public function getSafeAttributeNames() {
		return $this->attributeNames();
	}

	public static function initWithJson(SmugmugAccount $account, $json, $class = __class__) {
		$o = new $class($account);
		$o->setAttributes($json);
		return $o;
	}

	public function setCategory($category) {
		// TODO: turn into category object.
		$this->_setAttribute('Category', $category);
	}

	public function getImages() {
		return $this->getMemoized('images', function($self) {	
			$json = $self->Account->getApi()->getImages($self);
			$images = array();
			foreach($json['Images'] as $imageData) {
				$images[] = SmugmugImage::initWithJson($self->Account, $imageData);
			}
			return $images;
		});
	}

	public function getImage($id, $key) {
		$image = $this->Api->getImage($id, $key);
		return SmugmugImage::initWithJson($this, $album);
	}
	
}
