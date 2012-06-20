<?php

$host = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'goldrush';


function getImagePath($id, $title) {
	return "./server/crops/" . $title . '.jpg';
}

?>