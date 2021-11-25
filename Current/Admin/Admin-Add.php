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


$admin_fullname = $admin_username = $admin_gender = $admin_nic = $admin_email = $type =  $admin_contact = $admin_password = $confirm_password = $send_password = "";
$name_err = $username_err = $password_err = $email_err = $confirm_password_err = $nic_err = $contact_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate Admin Name
    if (empty(trim($_POST["admin_fullname"]))) {
        $name_err = "Please enter a name.";
    } else {
        // Prepare a select statement
        $sql = "SELECT admin_id FROM admin WHERE admin_fullname = ?";

        if ($stmt = $link->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_name);

            // Set parameters
            $param_name = trim($_POST["admin_fullname"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                /* store result */
                $stmt->store_result();

                if ($stmt->num_rows() >= 1) {
                    $name_err = "This admin already has an account!";
                } else {
                    $admin_fullname = trim($_POST["admin_fullname"]);
                }
            } else {
                echo "Oops! Something went wrong when inserting name. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate Admin Username
    if (empty(trim($_POST["admin_username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT admin_id FROM admin WHERE admin_username = ?";

        if ($stmt = $link->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = trim($_POST["admin_username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                /* store result */
                $stmt->store_result();

                if ($stmt->num_rows() >= 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $admin_username = trim($_POST["admin_username"]);
                }
            } else {
                echo "Oops! Something went wrong when inserting username. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    //validate email
    if (empty(trim($_POST["admin_email"]))) {
        $email_err = "Please enter an email address!";
    } else {
        $admin_email = trim($_POST["admin_email"]);
        $admin_email = stripslashes($admin_email);
        $admin_email = htmlspecialchars($admin_email);
        if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        } else {
            // Prepare a select statement
            $sql = "SELECT admin_id FROM admin WHERE admin_email = ?";

            if ($stmt = $link->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_email);

                // Set parameters
                $param_email = $admin_email;

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    /* store result */
                    $stmt->store_result();

                    if ($stmt->num_rows() >= 1) {
                        $email_err = "This Email is already taken.";
                    } else {
                        $admin_email = trim($_POST["admin_email"]);
                    }
                } else {
                    echo "Oops! Something went wrong when inserting email. Please try again later.";
                }

                // Close statement
                $stmt->close();
            }
        }
    }

    if (!preg_match("/^[0-9'V'v]*$/", strlen($_POST["admin_nic"]))) {
        $nic_err = "Only Numbers and V or v allowed for old version and Only Numbers are allowed for new version";
    } else if (strlen($_POST["admin_nic"]) != 10 && strlen($_POST["admin_nic"]) != 12) {
        $nic_err = "NIC number is Invalid";
    } else {
        $admin_nic = $_POST['admin_nic'];
    }

    if (empty(trim($_POST["admin_contact"]))) {
        $contact_err = "Please enter a contact number.";
    } elseif (strlen(trim($_POST["admin_contact"])) != 10) {
        $contact_err = "Invalid c=Contact Number.";
    } else {
        $admin_contact = trim($_POST["admin_contact"]);
        $send_contact = $admin_contact;
    }

    // Validate password
    if (empty(trim($_POST["admin_password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["admin_password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $admin_password = trim($_POST["admin_password"]);
        $send_password = $admin_password;
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($admin_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    $admin_gender = $_POST['gender'];
    $type = $_POST['type'];

    // Check input errors before inserting in database
    if (empty($name_err) && empty($username_err) && empty($email_err) && empty($nic_err) && empty($contact_err) && empty($password_err) && empty($confirm_password_err)) {


        // Prepare an insert statement
        $sql = "INSERT INTO admin (admin_fullname, admin_username, gender, admin_nic, admin_email, admin_contact, admin_password,type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $link->prepare($sql)) {


            // Bind variables to the prepared statement as parameters
            if ($stmt->bind_param("ssssssss", $param_name, $param_username, $param_gender, $param_nic, $param_email, $param_contact, $param_password, $param_type))

                // Set parameters
                $param_name = $admin_fullname;
            $param_username = $admin_username;
            $param_gender = $admin_gender;
            $param_nic = $admin_nic;
            $param_email = $admin_email;
            $param_contact = $admin_contact;
            $param_password = password_hash($admin_password, PASSWORD_DEFAULT); // Creates a password hash
            $param_type = $type;


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
                    $mail->addAddress($admin_email);     // Add a recipient

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Online Electricity and Water Bill Management System';

                    $mail->Body    = "<h3>Welcome to the Online Electricity and Water Bill Management System</h3><br><br>Your administrator account has been created succesfully.<br><br> Here's your account information:<br>
                     Name: $admin_fullname <br>
                     Username: $admin_username <br>
                     Gender: $admin_gender<br>
                     NIC: $admin_nic<br>
                     Email: $admin_email<br>
                     Contact No: $admin_contact<br>
                     Password: $send_password <br>
                     <br> Best Regards, <br> OEAWBMS Team";

                    $mail->send();
                    //  echo $user->showwMessage('success','We have send you  reset link,please check your email');

                } catch (Exception $e) {
                    echo 'Something went wrong,try again later';
                }
                header("Location: ../../Current-Admin-Login.php");
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
<div class="row justify-content-center wrapper">
    <div class="col-lg-7 bg-white p-4 pt-12">
        <h4 class="text-center font-weight-bold">Add Admin</h4>
        <hr class="my-3" />
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="px-3 needs-validation" id="admin_add">

            <p style="font-size: 14px;">Please fill this form to create an admin account.</p>

            <div class="form-group">
                <label>Admin Fullname</label>
                <input type="text" class="form-control" name="admin_fullname" placeholder="Enter Admin Name" value="<?php echo $admin_fullname; ?>" required>
                <span class="help-block"><?php echo $name_err; ?></span>
            </div><br>

            <div class="form-group">
                <label>Admin Username</label>
                <input type="text" class="form-control" name="admin_username" placeholder="Enter Admin Username" value="<?php echo $admin_username; ?>" required>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div><br>

            <div class="row">
                <div class="col-md-6">
                    <label>Gender</label>
                    <select id="gender" name="gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>NIC Number</label>
                    <input type="text" class="form-control" name="admin_nic" placeholder="Enter the NIC Number" required>
                    <span class="help-block"><?php echo $nic_err; ?></span>
                </div>
            </div><br>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="admin_email" placeholder="Enter Email" value="<?php echo $admin_email; ?>" required>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div><br>

            <div class="form-group">
                <label>Contact No</label>
                <input type="text" class="form-control" name="admin_contact" placeholder="Enter a Contact Number" value="<?php echo $admin_contact; ?>" required>
                <span class="help-block"><?php echo $contact_err; ?></span>
            </div><br>

            <div class="row">
                <div class=" col-md-6">
                    <label>Password</label>
                    <input type="password" class="form-control" name="admin_password" placeholder="Enter Password" required>
                </div>

                <div class=" col-md-6">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Re-Enter Password" required>
                </div>
            </div><br>

            <div class="form-group">
                <label>Type</label>
                <select id="type" name="type" class="form-control">
                    <option value="Electricity">Electricity</option>
                    <option value="Water">Water</option>
                </select>
            </div><br>

            <div class="form-group">
                <button class="btn btn-danger btn-lg btn-block myBtn" type="submit " name="submit" style="width: 100%;">Add</button>
            </div><br>

            <hr class="my-3" />
        </form>
    </div>
    <!-- Registration Form End -->
</div>

<footer>
    <div class="pull-right">
        Online Electricity and Water Bill Management System
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous">
</script>
</body>

</html>