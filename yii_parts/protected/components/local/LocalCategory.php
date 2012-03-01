<?php

/**
 * Represents a category folder on the local file system
 */
class LocalCategory extends LocalBaseModel {
	
	public function getAlbums() {
		$folders = $this->collectFolders();
		return LocalAlbum::fromCollection($folders);
	}

}
