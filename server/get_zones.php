<?php

header("Content-type:application/json;charset=UTF-8");

$mysqli = new mysqli('localhost', 'root', 'root', 'goldrush');
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = 'SELECT `id`, `zone`, `text`, `title`, `crop`, `image` FROM `images`;';
if ($result = $mysqli->query($query)) {

	$zones = array();

    while ($image = $result->fetch_object()) {
    	if (!array_key_exists($image->zone, $zones))
    		$zones[$image->zone] = array();

    	$title = htmlentities($image->title);
    	$text = htmlentities($image->text);
    	$crop = explode(',', $image->crop);

    	$zones[$image->zone][] = array("title" => $title, "text" => $text, "crop" => $crop, "path" => "/server/image.php?id=" . $image->id);
    }

    /* free result set */
    $result->close();

    echo json_encode($zones, JSON_FORCE_OBJECT);
}

$mysqli->close();
	
?>