<?php

header("Content-type:image/jpeg");

$mysqli = new mysqli('localhost', 'root', 'root', 'goldrush');
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = 'SELECT `id`, `image` FROM `images` WHERE `id` = "' . $_GET['id'] . '";';
if ($result = $mysqli->query($query)) {

	$zones = array();
    $image = $result->fetch_object();
    
    echo $image->image;

    /* free result set */
    $result->close();
}

$mysqli->close();

?>