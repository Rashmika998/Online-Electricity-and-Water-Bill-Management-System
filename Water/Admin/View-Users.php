<?php

require_once 'Admin-Header.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
    
require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
    
// Load Composer's autoloader
require '../../vendor/autoload.php';
    
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

function allUsers(){
    $db = new mysqli('localhost', 'root', '', 'ocawbms');
    $all = mysqli_query($db, "SELECT * FROM users");
    $all_users = mysqli_num_rows($all);
    return $all_users;
  }

$user_name = $user_gender = $user_nic = $user_email = $user_contact = $user_password = $confirm_password = $send_password = "";
$username_err = $password_err = $email_err = $confirm_password_err = $nic_err = $contact_err = $stat_err = "";
$name_err = $name = $user_account = $user_address = $user_area = $address_err = $area_err = $acc_err = $user_premises = $premises_err = "";
$stat = $_SESSION['var'] = 1;

    // Processing form data when form is submitted
    if (isset($_POST['submit_add'])) {
    
        // Validate user Username
        if (empty(trim($_POST["user_name"]))) {
            $username_err = "Please enter a username.";
        } else {
            // Prepare a select statement
            $sql = "SELECT user_id FROM users WHERE user_name = ?";
    
            if ($stmt = $link->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_username);
    
                // Set parameters
                $param_username = trim($_POST["user_name"]);
    
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    /* store result */
                    $stmt->store_result();
    
                    if ($stmt->num_rows() >= 1) {
                        $username_err = "This Username is already taken.";
                    } else {
                        $user_name = trim($_POST["user_name"]);
                    }
                } else {
                    echo "Oops! Something went wrong when inserting username. Please try again later.";
                }
    
                // Close statement
                $stmt->close();
            }
        }
    
        //validate email
        if (empty(trim($_POST["user_email"]))) {
            $email_err = "Please enter an email address!";
        } else {
            $user_email = trim($_POST["user_email"]);
            $user_email = stripslashes($user_email);
            $user_email = htmlspecialchars($user_email);
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email format";
            } else {
                // Prepare a select statement
                $sql = "SELECT user_id FROM users WHERE user_email = ?";
    
                if ($stmt = $link->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $param_email);
    
                    // Set parameters
                    $param_email = $user_email;
    
                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        /* store result */
                        $stmt->store_result();
    
                        if ($stmt->num_rows() >= 1) {
                            $email_err = "This Email Address is already taken.";
                        } else {
                            $user_email = trim($_POST["user_email"]);
                        }
                    } else {
                        echo "Oops! Something went wrong when inserting email. Please try again later.";
                    }
    
                    // Close statement
                    $stmt->close();
                }
            }
        }
    
        if (!preg_match("/^[0-9'V'v]*$/",strlen($_POST["user_nic"]))) {
            $nic_err = "Only Numbers and V or v allowed for old version and Only Numbers are allowed for new version";
        }else if (strlen($_POST["user_nic"])!=10 && strlen($_POST["user_nic"])!=12) {
            $nic_err = "NIC number is Invalid";
        }else{
            $user_nic = $_POST['user_nic'];
        }
    
        if (empty(trim($_POST["user_contact"]))) {
            $contact_err = "Please enter a Contact Number.";
        } elseif (strlen(trim($_POST["user_contact"])) != 10){
            $contact_err = "Invalid Contact Number.";
        } else {
            $user_contact = trim($_POST["user_contact"]);
            $send_contact = $user_contact;
        }
    
        // Validate password
        if (empty(trim($_POST["user_password"]))) {
            $password_err = "Please enter a password.";
        } elseif (strlen(trim($_POST["user_password"])) < 6) {
            $password_err = "Password must have atleast 6 characters.";
        } else {
            $user_password = trim($_POST["user_password"]);
            $send_password = $user_password;
        }
    
        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($user_password != $confirm_password)) {
                $confirm_password_err = "Password did not match.";
            }
        }
    
        $user_gender = $_POST['gender'];
    
        // Check input errors before inserting in database
        if (empty($username_err) && empty($email_err) && empty($nic_err) && empty($contact_err) && empty($password_err) && empty($confirm_password_err)) {
    
    
            // Prepare an insert statement
            $sql = "INSERT INTO users (user_name, gender, user_nic, user_email, user_contact, user_password) VALUES (?, ?, ?, ?, ?, ?)";
    
            if ($stmt = $link->prepare($sql)) {
    
    
                // Bind variables to the prepared statement as parameters
                if ($stmt->bind_param("ssssss", $param_username,$param_gender, $param_nic, $param_email, $param_contact, $param_password))
    
                    // Set parameters
                $param_username = $user_name;
                $param_gender = $user_gender;
                $param_nic = $user_nic;
                $param_email = $user_email;
                $param_contact = $user_contact;
                $param_password = password_hash($user_password, PASSWORD_DEFAULT); // Creates a password hash
    
    
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
    
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
    
                        $mail->Body    = "<h3>Welcome to the Online Electricity and Water Bill Management System</h3><br><br>Your user account has been created succesfully.<br><br> Here's your account information:<br>
                         Username: $user_name <br>
                         Gender: $user_gender<br>
                         NIC: $user_nic<br>
                         Email: $user_email<br>
                         Contact No: $user_contact<br>
                         <br> Best Regards, <br> OEAWBMS Team";
    
                        //$mail->send();
                        //  echo $user->showwMessage('success','We have send you  reset link,please check your email');
    
                    } catch (Exception $e) {
                         echo 'Something went wrong,try again later';
    
                    }
                    $user_name = $user_nic = $user_contact = $user_email = "";
                    header("Location:User-Added.php");
                    exit();
                } else {
    
                    echo "Something went wrong when executing. Please try again later.";
                }
    
                // Close statement
                $stmt->close();
            }
        }
    
        // Close connection
        $link->close();
    }


    if (isset($_POST['submit_regi'])) {

        // Validate user Username
        if (empty(trim($_POST["name"]))) {
            $name_err = "Please enter the Name.";
        } else {
                $name = trim($_POST["name"]);
        }
    
        //validate address
        if (empty(trim($_POST["user_address"]))) {
            $address_err = "Please enter the Address!";
        } else {
            $user_address = trim($_POST["user_address"]);           
        }
    
        if (empty(trim($_POST["user_area"]))) {
            $area_err = "Please enter the Area Office as mentioned in the Bill!";
        } else {
            $user_area = trim($_POST["user_area"]);           
        }
    
        
        if (empty(trim($_POST["user_premises"]))) {
            $premises_err = "Please enter the Premises ID.";
        } else {
            $user_premises = trim($_POST["user_premises"]);
        }
    
        if (empty(trim($_POST["user_account"]))) {
            $acc_err = "Please enter the account number.";
        } elseif (strlen(trim($_POST["user_account"])) != 10){
            $acc_err = "Invalid Account Number. SHould consist with only 10 numbers";
        } else {
            $user_account = trim($_POST["user_account"]);
        }

        $email = $_POST['stat'];
        $find_user_id = mysqli_query($link, "SELECT user_id FROM users WHERE user_email = '$email'");
        $found_uid = mysqli_fetch_assoc($find_user_id);
    
        // Check input errors before inserting in database
        if (empty($name_err) && empty($address_err) && empty($area_err) && empty($premises_err) && empty($acc_err)) {
    
            $user_id = $found_uid['user_id'];
    
            // Prepare an insert statement
            $sql = "INSERT INTO water_details (user_id, name, user_address, user_area, user_premises, user_account) VALUES (?, ?, ?, ?, ?, ?)";
    
            if ($stmt = $link->prepare($sql)) {
    
    
                // Bind variables to the prepared statement as parameters
                if ($stmt->bind_param("isssss",$param_userid, $param_name, $param_address, $param_area, $param_premises, $param_acc))
    
                    // Set parameters
                $param_userid = $user_id;
                $param_name = $name;
                $param_address = $user_address;
                $param_area = $user_area;
                $param_premises = $user_premises;
                $param_acc = $user_account; // Creates a password hash
    
                $message = "Uploaded the registration form.";
                $activity = "INSERT INTO activity_log (user_id, message) VALUES ('$user_id', '$message')";
    
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    $name = $stat = $user_account = $user_address = $user_area = $user_premises = "";
                    mysqli_query($link,$activity);
                    header("Location: User-Registered.php");
                    
                    exit();
                } else {
    
                    echo "Something went wrong when executing. Please try again later.";
                }
    
                // Close statement
                $stmt->close();
            }
        }
    
        // Close connection
        $link->close();
    }
  
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />

<div class="row justify-content-center wrapper">
    <div class="col-lg-12 bg-white p-4">
        <div class="row gutters-sm">
            <div class=" col-md-8 mb-2">
                <div class="border shadow-lg card p-2">
                    <h4 class="text-center font-weight-bold">All Users(<?php echo allUsers()?>)</h4>
                    <hr class="my-3" />
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-hover" style="font-size: 14px;" id="myTable">
                            <thead style="font-weight: bold;font-size: 16px;">
                                <tr>
                                    <td style="text-align: center;">UserName</td>
                                    <td style="text-align: center;">Registered/Not Registered</td>
                                    <td style="text-align: center;">Register Status</td>
                                    <td style="text-align: center;">Current Status</td>
                                </tr>
                            </thead>
                            <?php
            $db = mysqli_connect("localhost","root","","ocawbms");
            $records = mysqli_query($db,"SELECT user_id, gender, user_name FROM users");

            while($data=mysqli_fetch_array($records)){
                // $_SESSION['learners_name'] = $data['learners_name'];
                ?>
                            <tr>
                                <td style="text-align: center;">
                                    <?php
                    if($data['gender'] == "Male"){?>
                                    <img src="https://img.icons8.com/color/60/000000/person-male.png" />
                                    <?php
                    }

                    else if($data['gender'] == "Female"){?>
                                    <img src="https://img.icons8.com/color/60/000000/person-female.png" />
                                    <?php
                    }

                    else{?>
                                    <img src="https://img.icons8.com/material-rounded/24/000000/user.png" />
                                    <?php
                    }

                    ?>
                                    &nbsp;<br><?php echo $data['user_name'];?>
                                </td>
                                <td style="text-align: center;">
                                    <?php
                    $uid = $data['user_id'];
                    $records_user = mysqli_query($db,"SELECT * FROM water_details WHERE user_id = '$uid'");
                    if($data_user=mysqli_fetch_array($records_user)){
                        ?>
                                    <div><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i></div>
                                </td>

                                <td style="text-align: center;">
                                    <?php
                        if($data_user['status'] == 'Approved'){
                            ?>
                                    <a class="btn btn-success">Approved</>
                                        <?php
                        }
                        else if($data_user['status'] == 'Rejected'){
                            ?>
                                        <a class="btn btn-danger">Rejected</a>
                                        <?php
                        }
                        else if($data_user['status'] == 'Pending'){
                            ?>
                                        <a class="btn btn-warning" style="color: white;">Pending</a>
                                        <?php
                        }

                        ?>
                                </td>

                                <td style="text-align: center;">
                                    <a href="View-Registration.php?user_id=<?php echo urlencode($data['user_id']);?>"
                                        class="btn btn-primary">View&nbsp;<i class="fa fa-info-circle"
                                            aria-hidden="true"></i></a>
                                </td>
                                <?php
                    }
                    else{
                        ?>
                                <div><i class="fa fa-times fa-2x" aria-hidden="true"></i></div>
                                </td>

                                <td style="text-align: center;">
                                    <div class="btn btn-dark">Not Registered</div>
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn btn-dark">Not Registered</div>
                                </td>
                                <?php
                    }
                    ?>


                            </tr>

                            <?php
            }

        ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class=" col-md-4 mb-2">

                <div class=" col-md-14 mb-2">
                    <div class="border shadow-lg card p-2">
                        <h2 class="align-items-center text-center p-2">User Registration</h2>
                        <?php
                    $pending = $approved = $rejected = $not_regi = 0;
                    $user_stat = mysqli_query($link,"SELECT * FROM users");
                    while($data_user_stat= mysqli_fetch_array($user_stat)){
                        $user_stat_id = $data_user_stat['user_id'];
                        $records_user_chart = mysqli_query($link,"SELECT * FROM water_details WHERE user_id = '$user_stat_id'");
                        if($data_user_chart = mysqli_fetch_array($records_user_chart)){
                            if($data_user_chart['status'] == 'Pending'){
                                $pending ++;
                            }

                            else if($data_user_chart['status'] == 'Approved'){
                                $approved ++;
                            }

                            else if($data_user_chart['status'] == 'Rejected'){
                                $rejected ++;
                            }
                        }
                        else{
                            $not_regi++;
                        }
                    }

                    $tot_users=  array();
                    array_push($tot_users,$pending,$approved,$rejected,$not_regi);
                    $tot_user_methods =  array();
                    array_push($tot_user_methods,"Pending","Approved","Rejected","Not Registered");
                    ?>
                        <canvas id="chartjs_bar"></canvas>
                    </div>
                </div><br>

                <div class="border shadow-lg card p-2">
                    <h3 class="align-items-center text-center p-2">Add User</h3>
                    <div class="panel-heading">
                        <div class="stat-panel text-center">
                            <div class="stat-panel-number h1 ">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#add">
                                    <div class="row">
                                        <div class="col-md-3" style="float:left;
                                                        border-radius: 100%;color:#734F96"><i
                                                class="fa fa-user-plus fa-2x" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-8">
                                            <p style="color: grey;">Click here to create a user account</p>
                                        </div>
                                    </div>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header " style="color: white;background-color: #734F96;">
                                                <h5 class="modal-title" id="addLabel">Create User Account</h5>
                                                <button type="button" class="btn" data-bs-dismiss="modal"
                                                    aria-label="Close" style="color: white;">
                                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="<?php $_SESSION['var'] = 1; echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                                    method="POST" class="px-3 needs-validation" id="user_add">

                                                    <p style="font-size: 14px;">*Please fill this form to create an user
                                                        account.</p>

                                                    <div class="form-group" style="text-align: left;">
                                                        <label
                                                            style="font-weight: normal;font-size: 18px;">Username</label>
                                                        <input type="text" class="form-control" name="user_name"
                                                            placeholder="Enter a Username"
                                                            value="<?php echo $user_name; ?>" required>
                                                        <span class="help-block"><?php echo $username_err; ?></span>
                                                    </div>

                                                    <div class="row gutters-sm">
                                                        <div class="form-group col-md-6" style="text-align: left;">
                                                            <label
                                                                style="font-weight: normal;font-size: 18px;">Gender</label>
                                                            <select id="gender" name="gender" class="form-control">
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-6" style="text-align: left;">
                                                            <label style="font-weight: normal;font-size: 18px;">NIC
                                                                Number</label>
                                                            <input type="text" class="form-control" name="user_nic"
                                                                placeholder="Enter the NIC Number" required>
                                                            <span class="help-block"><?php echo $nic_err; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="row gutters-sm">
                                                        <div class="form-group col-md-6" style="text-align: left;">
                                                            <label
                                                                style="font-weight: normal;font-size: 18px;">Email</label>
                                                            <input type="email" class="form-control" name="user_email"
                                                                placeholder="Enter Email"
                                                                value="<?php echo $user_email; ?>" required>
                                                            <span class="help-block"><?php echo $email_err; ?></span>
                                                        </div>

                                                        <div class="form-group col-md-6" style="text-align: left;">
                                                            <label style="font-weight: normal;font-size: 18px;">Contact
                                                                No</label>
                                                            <input type="text" class="form-control" name="user_contact"
                                                                placeholder="Enter a Contact Number"
                                                                value="<?php echo $user_contact; ?>" required>
                                                            <span class="help-block"><?php echo $contact_err; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="row gutters-sm">
                                                        <div class="form-group col-md-6" style="text-align: left;">
                                                            <label
                                                                style="font-weight: normal;font-size: 18px;">Password</label>
                                                            <input type="password" class="form-control"
                                                                name="user_password" placeholder="Enter Password"
                                                                required>
                                                        </div>

                                                        <div class="form-group col-md-6" style="text-align: left;">
                                                            <label style="font-weight: normal;font-size: 18px;">Confirm
                                                                Password</label>
                                                            <input type="password" class="form-control"
                                                                name="confirm_password" placeholder="Re-Enter Password"
                                                                required>
                                                        </div>
                                                    </div><br>
                                                    <hr class="my-3" />

                                                    <div class="row gutters-sm" style="float: right;">
                                                        <div class="form-group col-md-8">
                                                            <button class="btn btn-block myBtn"
                                                                style="background-color: #734F96;color: white;"
                                                                type="submit " name="submit_add">Create
                                                                Account</button>
                                                        </div>
                                                </form>
                                                <div class="form-group col-md-4">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class=" col-md-14 mb-2">
                <div class="border shadow-lg card p-2">
                    <h3 class="align-items-center text-center p-2">Register User</h3>
                    <div class="panel-heading">
                        <div class="stat-panel ">
                            <div class="stat-panel-number h1 ">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#register">
                                    <div class="row">
                                        <div class="col-md-4" style="padding-right:10px ;color:#CD7F32"><i
                                                class="fa fa-user-plus fa-2x" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-7">
                                            <p style="color: grey; float: left;">Click here to register a user account
                                                for
                                                water
                                                bill management system</p>
                                        </div>
                                    </div>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="register" tabindex="-1" aria-labelledby="registerLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header " style="color: white;background-color: #CD7F32;">
                                                <h5 class="modal-title" id="registerLabel">Create User Account</h5>
                                                <button type="button" class="btn" data-bs-dismiss="modal"
                                                    aria-label="Close" style="color: white;">
                                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="<?php $_SESSION['var'] = 2; echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                                    method="POST" class="px-3 needs-validation" id="user_add">
                                                    <p style="font-size: 14px;">*Please fill this form to register for
                                                        the
                                                        water bill management system. All
                                                        the information is related to manual bill</p>

                                                    <div class="form-group">
                                                        <label>User Email</label>
                                                        <input type="text" class="form-control" name="stat"
                                                            placeholder="Enter the User Email" required>
                                                        <span class="help-block"><?php echo $stat_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Name of the Person</label>
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="Enter the Name" value="<?php echo $name; ?>"
                                                            required>
                                                        <span class="help-block"><?php echo $name_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control" name="user_address"
                                                            placeholder="Enter the Address"
                                                            value="<?php echo $user_address; ?>" required>
                                                        <span class="help-block"><?php echo $address_err; ?></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Area Office</label>
                                                        <input type="text" class="form-control" name="user_area"
                                                            placeholder="Enter the Area Office"
                                                            value="<?php echo $user_area; ?>" required>
                                                        <span class="help-block"><?php echo $area_err; ?></span>
                                                    </div>

                                                    <div class="row gutters-sm">
                                                        <div class="form-group col-md-6">
                                                            <label>Premises ID</label>
                                                            <input type="text" class="form-control" name="user_premises"
                                                                placeholder="Enter the Premises ID"
                                                                value="<?php echo $user_premises; ?>" required>
                                                            <span class="help-block"><?php echo $premises_err; ?></span>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Electricity Account Number</label>
                                                            <input type="text" class="form-control" name="user_account"
                                                                placeholder="Enter the Account Number"
                                                                value="<?php echo $user_account; ?>" required>
                                                            <span class="help-block"><?php echo $acc_err; ?></span>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <hr class="my-3" />

                                                    <div class="row gutters-sm" style="float: right;">
                                                        <div class="form-group col-md-6">
                                                            <button class="btn btn-block myBtn" type="submit "
                                                                style="background-color: #CD7F32;color: white;"
                                                                name="submit_regi">Register</button>
                                                        </div>
                                                </form>
                                                <div class="form-group col-md-6">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class=" col-md-14 mb-2">
                <div class="border shadow-lg card p-2">
                    <h3 class="align-items-center text-center p-2">Red Bill Users</h3>
                    <div class="panel-heading">
                        <div class="stat-panel ">
                            <div class="stat-panel-number h1 ">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#redBill">
                                    <div class="row">
                                        <div class="col-md-4" style="padding-right:10px ;color:red"><i
                                                class="fa fa-user-times fa-2x" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-7">
                                            <p style="color: grey; float: left;">Users who
                                                didn't pay the bill within the deadline.</p>
                                        </div>
                                    </div>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="redBill" tabindex="-1" aria-labelledby="redBillLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger" style="color: white;">
                                                <h5 class="modal-title" id="redBillLabel">Red Bill Users</h5>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                                    aria-label="Close" style="color: white;">
                                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive-sm">
                                                    <table class="table table-striped table-hover"
                                                        style="font-size: 14px;" id="myTable">
                                                        <thead style="font-weight: bold;font-size: 16px;">
                                                            <tr>
                                                                <td style="text-align: center;">UserName</td>
                                                                <td style="text-align: center;">Month</td>
                                                                <td style="text-align: center;">Contact</td>
                                                                <td style="text-align: center;">View</td>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                $red_bill = mysqli_query($link,"SELECT DISTINCT user_id,month FROM water_red_bill");
                                                while($results_red_bill = mysqli_fetch_assoc($red_bill)){
                                                    $red_id = $results_red_bill['user_id'];
                                                    $users = mysqli_query($link,"SELECT * FROM users WHERE user_id = '$red_id'");
                                                    $results_users = mysqli_fetch_assoc($users);
                                                    ?>
                                                        <tr style="text-align: center; font-weight: normal;">
                                                            <td><?php echo $results_users['user_name'] ?></td>
                                                            <td><?php echo $results_red_bill['month'] ?></td>
                                                            <td><?php echo $results_users['user_contact'] ?></td>
                                                            <td><a class="btn btn-danger" role="button" href="View-Registration.php?user_id=<?php echo $red_id ?>">View</a></td>
                                                        </tr>
                                                        <?php
                                                }
                                                ?>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<style>
label {
    font-weight: normal;
    font-size: 18px;
}

.form-group {
    text-align: left;
}

.help-block {
    color: red;
}
</style>

<!-- <style>
.page-link,
.page-link:hover,
.page-group-current-page:active {
    color: red;
    text-decoration: none;
}
</style> -->

<script src="../../vendor.bundle.base.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/sc-2.0.3/sp-1.2.2/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript">
var ctx = document.getElementById("chartjs_bar").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($tot_user_methods); ?>,
        datasets: [{
            backgroundColor: [
                "#ffc750",
                "#2ec551",
                "#ff407b",
                "#3B444B",

            ],
            data: <?php echo json_encode($tot_users); ?>,
        }]
    },
    options: {
        legend: {
            display: true,
            position: 'bottom',

            labels: {
                fontColor: '#71748d',
                fontSize: 14,
            }
        },


    }
});
</script>

<?php
require_once 'Admin-Footer.php';
?>