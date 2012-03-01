<?php

class LocalImage extends LocalBaseModel {

	static public function fromCollection(FileCollection $collection) {
		$array = array();
		foreach($collection as $folder) {
			$array[] = static::fromFileInfo($folder);
		}
		return $array;
	}

}
