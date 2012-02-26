<?php

class SmugmugAccount extends CComponent {
	
	private $_api;

	public function __construct() {
		
	}

	public function setApi(SmugmugApi $api) {
		$this->_api = $api;
	}

	public function getApi() {
		return $this->_api;
	}

	public function getAlbums() {
		$rawAlbums = $this->getApi()->getAlbums();

		$albums = array();

		foreach($rawAlbums as $album) {
			$albums[]  = SmugmugAlbum::initWithJson($this, $album);
		}

		return $albums;
	}

	public function getAlbum($id, $key) {
		$album = $this->Api->getAlbum($id, $key);
		return SmugmugAlbum::initWithJson($this, $album);
	}

}

