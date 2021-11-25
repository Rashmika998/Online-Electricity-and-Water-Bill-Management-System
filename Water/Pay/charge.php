<?php
session_start();
$id = $_SESSION["userid"];
require_once '../../vendor/autoload.php';
require_once '../../includes/db.inc.php';
require_once '../../includes/functions.inc.php';

\Stripe\Stripe::setApiKey('sk_test_51I2wZ8EG7KGMl4QwyFek7A5Tdi5HmY1zhvfDZXF3tOg5nmEthyYa0TiQqhU36ElpmdQYHdrvRC4ywfzOJZQEWi1p00U56ikRwn');

// Sanitize POST Array
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$token = $POST['stripeToken'];
$amount = $_SESSION['amount'];
$email=$_SESSION['email'];
$name=$_SESSION['name'];
$tot=0;
$attempt = 0;
$NewResult='N/A';
$Description ='';

date_default_timezone_set('Asia/Colombo');
$dt = date('Y-m-d H:i:s');

if($amount == 1700 || $amount == 2000 || $amount == 2250){

    if($_SESSION['update']==1)
    {
        $sql = "INSERT INTO written_payment (user_id, token, amount) VALUES (?,?,?);";
        $stmt = mysqli_stmt_init($link);

        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("location: ../NewLicense/RegisterForLicense.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"sss",$id ,$token,$amount);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $subject= "E-License Registration Payment Confirmation";
        $body= "Hello " .$name. "! <br>We have received your registration payment. Exam details will be posted onto your DLMS page.<br><br>
        <table class='0 border'>
        <tr>
            <td>Voucher reference no</td>
            <td>:</td>
            <td>".$token."</td>
        </tr> 
        <tr>
            <td>Payment method</td>
            <td>:</td>
            <td>Online</td>
        </tr> 
        <tr>
            <td>Amount:  </td>
            <td>:</td>
            <td>".$amount.".00 LKR</td>
        </tr> 
        <tr>
            <td>Date & Time:  </td>
            <td>:</td>
            <td>".$dt."</td>
        </tr> 
        </table><br><br>Thank you";

        $sql = "INSERT INTO payments (token,user_id,amount,paid_at,Description) VALUES (?,?,?,?,?);";
        $stmt = mysqli_stmt_init($link);

        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("location:  ../NewLicense/RegisterForLicense.php?error=stmtfailed");
            exit();
        }
        $Description ='Registeration fee for new license';
        mysqli_stmt_bind_param($stmt,"sssss",$token,$id ,$amount, $dt,$Description);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        sendEmail($email, $name, $body, $subject);

        header("Location: ../NewLicense/RegisterForLicense.php?error=RegistrationPaid");
        exit();
    }

    else if($_SESSION['update']==2)
    {
        $sql = "UPDATE written_payment SET amount=?, paid_at=?, paid=?, scheduled=?, attempt=? WHERE user_id =?;";
        $stmt = mysqli_stmt_init($link);

        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("location: ../NewLicense/writtenExams.php?error=stmtfailed");
            exit();
        }
        $paid='Yes';
        $scheduled='No';
        $attempt=1;
        $newResult = 'N/A';

        mysqli_stmt_bind_param($stmt,"ssssss",$amount,$dt,$paid,$scheduled,$attempt,$id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

            $sql = "UPDATE written_exam SET attempt=?,result=? WHERE user_id = ?;";
            $stmt = mysqli_stmt_init($link);

            if (!mysqli_stmt_prepare($stmt,$sql)) {
                header("location: ../NewLicense/writtenExams.php?error=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt,"sss",$attempt,$newResult,$id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $subject= "E-License Re-Registration Payment Confirmation";
        $body= "Hello " .$name. "! <br>We have received your registration payment. Exam details will be posted onto your DLMS page.<br><br>
        <table class='0 border'>
        <tr>
            <td>Voucher reference no</td>
            <td>:</td>
            <td>".$token."</td>
        </tr> 
        <tr>
            <td>Payment method</td>
            <td>:</td>
            <td>Online</td>
        </tr> 
        <tr>
            <td>Amount:  </td>
            <td>:</td>
            <td>".$amount.".00 LKR</td>
        </tr> 
        <tr>
            <td>Date & Time:  </td>
            <td>:</td>
            <td>".$dt."</td>
        </tr> 
        </table><br><br>Thank you";

        $sql = "INSERT INTO payments (token,user_id,amount,paid_at,Description) VALUES (?,?,?,?,?);";
        $stmt = mysqli_stmt_init($link);

        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("location:  ../NewLicense/writtenExams.php?error=stmtfailed");
            exit();
        }
        $Description ='Registeration fee for new license';
        mysqli_stmt_bind_param($stmt,"sssss",$token,$id ,$amount, $dt,$Description);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        sendEmail($email, $name, $body, $subject);

        header("Location: ../NewLicense/writtenExams.php?error=RegistrationPaid");
        exit();
    }

    
    
}
else if ($amount == 250){ //re-sit written 

    //check whether user paid or not
    $sql = "SELECT * FROM written_payment WHERE user_id = $id;";
    $result = mysqli_query($link, $sql) or die( mysqli_error($link));
    while ($row = mysqli_fetch_assoc($result)) 
    {
        $tot = $row['amount'] + $_SESSION['amount'];
        $attempt =$row['attempt']+1;
    }
    
    $paid ='Yes';
    $scheduled = 'No';

    $sql = "UPDATE written_payment SET amount= ?, paid_at = ?, paid =?, scheduled=?, attempt=? WHERE user_id =?;";
    $stmt = mysqli_stmt_init($link);
    
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("location: ../writtenExams.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"ssssss", $tot, $dt, $paid, $scheduled, $attempt, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        
    $sql = "UPDATE written_exam SET result= ?, attempt=? WHERE user_id =?;"; ////////////////////////////////////////////
    $stmt = mysqli_stmt_init($link);
    
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("location: ../writtenExams.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"sss", $NewResult,$attempt, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    $sql = "INSERT INTO payments (token,user_id,amount,paid_at,Description) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($link);

    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("location:  ../writtenExams.php?error=stmtfailed");
        exit();
    }
    $Description ='Re-Register for written exam';
    mysqli_stmt_bind_param($stmt,"sssss",$token,$id ,$amount, $dt,$Description);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $subject= "Written Exam Re-Registration Payment Confirmation";
    $body= "Hello " .$name. "! <br>We have received your re-registration payment. Exam details will be posted onto your DLMS page.<br><br>
    <table class='0 border'>
    <tr>
        <td>Voucher reference no</td>
        <td>:</td>
        <td>".$token."</td>
    </tr> 
    <tr>
        <td>Payment method</td>
        <td>:</td>
        <td>Online</td>
    </tr> 
    <tr>
        <td>Amount:  </td>
        <td>:</td>
        <td>".$amount.".00 LKR</td>
    </tr> 
    <tr>
        <td>Date & Time:  </td>
        <td>:</td>
        <td>".$dt."</td>
    </tr> 
    </table><br><br>Thank you";
        
    sendEmail($email, $name, $body, $subject);

    header("Location: ../NewLicense/writtenExams.php?error=none");
    exit();
}
?>
