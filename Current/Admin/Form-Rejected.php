<?php
require '../../Config.php';

$user_id = $_GET['user_id'];

$feedback_err = "";

if(empty($_POST['feedback'])){
    $feedback_err = "Please Provide Reasons!";
}
else{
$feedback = $_POST['feedback'];
}

$reject = mysqli_query($link, "UPDATE current_details SET status = 'Rejected', feedback = '$feedback' WHERE user_id = '$user_id'");

if($reject && empty($feedback_err)){
    header("Location: Admin-Dashboard.php");
    exit();
}

else {
    echo "Something went wrong when executing. Please try again later.";
}
  
// Close connection
$link->close();

?>