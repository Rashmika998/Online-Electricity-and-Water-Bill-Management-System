<?php
require_once '../../Config.php';
require_once 'User-Header.php';

$user_id = $_SESSION['uid'];
$uname = $_SESSION['user_uname'];
$sql_record = "SELECT * FROM water_details WHERE user_id='" . $user_id . "'";
$recordsDetails = mysqli_query($link, $sql_record);
if ($dataDetails = mysqli_fetch_assoc($recordsDetails)) {

?>
    <div class="row justify-content-center wrapper">
        <div class="col-lg-7 bg-white p-4 pt-12">
            <?php
            if ($dataDetails['status'] == 'Pending') {
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Dear <?php echo $uname ?>!</strong> You have succesfully uploaded the form. Your form is still
                    <?php echo $dataDetails['status']; ?> and it is displayed in below. If you have any issues contact us.
                </div>
            <?php
            } else if ($dataDetails['status'] == 'Approved') {
            ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Dear <?php echo $uname ?>!</strong> You have succesfully uploaded the form. Now you can upload an
                    image of you water meter
                    to get updated about your bill. Your form is
                    <?php echo $dataDetails['status']; ?> and it is displayed in below. If you have any issues contact us.
                </div>
                <div class="form-group">
                    <div>
                        <h5 class="text-center" style="color: green;">Approved&nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i></h5>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Dear <?php echo $uname ?>!</strong> Your form is
                    <?php echo $dataDetails['status']; ?> and see what went wrong in below 'Reasons to be Rejected' field. If
                    you have any issues contact us.

                </div>
            <?php
            }
            ?>

            <h4 class="text-center font-weight-bold">Registered Water Bill Management Form</h4>
            <hr class="my-3" />
            <form class="px-3 needs-validation">
                <div class="form-group">
                    <label>Name of the Person</label>
                    <input type="text" class="form-control" name="name" disabled value="<?php echo $dataDetails['name']; ?>">
                </div><br>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="user_address" disabled value="<?php echo $dataDetails['user_address']; ?>">
                </div><br>

                <div class="form-group">
                    <label>Category</label>
                    <input type="text" class="form-control" name="category" disabled value="<?php echo $dataDetails['category']; ?>">
                </div><br>

                <div class="row">
                    <div class=" col-md-6">
                        <label>Account Number</label>
                        <input type="text" class="form-control" name="user_account" disabled value="<?php echo $dataDetails['user_account']; ?>">
                    </div>

                    <div class=" col-md-6">
                        <label>Meter Number</label>
                        <input type="text" class="form-control" name="user_meter" disabled value="<?php echo $dataDetails['user_meter']; ?>">
                    </div>
                </div><br>

                <?php
                if ($dataDetails['status'] == 'Rejected') {
                ?>
                    <div class="form-group">
                        <label>Reasons to be Rejected</label>
                        <input type="textarea" class="form-control" name="user_area" disabled value="<?php echo $dataDetails['feedback']; ?>">
                    </div><br>
                    <div class="form-group">
                        <a href="Register-Again.php" class=" btn btn-danger">
                            Register Again</a>
                    </div><br>
                <?php
                }
                ?>

                <hr class="my-3" />
            </form>
        </div>
        <!-- Registration Form End -->
    </div>
<?php

} else {
    $name = $user_address = $user_account = $user_meter = $category = "";
    $name_err = $address_err = $acc_err = $meter_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

        if (empty(trim($_POST["user_meter"]))) {
            $meter_err = "Please enter the meter ID.";
        } else {
            $user_meter = trim($_POST["user_meter"]);
        }

        if (empty(trim($_POST["user_account"]))) {
            $acc_err = "Please enter the account number.";
        } elseif (strlen(trim($_POST["user_account"])) != 16) {
            $acc_err = "Invalid Account Number. Should consist with only 16 characters";
        } else {
            $user_account = trim($_POST["user_account"]);
        }

        $category = $_POST["category"];

        // Check input errors before inserting in database
        if (empty($name_err) && empty($address_err) && empty($area_err) && empty($premises_err) && empty($acc_err)) {


            // Prepare an insert statement
            $sql = "INSERT INTO water_details (user_id, name, user_address, user_account, user_meter,category) VALUES (?, ?, ?, ?, ?, ?)";

            if ($stmt = $link->prepare($sql)) {


                // Bind variables to the prepared statement as parameters
                if ($stmt->bind_param("isssss", $param_userid, $param_name, $param_address, $param_acc, $param_meter, $param_category))

                    // Set parameters
                    $param_userid = $user_id;
                $param_name = $name;
                $param_address = $user_address;
                $param_acc = $user_account; // Creates a password hash
                $param_meter = $user_meter;
                $param_category = $category;

                $message = "Uploaded the registration form for water bill management system.";
                $activity = "INSERT INTO activity_log (user_id, message) VALUES ('$user_id', '$message')";

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    header("Location: User-Registered.php");
                    mysqli_query($link, $activity);
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
            <h4 class="text-center font-weight-bold">Registration for Water Bill Management</h4>
            <hr class="my-3" />
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="px-3 needs-validation" id="user_add">

                <p style="font-size: 14px;">*Please fill this form to register for the water bill management system. All
                    the information is related to manual bill</p>

                <div class="form-group">
                    <label>Name of the Person</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter the Name" value="<?php echo $name; ?>" required>
                    <span class="help-block"><?php echo $name_err; ?></span>
                </div><br>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="user_address" placeholder="Enter the Address" value="<?php echo $user_address; ?>" required>
                    <span class="help-block"><?php echo $address_err; ?></span>
                </div><br>

                <div class="form-group">
                    <label>Category</label>
                    <select id="category" name="category" class="form-control">
                        <option value="Domestic - 10">Domestic - 10</option>
                        <option value="Religious & Charity - 11">Religious & Charity - 11</option>
                        <option value="Industry - 12">Industry - 12</option>
                        <option value="Hotel - 13">Hotel - 13</option>
                        <option value="General Purpose - 14">General Purpose - 14</option>
                    </select>
                </div><br>

                <div class="row">
                    <div class=" col-md-6">
                        <label>Account Number</label>
                        <input type="text" class="form-control" name="user_account" placeholder="Enter the Account Number" value="<?php echo $user_account; ?>" required>
                        <span class="help-block"><?php echo $acc_err; ?></span>
                    </div>
                    <div class=" col-md-6">
                        <label>Meter Number</label>
                        <input type="text" class="form-control" name="user_meter" placeholder="Enter the meter number" value="<?php echo $user_meter; ?>" required>
                        <span class="help-block"><?php echo $meter_err; ?></span>
                    </div>
                </div><br>

                <div class="form-group">
                    <button class="btn btn-primary btn-lg btn-block myBtn" type="submit " name="submit">Submit</button>
                </div><br>

                <hr class="my-3" />
            </form>
        </div>
        <!-- Registration Form End -->
    </div>


    <style>
        .help-block {
            color: red;
        }
    </style>

<?php
}
?>


<?php
require_once 'User-Footer.php'
?>