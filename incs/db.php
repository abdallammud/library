<?php 
$servername = "localhost";
$username   = "u264673343_library_user";
$password   = "Hooyomcn94@";
$db = "u264673343_library";

$GLOBALS['conn'] = $conn = new mysqli($servername, $username, $password, $db);

if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}





?>
