<?php
require_once 'Admin-Header.php';
$uid = $_GET['user_id'];
$sql_record = "SELECT * FROM water_details WHERE user_id='" . $uid . "'";

$sql_month = "SELECT * FROM water_bill_month";
$records_month = mysqli_query($link, $sql_month);
$data_month = mysqli_fetch_assoc($records_month);
$bill_month = $data_month['month'];

$recordsDetails = mysqli_query($link, $sql_record);
$dataDetails = mysqli_fetch_assoc($recordsDetails);

$sql = "SELECT * FROM users WHERE user_id='" . $uid . "'";
$records = mysqli_query($link, $sql);
$data = mysqli_fetch_assoc($records);

$sql_img = "SELECT * FROM water_image_upload WHERE user_id='" . $uid . "' AND month = '$bill_month'";
$records_img = mysqli_query($link, $sql_img);
$data_img = mysqli_fetch_assoc($records_img);

$all_imgs = "SELECT * FROM water_image_upload WHERE user_id='" . $uid . "'";
$records_all_imgs = mysqli_query($link, $all_imgs);
$data_all_imgs = mysqli_fetch_assoc($records_all_imgs);

$sql_month_bill = "SELECT * FROM water_bill WHERE user_id='" . $uid . "' AND month = '$bill_month'";
$records_month_bill = mysqli_query($link, $sql_month_bill);
$data_month_bill = mysqli_fetch_assoc($records_month_bill);

$sql_bill = "SELECT * FROM water_bill WHERE user_id='" . $uid . "'";
$records_bill = mysqli_query($link, $sql_bill);
$data_bill = mysqli_fetch_assoc($records_bill);

$meter_err = $units_err = $charge_err = $total_err = "";


?>
<link rel="stylesheet" type=text/css href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />

<div class="row justify-content-center wrapper">
    <div class="col-lg-12 p-4 pt-12" style="background-color: #E5E4E2;">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
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
                                <h4><?php echo $data['user_name'] ?></h4>
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
            <?php
            if ($dataDetails['status'] == 'Pending') {
            ?>
                <div class="col-md-7">
                    <div class="card border shadow-lg mb-4 p-2">
                        <h2 class="text-center">Registered Water Bill Management Form</h2>
                        <hr>
                        <div class="px-3 needs-validation">
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

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="user_account" disabled value="<?php echo $dataDetails['user_account']; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Meter Number</label>
                                    <input type="text" class="form-control" name="user_meter" disabled value="<?php echo $dataDetails['user_meter']; ?>">
                                </div>
                            </div><br>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <button class="btn btn-success btn-lg btn-block myBtn" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success" style="color: white;">
                                                    <h5 class="modal-title" id="approveModalLabel">Approve</h5>
                                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close" style="color: white;">
                                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="Form-Approved.php?user_id=<?php echo $data['user_id'] ?>" method="POST" class="px-3 needs-validation" id="admin_add">
                                                        <div class="form-group">
                                                            <label>Select the Category</label>
                                                            <select id="category" name="category" class="form-control">
                                                                <option value="Domestic">Domestic</option>
                                                                <option value="Industrial 1">Industrial 1</option>
                                                                <option value="Hotel 1">Hotel 1</option>
                                                                <option value="Religious & Charity">Religious & Charity
                                                                </option>
                                                                <option value="General Purpose 1">General Purpose 1</option>
                                                            </select>
                                                        </div><br>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Approve</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <button class="btn btn-danger btn-lg btn-block myBtn" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectModalLabel">Reject</h5>
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to Reject this form? If so please provide Reasons
                                                    for Rejection.
                                                    <form class="px-3 needs-validation" method="POST" action="Form-Rejected.php?user_id=<?php echo $data['user_id'] ?>">
                                                        <div class="form-group"><br>
                                                            <label>Reasons for Rejection</label>
                                                            <input type="text" class="form-control" name="feedback" required placeholder="Please provide Reasons">
                                                        </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button name="submit" type="submit" class="btn btn-danger">Yes</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
            } else if ($dataDetails['status'] == 'Approved') {
                if ($data_img['status'] == 'Pending') {
                ?>
                    <div class="col-md-4">
                        <div class="card border shadow-lg mb-4 p-2">
                            <h2 class="text-center">Registered Form</h2>
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center;">
                                <strong>Form Approved&nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i></strong>
                            </div>
                            <div class="px-3 needs-validation">
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

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Account Number</label>
                                        <input type="text" class="form-control" name="user_account" disabled value="<?php echo $dataDetails['user_account']; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Meter Number</label>
                                        <input type="text" class="form-control" name="user_meter" disabled value="<?php echo $dataDetails['user_meter']; ?>">
                                    </div>
                                </div><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card  border shadow-lg mb-3">
                            <h2 class="text-center">Meter Image</h2>
                            <div class="card-body">
                                <div class="col-md-14">
                                    <div class="alert alert-dark alert-dismissible fade show" role="alert" style="text-align: center;">
                                        Uploaded Image&nbsp;<i class="fa fa-file-image-o" aria-hidden="true"></i> for
                                        <strong><?php echo $bill_month ?></strong>
                                    </div>

                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Image File Name</th>
                                                <th scope="col" style="text-align: center;">Download</th>
                                            </tr>
                                        </thead>
                                        <?php

                                        $sql_one = "SELECT * FROM water_image_upload WHERE user_id = '$uid' AND month = '$bill_month'";
                                        $result_one = mysqli_query($link, $sql_one);

                                        $arrear_rem = "SELECT * FROM water_pay WHERE id = (SELECT MAX(id) FROM water_pay) AND user_id = '$uid'";
                                        $result_arrear = mysqli_query($link, $arrear_rem);
                                        $row_arrear = mysqli_fetch_array($result_arrear);

                                        if ($row = mysqli_fetch_array($result_one)) {
                                        ?>
                                            <td><i class="fa fa-file-image-o" aria-hidden="true"></i>&nbsp;<?php echo $row['filename']; ?></td>
                                            <td style="text-align: center;"><a href="Download-Month.php?user_id=<?php echo urlencode($row['user_id']); ?>&month=<?php echo urlencode($bill_month) ?>"><?php $row['filename']; ?><i class="fa fa-download"></i></a></td>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                    <br>
                                    <p>Image was uploaded on <strong><?php echo $row['uploaded_at']; ?></strong></p>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <button class="btn btn-success btn-lg btn-block myBtn" data-bs-toggle="modal" data-bs-target="#updateBill">Update Bill</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="updateBill" tabindex="-1" aria-labelledby="updateBillLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary" style="color: white;">
                                                            <h5 class="modal-title" id="updateBillLabel">Update Bill</h5>
                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa fa-times" aria-hidden="true"></i></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="px-3 needs-validation" method="POST" action="Bill-Update.php?user_id=<?php echo $data['user_id'] ?>">
                                                                <input type="text" name="user_email" class="form-control" value="<?php echo $data['user_email'] ?>" hidden>
                                                                <div class="form-row">
                                                                    <diV class="form-group col-md-2"><img src="../../images/water_bill.png"></diV>
                                                                    <div class="form-group col-md-10 p-2">
                                                                        <h5 style="text-align: center;">National Water Supply and Drainage Board
                                                                            <br>Statement of Water Account<h5>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control" value="<?php echo $dataDetails['name'] ?>" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Address</label>
                                                                    <input type="text" class="form-control" value="<?php echo $dataDetails['user_address'] ?>" disabled>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Account Number</label>
                                                                        <input type="text" class="form-control" value="<?php echo $dataDetails['user_account'] ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Meter Number</label>
                                                                        <input type="text" class="form-control" value="<?php echo $dataDetails['user_meter'] ?>" disabled>
                                                                    </div>
                                                                </div><br>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label>Category</label>
                                                                        <input type="text" class="form-control" value="<?php echo $dataDetails['category'] ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Month</label>
                                                                        <input type="month" class="form-control" name="month" required>
                                                                        <span class="help-block"><?php echo $meter_err; ?></span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Meter Reading</label>
                                                                        <input type="text" class="form-control" name="meter" required placeholder="Ex:23654">
                                                                        <span class="help-block"><?php echo $meter_err; ?></span>
                                                                    </div>
                                                                </div><br>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label>Arrear from previous month
                                                                            <?php echo date('F') ?></label>
                                                                        <input type="text" class="form-control" value="<?php echo $row_arrear['arrear'] ?>" disabled>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Units Consumed for Month
                                                                            <?php echo date('F') ?></label>
                                                                        <input type="text" class="form-control" name="units" required placeholder="Ex:100">
                                                                        <span class="help-block"><?php echo $units_err; ?></span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Charge for Electricity Consumed (Rs.)</label>
                                                                        <input type="text" class="form-control" name="charge" required placeholder="Ex:1000.00">
                                                                        <span class="help-block"><?php echo $charge_err; ?></span>
                                                                    </div>
                                                                </div><br>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Total Amount Due (Rs.)</label>
                                                                        <input type="text" class="form-control" name="total" placeholder="Ex:1500.00" required>
                                                                        <span class="help-block"><?php echo $total_err; ?></span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Due Date</label>
                                                                        <input type="date" class="form-control" name="due" required placeholder="Click the Calender Icon">
                                                                    </div>
                                                                </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button name="submit" type="submit" class="btn btn-primary">Update</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button class="btn btn-danger btn-lg btn-block myBtn" data-bs-toggle="modal" data-bs-target="#rejectImageModal">Reject</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="rejectImageModal" tabindex="-1" aria-labelledby="rejectImageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="rejectImageModalLabel">Reject</h5>
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa fa-times" aria-hidden="true"></i></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to Reject this form? If so please provide
                                                            Reasons
                                                            for Rejection.
                                                            <form class="px-3 needs-validation" method="POST" action="Form-Rejected.php?user_id=<?php echo $data['user_id'] ?>">
                                                                <div class="form-group"><br>
                                                                    <label>Reasons for Rejection</label>
                                                                    <input type="text" class="form-control" name="feedback" required placeholder="Please provide Reasons">
                                                                </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button name="submit" type="submit" class="btn btn-danger">Yes</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
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
                    <div class="col-md-14">
                        <div class="card mb-3">
                            <h2 class="text-center">Previous Bills & Payments</h2>
                            <div class="card-body">
                                <div class="table-responsive-sm">
                                    <table class="table table-striped table-hover" style="font-size: 14px;" id="payTable">
                                        <thead style="font-weight: bold;font-size: 16px;">
                                            <tr style="text-align: center;">
                                                <td style="text-align: center;">Month</td>
                                                <td style="text-align: center;">Name</td>
                                                <td style="text-align: center;">Bill</td>
                                                <td style="text-align: center;">Amount</td>
                                                <td style="text-align: center;">Paid</td>
                                            </tr>
                                        </thead>
                                        <?php
                                       
                                        $records_one_pay = mysqli_query($link, "SELECT * FROM water_pay WHERE user_id = '$uid'");
                                        $i=1;
                                        while ($data_one_pay = mysqli_fetch_assoc($records_one_pay)) {
                                            $arrear_rem_one = "SELECT * FROM water_pay WHERE id = (SELECT MAX(id)-'$i' FROM water_pay) AND user_id = '$uid'";
                                            $result_arrear_one = mysqli_query($link, $arrear_rem_one);
                                            $row_arrear_one = mysqli_fetch_array($result_arrear_one);

                                            $bill_one_month = $data_one_pay['month'];
                                            $results_month_bill = mysqli_query($link, "SELECT * FROM water_bill WHERE month = '$bill_one_month'");
                                            $data_bill_month = mysqli_fetch_assoc($results_month_bill);
                                            $id = strval($data_one_pay['id']);
                                        ?>
                                            <tr style="text-align: center;">
                                                <td><?php echo $data_one_pay['month']; ?></td>
                                                <td><?php echo $data_one_pay['pay_name']; ?></td>
                                                <td style="text-align: center;">
                                                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#payment<?php echo $id; ?>">View&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></button>

                                                </td>
                                                <div class="modal fade" id="payment<?php echo $id; ?>" tabindex="-1" aria-labelledby="payment<?php echo $id; ?>Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h4 class="modal-title" id="payment<?php echo $id; ?>Label" style="color: white;">
                                                                    Payment</h4>
                                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="px-3 needs-validation">
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-2"><img src="../../images/water_bill.png"></div>
                                                                        <div class="form-group col-md-12 p-2">
                                                                            <h5 style="text-align: center;">National Water Supply and Drainage Board
                                                                                <br>Statement of Water Account<h5>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Name</label>
                                                                        <input type="text" class="form-control" value="<?php echo $dataDetails['name'] ?>" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Address</label>
                                                                        <input type="text" class="form-control" value="<?php echo $dataDetails['user_address'] ?>" disabled>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-4">
                                                                            <label>Account Number</label>
                                                                            <input type="text" class="form-control" value="<?php echo $dataDetails['user_account'] ?>" disabled>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label>Meter Number</label>
                                                                            <input type="text" class="form-control" value="<?php echo $dataDetails['user_meter'] ?>" disabled>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label>Category</label>
                                                                            <input type="text" class="form-control" value="<?php echo $dataDetails['category'] ?>" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label>Meter Reading</label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['meter'] ?>" disabled>
                                                                        </div>

                                                                        <div class="form-group col-md-6">
                                                                            <label>Units Consumed for Month
                                                                                <?php echo date('F') ?></label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['units'] ?>" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="col-md-4">
                                                                            <label>Arrear from previous month</label>
                                                                            <input type="text" class="form-control" value="<?php echo $row_arrear_one['arrear'] ?>" disabled>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label>Charge For the Month(Rs.)</label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['charge'] ?>" disabled>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label>Total Amount Due (Rs.)</label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['total'] ?>" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label>Updated</label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['updated_at'] ?>" disabled>

                                                                        </div>

                                                                        <div class="form-group col-md-6">
                                                                            <label>Due Date</label>
                                                                            <input type="date" class="form-control" value="<?php echo $data_bill_month['due'] ?>" disabled>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <td>
                                                    <div class="btn btn-success"><?php echo $data_one_pay['pay_amount']; ?></div>
                                                </td>
                                                <td><?php echo $data_one_pay['paid_at']; ?></td>
                                            </tr>

                                        <?php
                                        $i=$i+1;
                                        }

                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                <?php

                } else if ($data_img['status'] == 'Prepared') {
                ?>
                    <div class="col-md-4">
                        <div class="card border shadow-lg mb-4 p-2">
                            <h2 class="text-center">Registered Form</h2>
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center;">
                                <strong>Form Approved&nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i></strong>
                            </div>
                            <div class="px-3 needs-validation">
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

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Account Number</label>
                                        <input type="text" class="form-control" name="user_account" disabled value="<?php echo $dataDetails['user_account']; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Meter Number</label>
                                        <input type="text" class="form-control" name="user_meter" disabled value="<?php echo $dataDetails['user_meter']; ?>">
                                    </div>
                                </div><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border shadow-lg mb-3">
                            <h2 class="text-center">Meter Image</h2>
                            <div class="card-body">
                                <div class="col-md-14">
                                    <!-- <div class="alert alert-dark alert-dismissible fade show" role="alert"
                                style="text-align: center;">
                                Uploaded Image&nbsp;<i class="fa fa-file-image-o" aria-hidden="true"></i> for
                                <strong><?php echo date('F Y') ?></strong>
                            </div> -->

                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Image File Name</th>
                                                <th scope="col" style="text-align: center;">Download</th>
                                            </tr>
                                        </thead>
                                        <?php

                                        $sql_img_one = "SELECT * FROM water_image_upload WHERE user_id = '$uid' AND month = '$bill_month'";
                                        $result_img_one = mysqli_query($link, $sql_img_one);
                                        if ($row_img = mysqli_fetch_array($result_img_one)) {
                                        ?>
                                            <td><i class="fa fa-file-image-o" aria-hidden="true"></i>&nbsp;<?php echo $row_img['filename']; ?></td>
                                            <td style="text-align: center;"><a href="Download-Month.php?user_id=<?php echo urlencode($row_img['user_id']); ?>&month=<?php echo urlencode($bill_month) ?>"><?php $row_img['filename']; ?><i class="fa fa-download"></i></a></td>
                                        <?php
                                        }
                                        ?>
                                    </table><br>
                                    <p>Image was uploaded on <strong><?php echo $row_img['uploaded_at']; ?></strong></p>

                                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center;">
                                        Bill Created for <strong><?php echo $bill_month ?></strong>&nbsp;<i class="fa fa-check" aria-hidden="true"></i>
                                    </div>
                                    <p>Bill was updated <strong><?php echo $data_month_bill['updated_at']; ?></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card border shadow-lg mb-3">
                            <h2 class="text-center">Updated Last Bill</h2>
                            <div class="px-3 needs-validation">
                                <?php
                                $month_bill = "SELECT * FROM water_bill WHERE user_id='" . $uid . "' AND month = '$bill_month'";
                                $records_month_bill = mysqli_query($link, $month_bill);
                                $results_month_bill = mysqli_fetch_assoc($records_month_bill);
                                ?>
                                <div class="form-row">
                                    <diV class="form-group col-md-2"><img src="../../images/water_bill.png"></diV>
                                    <div class="form-group col-md-10 p-2">
                                        <br>
                                        <h4 style="text-align: center;">National Water Supply and Drainage Board
                                            <br>Statement of Water Account<h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="<?php echo $dataDetails['name'] ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" value="<?php echo $dataDetails['user_address'] ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Bill-Month</label>
                                    <input type="text" class="form-control" value="<?php echo $results_month_bill['month'] ?>" disabled>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Account Number</label>
                                        <input type="text" class="form-control" value="<?php echo $dataDetails['user_account'] ?>" disabled>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Meter Number</label>
                                        <input type="text" class="form-control" value="<?php echo $dataDetails['user_meter'] ?>" disabled>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Category</label>
                                        <input type="text" class="form-control" value="<?php echo $dataDetails['category'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label>Arrear from previous month</label>
                                        <input type="text" class="form-control" value="<?php echo $row_arrear['arrear'] ?>" disabled>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Meter Reading</label>
                                        <input type="text" class="form-control" value="<?php echo $results_month_bill['meter'] ?>" disabled>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Units Consumed for Month
                                            <?php echo date('F') ?></label>
                                        <input type="text" class="form-control" value="<?php echo $results_month_bill['units'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Charge For the Month(Rs.)</label>
                                        <input type="text" class="form-control" value="<?php echo $results_month_bill['charge'] ?>" disabled>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Total Amount Due (Rs.)</label>
                                        <input type="text" class="form-control" value="<?php echo $results_month_bill['total'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Updated</label>
                                        <input type="text" class="form-control" value="<?php echo $results_month_bill['updated_at'] ?>" disabled>

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Due Date</label>
                                        <input type="date" class="form-control" value="<?php echo $results_month_bill['due'] ?>" disabled>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card mb-3">
                            <h2 class="text-center">Previous Bills & Payments</h2>
                            <div class="card-body">
                                <div class="table-responsive-sm">
                                    <table class="table table-striped table-hover" style="font-size: 14px;" id="payTable">
                                        <thead style="font-weight: bold;font-size: 16px;">
                                            <tr style="text-align: center;">
                                                <td style="text-align: center;">Month</td>
                                                <td style="text-align: center;">Name</td>
                                                <td style="text-align: center;">Image</td>
                                                <td style="text-align: center;">Bill</td>
                                                <td style="text-align: center;">Amount</td>
                                                <td style="text-align: center;">Paid</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        $records_one_bill = mysqli_query($link, "SELECT * FROM water_bill WHERE user_id = '$uid'");
                                        $i=1;
                                        while ($data_bill_month = mysqli_fetch_assoc($records_one_bill)) {
                                            $arrear_rem_one = "SELECT * FROM water_pay WHERE id = (SELECT MAX(id)-'$i' FROM water_pay) AND user_id = '$uid'";
                                            $result_arrear_one = mysqli_query($link, $arrear_rem_one);
                                            $row_arrear_one = mysqli_fetch_array($result_arrear_one);

                                            $results_month_bill = $data_bill_month['month'];

                                            $results_month_image = mysqli_query($link, "SELECT * FROM water_image_upload WHERE month = '$results_month_bill' AND user_id = '$uid'");
                                            $data_image_month = mysqli_fetch_assoc($results_month_image);

                                            $records_one_pay = mysqli_query($link, "SELECT * FROM water_pay WHERE month = '$results_month_bill' AND user_id = '$uid'");


                                            $id = strval($data_bill_month['id']);
                                        ?>
                                            <tr style="text-align: center;">
                                                <td><?php echo $data_bill_month['month']; ?></td>
                                                <?php
                                                if ($data_one_pay = mysqli_fetch_assoc($records_one_pay)) {
                                                ?>
                                                    <td><?php echo $data_one_pay['pay_name']; ?></td>
                                                    <td style="text-align: center;"><a href="Download-Month.php?user_id=<?php echo urlencode($data_image_month['user_id']); ?>&month=<?php echo urlencode($results_month_bill); ?>"><?php $data_image_month['filename']; ?><i class="fa fa-download"></i></a></td>
                                                    <td style="text-align: center;">
                                                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#payment<?php echo $id; ?>">View&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></button>
                                                    </td>
                                                    <td>
                                                        <div class="btn btn-success"><?php echo $data_one_pay['pay_amount']; ?></div>
                                                    </td>
                                                    <td><?php echo $data_one_pay['paid_at']; ?></td>
                                                <?php
                                                } else {
                                                ?>
                                                    <td>
                                                        <div class="btn btn-danger" role="button">Not Paid</div>
                                                    </td>
                                                    <td style="text-align: center;"><a href="Download-Month.php?user_id=<?php echo urlencode($data_image_month['user_id']); ?>&month=<?php echo urlencode($results_month_bill); ?>"><?php $data_image_month['filename']; ?><i class="fa fa-download"></i></a></td>
                                                    <td style="text-align: center;">
                                                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#payment<?php echo $id; ?>">View&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></button>

                                                    </td>
                                                    <td>
                                                        <div class="btn btn-danger" role="button">Not Paid</div>
                                                    </td>
                                                    <td>
                                                        <div class="btn btn-danger" role="button">Not Paid</div>
                                                    </td>
                                                <?php
                                                }
                                                ?>
                                                <div class="modal fade" id="payment<?php echo $id; ?>" tabindex="-1" aria-labelledby="payment<?php echo $id; ?>Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h4 class="modal-title" id="payment<?php echo $id; ?>Label" style="color: white;">
                                                                    Bill</h4>
                                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa fa-times" aria-hidden="true"></i></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="px-3 needs-validation">
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-2"><img src="../../images/water_bill.png"></div>
                                                                        <div class="form-group col-md-12 p-2">
                                                                            <h5 style="text-align: center;">National Water Supply and Drainage Board
                                                                                <br>Statement of Water Account<h4>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Name</label>
                                                                        <input type="text" class="form-control" value="<?php echo $dataDetails['name'] ?>" disabled>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Address</label>
                                                                        <input type="text" class="form-control" value="<?php echo $dataDetails['user_address'] ?>" disabled>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-4">
                                                                            <label>Account Number</label>
                                                                            <input type="text" class="form-control" value="<?php echo $dataDetails['user_account'] ?>" disabled>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label>Meter Number</label>
                                                                            <input type="text" class="form-control" value="<?php echo $dataDetails['user_meter'] ?>" disabled>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label>Category</label>
                                                                            <input type="text" class="form-control" value="<?php echo $dataDetails['category'] ?>" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="col-md-4">
                                                                            <label>Arrear from previous month</label>
                                                                            <input type="text" class="form-control" value="<?php echo $row_arrear_one['arrear'] ?>" disabled>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label>Meter Reading</label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['meter'] ?>" disabled>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label>Units Consumed for Month
                                                                                <?php echo date('F') ?></label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['units'] ?>" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label>Charge For the Month(Rs.)</label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['charge'] ?>" disabled>
                                                                        </div>

                                                                        <div class="form-group col-md-6">
                                                                            <label>Total Amount Due (Rs.)</label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['total'] ?>" disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label>Updated</label>
                                                                            <input type="text" class="form-control" value="<?php echo $data_bill_month['updated_at'] ?>" disabled>

                                                                        </div>

                                                                        <div class="form-group col-md-6">
                                                                            <label>Due Date</label>
                                                                            <input type="date" class="form-control" value="<?php echo $data_bill_month['due'] ?>" disabled>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>

                                        <?php
                                        $i=$i+1;
                                        }

                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>

    <?php
                } else {
    ?>
        <div class="col-md-8">
            <div class="card border shadow-lg mb-4 p-3">
                <h2 class="text-center">Registered Form</h2>
                <hr>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center;">
                    <strong>Form Approved&nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i></strong>
                </div>
                <div class="px-3 needs-validation">
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

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Account Number</label>
                            <input type="text" class="form-control" name="user_account" disabled value="<?php echo $dataDetails['user_account']; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Meter Number</label>
                            <input type="text" class="form-control" name="user_meter" disabled value="<?php echo $dataDetails['user_meter']; ?>">
                        </div>
                    </div><br>
                </div>

            </div>

        </div><br>
        <div class="col-md-14">
            <div class="card mb-3">
                <h2 class="text-center">Previous Bills & Payments</h2>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-hover" style="font-size: 14px;" id="payTable">
                            <thead style="font-weight: bold;font-size: 16px;">
                                <tr style="text-align: center;">
                                    <td style="text-align: center;">Month</td>
                                    <td style="text-align: center;">Name</td>
                                    <td style="text-align: center;">Image</td>
                                    <td style="text-align: center;">Bill</td>
                                    <td style="text-align: center;">Amount</td>
                                    <td style="text-align: center;">Paid</td>
                                </tr>
                            </thead>
                            <?php
                            $records_one_bill = mysqli_query($link, "SELECT * FROM water_bill WHERE user_id = '$uid'");
                            $i=1;
                            while ($data_bill_month = mysqli_fetch_assoc($records_one_bill)) {
                                $arrear_rem_one = "SELECT * FROM water_pay WHERE id = (SELECT MAX(id)-'$i' FROM water_pay) AND user_id = '$uid'";
                                $result_arrear_one = mysqli_query($link, $arrear_rem_one);
                                $row_arrear_one = mysqli_fetch_array($result_arrear_one);

                                $results_month_bill = $data_bill_month['month'];

                                $results_month_image = mysqli_query($link, "SELECT * FROM water_image_upload WHERE month = '$results_month_bill' AND user_id = '$uid'");
                                $data_image_month = mysqli_fetch_assoc($results_month_image);

                                $records_one_pay = mysqli_query($link, "SELECT * FROM water_pay WHERE month = '$results_month_bill' AND user_id = '$uid'");


                                $id = strval($data_bill_month['id']);
                            ?>
                                <tr style="text-align: center;">
                                    <td><?php echo $data_bill_month['month']; ?></td>
                                    <?php
                                    if ($data_one_pay = mysqli_fetch_assoc($records_one_pay)) {
                                    ?>
                                        <td><?php echo $data_one_pay['pay_name']; ?></td>
                                        <td style="text-align: center;"><a href="Download-Month.php?user_id=<?php echo urlencode($data_image_month['user_id']); ?>&month=<?php echo urlencode($results_month_bill); ?>"><?php $data_image_month['filename']; ?><i class="fa fa-download"></i></a></td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#payment<?php echo $id; ?>">View&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></button>
                                        </td>
                                        <td>
                                            <div class="btn btn-success"><?php echo $data_one_pay['pay_amount']; ?></div>
                                        </td>
                                        <td><?php echo $data_one_pay['paid_at']; ?></td>
                                    <?php
                                    } else {
                                    ?>
                                        <td>
                                            <div class="btn btn-danger" role="button">Not Paid</div>
                                        </td>
                                        <td style="text-align: center;"><a href="Download-Month.php?user_id=<?php echo urlencode($data_image_month['user_id']); ?>&month=<?php echo urlencode($results_month_bill); ?>"><?php $data_image_month['filename']; ?><i class="fa fa-download"></i></a></td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#payment<?php echo $id; ?>">View&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></button>

                                        </td>
                                        <td>
                                            <div class="btn btn-danger" role="button">Not Paid</div>
                                        </td>
                                        <td>
                                            <div class="btn btn-danger" role="button">Not Paid</div>
                                        </td>
                                    <?php
                                    }
                                    ?>

                                    <div class="modal fade" id="payment<?php echo $id; ?>" tabindex="-1" aria-labelledby="payment<?php echo $id; ?>Label" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h4 class="modal-title" id="payment<?php echo $id; ?>Label" style="color: white;">
                                                        Bill</h4>
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="px-3 needs-validation">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-2"><img src="../../images/water_bill.png"></div>
                                                            <div class="form-group col-md-12 p-2">
                                                                <h5 style="text-align: center;">National Water Supply and Drainage Board
                                                                    <br>Statement of Water Account<h5>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input type="text" class="form-control" value="<?php echo $dataDetails['name'] ?>" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <input type="text" class="form-control" value="<?php echo $dataDetails['user_address'] ?>" disabled>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label>Account Number</label>
                                                                <input type="text" class="form-control" value="<?php echo $dataDetails['user_account'] ?>" disabled>
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label>Meter Number</label>
                                                                <input type="text" class="form-control" value="<?php echo $dataDetails['user_meter'] ?>" disabled>
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label>Category</label>
                                                                <input type="text" class="form-control" value="<?php echo $dataDetails['category'] ?>" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-md-4">
                                                                <label>Arrear from previous month</label>
                                                                <input type="text" class="form-control" value="<?php echo $row_arrear_one['arrear'] ?>" disabled>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>Meter Reading</label>
                                                                <input type="text" class="form-control" value="<?php echo $data_bill_month['meter'] ?>" disabled>
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label>Units Consumed for Month
                                                                    <?php echo date('F') ?></label>
                                                                <input type="text" class="form-control" value="<?php echo $data_bill_month['units'] ?>" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Charge For the Month(Rs.)</label>
                                                                <input type="text" class="form-control" value="<?php echo $data_bill_month['charge'] ?>" disabled>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label>Total Amount Due (Rs.)</label>
                                                                <input type="text" class="form-control" value="<?php echo $data_bill_month['total'] ?>" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Updated</label>
                                                                <input type="text" class="form-control" value="<?php echo $data_bill_month['updated_at'] ?>" disabled>

                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label>Due Date</label>
                                                                <input type="date" class="form-control" value="<?php echo $data_bill_month['due'] ?>" disabled>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </tr>

                            <?php
                            $i=$i+1;
                            }

                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <?php
                }
    ?>

<?php
            } else if ($dataDetails['status'] == 'Rejected') {
?>
    <div class="col-md-8">
        <div class="card border shadow-lg mb-4 p-2">
            <h2 class="text-center">Rejected Water Bill Management Form</h2>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="text-align: center;">
                <strong>Form Rejected&nbsp;<i class="fa fa-times" aria-hidden="true"></i></strong>
            </div>
            <div class="px-3 needs-validation">
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

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Account Number</label>
                        <input type="text" class="form-control" name="user_account" disabled value="<?php echo $dataDetails['user_account']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Meter Number</label>
                        <input type="text" class="form-control" name="user_meter" disabled value="<?php echo $dataDetails['user_meter']; ?>">
                    </div>
                </div><br>

                <div class="form-group">
                    <label>Reasons for Rejection</label>
                    <input type="text" class="form-control" name="feedback" disabled value="<?php echo $dataDetails['feedback']; ?>">
                </div>

            </div>
        </div>
    </div>
<?php
            }
?>
<div class="row gutters-sm">
    <div class="col-md-6">
        <div class="card border shadow-lg mb-3">
            <h2 class="text-center">Send Reminder</h2>
            <div class="card-body">
                <div class="alert alert-primary alert-dismissible fade show" role="alert" style="text-align: center;">
                    Send a reminder to upload the image of the meter before deadline&nbsp;<i class="fa fa-calendar" aria-hidden="true"></i>
                    for the bill. A notification will be sent
                    to the user account as well as an email for user's email address.
                </div>
                <h4 class="text-center">Send a New Reminder</h4>
                <form class="px-3 needs-validation" method="POST" action="Send-Reminder.php?user_id=<?php echo $dataDetails['user_id'] ?>">
                    <div class="form-group"><br>
                        <input name="user_name" value="<?php echo $data['user_name'] ?>" hidden>
                        <input name="user_email" value="<?php echo $data['user_email'] ?>" hidden>
                        <label>Reminder:</label>
                        <textarea type="text" style="height: 200px;" class="form-control" name="message">You have not uploaded the image of your water meter to get update about your payable bill. Please update it as soon as possible. Extra charges may apply if the image is not uploaded before the deadline! Discard this message if you have already uploaded the image.</textarea>
                    </div>
                    <button class="btn btn-primary" style="float: right;">Send&nbsp;<i class="fa fa-share-square-o" aria-hidden="true"></i></button>
                </form><br>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border shadow-lg mb-3">
            <h2 class="text-center">Previously Sent Reminders</h2>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" style="text-align: center;">Reminder</th>
                        <th scope="col" style="text-align: center;">Month</th>
                        <th scope="col" style="text-align: center;">Sent</th>
                    </tr>
                </thead>
                <?php
                $sql_rem = "SELECT * FROM water_notifications WHERE user_id = '$uid'";
                $result_rem = mysqli_query($link, $sql_rem);
                while ($row_rem = mysqli_fetch_array($result_rem)) {
                ?>
                    <tr>
                        <td style="text-align: center;"><button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#msgModal">See
                                Message</button></td>
                        <!-- Modal -->
                        <div class="modal fade" id="msgModal" tabindex="-1" aria-labelledby="msgModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="msgModalLabel">Message</h5>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-times" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo $row_rem['message']; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <td style="text-align: center;"><?php echo $row_rem['month']; ?></td>
                        <td style="text-align: center;"><?php echo $row_rem['date_time']; ?></td>
                    </tr>
                <?php

                }
                ?>
            </table>
        </div>
    </div>
</div>

    </div>
</div>
<script src="../../vendor.bundle.base.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/sc-2.0.3/sp-1.2.2/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#payTable').DataTable();
    });
</script>

<?php
require_once 'Admin-Footer.php';
?>