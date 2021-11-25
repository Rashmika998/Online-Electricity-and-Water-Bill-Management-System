<?php

require '../../Config.php';

$name_err = $username_err = $password_err = $email_err = $confirm_password_err = $nic_err = $contact_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    
    $admin_id = $_SESSION['admin_id'];

    $sql = "SELECT * FROM admin WHERE admin_id='" . $admin_id . "'";
    $records = mysqli_query($link, $sql);
    $data = mysqli_fetch_assoc($records);

    $admin_username = $data['admin_username'];
    $admin_fullname = $data['admin_fullname'];
    $admin_nic = $data['admin_nic'];
    $admin_contact = $data['contact'];
    $admin_email = $data['admin_email'];
    $gender = $data['gender'];

    
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

    if (!preg_match("/^[0-9'V'v]*$/",strlen($_POST["admin_nic"]))) {
        $nic_err = "Only Numbers and V or v allowed for old version and Only Numbers are allowed for new version";
    }else if (strlen($_POST["admin_nic"])!=10 && strlen($_POST["admin_nic"])!=12) {
        $nic_err = "NIC number is Invalid";
    }else{
        $admin_nic = $_POST['admin_nic'];
    }

    if (empty(trim($_POST["admin_contact"]))) {
        $contact_err = "Please enter a contact number.";
    } elseif (strlen(trim($_POST["admin_contact"])) != 10){
        $contact_err = "Invalid c=Contact Number.";
    } else {
        $admin_contact = trim($_POST["admin_contact"]);
        $send_contact = $admin_contact;
    }

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

    if(isset($_POST['gender']))
    $gender = $_POST['gender'];

    $update = "UPDATE admin SET admin_username = '$admin_username', admin_fullname = '$admin_fullname', admin_nic = '$admin_nic', 
    admin_contact = '$admin_contact', admin_email = '$admin_email', gender = '$gender' WHERE admin_id = '$admin_id'";

    if(mysqli_query($link,$update)){
        header("Location:Admin-Dashboard.php");
    }

    else{
        mysqli_error($link);
    }
}

?>