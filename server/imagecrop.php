<?php

function cropImage($image, $crop, $filename) {
	$cropArray = explode(',', $crop);

	$thumb_width = $cropArray[4];
	$thumb_height = $cropArray[5];

	$width = imagesx($image);
	$height = imagesy($image);

	$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

	error_log('0,0 '.$cropArray[0].','.$cropArray[1].' '.($cropArray[0] + $thumb_width).','.($cropArray[1] + $thumb_height));
	// Resize and crop
	imagecopyresampled($thumb,
	                   $image,
	                   0, 0,
	                   $cropArray[0], $cropArray[1],
	                   $thumb_width, $thumb_height,
	                   $thumb_width, $thumb_height);
	imagejpeg($thumb, $filename, 100);
}

?>