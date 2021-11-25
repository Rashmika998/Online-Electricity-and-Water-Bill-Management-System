<?php

//Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
// if(isset($_SESSION["loggedin_admin"]) && $_SESSION["loggedin_admin"] === true){
//   header("location: Admin-Dashboard.php");
//   exit;
// }
 
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ocawbms');
 
$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
  
// Define variables and initialize with empty values
$admin_username = $admin_password = "";
$username_err = $password_err = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["admin_username"]))){
        $username_err = "Please enter the username.";
    } else{
        $admin_username = trim($_POST["admin_username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["admin_password"]))){
        $password_err = "Please enter your password.";
    } else{
        $admin_password = trim($_POST["admin_password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        
        $sql = "SELECT admin_id, admin_username, admin_password FROM admin WHERE admin_username = ?";
        
        if($stmt = $link->prepare($sql)){
           

            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
              // Set parameters
              $param_username = $admin_username;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows() == 1){                    
                    // Bind result variables
                    $stmt->bind_result($admin_id, $admin_username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($admin_password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin_admin"] = true;
                            $_SESSION["admin_id"] = $admin_id;
                            $_SESSION["admin_uname"] = $admin_username; 
                            
                            // Redirect user to welcome page
                            header("location: Admin-Dashboard.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $link->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type=text/css
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">

    <style type="text/css">
    html,
    body {
        font: 14px sans-serif;
        height: 100%;
    }
    </style>
</head>

<body>

    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-lg-6">
                <div class="card border-dark shadow-lg">


                    <div class="card-body">
                        <h2>Admin Login</h2>
                        <p>Please fill in your admin credentials to login.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group"  style="opacity: 0.8;">
                                <label>Admin Username</label>
                                <input type="text" name="admin_username" class="form-control"
                                    value="<?php echo $admin_username; ?>">
                                <span class="help-block"><?php echo $username_err; ?></span>
                            </div>
                            <div class="form-group"  style="opacity: 0.8;">
                                <label>Password</label>
                                <input type="password" name="admin_password" class="form-control">
                                <span class="help-block"><?php echo $password_err; ?></span>

                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Login">
                            </div>
                            <div class="forgot float-right">
                                <a href="Forgot-Password.php">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>