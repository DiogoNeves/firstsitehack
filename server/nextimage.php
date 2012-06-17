<?php

require 'globals.php';

header("Content-type:application/json;charset=UTF-8");

// Weird code...
if (!array_key_exists('teamname', $_GET)) {
    echo json_encode('NO_TEAM');
    exit();
}

$teamname = $_GET['teamname'];
if (is_null($teamname) || strlen($teamname) == 0) {
    echo json_encode('NO_TEAM');
    exit();
}

$zone = 0;
if (array_key_exists('zone', $_GET)) {
    $zone = intval($_GET['zone']);
}


$mysqli = new mysqli($host, $user, $pass, $database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT `id`, `title`, `text`, `zone`, `crop` FROM `images` WHERE ";
$query .= "(SELECT MIN(`zone`) AS zone FROM `images` WHERE IFNULL((SELECT MAX(`zone`) AS zone FROM `unlocked_images`, `images` WHERE `team_name` = \"{$teamname}\" AND `image_id` = `id`), 0) < `zone`) = `zone`";
if ($zone > 0)
	$query .= "(SELECT MIN(`zone`) AS zone FROM `images` WHERE `zone` >= \"{$zone}\") = `zone`";

$query .= " ORDER BY RAND() LIMIT 0,1;";

if ($result = $mysqli->query($query)) {

    $img = $result->fetch_object();
    if ($img) {
    	$crop = explode(',', $img->crop);
    	echo json_encode(array("id" => $img->id, "text" => $img->text, "zone" => $img->zone, "crop" => $crop, "path" => htmlentities(getImagePath($img->id, $img->title))));
    }
    else {
    	echo json_encode('done');
    }

    /* free result set */
    $result->close();
}

$mysqli->close();
	
?>