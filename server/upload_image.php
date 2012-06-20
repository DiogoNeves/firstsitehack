<?php

require 'globals.php';
require 'imagecrop.php';

header("Content-type:application/json;charset=UTF-8");

if (is_null($_POST['title'])) {
	echo json_encode('NO_TITLE');
	return;
}

$zone = is_null($_POST['zone']) || strlen($_POST['zone']) == 0 ? '1' : $_POST['zone'];
$crop = '0,0,0,0,0,0';
if (!is_null($_POST['crop']))
	$crop = join(',', $_POST['crop']);

$mysqli = new mysqli($host, $user, $pass, $database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT COUNT(`id`) FROM `images` WHERE `zone` = \"{$zone}\";";
if ($result = $mysqli->query($query)) {
	$count = $result->fetch_array();
	if ($count[0] > 6) {
		echo json_encode('TOO_MANY');
		exit();
	}
}

//$image = substr($mysqli->real_escape_string($_POST['image']), 0, 10);
$image = $mysqli->real_escape_string($_POST['image']);

$query = 'INSERT INTO images (title, text, zone, crop, image) VALUES ("' . $_POST['title'] . '", "' . $_POST['text'] . '", "' . $zone . '", "' . $crop . '", "' . $image . '")';
if ($mysqli->query($query)) {
	//error_log(substr($image, 0, 40));
	$clean = str_replace('data:image/jpeg;base64,', '', $image);
	$clean = str_replace(' ', '+', $clean);
	$decoded = base64_decode($clean);
	$binimage = imagecreatefromstring($decoded);

	if ( !file_exists('crops/') ) {
		mkdir ('crops/', 0777);
	}
	cropImage($binimage, $crop, 'crops/' . $_POST['title'] . '.jpg');
	imagedestroy($binimage);
}

$mysqli->close();

echo json_encode('OK');

?>