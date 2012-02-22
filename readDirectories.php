<?php

$dir = dirname(__FILE__) . '/Pictures';

$allowedMimeTypes = array(
	'image/gif',
	'image/jpeg',
	'image/png'
);

rIterate($dir);

function rIterate($dir) {

	if(is_dir($dir)) {
		$iterator = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);

		echo 'Working on directory ' . $iterator->getPath() . "\n";

		$currentCategory = null;
		$currentAlbum = null;

		foreach(new RecursiveIteratorIterator($iterator) as $file) {

			if($file->isDir()) { 
				continue; 
			}

			if(!isFileImage($file)) { 
				continue; 
			}

			$category = getCategory($file);
			$album = getAlbum($file);

			if($category != $currentCategory || $album != $currentAlbum) {
				echo 'Category: ' . $category . ', Album: ' . $album . "\n";
				$currentAlbum = $album;
				$currentCategory = $category;
			}

			processDirItem($file);
		}
	}
}

function isFileImage(SplfileInfo $file) {

	global $allowedMimeTypes;

	try{

		$imageInfo = getimagesize($file);

		//echo var_dump($imageInfo);

		if(isset($imageInfo['mime']) && in_array($imageInfo['mime'], $allowedMimeTypes)) {
			return true;
		}

	}
	catch(Exception $e) {

	}

	return false;
}

function processDirItem(SplfileInfo $item) {
	if ($item->isFile()) {
		echo $item->getPathName() . "\n";
	}
	else if(!$item->isDir()) {
		echo 'directory: ' . $item->getPathName() . "\n";
	}
}

function getCategory(SplfileInfo $filepath) {
	$index = 2;
	if($filepath->isFile()) {
		$index++;
	}
	
	$parts = explode('/', $filepath->getPathName());
	if(count($parts) > $index) {
		return $parts[count($parts) - $index];
	}
}

function getAlbum(SplfileInfo $filepath) {
	$index = 1;
	if($filepath->isFile()) {
		$index++;
	}
	$parts = explode('/', $filepath->getPathName());
	if(count($parts) > $index) {
		return $parts[count($parts) - $index];
	}
}

