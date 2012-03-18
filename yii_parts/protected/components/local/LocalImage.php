<?php

/**
 * Represents a local image file. Has a reference to the db store where
 * we keep extended info about the file.
 */
class LocalImage extends LocalBaseModel implements iComparable {

	static public function fromCollection(FileCollection $collection) {
		$array = new ImageCollection();
		foreach($collection as $folder) {
			$array[] = static::fromFileInfo($folder);
		}
		return $array;
	}

	private $_model;

	/**
	 * Get the db model representing this images data
	 */
	public function getModel() {

		if(!isset($this->_model)) {
			$model = Photos::model()->find(
				'filename=:filename', 
				array(
					'filename'=>$this->FolderName
				)
			);

			if(!isset($model)) {
				$model = new Photos();
			}

			$this->_model = $model;
		}

		return $this->_model;
	}

	public function updateModel() {
		$this->model->abs_path = $this->FolderPath;
		$this->model->filename = $this->FolderName;
		$this->model->hash = $this->hash;
		$this->model->date_modified = date ('Y-m-d H:i:s', filemtime($this->FolderPath));
		$this->model->date_last_synced = date ('Y-m-d H:i:s', time());
		return $this;
	}

	public function save() {
		if(!$this->model->save()) {
			echo '<pre>' . CVarDumper::dumpAsString($this->model->getErrors()) . '</pre>';
			exit;
		}
	}

	public function getIsNew() {
		return $this->model->isNewRecord;
	}

	public function getHash() {
		return md5_file($this->FolderPath);
	}

	public function getHasChanged() {
		$dateModified = date ('Y-m-d H:i:s', filemtime($this->FolderPath));
		return (($this->model->hash != $this->Hash) 
			|| ($this->model->date_modified != $dateModified));
	}

	public function isEqualTo(iComparable $compare) {
		return $this->comparable == $compare->comparable;
	}

	public function isNewerThan(iComparable $compare) {
		return $this->ModifiedUtcTime > $compare->ModifiedUtcTime;
	}

	public function getComparable() {
		return $this->model->hash;
	}

	public function getModifiedUtcTime() {
		return strtotime($this->model->date_last_synced);
	}

}
