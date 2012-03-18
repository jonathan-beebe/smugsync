<?php

/**
 * Represents an account's folder on the local file system
 */
class LocalAccount extends LocalBaseModel {
	
	public function getAccountName() {
		return $this->Folder->getFilename();
	}

	/**
	 * @return LocalCategory
	 */
	public function getCategories() {
		// Categories are all 1st level folders.
		$folders = $this->collectFolders();
		return LocalCategory::fromCollection($folders);
	}

}
