<?php
require_once '../../Config.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

// Load Composer's autoloader
require '../../vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);


$admin_email = $email_err = " ";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["admin_email"]))){
        $email_err = "Please enter an email.";     
    } 
    else{
        $admin_email = trim($_POST["admin_email"]);
        $admin_email = stripslashes($admin_email);
        $admin_email = htmlspecialchars($admin_email);
        if(!filter_var($admin_email, FILTER_VALIDATE_EMAIL)){
            $email_err = "Invalid email format!";
        }
    }

    $records = mysqli_query($link,"SELECT admin_id, admin_username, admin_password FROM admin WHERE admin_email = '$admin_email'");
    if($data=mysqli_fetch_array($records)){
        $_SESSION['admin_id'] = $data['admin_id'];
        
        try {
            
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = "ocawbms2021@gmail.com";
            $mail->Password = "OCAWBMS2021";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;

            //Recipients
            $mail->setFrom("ocawbms2021@gmail.com", "OCAWBMS");
            $mail->addAddress($admin_email);     // Add a recipient


            $admin_name=$data['admin_username'];
            $admin_id=$data['admin_id'];

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Online Electricity and Water Bill Management System -Administrator Recover Password";

            $mail->Body    = "Dear $admin_name , <br><br> Click the below link to reset the password<br>
            <a href='http://localhost/OCAWBMS/Current/Admin/Reset-Password.php?admin_id=$admin_id'>
           <h4> Reset Password</h4></a>
            <br>If you didn't request this forgotten password email, no action is needed, your password will not be reset. However,
            you may want to change your password as someone may have guessed it.<br>  <br> Best Regards <br> DLMS Team";

            if($mail->send()){
                echo '<br/> <div class="row justify-content-center wrapper"><div class="alert alert-success alert-dismissible fade show"
                 role="alert" ><p>Recovery Link is succefully sent to your logged email address.Click the link in their or copy and paste it in the browser to reset your password.</p><strong>';
                echo ' </strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div> </div>';
                    
            }

        }
         catch (Exception $e) {
            echo '<br/> <div class="row justify-content-center wrapper"><div class="alert alert-danger alert-dismissible fade show" 
            role="alert" ><p>Something went wrong,try again later.</p><strong>';
            echo ' </strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div> </div>';
        }
     
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"
    integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA=="
    crossorigin="anonymous" />

<body>
    <div class="row justify-content-center wrapper" id="login-box">
        <div class="col-lg-7 bg-white p-4">
            <h4 class="text-center font-weight-bold">Recover Password</h4>
            <hr class="my-3" />
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email Address</label>
                    <input type="text" name="admin_email" class="form-control"
                        placeholder="Please enter the email address you logged in">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Verify">
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous"></script>
</body>

</html>