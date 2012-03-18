<?php

/**
 * Represents a category folder on the local file system
 */
class LocalCategory extends LocalBaseModel {
	
	/**
	 * @return LocalAlbum
	 */
	public function getAlbums() {
		$folders = $this->collectFolders();
		return LocalAlbum::fromCollection($folders);
	}

}
