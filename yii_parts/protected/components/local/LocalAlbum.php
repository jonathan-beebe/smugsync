<?php

class LocalAlbum extends LocalBaseModel {

	public function getAllowedMimetypes() {
		return array(
			'image/gif',
			'image/jpeg',
			'image/png'
		);
	}

	/**
	 * @return LocalImage
	 */
	public function getImages() {
		$mimetypes = $this->AllowedMimetypes;
		$files = $this->collectFiles(function(SplFileInfo $info) use ($mimetypes) {
			if($imageInfo = @getimagesize($info)) {
				if(isset($imageInfo['mime']) && in_array($imageInfo['mime'], $mimetypes)) {
					return true;
				}
			}
			return false;
		});
		return LocalImage::fromCollection($files);
	}

}
