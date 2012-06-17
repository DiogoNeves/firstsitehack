<?php

require 'globals.php';

header("Content-type:application/json;charset=UTF-8");

if (!array_key_exists('teamname', $_POST)) {
	echo json_encode('NO_TEAM');
	exit();
}

$teamname = $_POST['teamname'];
if (is_null($teamname) || strlen($teamname) == 0) {
	echo json_encode('NO_TEAM');
	exit();
}

if (!array_key_exists('id', $_POST)) {
	echo json_encode('NO_ID');
	exit();
}

$id = $_POST['id'];
if (is_null($id) || strlen($id) == 0) {
	echo json_encode('NO_ID');
	exit();
}

$mysqli = new mysqli($host, $user, $pass, $database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$teamname = $mysqli->real_escape_string($teamname);

$query = "INSERT INTO unlocked_images (image_id, team_name, score_earned) VALUES (\"{$id}\", \"{$teamname}\", \"200\")";
$result = $mysqli->query($query);

$mysqli->close();

echo json_encode(($result ? 'OK' : 'NAH'));

?>