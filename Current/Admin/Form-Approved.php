<?php
require '../../Config.php';

$user_id = $_GET['user_id'];
$category = $_POST['category'];
$approve = mysqli_query($link, "UPDATE current_details SET status = 'Approved', category = '$category' WHERE user_id = '$user_id'");

if($approve){
    header("Location: Admin-Dashboard.php");
    exit();
}

else {
    echo "Something went wrong when executing. Please try again later.";
}
  
// Close connection
$link->close();

?>