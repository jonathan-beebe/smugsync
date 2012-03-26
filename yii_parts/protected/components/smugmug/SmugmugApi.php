<?php

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

	public function getCategories() {
		return $this->getApi()->categories_get();
	}

	/**
	 * Create a category with the given name.
	 *
	 * <code>
	 *   // Results from the api
	 *   array
	 *   (
	 *       'id' => 1125924
	 *   )
	 * </code>
	 *
	 * @param string $name The category name.
	 * @return array The json results.
	 */
	public function createCategory($params) {
		return $this->getApi()->categories_create($params);
	}

	/**
	 * Transform an attribute array into 'key=value,other=something'
	 * The api wrapper does not accept argument arrays, only csv strings.
	 * @param array $array
	 * @return string
	 */
	private function transformArgsArray($array) {
		$s = $this->array_implode('=', ',', $array);
		return $s;
	}

	/**
	 * Implode an array with the key and value pair giving
	 * a glue, a separator between pairs and the array
	 * to implode.
	 *
	 * @see http://www.php.net/manual/en/function.implode.php#106085
	 *
	 * @param string $glue The glue between key and value
	 * @param string $separator Separator between pairs
	 * @param array $array The array to implode
	 * @return string The imploded array
	 */
	function array_implode( $glue, $separator, $array ) {
		if ( ! is_array( $array ) ) return $array;
		$string = array();
		foreach ( $array as $key => $val ) {
			if ( is_array( $val ) )
				$val = implode( ',', $val );
			$string[] = "{$key}{$glue}{$val}";
			
		}
		return implode( $separator, $string );
		
	}

	/**
	 * Get all albums for account.
	 * @return array The raw json from the api query
	 */
	public function getAlbums() {
		return $this->getApi()->albums_get();
	}

	/**
	 * Get an album by id and key.
	 * @return array The raw json from the api query
	 */
	public function getAlbum($id, $key) {
		return $this->getApi()->albums_getInfo(array(
			'AlbumID'=>$id,
			'AlbumKey'=>$key
		));
	}

	/**
	 * Create an album with the given title.
	 *
	 * <code>
	 *   // Results from the api
	 *   array
	 *   (
	 *       'id' => 1125924
	 *   )
	 * </code>
	 *
	 * @param array $params The params for the new album.
	 * @return array The json results.
	 */
	public function createAlbum($params) {
		return $this->getApi()->albums_create($params);
	}

	public function getImages($entity) {

		$type = get_class($entity);
		$images = array();

		switch($type) {

			case 'SmugmugAlbum' :
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

	public function getImage($id, $key) {
		return $this->getApi()->images_getInfo(array(
			'ImageID'=>$id,
			'ImageKey'=>$key
		));
	}
}

