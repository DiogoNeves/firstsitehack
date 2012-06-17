<?php

require 'globals.php';

header("Content-type:application/json;charset=UTF-8");

$teamname = $_POST['teamname'];
if (is_null($teamname) || strlen($teamname) == 0) {
	echo json_encode('NO_TEAM');
	return;
}

$mysqli = new mysqli($host, $user, $pass, $database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$teamname = $mysqli->real_escape_string($teamname);

$query = 'INSERT INTO profiles (team_name) VALUES ("' . $teamname . '")';
$result = $mysqli->query($query);

$mysqli->close();

echo json_encode(($result ? 'OK' : 'ALREADY EXISTS'));

?>