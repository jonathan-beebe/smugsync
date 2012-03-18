<?php

class LocalBaseModel extends CModel {

	private $_basePath;

	/**
	 * @constructor
	 * @param string $basePath The directory containing this account.
	 * @param string $account The account name and folder name.
	 */
	public function __construct($path) {
		$this->_basePath = $path;
	}

	/**
	 * Create an array of models given a collection of folders.
	 * Useful for getting folders of folders as model objects.
	 * @return ImageCollection
	 */
	static public function fromCollection(FolderCollection $collection) {
		$array = new CList();
		foreach($collection as $folder) {
			$array[] = static::fromFileInfo($folder);
		}
		return $array;
	}

	/**
	 * Create a model from an SplFileInfo object
	 */
	static public function fromFileInfo(SplFileInfo $info) {
		return new static($info);
	}

	/**
	 * needed to satisy CModel implementation
	 */
	public function attributeNames() {}

	/**
	 * Get the full path to this folder.
	 * @return string
	 */
	public function getFolderPath() {
		return realpath($this->_basePath);
	}

	/**
	 * @return SplFileInfo
	 */
	public function getFolder() {
		return new SplFileInfo($this->FolderPath);
	}

	/**
	 * Get the name of this folder.
	 * @return string
	 */
	public function getFolderName() {
		return $this->Folder->getFilename();
	}

	/**
	 * @return SplFileInfo
	 */
	public function getParent() {
		return new SplFileInfo($this->Folder->getPath());
	}

	/**
	 * Get the name of the parent folder containing this folder.
	 * @return string
	 */
	public function getParentName() {
		return $this->Parent->getFilename();
	}

	/**
	 * Does this folder actually exist on the file system?
	 * @return boolean
	 */
	public function getDoesPathExist() {
		return file_exists($this->FolderPath) && is_dir($this->FolderPath);
	}

	/**
	 * @return FolderCollection
	 */
	public function collectFolders($class = 'FolderCollection') {
		$i = new FilesystemIterator($this->FolderPath, FilesystemIterator::SKIP_DOTS);
		$collection = new $class;
		/* @var SplFileInfo $file */
		foreach($i as $file) {
			if($file->isDir()) { $collection[] = $file; }
		}
		return $collection;
	}

	/**
	 * Collect all valid files within the folder.
	 * Optionally pass in a custom callback to validate the file as collectible.
	 *
	 * @param function $callback
	 * @return FileCollection
	 */
	public function collectFiles($callback = null, $class = 'FileCollection') {
		if(!isset($callback)) { $callback = function($i) { return $i->isFile(); }; }
		$i = new FilesystemIterator($this->FolderPath, FilesystemIterator::SKIP_DOTS);
		$collection = new $class();
		/* @var SplFileInfo $file */
		foreach($i as $file) {
			if($callback($file)) {
				$collection[] = $file; 
			}
		}
		return $collection;
	}

	public function __toString() {
		return (string) $this->FolderPath;
	}
}
