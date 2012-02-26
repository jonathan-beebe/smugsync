<?php

class SmugmugImage extends SmugmugBaseModel {

	public function attributeNames () {
		return array(
			'id',
			'Key',
			'Caption', 
			'Date', 
			'FileName', 
			'Format', 
			'Height', 
			'Hidden', 
			'Keywords', 
			'LargeURL', 
			'LastUpdated', 
			'LightboxURL', 
			'MD5Sum', 
			'MediumURL', 
			'OriginalURL', 
			'Position', 
			'Serial', 
			'Size', 
			'SmallURL', 
			'ThumbURL', 
			'TinyURL', 
			'Type', 
			'URL', 
			'Watermark', 
			'Width', 
			'X2LargeURL', 
			'X3LargeURL', 
			'XLargeURL'
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
}
