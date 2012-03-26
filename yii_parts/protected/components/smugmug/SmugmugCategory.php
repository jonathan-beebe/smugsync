<?php

class SmugmugCategory extends SmugmugBaseModel {

	public function attributeNames () {
		return array(
			'id',
			'Name',
			'NiceName',
			'Type'
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
