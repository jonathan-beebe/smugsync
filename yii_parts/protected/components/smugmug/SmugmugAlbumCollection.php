<?php

class SmugmugAlbumCollection extends BaseCollection {

	public function containsAlbumTitle($name) {
		$cat = $this->getAlbumByName($name);
		return (isset($cat) && !empty($cat));
	}

	public function getAlbumByTitle($name) {
		foreach($this as $a) {
			// echo '<pre> ' . CVarDumper::dumpAsString($a->attributes) . '</pre>';
			if($a->Title == $name) { return $a; }
		}
		return null;
	}

}
