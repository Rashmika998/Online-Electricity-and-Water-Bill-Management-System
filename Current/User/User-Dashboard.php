<?php
// require_once '../../Config.php';
require_once 'User-Header.php';


if (!isset($_SESSION['loggedin_user'])) {
    header('Location: User-Login.php');
    exit;
} else {

    $user_name = $_SESSION['user_uname'];
    $sql = "SELECT * FROM users WHERE user_name='" . $user_name . "'";
    $records = mysqli_query($link, $sql);
    $data = mysqli_fetch_assoc($records);
    $_SESSION['uid'] = $data['user_id'];

    $uid = $data['user_id'];

    $sql_method = "SELECT * FROM current_details WHERE user_id='" . $uid . "'";
    $records_method = mysqli_query($link, $sql_method);
    $data_method = mysqli_fetch_assoc($records_method);

    $sql_month = "SELECT * FROM bill_month";
    $records_month = mysqli_query($link, $sql_month);
    $data_month = mysqli_fetch_assoc($records_month);
    $due_month = $data_month['month'];

    $sql_img = "SELECT * FROM image_upload WHERE user_id='" . $uid . "' AND month = '$due_month'ORDER BY id DESC LIMIT 1";
    $records_img = mysqli_query($link, $sql_img);

    $sql_bill = "SELECT * FROM current_bill WHERE user_id='" . $uid . "' AND month = '$due_month'";
    $records_bill = mysqli_query($link, $sql_bill);
}



$username_err = $password_err = $email_err = $confirm_password_err = $nic_err = $contact_err = $new_password_err  = $confirm_password_err = "";
?>
<div class="row justify-content-center wrapper">
    <div class="col-lg-12 p-4 pt-12" style="background-color: #E5E4E2;">
        <div class="row gutters-sm">
            <div class=" col-md-4 mb-3">
                <div class="card border shadow-lg p-2">
                    <h2 class="align-items-center text-center">Profile</h2>
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <?php
                            if ($data['gender'] == "Male") { ?>
                                <img src="https://img.icons8.com/color/120/000000/person-male.png" />
                            <?php
                            } else if ($data['gender'] == "Female") { ?>
                                <img src="https://img.icons8.com/color/120/000000/person-female.png" />
                            <?php
                            } else { ?>
                                <img src="https://img.icons8.com/material-rounded/120/000000/user.png" />
                            <?php
                            }

                            ?>

                            <div class="mt-3">
                                <h4><?php echo $user_name ?></h4>
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#editModal">
                                    Edit Profile&nbsp;<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </button>


                                <!-- Modal -->
                                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark" style="color: white;">
                                                <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal" style="color: white;" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                            </div>
                                            <div class="modal-body" style="text-align: left;">
                                                <form action="Edit.php" method="POST" class="px-3 needs-validation">

                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" class="form-control" name="user_name" value="<?php echo $data['user_name']; ?>">
                                                        <span class="help-block"><?php echo $username_err; ?></span>
                                                    </div><br>
                                                    <div class="form-group">
                                                        <label>Gender</label>
                                                        <select id="gender" name="gender" class="form-control">
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div><br>

                                                    <div class="form-group">
                                                        <label>NIC Number</label>
                                                        <input type="text" class="form-control" name="user_nic" value="<?php echo $data['user_nic'] ?>">
                                                        <span class="help-block"><?php echo $nic_err; ?></span>

                                                    </div><br>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" name="user_email" placeholder="Enter Email" value="<?php echo $data['user_email']; ?>">
                                                        <span class="help-block"><?php echo $email_err; ?></span>
                                                    </div><br>

                                                    <div class="form-group">
                                                        <label>Contact No</label>
                                                        <input type="text" class="form-control" name="user_contact" placeholder="Enter a Contact Number" value="<?php echo $data['user_contact']; ?>">
                                                        <span class="help-block"><?php echo $contact_err; ?></span>
                                                    </div><br>

                                            </div>
                                            <div class="modal-footer">

                                                <button type="submit" class="btn btn-success">Save changes</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editPasswordModal">
                                    Change Password&nbsp;<i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                </button>


                                <!-- Modal -->
                                <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark" style="color: white;">
                                                <h5 class="modal-title" id="editPasswordModalLabel">Change Password</h5>
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal" style="color: white;" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                            </div>
                                            <div class="modal-body" style="text-align: left;">
                                                <form action="Edit-Password.php" method="POST" class="px-3 needs-validation">

                                                    <div class="form-group">
                                                        <label>New Password</label>
                                                        <input type="password" name="new_password" class="form-control">
                                                        <span class="help-block"><?php echo $new_password_err; ?></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Confirm Password</label>
                                                        <input type="password" name="confirm_password" class="form-control">
                                                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                                    </div>

                                            </div>
                                            <div class="modal-footer">

                                                <button type="submit" class="btn btn-success">Save changes</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><br>
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Gender</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $data['gender'] ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">NIC Number</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $data['user_nic'] ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email Address</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $data['user_email'] ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Contact Number</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $data['user_contact'] ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Joined</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php echo $data['created_at'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row gutters-sm">
                    <div class="col-md-6">
                        <div class="card border shadow-lg mb-2 p-2">
                            <h2 class="align-items-center text-center">Guide</h2>
                            <div class="card-body">
                                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="align-items-center text-center">
                                                <p style="font-size: 18px;">Welcome to Electricity Bill Management System
                                                    with CEB</p style="font-size: 18px;">
                                            </div>
                                            <img src="../../images/ceb.png" class="d-block w-100" alt="...">

                                        </div>
                                        <div class="carousel-item">
                                            <div class="align-items-center text-center">
                                                <h4>First Step</h4>
                                                <p>Register for Electricity Bill Management System by Providing Relevant
                                                    Information.</p>
                                            </div>
                                            <img src="../../images/register.png" class="d-block w-100" alt="...">

                                        </div>
                                        <div class="carousel-item">
                                            <div class="align-items-center text-center">
                                                <h4>Second Step</h4>
                                                <p>Upload a Clear Image of the Meter According to the Month When it is
                                                    required.</p>
                                            </div>
                                            <img src="../../images/cam.png" class="d-block w-100" alt="...">

                                        </div>
                                        <div class="carousel-item">
                                            <div class="align-items-center text-center">
                                                <h4>Third Step</h4>
                                                <p>Pay for the Durable Bill Through System(Optional).</p>
                                            </div>
                                            <img src="../../images/payment.png" class="d-block w-100" alt="...">

                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="card border shadow-lg mb-3 p-2">
                            <div class="card-body align-items-center text-center">
                                <!-- <h2 class="align-items-center text-center">Billing Month</h2> -->
                                <h5 class="align-items-center text-center">Hello <?php echo $user_name ?>!</h5>
                                <h6><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Billing Month:
                                    <strong><?php echo $due_month; ?></strong>
                                </h6>
                                <h6 class="align-items-center text-center">Category:
                                    <?php echo $data_method['category'] ?></h6>
                                <a href="../../Water/User/User-Dashboard.php"><button class="btn btn-primary">Switch to
                                        Water Bill&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></button></a>

                            </div>
                        </div>

                        <div class="col-md-14">
                            <div class="card border shadow-lg mb-3 p-2">
                                <h2 class="align-items-center text-center">Progress</h2>
                                <?php

                                $sql = "SELECT * FROM current_details WHERE user_id='" . $uid . "'";
                                $exist = "SELECT COUNT(user_id) FROM current_details WHERE user_id='" . $uid . "'";
                                if (mysqli_query($link, $sql)) {
                                    $recordsDetails = mysqli_query($link, $sql);
                                    $dataDetails = mysqli_fetch_assoc($recordsDetails);
                                    $status = $dataDetails['status'];
                                    if ($status == 'Pending') {
                                ?>
                                        <div class="card-body align-items-center text-center btn btn-light">
                                            <div class="row">
                                                <h5 class="align-items-center text-center">Your Registration Form is still
                                                    <?php echo $status; ?>...</h5>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped  bg-warning progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                    </div>
                                                </div><br>
                                                <a href="User-Register.php" style="text-decoration: none;">
                                                    <h7 class="align-items-center text-center">Click here to view the filled
                                                        form
                                                    </h7>
                                                </a>
                                            </div>
                                        </div>

                                        <?php
                                    } else if ($status == 'Approved') {
                                        if ($data_img = mysqli_fetch_assoc($records_img)) {
                                            if ($data_img['status'] == 'Prepared') {
                                                if ($data_bill = mysqli_fetch_assoc($records_bill)) {
                                                    if ($data_bill['status'] == 'Paid') {
                                        ?>
                                                        <div class="card-body align-items-center text-center btn bg-white">
                                                            <div class="row">
                                                                <div class="alert alert-success" role="alert">
                                                                    <h5 class="align-items-center text-center">Bill Payment is Done&nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i></h5>
                                                                    You have paid the bill for <?php echo $due_month; ?>.
                                                                    You will recieve an email about your payment information and you can
                                                                    see it from here as well.
                                                                    <a class="alert-link" href="User-Pay.php" style="text-decoration: none;"><br>
                                                                        <h7 class="align-items-center text-center">View Payment&nbsp;<i class="fa fa-credit-card" aria-hidden="true"></i></h7>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="card-body align-items-center text-center btn btn-light">
                                                            <div class="row">
                                                                <h5 class="align-items-center text-center">Your Payable Bill is
                                                                    Prepared&nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i>

                                                                </h5><br>
                                                                <div class="align-items-center text-center">
                                                                    <div class="progress">
                                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>

                                                                </div><br>
                                                                <p>Your payable bill is prepared.
                                                                    Please settle the bill charge before the due date given in the bill.
                                                                    Extra charges may apply if the charge
                                                                    is not settled within the due date. If you have any issues regarding
                                                                    the
                                                                    bill please contact us.
                                                                    <a href="User-Pay.php" style="text-decoration: none;"><Br>
                                                                        <h7 class="align-items-center text-center">View Bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></h7>
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="card-body align-items-center text-center btn btn-light">
                                                        <div class="row">
                                                            <h5 class="align-items-center text-center">Your Payable Bill is
                                                                Prepared&nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i>

                                                            </h5><br>
                                                            <div class="align-items-center text-center">
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>

                                                            </div><br>
                                                            <p>Your payable bill is prepared.
                                                                Please settle the bill charge before the due date given in the bill.
                                                                Extra charges may apply if the charge
                                                                is not settled within the due date. If you have any issues regarding
                                                                the
                                                                bill please contact us.
                                                                <a href="Bill-Info.php" style="text-decoration: none;"><Br>
                                                                    <h7 class="align-items-center text-center">View Bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></h7>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                            } else if ($data_img['status'] == 'Pending') {
                                                ?>
                                                <div class="card-body align-items-center text-center btn btn-light">
                                                    <div class="row">
                                                        <h5 class="align-items-center text-center">Your Payable Bill is
                                                            Pending&nbsp;<i class="fa fa-file-text-o" aria-hidden="true"></i>

                                                        </h5><br>
                                                        <div class="align-items-center text-center">
                                                            <div class="spinner-grow text-warning" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                            <div class="spinner-grow text-warning" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                            <div class="spinner-grow text-warning" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                            <div class="spinner-grow text-warning" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                            <div class="spinner-grow text-warning" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                        </div>
                                                        <p>You have uploaded the image of the meter&nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i>.
                                                            Please wait untill it get confirmed by administrators.
                                                            <a href="Image-Upload.php" style="text-decoration: none;">
                                                                <h7 class="align-items-center text-center">Click here
                                                                </h7>
                                                            </a>to view the uploaded image
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php
                                            } else if ($data_img['status'] == 'Rejected') {
                                            ?>
                                                <div class="card-body align-items-center text-center btn bg-white">
                                                    <div class="row">
                                                        <div class="alert alert-danger" role="alert">
                                                            <h5 class="align-items-center text-center">Your uploaded image was rejected&nbsp;<i class="fa fa-times" aria-hidden="true"></i></h5>
                                                            Reason is <?php echo $data_img['feedback']; ?>
                                                            <a class="alert-link" href="Image-Upload.php" style="text-decoration: none;"><br>
                                                                <h7 class="align-items-center text-center">Click here to upload image again&nbsp;</h7>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="card-body align-items-center text-center btn btn-light">
                                                <div class="row">
                                                    <h5 class="align-items-center text-center">Your
                                                        Registration
                                                        Form is
                                                        Approved&nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i></h5>
                                                    <br>
                                                    <div class="align-items-center text-center">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>

                                                    </div><br>
                                                    <a href="Image-Upload.php" style="text-decoration: none;">
                                                        <h7 class="align-items-center text-center">Click
                                                            here to
                                                            upload
                                                            the
                                                            image of the meter</h7>
                                                    </a>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                    } else if ($status == 'Rejected') {
                                        ?>
                                        <div class="card-body align-items-center text-center btn btn-light">
                                            <div class="row">
                                                <h5 class="align-items-center text-center">Your
                                                    Registration
                                                    Form is
                                                    Rejected&nbsp;<i class="fa fa-times" aria-hidden="true"></i></h5><br>
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div><br>
                                                <a href="User-Register.php" style="text-decoration: none;">
                                                    <h7 class="align-items-center text-center">
                                                        Click
                                                        here to
                                                        see what went wrong</h7>
                                                </a>
                                            </div>
                                        </div>

                                    <?php
                                    } else {
                                    ?>
                                        <div class="card-body align-items-center text-center btn bg-white">
                                            <div class="row">
                                                <div class="alert alert-danger" role="alert">
                                                    <h5 class="align-items-center text-center">You have not registered still! &nbsp;<i class="fa fa-exclamation" aria-hidden="true"></i></h5>
                                                    <a class="alert-link" href="User-Register.php" style="text-decoration: none;"><br>
                                                        <h7 class="align-items-center text-center">Click here to register for the electricity bill&nbsp;<i class="fa fa-credit-card" aria-hidden="true"></i></h7>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }

                                ?>
                            </div>
                        </div>
                        <div class="col-md-14">
                            <div class="card border shadow-lg mb-2 p-2">
                                <div class="card-body align-items-center text-center">
                                    <?php

                                    if ($data_method['category'] == 'Domestic') {
                                    ?>
                                        <button type="button" class="btn btn-lg btn-dark" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#domesticeModal">
                                            How your Bill is Calculated?
                                        </button>Click the above button to see how
                                        your
                                        monthly bill is calculated accroding to the
                                        units you used.

                                        <!-- Modal -->
                                        <div class="modal fade" id="domesticeModal" tabindex="-1" aria-labelledby="domesticeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark" style="color: white;">
                                                        <h5 class="modal-title" id="domesticeModalLabel">
                                                            Category -
                                                            Domestic&nbsp;<i class="fa fa-home" aria-hidden="true"></i>
                                                        </h5>
                                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive-sm">
                                                            <table class="table table-striped table-hover" style="text-align: center;">
                                                                <thead style="font-weight: bold;">
                                                                    <tr>
                                                                        <th> Consumption
                                                                        </th>
                                                                        <th>Charge<br>(Rs/kWh)
                                                                        </th>
                                                                        <th>Fixed
                                                                            Charge<br>(Rs/month)
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tr>
                                                                    <td>0-30</td>
                                                                    <td>3.00</td>
                                                                    <td>30.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>31-60</td>
                                                                    <td>4.70</td>
                                                                    <td>60.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>61-90</td>
                                                                    <td>7.50</td>
                                                                    <td>90.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>91-120</td>
                                                                    <td>21.00</td>
                                                                    <td>315.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>121-180</td>
                                                                    <td>24.00</td>
                                                                    <td>315.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>180 ></td>
                                                                    <td>36.00</td>
                                                                    <td>315.00</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else if ($data_method['category'] == 'Industrial 1') {
                                    ?>
                                        <button type="button" class="btn btn-dark" style="color: white;" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#industryModal">
                                            How your Bill is Calculated?
                                        </button><br>Click the above button to see how
                                        your
                                        monthly bill is calculated accroding to the
                                        units you used.

                                        <!-- Modal -->
                                        <div class="modal fade" id="industryModal" tabindex="-1" aria-labelledby="industryModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark" style="color: white;">
                                                        <h5 class="modal-title" id="industryModalLabel">
                                                            Category -
                                                            Industry&nbsp;<i class="fa fa-industry" aria-hidden="true"></i>
                                                        </h5>
                                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive-sm">
                                                            <table class="table table-striped table-hover" style="text-align: center;">
                                                                <thead style="font-weight: bold;">
                                                                    <tr>
                                                                        <th>Consume
                                                                        </th>
                                                                        <th>Charge<br>(Rs/kWh)
                                                                        </th>
                                                                        <th>Fixed<br>Charge<br>(Rs/month)
                                                                        </th>
                                                                        <th>Max<br>Demand<br>Charge<br>(Rs/kVA)
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tr>
                                                                    <td>1-1</td>
                                                                    <td>10.50</td>
                                                                    <td>240.00</td>
                                                                    <td>-</td>
                                                                </tr>
                                                                <td colspan="4" style="padding-right: 350px;">
                                                                    1-2</td>

                                                                <tr>
                                                                    <td>Day</td>
                                                                    <td>10.45</td>
                                                                    <td rowspan="3" style="padding-top: 50px;">
                                                                        3000.00</td>
                                                                    <td rowspan="3" style="padding-top: 50px;">
                                                                        850.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Peak</td>
                                                                    <td>13.60</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Off Peak
                                                                    </td>
                                                                    <td>7.35</td>
                                                                </tr>
                                                                <td colspan="4" style="padding-right: 350px;">
                                                                    1-3</td>
                                                                <tr>
                                                                    <td>Day</td>
                                                                    <td>10.25</td>
                                                                    <td rowspan="3" style="padding-top: 50px;">
                                                                        3000.00</td>
                                                                    <td rowspan="3" style="padding-top: 50px;">
                                                                        750.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Peak</td>
                                                                    <td>13.40</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Off Peak
                                                                    </td>
                                                                    <td>7.15</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else if ($data_method['category'] == 'General Purpose 1') {
                                    ?>
                                        <button type="button" class="btn btn-dark" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#generalModal">
                                            How your Bill is Calculated?
                                        </button>Click the above button to see how
                                        your
                                        monthly bill is calculated accroding to the
                                        units you used.

                                        <!-- Modal -->
                                        <div class="modal fade" id="generalModal" tabindex="-1" aria-labelledby="generalModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark" style="color: white;">
                                                        <h5 class="modal-title" id="generalModalLabel">
                                                            Category - General
                                                            Purpose&nbsp;<i class="fa fa-building" aria-hidden="true"></i>
                                                        </h5>
                                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive-sm">
                                                            <table class="table table-striped table-hover" style="text-align: center;">
                                                                <thead style="font-weight: bold;">
                                                                    <tr>
                                                                        <th>Consum
                                                                        </th>
                                                                        <th>Charge<br>(Rs/kWh)
                                                                        </th>
                                                                        <th>Fixed<br>Charge<br>(Rs/month)
                                                                        </th>
                                                                        <th>Max<br>Demand<br>Charge<br>(Rs/kVA)
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tr>
                                                                    <td>GP-1</td>
                                                                    <td>19.50</td>
                                                                    <td>240.00</td>
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>GP-2</td>
                                                                    <td>19.40</td>
                                                                    <td>3000.00</td>
                                                                    <td>850.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>GP-3</td>
                                                                    <td>19.10</td>
                                                                    <td>3000.00</td>
                                                                    <td>750.00</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else if ($data_method['category'] == 'Hotel 1') {
                                    ?>
                                        <button type="button" class="btn btn-dark" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#hotelModal">
                                            How your Bill is Calculated?
                                        </button>Click the above button to see how
                                        your
                                        monthly bill is calculated accroding to the
                                        units you used.

                                        <!-- Modal -->
                                        <div class="modal fade" id="hotelModal" tabindex="-1" aria-labelledby="hotelModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark" style="color: white;">
                                                        <h5 class="modal-title" id="hotelModalLabel">
                                                            Category - Hotel</h5>
                                                        &nbsp;<i class="fa fa-cutlery" aria-hidden="true"></i>
                                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive-sm">
                                                            <table class="table table-striped table-hover" style="text-align: center;">
                                                                <thead style="font-weight: bold;">
                                                                    <tr>
                                                                        <th>Consumption
                                                                        </th>
                                                                        <th>Charge<br>(Rs/kWh)
                                                                        </th>
                                                                        <th>Fixed
                                                                            Charge<br>(Rs/month)
                                                                        </th>
                                                                        <th>Max
                                                                            Demand
                                                                            Charge<br>(Rs/kVA)
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tr>
                                                                    <td>H-1</td>
                                                                    <td>19.50</td>
                                                                    <td>240.00</td>
                                                                    <td>-</td>
                                                                </tr>
                                                                <td colspan="4" style="padding-right: 350px;">
                                                                    H-2</td>

                                                                <tr>
                                                                    <td>Day</td>
                                                                    <td>13.00</td>
                                                                    <td rowspan="3" style="padding-top: 50px;">
                                                                        3000.00</td>
                                                                    <td rowspan="3" style="padding-top: 50px;">
                                                                        850.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Peak</td>
                                                                    <td>16.90</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Off Peak
                                                                    </td>
                                                                    <td>9.15</td>
                                                                </tr>
                                                                <td colspan="4" style="padding-right: 350px;">
                                                                    H-3</td>
                                                                <tr>
                                                                    <td>Day</td>
                                                                    <td>12.60</td>
                                                                    <td rowspan="3" style="padding-top: 50px;">
                                                                        3000.00</td>
                                                                    <td rowspan="3" style="padding-top: 50px;">
                                                                        750.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Peak</td>
                                                                    <td>16.40</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Off Peak
                                                                    </td>
                                                                    <td>8.85</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else if ($data_method['category'] == 'Religious & Charity') {
                                    ?>
                                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" style="width: 100%;" data-bs-target="#domesticeModal">
                                            How your Bill is Calculated?
                                        </button>Click the above button to see how
                                        your
                                        monthly bill is calculated accroding to the
                                        units you used.

                                        <!-- Modal -->
                                        <div class="modal fade" id="domesticeModal" tabindex="-1" aria-labelledby="domesticeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark" style="color: white;">
                                                        <h5 class="modal-title" id="domesticeModalLabel">
                                                            Category - Religious &
                                                            Charity</h5>&nbsp;<i class="fa fa-university" aria-hidden="true"></i>
                                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="accordion-body">
                                                            <table class="table table-striped table-hover" style="text-align: center;">
                                                                <thead style="font-weight: bold;">
                                                                    <tr>
                                                                        <th>Consumption
                                                                        </th>
                                                                        <th>Charge<br>(Rs/kWh)
                                                                        </th>
                                                                        <th>Fixed
                                                                            Charge<br>(Rs/month)
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tr>
                                                                    <td>0-30</td>
                                                                    <td>1.90</td>
                                                                    <td>30.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>31-90</td>
                                                                    <td>2.80</td>
                                                                    <td>60.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>91-120</td>
                                                                    <td>6.75</td>
                                                                    <td>180.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>121-180</td>
                                                                    <td>7.50</td>
                                                                    <td>180.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>180 ></td>
                                                                    <td>9.40</td>
                                                                    <td>240.00</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row gutters-sm">
            <div class=" col-md-6 mb-3">
                <div class="card border shadow-lg p-2">
                    <h2 class="align-items-center text-center">Electricity Usage</h2>
                    <?php
                    $sql_units = "SELECT * FROM current_bill WHERE user_id='" . $uid . "' LIMIT 6";
                    $records_units = mysqli_query($link, $sql_units);
                    $tot_months =  array();

                    while ($data_units = mysqli_fetch_array($records_units)) {
                        array_push($tot_months, $data_units['month']);
                        $units[] = $data_units['units'];
                    }
                    ?>

                    <div class="card-body align-items-center text-center">
                        <canvas id="chartjs_bar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript">
    var ctx = document.getElementById("chartjs_bar").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($tot_months); ?>,
            datasets: [{
                backgroundColor: [
                    "#5969ff",
                    "#ff407b",
                    "#25d5f2",
                    "#ffc750",
                    "#2ec551",
                    "#7040fa",
                    "#ff004e"
                ],
                data: <?php echo json_encode($units); ?>,
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
require_once 'User-Footer.php'
?>