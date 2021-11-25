<?php
require_once 'Admin-Header.php';

$sql_month = "SELECT * FROM bill_month";
$records_month = mysqli_query($link, $sql_month);
$data_month = mysqli_fetch_assoc($records_month);
$bill_month = $data_month['month'];

function allUsers(){
    $db = new mysqli('localhost', 'root', '', 'ocawbms');
    $all = mysqli_query($db, "SELECT * FROM current_bill");
    $all_users = mysqli_num_rows($all);
    return $all_users;
  }
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
<div class="row justify-content-center wrapper">
    <div class="col-lg-8 bg-white p-4">
        <h4 class="text-center font-weight-bold">All Bills for <?php echo $bill_month?></h4>
        <!-- <a href="Pdf.php">PDF</a> -->
        <hr class="my-3" />
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover" style="font-size: 14px;" id="myTable">
                <thead style="font-weight: bold;font-size: 16px;">
                    <tr>
                        <th style="text-align: center;">UserName</th>
                        <th>Month</th>
                        <th>Meter Image</th>
                        <th style="text-align: center;">Download Img</th>
                        <th style="text-align: center;">Bill</th>
                        <th style="text-align: center;">Download Bill(PDF)</th>
                        <th style="text-align: center;">Bill Status</th>
                    </tr>
                </thead>
                <?php
            $db = mysqli_connect("localhost","root","","ocawbms");
            $records_bill = mysqli_query($db,"SELECT * FROM current_bill WHERE month = '$bill_month'");

            while($data_bill=mysqli_fetch_assoc($records_bill)){
                ?>
                <tr>
                    <td style="text-align: center;">
                        <?php
                    $uid = $data_bill['user_id'];
                    $recordDetails = mysqli_query($db,"SELECT * FROM current_details WHERE user_id = '$uid'");
                    $dataDetails=mysqli_fetch_assoc($recordDetails);

                    $records = mysqli_query($db,"SELECT * FROM users WHERE user_id = '$uid'");
                    $data=mysqli_fetch_assoc($records);
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
                    <td>
                        <?php
                    $records_img = mysqli_query($db,"SELECT * FROM image_upload WHERE user_id = '$uid' AND month = '$bill_month'");
                    $data_img =mysqli_fetch_array($records_img);
                    echo $data_img['month'];
                    ?>
                    </td>
                    <td><i class="fa fa-file-image-o" aria-hidden="true"></i>&nbsp;<?php echo $data_img['filename'];?>
                    </td>
                    <td style="text-align: center;"><a
                            href="Download-Month.php?user_id=<?php echo urlencode($data_img['user_id']); ?>&month=<?php echo urlencode($bill_month) ?>"><?php $data_img['filename'];?><i
                                class="fa fa-download"></i></a></td>

                    <td style="text-align: center;">
                        <button class="btn btn-dark" data-bs-toggle="modal"
                            data-bs-target="#<?php echo $data['user_name'];?>">View&nbsp;<i class="fa fa-file-text-o"
                                aria-hidden="true"></i></button>
                               

                    </td>
                    <div class="modal fade" id="<?php echo $data['user_name'];?>" tabindex="-1"
                        aria-labelledby="<?php echo $data['user_name'];?>Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h4 class="modal-title" id="<?php echo $data['user_name'];?>Label"
                                        style="color: white;">
                                        Bill</h4>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                                <div class="modal-body">

                                    <div class="px-3 needs-validation">
                                        <div class="form-row">
                                            <div class="form-group col-md-2"><img src="../../images/ceb_bill.png"></div>
                                            <div class="form-group col-md-12 p-2">
                                                <h5 style="text-align: center;">Ceylon Electricity
                                                    Board Statement of Electricity Account<h5>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><?php $name = 'Name' ?>Name</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $dataDetails['name'] ?>" disabled>
                                        </div><br>
                                        <div class="form-group">
                                            <label><?php $user_address = 'Address' ?>Address</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $dataDetails['user_address'] ?>" disabled>
                                        </div><br>
                                        <div class="form-group">
                                            <label><?php $user_accs = 'Electricity Account Number' ?>Electricity Account Number</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $dataDetails['user_account'] ?>" disabled>
                                        </div><br>

                                        <div class="form-group">
                                            <label><?php $category = 'Category' ?>Category</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $dataDetails['category'] ?>" disabled>
                                        </div><br>

                                        <div class="form-group">
                                            <label><?php $meter = 'Meter Reading' ?>Meter Reading</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $data_bill['meter'] ?>" disabled>
                                        </div><br>

                                        <div class="form-group">
                                            <label><?php $units = 'Units' ?>Units Consumed for Month
                                                <?php echo date('F')?></label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $data_bill['units'] ?>" disabled>
                                        </div><br>

                                        <div class="form-group">
                                            <label><?php $charge = 'Charge for the month' ?>Charge For the Month(Rs.)</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $data_bill['charge'] ?>" disabled>
                                        </div><br>

                                        <div class="form-group">
                                            <label><?php $total = 'Total Amount' ?>Total Amount Due (Rs.)</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $data_bill['total'] ?>" disabled>
                                        </div><br>

                                        <div class="form-group">
                                            <label>Updated</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo $data_bill['updated_at']?>" disabled>

                                        </div><br>

                                        <div class="form-group">
                                            <label>Due Date</label>
                                            <input type="date" class="form-control"
                                                value="<?php echo $data_bill['due'] ?>" disabled>
                                        </div><br>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <td style="text-align: center;"><a href="Pdf.php?user_id=<?php echo $uid; ?>&month=<?php echo $bill_month; ?>&uname=<?php echo $admin_username; ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                    <td style="text-align: center;">
                        <?php 
                    if($data_bill['status'] == 'Not Paid'){
                        ?>
                        <div class="btn btn-warning" style="color: white;">Not Paid</div>
                        <?php
                    } 
                    else if($data_bill['status'] == 'Paid'){
                        $records_pay = mysqli_query($db,"SELECT * FROM current_pay WHERE user_id = '$uid'");
                        $data_pay =mysqli_fetch_assoc($records_pay);
                        ?>
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#<?php echo $data_pay['token'];?>">Paid&nbsp;<i class="fa fa-list-alt"
                                aria-hidden="true"></i></button>

                        <div class="modal fade" id="<?php echo $data_pay['token'];?>" tabindex="-1"
                            aria-labelledby="<?php echo $data_pay['token'];?>Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title" id="<?php echo $data_pay['token'];?>Label"
                                            style="color: white;">
                                            Payment</h4>
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i class="fa fa-times" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="px-3 needs-validation" style="text-align: left;">
                                            <div class="form-group">
                                                <label>Bill Owner Name</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $dataDetails['name']; ?>" disabled>
                                            </div><br>

                                            <div class="form-group">
                                                <label>Bill Month</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $bill_month; ?>" disabled>
                                            </div><br>

                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data_pay['pay_name'] ?>" disabled>
                                            </div><br>

                                            <div class="form-group">
                                                <label>NIC Number</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data_pay['pay_nic'] ?>" disabled>
                                            </div><br>

                                            <div class="form-group">
                                                <label>Amount(Rs.)</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $data_pay['pay_amount'] ?>" disabled>
                                            </div><br>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <?php
                    } 
                    ?>
                    </td>
                </tr>

                <?php
            }

        ?>
            </table>
        </div>
    </div>
</div>

<script src="../../vendor.bundle.base.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/sc-2.0.3/sp-1.2.2/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>
<?php
require_once 'Admin-Footer.php';
?>