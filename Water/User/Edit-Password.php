<?php

require_once '../../Config.php';

$new_password_err = $confirm_password_err = $new_password  = $confirm_password = "";

$user_id = $_SESSION['user_id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET user_password = '$new_password' WHERE user_id = '$user_id'";
        
        if(mysqli_query($link,$sql)){
            $message = "Password changed.";
            $activity = "INSERT INTO activity_log (user_id, message) VALUES ('$user_id', '$message')";
            mysqli_query($link,$activity);
            header("Location:../../User-Login.php");
            
        }

        else{
            mysqli_error($link);
        }
    }

    else{
        echo $new_password_err;
        echo "\n";
        echo $confirm_password_err;
    }
    
    // Close connection
    $link->close();
}

?>