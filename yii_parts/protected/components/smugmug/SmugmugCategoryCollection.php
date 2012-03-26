<?php

class SmugMugCategoryCollection extends BaseCollection {

	public function containsCategoryName($name) {
		$cat = $this->getCategoryByName($name);
		return (isset($cat) && !empty($cat));
	}

	public function getCategoryByName($name) {
		foreach($this as $cat) {
			if($cat->Name == $name) { return $cat; }
		}
		return null;
	}

}
