<?php
$con = mysqli_connect("localhost", "root", "", "ocawbms");

if (isset($_GET['user_id'])) {
    
	$user_id = $_GET['user_id'];
	$query = "SELECT filename, image, filetype, size FROM image_upload WHERE user_id = '$user_id'";
	$result = mysqli_query($con, $query) or die('Error, query failed');


    list($name, $content, $type, $size) = mysqli_fetch_array($result);
    header("Content-Disposition: attachment; filename=$name");
    header("Content-length: $size");
    header("Content-type: $type");
    echo $content;


	exit;
}

?>