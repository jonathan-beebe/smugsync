<?php

require_once('lib/phpSmug/phpSmug.php');

class SmugmugApi {
	
	private $_key;
	private $_secret;

	public function __construct($key, $secret) {
		$this->_key = $key;
		$this->_secret = $secret;
	}

	private $_api;
	private function getApi() {
		if(!isset($this->_api)) {
			$this->_api = new phpSmug( 
				"APIKey=" . $this->_key, 
				"AppName=SmugSync" 
			);
		}
		return $this->_api;
	}

	public function login($email, $password) {
		$this->getApi()->login( 
			"EmailAddress=$email", 
			"Password=$password" 
		);	
	}

	public function getAlbums() {
		return $this->getApi()->albums_get();
	}

	public function getImages($entity) {

		$type = get_class($entity);
		$images = array();

		switch($type) {

			case 'SmugmugAlbum' :

			echo "\nId" . $entity->Id. "\n";
				$images = $this->getApi()->images_get( 
					"AlbumID={$entity->Id}", 
					"AlbumKey={$entity->Key}", 
					"Heavy=1" 
				);
				$images = ( $this->getApi()->APIVer == "1.3.0" ) ? $images['Images'] : $images;
				break;
		}

		return $images;
	}
}

