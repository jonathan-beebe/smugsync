<?php

	// call like this: php test.php smugmugemail smugmugpassword

	$email = $argv[1];
	$password = $argv[2];

	require_once('components/SmugmugAccount.php');
	require_once('components/SmugmugApi.php');
	require_once('components/SmugmugAlbum.php');

	// define $key and $secret in config
	include('config.php');

	$account = new SmugmugAccount($key, $secret);

	try {

		$api = new SmugmugApi($key, $secret);
		$api->login($email, $password);

		$account->setApi($api);
		$albums = $account->getAlbums();

		/*
		$albums = array (
		  array (
			'id' => 20881133,
			'Key' => 'C9RxfT',
			'Category' => 
			array (
			  'id' => 45,
			  'Name' => 'Friends',
			),
			'Title' => '2011 New Years Eve Celebration',
		  ),
		  array (
			'id' => 20792200,
			'Key' => 'VKHtXT',
			'Category' => 
			array (
			  'id' => 9,
			  'Name' => 'Family',
			),
			'Title' => '2011 Christmas',
		  )
		);
		*/

		foreach($albums as $album) {
			//echo "\n" . get_class($album) . "\n";
			//var_export($album->toArray());
			//echo "\n\n";
		}

		$images = $albums[0]->getImages();
		var_export($images);

		exit;

		// Get list of images and other useful information
		$images = $f->images_get( "AlbumID={$albums['0']['id']}", "AlbumKey={$albums['0']['Key']}", "Heavy=1" );
		$images = ( $f->APIVer == "1.3.0" ) ? $images['Images'] : $images;

		var_export($images);

		// Display the thumbnails and link to the medium image for each image
		/*
		foreach ( $images as $image ) {
			echo '<a href="'.$image['MediumURL'].'"><img src="'.$image['TinyURL'].'" title="'.$image['Caption'].'" alt="'.$image['id'].'" /></a>';
		}
		*/
	}
	catch ( Exception $e ) {
		echo "{$e->getMessage()} (Error Code: {$e->getCode()})";
	}
