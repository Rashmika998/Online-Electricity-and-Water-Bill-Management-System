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
$user_email = $_POST['user_email'];
$meter = $units = $charge = $total = $month = "";
$meter_err = $units_err = $charge_err = $total_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!preg_match("/^[0-9]*$/",$meter)){
        $meter_err = "Only numbers are allowed!";
    }
    else{
        $meter = $_POST["meter"];
    }

    if (!preg_match("/^[0-9]*$/",$units)){
        $units_err = "Only numbers are allowed!";
    }
    else{
        $units = $_POST["units"];
    }

    if (!preg_match("/^[0-9]*$/",$charge)){
        $charge_err = "Only numbers are allowed!";
    }
    else{
        $charge = $_POST["charge"];
    }

    if (!preg_match("/^[0-9]*$/",$total)){
        $total_err = "Only numbers are allowed!";
    }
    else{
        $total = $_POST["total"];
    }

    $month = $_POST['month'];
    $due = $_POST['due'];

    $sql = "INSERT INTO current_bill (user_id, month, meter, units, charge, total, due) VALUES ('$user_id', '$month', '$meter', '$units', '$charge', '$total', '$due')";
    $update = "UPDATE image_upload SET status = 'Prepared' WHERE user_id = '$user_id'";
    if(mysqli_query($link, $sql) && mysqli_query($link,$update)){
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
            $mail->Subject = 'Online Electricity and Water Bill Management System';

            $mail->Body    = "Your Payable Bill was prepared. Please login to your account and pay it before dealine:<br>
             <br>Best Regards, <br>OEAWBMS Team";

            // $mail->send();
            //  echo $user->showwMessage('success','We have send you  reset link,please check your email');

        } catch (Exception $e) {
             echo 'Something went wrong,try again later';

        }

        header("Location:Admin-Dashboard.php");
    }

    else{
        echo ("Something ent wrong. Please try again later!".mysqli_error($link));
    }

    mysqli_close($link);
}
?>