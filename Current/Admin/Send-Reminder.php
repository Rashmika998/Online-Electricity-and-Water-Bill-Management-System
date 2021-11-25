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

$user_id = $_GET['user_id'];
$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $month = date("F Y");
    $message = $_POST['message'];
    $user_email = $_POST['user_email'];
    $user_name = $_POST['user_name'];
    $sql = "INSERT INTO notifications (user_id, month, message) VALUES ('$user_id', '$month', '$message')";
    
    if (mysqli_query($link, $sql)){
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
            $mail->addAddress($user_email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Online Electricity and Water Bill Management System Reminders';

            $mail->Body    = "<h5>Dear '$user_name',</h5><br>".$message."<br>Best Regards,<br>OEAWBMS Team";

            $mail->send();

        } catch (Exception $e) {
             echo 'Something went wrong,try again later';
        }
        header("Location: View-Registration.php?user_id=$user_id");
        exit();
    }
    else{
        echo ("Something went wrong. Please try again later!".mysqli_error($link));
    }
}


?>