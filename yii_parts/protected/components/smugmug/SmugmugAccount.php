<?php

class SmugmugAccount extends BaseComponent {
	
	private $_api;

	public function __construct() {
		
	}

	public function setApi(SmugmugApi $api) {
		$this->_api = $api;
	}

	public function getApi() {
		return $this->_api;
	}

	public function getCategories($force = false) {
		return $this->getMemoized('categories', function($self) {
			$rawCategories = $self->getApi()->getCategories();	
			$categories = new SmugmugCategoryCollection();
			foreach($rawCategories as $rawCat) {
				$categories[] = SmugmugCategory::initWithJson($self, $rawCat);
			}
			return $categories;
		}, $force);
	}

	public function getCategory($name, $createIfMissing = false) {
		$categories = $this->Categories;
		$cat = $categories->getCategoryByName($name);

		if(empty($cat) && $createIfMissing) {

			$result = $this->getApi()->createCategory(array(
				'Name'=>$name
			));

			// Refresh the categories to include newly created.
			$categories = $this->getCategories(true);
			$cat = $categories->getCategoryByName($name);
		}

		return $cat;
	}

	/**
	 * Get all albums for account.
	 * @return SmugMugAlbumCollection
	 */
	public function getAlbums($force = false) {
		return $this->getMemoized('albums', function($self) {
			$rawAlbums = $self->getApi()->getAlbums();
			$albums = new SmugmugAlbumCollection();
			foreach($rawAlbums as $album) {
				$albums[]  = SmugmugAlbum::initWithJson($self, $album);
			}
			return $albums;
		}, $force);
	}

	/**
	 * Get an album. Optionally create if missing.
	 * @param array $attr Attributes to query album with.
	 * @param boolean $createIfMissing Should be create the missing album?
	 * @return SmugmugAlbum
	 */
	public function getAlbum($attr, $createIfMissing = false) {
		if(isset($attr['Title'])) {
			$album = $this->_getAlbumByTitle($attr['Title'], $createIfMissing);	
		}
		else if(isset($attr['Id']) && isset($attr['Key'])) {
			$json = $this->Api->getAlbum($attr['Id'], $attr['Key']);
			$album = SmugmugAlbum::initWithJson($this, $json);
		}
		return $album;
	}

	/**
	 * Find an array by title. Optionally create if missing.
	 * @param string $title The album's title.
	 * @param boolean $createIfMissing Should be create the missing album?
	 * @return SmugmugAlbum
	 */
	private function _getAlbumByTitle($title, $createIfMissing = false) {
		$albums = $this->Albums;	
		$album = $albums->getAlbumByTitle($title);

		if(empty($album) && $createIfMissing) {

			$result = $this->getApi()->createAlbum(array(
				'Title'=>$title
			));

			// echo '<p>Creating new album</p>';
			// echo '<pre> ' . CVarDumper::dumpAsString($result) . '</pre>';

			// Refresh to include newly created.
			$albums = $this->getAlbums(true);
			$album = $albums->getAlbumByTitle($title);
		}

		return $album;
	}

}

