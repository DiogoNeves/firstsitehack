<?php

require 'globals.php';

header("Content-type:application/json;charset=UTF-8");

if (!array_key_exists('teamname', $_GET)) {
    echo json_encode('NO_TEAM');
    exit();
}

$teamname = $_GET['teamname'];
if (is_null($teamname) || strlen($teamname) == 0) {
    echo json_encode('NO_TEAM');
    exit();
}

$mysqli = new mysqli($host, $user, $pass, $database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT `title`, `image_id`, `score_earned` FROM `unlocked_images`, `images` WHERE `team_name` = \"{$teamname}\" AND `image_id` = `id`";
if ($result = $mysqli->query($query)) {

    $score = 0;
	$images = array();

    while ($img = $result->fetch_object()) {
        error_log('Title: ' . $img->title);
        $images[] = htmlentities(getImagePath($img->image_id, $img->title));
        $score += $img->score_earned;
    }

    /* free result set */
    $result->close();

    echo json_encode(array("score" => $score, "images" => $images));
}

$mysqli->close();
	
?>