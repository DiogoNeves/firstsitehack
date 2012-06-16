<?php

header("Content-type:application/json;charset=UTF-8");

if (is_null($_POST['title'])) {
	echo json_encode('NO_TITLE');
	return;
}

$zone = is_null($_POST['zone']) || strlen($_POST['zone']) == 0 ? 'Zone 1' : $_POST['zone'];
$crop = '0,0,0,0,0,0';
if (!is_null($_POST['crop']))
	$crop = join(',', $_POST['crop']);

$mysqli = new mysqli('localhost', 'root', 'root', 'goldrush');
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$image = substr($mysqli->real_escape_string($_POST['image']), 0, 10);

$query = 'INSERT INTO images (title, text, zone, crop, image) VALUES ("' . $_POST['title'] . '", "' . $_POST['text'] . '", "' . $zone . '", "' . $crop . '", "' . $image . '")';
//echo json_encode($query);
$mysqli->query($query);

$mysqli->close();

echo json_encode('OK');
//echo json_encode($_POST);

?>