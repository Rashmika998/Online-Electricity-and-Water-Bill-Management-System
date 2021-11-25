<?php
require_once '../../Config.php';
require_once 'Admin-Header.php';


if (!isset($_SESSION['loggedin_admin'])) {
    header('Location: ../../Water-Admin-Login.php');
    exit;
  } else {
    $admin_username = $_SESSION['admin_uname'];
    $sql = "SELECT * FROM admin WHERE admin_username='" . $admin_username . "'";
    $records = mysqli_query($link, $sql);
    $data = mysqli_fetch_assoc($records);
    $a_id = $data['admin_id'];
    $_SESSION['admin_id'] = $a_id;
  }
  
  function pendingUsers(){
    $db = new mysqli('localhost', 'root', '', 'ocawbms');
    $pending = mysqli_query($db, "SELECT * FROM water_details WHERE status = 'Pending'");
    $result_pending = mysqli_num_rows($pending);
    return $result_pending;
  }

  function approvedUsers(){
    $db = new mysqli('localhost', 'root', '', 'ocawbms');
    $approved = mysqli_query($db, "SELECT * FROM water_details WHERE status = 'Approved'");
    $result_approved = mysqli_num_rows($approved);
    return $result_approved;
  }

  function rejectedUsers(){
    $db = new mysqli('localhost', 'root', '', 'ocawbms');
    $rejected = mysqli_query($db, "SELECT * FROM water_details WHERE status = 'Rejected'");
    $result_rejected = mysqli_num_rows($rejected);
    return $result_rejected;
  }

  function imageUploaded(){
    $db = new mysqli('localhost', 'root', '', 'ocawbms');
    $sql_month = "SELECT * FROM water_bill_month";
    $records_month = mysqli_query($db, $sql_month);
    $data_month = mysqli_fetch_assoc($records_month);
    $bill_month = $data_month['month'];
    $image_uploaded = mysqli_query($db, "SELECT * FROM water_image_upload WHERE status = 'Pending' AND month = '$bill_month'");
    $result_img_upload = mysqli_num_rows($image_uploaded);
    return $result_img_upload;
  }

  function pendingPay(){
    $db = new mysqli('localhost', 'root', '', 'ocawbms');
    $sql_month = "SELECT * FROM water_bill_month";
    $records_month = mysqli_query($db, $sql_month);
    $data_month = mysqli_fetch_assoc($records_month);
    $bill_month = $data_month['month'];
    $pending_pay = mysqli_query($db, "SELECT * FROM water_bill WHERE status = 'Not Paid' AND month = '$bill_month'");
    $result_pending_pay = mysqli_num_rows($pending_pay);
    return $result_pending_pay;
  }

  function totalPay(){
    $db = new mysqli('localhost', 'root', '', 'ocawbms');
    $sql_month = "SELECT * FROM water_bill_month";
    $records_month = mysqli_query($db, $sql_month);
    $data_month = mysqli_fetch_assoc($records_month);
    $bill_month = $data_month['month'];
    $total_pay = mysqli_query($db, "SELECT * FROM water_bill WHERE status = 'Paid' AND month = '$bill_month'");
    $result_total_pay = mysqli_num_rows($total_pay);
    return $result_total_pay;
  }

  $sql_month = "SELECT * FROM water_bill_month";
    $records_month = mysqli_query($link, $sql_month);
    $data_month = mysqli_fetch_assoc($records_month);
    $bill_month = $data_month['month'];

  $name_err = $username_err = $new_password_err = $email_err  = $confirm_password_err = $nic_err = $contact_err = "";

  if($_SERVER["REQUEST_METHOD"] == "POST"){
      $month = $_POST['month'];
      $a_id = $data['admin_id'];
      date_default_timezone_set('Asia/Colombo');
      $updated_at = date("Y-m-d H:i:s");

      $sql = "UPDATE water_bill_month SET admin_id = '$a_id', month = '$month', updated_at = '$updated_at' WHERE id = '1'";

      $sql_red_bill = mysqli_query($link, "SELECT user_id FROM water_bill WHERE status = 'Not Paid' AND month = '$bill_month'");

      if(mysqli_query($link, $sql)){
          while($data_red_bill = mysqli_fetch_assoc($sql_red_bill)){
              $red_id = $data_red_bill['user_id'];
              $insert = mysqli_query($link,"INSERT INTO water_red_bill (user_id, month) VALUES ('$red_id','$bill_month')");
          }
         // header("Location:Month-Updated.php");
        echo '<br/> <div class="alert alert-success alert-dismissible fade show" role="alert" ><strong>';
        echo 'Billing month updated succesfully! Refresh the page once it is updated';
        echo ' </strong> <button type="button" class="btn btn-success-close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>';
      }
      else{
          echo mysqli_error($link);
      }
  }
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
<div class="row justify-content-center wrapper">
    <div class="col-lg-12 p-4 pt-12" >
        <div class="row gutters-sm">
            <div class=" col-md-4 mb-3">
                <div class="border card p-2">
                    <h2 class="align-items-center text-center">Customer Water Usage for Month</h2>
                    <div class="card-body">
                        <?php
                            $domestic_units=$industrial_units=$religious_units=$hotel_units=$general_units=0;
                            $avg_domestic = $avg_general = $avg_hotel = $avg_religious = $avg_industrial = 0;
                            $domestic = mysqli_query($link, "SELECT * FROM water_bill WHERE month = '$bill_month'");
                            while($result_domestic = mysqli_fetch_array($domestic)){
                                $unit_uid = $result_domestic['user_id'];
                                $units = mysqli_query($link, "SELECT * FROM water_details WHERE user_id = '$unit_uid'");
                                $unit_method = mysqli_fetch_assoc($units);
                                if($unit_method['category'] == 'Domestic'){
                                    $domestic_units += $result_domestic['units'];
                                }

                                else if($unit_method['category'] == 'Industrial 1'){
                                    $industrial_units +=$result_domestic['units'];
                                }

                                else if($unit_method['category'] == 'Religious & Charity'){
                                    $religious_units += $result_domestic['units'];
                                }

                                else if($unit_method['category'] == 'Hotel 1'){
                                    $hotel_units += $result_domestic['units'];
                                }

                                else{
                                    $general_units += $result_domestic['units'];
                                }
                            }

                            $tot_units =  array();
                            $all = $domestic_units+ $industrial_units+$religious_units+$hotel_units+$general_units;
                            if ($all != 0) {
                                $avg_domestic = number_format(($domestic_units / $all) * 100, 2);
                                $avg_industrial = number_format(($industrial_units / $all) * 100, 2);
                                $avg_religious = number_format(($religious_units / $all) * 100, 2);
                                $avg_hotel = number_format(($hotel_units / $all) * 100, 2);
                                $avg_general = number_format(($general_units / $all) * 100, 2);
                                array_push($tot_units, $avg_domestic, $avg_industrial, $avg_religious, $avg_hotel, $avg_general);
                                $tot_methods =  array();
                                array_push($tot_methods, "Domestic", "industrial", "Religious & Charity", "Hotel 1", "General Purpose");
                            } else {
                            ?>
                                <div class="alert alert-primary" role="alert">
                                    Still no data to be shown!
                                </div>
                            <?php
                            }           
                        ?>
                        <canvas id="chartjs_bar"></canvas>

                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-14">
                    <div class="card border  mb-3 p-2">
                        <h2 class="align-items-center text-center  p-2">Billing Month</h2>
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                enctype="multipart/form-data">
                                <?php
                                    $sql_month = "SELECT * FROM water_bill_month";
                                    $records_month = mysqli_query($link, $sql_month);
                                    $data_month = mysqli_fetch_assoc($records_month);
                                    $admin_id = $data_month['admin_id'];
                                    $sql_admin = "SELECT * FROM admin WHERE admin_id = '$admin_id' AND type = 'Water'";
                                    $records_admin = mysqli_query($link, $sql_admin);
                                    $data_admin = mysqli_fetch_assoc($records_admin);
                                    $month = $data_month['month'];
                                    ?>
                                <div class="row gutters-sm">
                                    <div class="form-group col-md-4">
                                        <label>Billing Month</label>
                                        <input type="month" class="form-control" name="month" required
                                            value="<?php echo $data_month['month'] ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Updated By</label>
                                        <input disabled type="text" class="form-control"
                                            value="<?php echo $data_admin['admin_username'] ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Updated At</label>
                                        <input disabled type="text" class="form-control"
                                            value="<?php echo $data_month['updated_at'] ?>">
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <button class="btn btn-outline-primary btn-md btn-block myBtn" type="submit "
                                        name="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card border  mb-3 p-2">
                    <h2 class="align-items-center text-center p-2">Live Dashboard</h2>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mb-3 alert-dark fade show">
                                    <div class="panel-heading">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1 ">
                                                <button type="button" class="btn" data-bs-toggle="modal"
                                                    data-bs-target="#paid">
                                                    <div class="row">
                                                        <div class="col-md-3" style="float:left;
                                                        border-radius: 100%;color:#734F96"><i
                                                                class="fa fa-check-square-o fa-2x"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h4 class="stat-panel-title">
                                                                <?php echo totalPay()?>
                                                            </h4>
                                                            <h5 style="color: grey;">Total Paid</h5>
                                                        </div>
                                                    </div>
                                                </button>

                                                <div class="modal fade" id="paid" tabindex="-1"
                                                    aria-labelledby="paidLabel" aria-hidden="true">
                                                    <div class="modal-dialog ">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color:#734F96">
                                                                <h4 class="modal-title" id="paidLabel"
                                                                    style="color: white;">
                                                                    Paid Users</h4>
                                                                <button type="button" class="btn"
                                                                    style="background-color:#734F96;color: white;"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body paid">
                                                                <table
                                                                    class="table table-striped table-hover table-paid"
                                                                    style="font-size: 14px;" id="paidTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Username</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <?php
                                                                        $records = mysqli_query($link,"SELECT * FROM water_bill WHERE status = 'Paid' AND month = '$month'");
                                                                        
                                                                        while($data=mysqli_fetch_array($records)){
                                                                            $uid = $data['user_id'];
                                                                            $recordsOne = mysqli_query($link,"SELECT * FROM users WHERE user_id = '$uid'");
                                                                            $dataOne=mysqli_fetch_array($recordsOne);
                                                                        ?>
                                                                    <tr>
                                                                        <td>
                                                                            <h6 style="float: left;">
                                                                                <?php echo $dataOne['user_name'];?>&nbsp;&nbsp;
                                                                            </h6>
                                                                            <a style="text-decoration: none; float: right;color:#734F96;"
                                                                                href="View-Registration.php?user_id=<?php echo $data['user_id']?>">View
                                                                                <i class="fa fa-cc-stripe"
                                                                                    aria-hidden="true"></i>
                                                                            </a>

                                                                        </td>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3 alert-warning fade show">
                                    <div class="panel-heading">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1 ">
                                                <button type="button" class="btn" data-bs-toggle="modal"
                                                    data-bs-target="#pendingPay">
                                                    <div class="row">
                                                        <div class="col-md-3" style="float:left;
                                                        border-radius: 100%;color:#FF9966">
                                                            <i class="fa fa-question-circle-o fa-2x"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h4 class="stat-panel-title">
                                                                <?php echo pendingPay()?>
                                                            </h4>
                                                            <h5 style="color: grey;">Pending to Pay</h5>
                                                        </div>
                                                    </div>
                                                </button>

                                                <div class="modal fade" id="pendingPay" tabindex="-1"
                                                    aria-labelledby="pendingPayLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color:#FF9966">
                                                                <h4 class="modal-title" id="pendingPayLabel"
                                                                    style="color: white;">
                                                                    Users Pending to Pay</h4>
                                                                <button type="button" class="btn"
                                                                    style="background-color:#FF9966;color: white;"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-striped table-hover"
                                                                    style="font-size: 14px;" id="pendingTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Username</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <?php
                                                                        $records = mysqli_query($link,"SELECT * FROM water_bill WHERE status = 'Not Paid' AND month = '$month'");
                                                                        
                                                                        while($data=mysqli_fetch_array($records)){
                                                                            $uid = $data['user_id'];
                                                                            $recordsOne = mysqli_query($link,"SELECT * FROM users WHERE user_id = '$uid'");
                                                                            $dataOne=mysqli_fetch_array($recordsOne);
                                                                        ?>
                                                                    <tr>
                                                                        <td>
                                                                            <h6 style="float: left;">
                                                                                <?php echo $dataOne['user_name'];?>&nbsp;&nbsp;
                                                                            </h6>
                                                                            <a style="text-decoration: none; float: right;color:#FF9966;"
                                                                                href="View-Registration.php?user_id=<?php echo $data['user_id']?>">View
                                                                                Bill
                                                                                <i class="fa fa-cc-stripe"
                                                                                    aria-hidden="true"></i>
                                                                            </a>

                                                                        </td>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3 alert-primary fade show">
                                    <div class="panel-heading ">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1 ">
                                                <button type="button" class="btn" data-bs-toggle="modal"
                                                    data-bs-target="#imageUpload">
                                                    <div class="row">
                                                        <div class="col-md-3" style="float:left;
                                                        border-radius: 100%;color:blue"><i class="fa fa-upload fa-2x"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h4 class="stat-panel-title">
                                                                <?php echo imageUploaded()?>
                                                            </h4>
                                                            <h5 style="color: grey;">Image Uploaded</h5>
                                                        </div>
                                                    </div>
                                                </button>

                                                <div class="modal fade" id="imageUpload" tabindex="-1"
                                                    aria-labelledby="imageUploadLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h4 class="modal-title" id="imageUploadLabel"
                                                                    style="color: white;">
                                                                    Image Uploaded Users</h4>
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-striped table-hover"
                                                                    style="font-size: 14px;" id="imgTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Username</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <?php
                                                                    $due_month = $data_month['month'];
                                                                        $records = mysqli_query($link,"SELECT * FROM water_image_upload WHERE status = 'Pending' AND month = '$month'");
                                                                        
                                                                        while($data=mysqli_fetch_array($records)){
                                                                            $uid = $data['user_id'];
                                                                            $recordsOne = mysqli_query($link,"SELECT * FROM users WHERE user_id = '$uid'");
                                                                            $dataOne=mysqli_fetch_array($recordsOne);
                                                                        ?>
                                                                    <tr>
                                                                        <td>
                                                                            <h6 style="float: left;">
                                                                                <?php echo $dataOne['user_name'];?>&nbsp;&nbsp;
                                                                            </h6>
                                                                            <a style="text-decoration: none; float: right;color:primary;"
                                                                                href="View-Registration.php?user_id=<?php echo $data['user_id']?>">Update
                                                                                Bill
                                                                                <i class="fa fa-file-text-o"
                                                                                    aria-hidden="true"></i>
                                                                            </a>

                                                                        </td>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3 alert-secondary fade show">
                                    <div class="panel-heading">
                                        <div class="stat-panel text-center">
                                            <div class="stat-panel-number h1">

                                                <button type="button" class="btn" data-bs-toggle="modal"
                                                    data-bs-target="#notUpload">
                                                    <div class="row">
                                                        <div class="col-md-3" style="float:left;
                                                        border-radius: 100%;color:#DE5D83"><i
                                                                class="fa fa-picture-o fa-2x" aria-hidden="true"></i>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h4 class="stat-panel-title">
                                                                <?php echo (approvedUsers()- imageUploaded()-pendingPay()-totalPay())?>
                                                            </h4>
                                                            <h5 style="color: grey;">Not Uploaded</h5>
                                                        </div>
                                                    </div>
                                                </button>

                                                <div class="modal fade" id="notUpload" tabindex="-1"
                                                    aria-labelledby="notUploadLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header"
                                                                style="background-color: #DE5D83;">
                                                                <h4 class="modal-title" id="notUploadLabel"
                                                                    style="color: white;">
                                                                    Users Pending to Upload Image</h4>
                                                                <button type="button" class="btn"
                                                                    style="background-color: #DE5D83; color: white;"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-striped table-hover"
                                                                    style="font-size: 14px;" id="pendingImgTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Username</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <?php
                                                                        $que = "SELECT user_id FROM water_details WHERE status = 'Approved' AND user_id NOT IN (SELECT user_id FROM image_upload WHERE month = '$due_month')";
                                                                        $records_not = mysqli_query($link,$que);
                                                                        while($data_not=mysqli_fetch_array($records_not)){
                                                                                $uid = $data_not['user_id'];
                                                                                $recordsOne = mysqli_query($link,"SELECT * FROM users WHERE user_id = '$uid'");
                                                                                $dataOne=mysqli_fetch_array($recordsOne);
                                                                        ?>
                                                                    <tr>
                                                                        <td>
                                                                            <h6 style="float: left;">
                                                                                <?php echo $dataOne['user_name'];?>&nbsp;&nbsp;
                                                                            </h6>
                                                                            <a style="text-decoration: none; float: right;color:#DE5D83;"
                                                                                href="View-Registration.php?user_id=<?php echo $data_not['user_id']?>">Reminder
                                                                                <i class="fa fa-envelope"
                                                                                    aria-hidden="true"></i>
                                                                            </a>

                                                                        </td>
                                                                    </tr>

                                                                    <?php
                                                                        }
                                                                   // }

                                                                        ?>
                                                                </table>
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

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-4 p-1 alert-warning fade show">
                                        <div class="panel-heading">
                                            <div class="stat-panel text-center">
                                                <div class="stat-panel-number h1 ">
                                                    <button type="button" class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#pendingModal">
                                                        <div class="row">
                                                            <div class="col-md-6" style="float:left;
                                                        border-radius: 100%;color:#FF8C00"><i
                                                                    class="fa fa-user-plus fa-3x"
                                                                    aria-hidden="true"></i></div>
                                                            <div class="col-md-6">
                                                                <h4 class="stat-panel-title">
                                                                    <?php echo pendingUsers();?></h4>
                                                                <h5 style="color: grey;">Pending Users</h5>
                                                            </div>
                                                        </div>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="pendingModal" tabindex="-1"
                                                        aria-labelledby="pendingModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-warning">
                                                                    <h4 class="modal-title" id="pendingModalLabel"
                                                                        style="color: white;">
                                                                        Pending Users</h4>
                                                                    <button type="button" class="btn btn-warning"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-striped table-hover"
                                                                        style="font-size: 14px;" id="pendingRegiTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Username</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <?php
                                                                        $records = mysqli_query($link,"SELECT * FROM water_details WHERE status = 'Pending'");
                                                                        
                                                                        while($data=mysqli_fetch_array($records)){
                                                                            $uid = $data['user_id'];
                                                                            $recordsOne = mysqli_query($link,"SELECT * FROM users WHERE user_id = '$uid'");
                                                                            $dataOne=mysqli_fetch_array($recordsOne);
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <h6 style="float: left;">
                                                                                    <?php echo $dataOne['user_name'];?>&nbsp;&nbsp;
                                                                                </h6>
                                                                                <a style="text-decoration: none; float: right;color:#FF8C00;"
                                                                                    href="View-Registration.php?user_id=<?php echo $data['user_id']?>">View
                                                                                    Form
                                                                                    <i class="fa fa-file-text"
                                                                                        aria-hidden="true"></i>
                                                                                </a>

                                                                            </td>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-4 p-1 alert-success fade show">
                                        <div class="panel-heading">
                                            <div class="stat-panel text-center">
                                                <div class="stat-panel-number h1 ">

                                                    <button type="button" class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#approvedModal">
                                                        <div class="row">
                                                            <div class="col-md-6" style="float:left;
                                                        border-radius: 100%;color:green"><i class="fa fa-user fa-3x"
                                                                    aria-hidden="true"></i></div>
                                                            <div class="col-md-6">
                                                                <h4 class="stat-panel-title">
                                                                    <?php echo approvedUsers();?></h4>
                                                                <h5 style="color: grey;">Approved Users</h5>
                                                            </div>
                                                        </div>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="approvedModal" tabindex="-1"
                                                        aria-labelledby="approvedModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-success">
                                                                    <h4 class="modal-title" id="approvedModalLabel"
                                                                        style="color: white;">
                                                                        Approved Users</h4>
                                                                    <button type="button" class="btn btn-success"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <i class="fa fa-times"
                                                                            aria-hidden="true"></i></button>
                                                                </div>
                                                                <div class="modal-body approved">
                                                                    <table
                                                                        class="table table-striped table-hover table-approved"
                                                                        style="font-size: 14px;" id="approvedTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Username</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <?php
                                                                        $records = mysqli_query($link,"SELECT * FROM water_details WHERE status = 'Approved'");
                                                                        
                                                                        while($data=mysqli_fetch_array($records)){
                                                                            $uid = $data['user_id'];
                                                                            $recordsOne = mysqli_query($link,"SELECT * FROM users WHERE user_id = '$uid'");
                                                                            $dataOne=mysqli_fetch_array($recordsOne);
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <h6 style="float: left;">
                                                                                    <?php echo $dataOne['user_name'];?>&nbsp;&nbsp;
                                                                                </h6>
                                                                                <a style="text-decoration: none; float: right;color:forestgreen"
                                                                                    href="View-Registration.php?user_id=<?php echo $data['user_id']?>">View
                                                                                    Form
                                                                                    <i class="fa fa-file-text"
                                                                                        aria-hidden="true"></i>
                                                                                </a>

                                                                            </td>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-4 p-1 alert-danger fade show">
                                        <div class="panel-heading">
                                            <div class="stat-panel text-center">
                                                <div class="stat-panel-number h1 ">

                                                    <button type="button" class="btn" data-bs-toggle="modal"
                                                        data-bs-target="#rejectedModal">
                                                        <div class="row">
                                                            <div class="col-md-6" style="float:left;
                                                        border-radius: 100%;color:red"><i
                                                                    class="fa fa-user-times fa-3x"
                                                                    aria-hidden="true"></i></div>
                                                            <div class="col-md-6">
                                                                <h4 class="stat-panel-title">
                                                                    <?php echo rejectedUsers();?></h4>
                                                                <h5 style="color: grey;">Rejected Users</h5>
                                                            </div>
                                                        </div>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="rejectedModal" tabindex="-1"
                                                        aria-labelledby="rejectedModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h4 class="modal-title " id="rejectedModalLabel"
                                                                        style="color: white;">
                                                                        Rejected Users</h4>
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <i class="fa fa-times"
                                                                            aria-hidden="true"></i></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-striped table-hover"
                                                                        style="font-size: 14px;" id="rejectedTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Username</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <?php
                                                                        $records = mysqli_query($link,"SELECT * FROM water_details WHERE status = 'Rejected'");
                                                                        
                                                                        while($data=mysqli_fetch_array($records)){
                                                                            $uid = $data['user_id'];
                                                                            $recordsOne = mysqli_query($link,"SELECT * FROM users WHERE user_id = '$uid'");
                                                                            $dataOne=mysqli_fetch_array($recordsOne);
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <h6 style="float: left;">
                                                                                    <?php echo $dataOne['user_name'];?>&nbsp;&nbsp;
                                                                                </h6>
                                                                                <a style="text-decoration: none; float: right;color:red;"
                                                                                    href="View-Registration.php?user_id=<?php echo $data['user_id']?>">View
                                                                                    Form
                                                                                    <i class="fa fa-file-text"
                                                                                        aria-hidden="true"></i>
                                                                                </a>

                                                                            </td>
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
                <div class="card border mb-3 p-2">
                    <div class="row gutters-sm">
                        <h2 class="align-items-center text-center">Domestic&nbsp;<i class="fa fa-home"
                                aria-hidden="true"></i></h2>
                        <div class="col-md-6">
                            <div class="card border mb-3 p-2">

                                <div class="table-responsive-sm">
                                    <table class="table table-striped table-hover" style="text-align: center;">
                                        <thead style="font-weight: bold;">
                                            <tr>
                                                <th> Consumption</th>
                                                <th>Charge<br>(Rs/kWh)</th>
                                                <th>Fixed Charge<br>(Rs/month)</th>
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
                        </div>

                        <div class="col-md-6">
                            <div class="card border mb-3 p-2">
                                <h2 class="align-items-center text-center">
                                    Usage
                                    <?php
                                    $dom_m1 = $dom_m2 = $dom_m3 = $dom_m4 = $dom_m5 = $dom_m6 = 0;
                                    $m1 = date("Y-m", strtotime('-1 month', strtotime($due_month)));
                                    $m2 = date("Y-m", strtotime('-1 month', strtotime($m1)));
                                    $m3 = date("Y-m", strtotime('-1 month', strtotime($m2)));
                                    $m4 = date("Y-m", strtotime('-1 month', strtotime($m3)));
                                    $m5 = date("Y-m", strtotime('-1 month', strtotime($m4)));
                                    $m6 = date("Y-m", strtotime('-1 month', strtotime($m5)));

                                    $tot_months=  array();
                                    array_push($tot_months,$m1,$m2,$m3,$m4,$m5,$m6);
                                    $tot_dom =  array();
                                    
                                    $usage = mysqli_query($link,"SELECT * FROM water_bill");
                                    $use_dom = 0;
                                    while($res = mysqli_fetch_array($usage)){
                                        $usage_id = $res['user_id'];
                                        $use = mysqli_query($link,"SELECT category FROM water_details WHERE user_id = '$usage_id'");
                                        $result = mysqli_fetch_array($use);
                                        if($result['category'] == 'Domestic'){
                                            if($res['month'] == $m1){
                                                $dom_m1 += $res['units'];
                                            }

                                            else if($res['month'] == $m2){
                                                $dom_m2 += $res['units'];
                                            }

                                            else if($res['month'] == $m3){
                                                $dom_m3 += $res['units'];
                                            }

                                            else if($res['month'] == $m4){
                                                $dom_m4 += $res['units'];
                                            }

                                            else if($res['month'] == $m5){
                                                $dom_m5 += $res['units'];
                                            }

                                            else if($res['month'] == $m6){
                                                $dom_m6 += $res['units'];
                                            }
                                        }
                                    }
                                    array_push($tot_dom,$dom_m1, $dom_m2,$dom_m3, $dom_m4,$dom_m5,$dom_m6);
                                    ?>
                                    <canvas id="dom_bar"></canvas>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-14">
                <div class="card border mb-3 p-2">
                    <div class="row gutters-sm">
                        <h2 class="align-items-center text-center">
                            Religious & Charity&nbsp;<i class="fa fa-university" aria-hidden="true"></i>
                        </h2>
                        <div class="col-md-6">
                            <div class="card border mb-3 p-2">

                                <div class="table-responsive-sm">
                                    <table class="table table-striped table-hover" style="text-align: center;">
                                        <thead style="font-weight: bold;">
                                            <tr>
                                                <th>Consumption</th>
                                                <th>Charge<br>(Rs/kWh)</th>
                                                <th>Fixed Charge<br>(Rs/month)</th>
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
                        </div>

                        <div class="col-md-6">
                            <div class="card border mb-3 p-2">
                                <h2 class="align-items-center text-center">
                                    Usage
                                    <?php
                                    $rel_m1 = $rel_m2 = $rel_m3 = $rel_m4 = $rel_m5 = $rel_m6 = 0;
                                     $tot_rel =  array();
                                     $usage = mysqli_query($link,"SELECT * FROM water_bill");
                                     while($res = mysqli_fetch_array($usage)){
                                         $usage_id = $res['user_id'];
                                        $use = mysqli_query($link,"SELECT category FROM water_details WHERE user_id = '$usage_id'");
                                        $result = mysqli_fetch_array($use);
                                         if($result['category'] == 'Religious & Charity'){
                                             if($res['month'] == $m1){
                                                 $rel_m1 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m2){
                                                 $rel_m2 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m3){
                                                 $rel_m3 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m4){
                                                 $rel_m4 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m5){
                                                 $rel_m5 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m6){
                                                 $rel_m6 += $res['units'];
                                             }
                                         }
                                     }
                                     array_push($tot_rel,$rel_m1, $rel_m2,$rel_m3, $rel_m4,$rel_m5,$rel_m6);
                                     ?>
                                    <canvas id="rel_bar"></canvas>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-14">
            <div class="card border mb-3 p-2">
                <div class="row gutters-sm">
                    <h2 class="align-items-center text-center">
                        Industry&nbsp;<i class="fa fa-industry" aria-hidden="true"></i>
                    </h2>
                    <div class="col-md-6">
                        <div class="card border mb-3 p-2">

                            <div class="table-responsive-sm">
                                <table class="table table-striped table-hover" style="text-align: center;">
                                    <thead style="font-weight: bold;">
                                        <tr>
                                            <th>Consume</th>
                                            <th>Charge<br>(Rs/kWh)</th>
                                            <th>Fixed<br>Charge<br>(Rs/month)</th>
                                            <th>Max<br>Demand<br>Charge<br>(Rs/kVA)</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>1-1</td>
                                        <td>10.50</td>
                                        <td>240.00</td>
                                        <td>-</td>
                                    </tr>
                                    <td colspan="4" style="padding-right: 350px;">1-2</td>

                                    <tr>
                                        <td>Day</td>
                                        <td>10.45</td>
                                        <td rowspan="3" style="padding-top: 50px;">3000.00</td>
                                        <td rowspan="3" style="padding-top: 50px;">850.00</td>
                                    </tr>
                                    <tr>
                                        <td>Peak</td>
                                        <td>13.60</td>
                                    </tr>
                                    <tr>
                                        <td>Off Peak</td>
                                        <td>7.35</td>
                                    </tr>
                                    <td colspan="4" style="padding-right: 350px;">1-3</td>
                                    <tr>
                                        <td>Day</td>
                                        <td>10.25</td>
                                        <td rowspan="3" style="padding-top: 50px;">3000.00</td>
                                        <td rowspan="3" style="padding-top: 50px;">750.00</td>
                                    </tr>
                                    <tr>
                                        <td>Peak</td>
                                        <td>13.40</td>
                                    </tr>
                                    <tr>
                                        <td>Off Peak</td>
                                        <td>7.15</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border mb-3 p-2">
                            <h2 class="align-items-center text-center">
                                Usage
                                <?php
                                    $ind_m1 = $ind_m2 = $ind_m3 = $ind_m4 = $ind_m5 = $ind_m6 = 0;
                                     $tot_ind =  array();
                                     $usage = mysqli_query($link,"SELECT * FROM water_bill");
                                     while($res = mysqli_fetch_array($usage)){
                                         $usage_id = $res['user_id'];
                                        $use = mysqli_query($link,"SELECT category FROM water_details WHERE user_id = '$usage_id'");
                                        $result = mysqli_fetch_array($use);
                                         if($result['category'] == 'Industry 1'){
                                             if($res['month'] == $m1){
                                                 $ind_m1 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m2){
                                                 $ind_m2 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m3){
                                                 $ind_m3 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m4){
                                                 $ind_m4 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m5){
                                                 $ind_m5 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m6){
                                                 $ind_m6 += $res['units'];
                                             }
                                         }
                                     }
                                     array_push($tot_ind,$ind_m1, $ind_m2,$ind_m3, $ind_m4,$ind_m5,$ind_m6);
                                     ?>
                                <canvas id="ind_bar"></canvas>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-14">
        <div class="card border mb-3 p-2">
            <div class="row gutters-sm">
                <h2 class="align-items-center text-center">
                    Hotel&nbsp;<i class="fa fa-cutlery" aria-hidden="true"></i>
                </h2>
                <div class="col-md-6">
                    <div class="card border mb-3 p-2">

                        <div class="table-responsive-sm">
                            <table class="table table-striped table-hover" style="text-align: center;">
                                <thead style="font-weight: bold;">
                                    <tr>
                                        <th>Consumption</th>
                                        <th>Charge<br>(Rs/kWh)</th>
                                        <th>Fixed Charge<br>(Rs/month)</th>
                                        <th>Max Demand Charge<br>(Rs/kVA)</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>H-1</td>
                                    <td>19.50</td>
                                    <td>240.00</td>
                                    <td>-</td>
                                </tr>
                                <td colspan="4" style="padding-right: 350px;">H-2</td>

                                <tr>
                                    <td>Day</td>
                                    <td>13.00</td>
                                    <td rowspan="3" style="padding-top: 50px;">3000.00</td>
                                    <td rowspan="3" style="padding-top: 50px;">850.00</td>
                                </tr>
                                <tr>
                                    <td>Peak</td>
                                    <td>16.90</td>
                                </tr>
                                <tr>
                                    <td>Off Peak</td>
                                    <td>9.15</td>
                                </tr>
                                <td colspan="4" style="padding-right: 350px;">H-3</td>
                                <tr>
                                    <td>Day</td>
                                    <td>12.60</td>
                                    <td rowspan="3" style="padding-top: 50px;">3000.00</td>
                                    <td rowspan="3" style="padding-top: 50px;">750.00</td>
                                </tr>
                                <tr>
                                    <td>Peak</td>
                                    <td>16.40</td>
                                </tr>
                                <tr>
                                    <td>Off Peak</td>
                                    <td>8.85</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border mb-3 p-2">
                        <h2 class="align-items-center text-center">
                            Usage
                            <?php
                                    $hotel_m1 = $hotel_m2 = $hotel_m3 = $hotel_m4 = $hotel_m5 = $hotel_m6 = 0;
                                     $tot_hotel =  array();
                                     $usage = mysqli_query($link,"SELECT * FROM water_bill");
                                     while($res = mysqli_fetch_array($usage)){
                                         $usage_id = $res['user_id'];
                                        $use = mysqli_query($link,"SELECT category FROM water_details WHERE user_id = '$usage_id'");
                                        $result = mysqli_fetch_array($use);
                                         if($result['category'] == 'Hotel 1'){
                                             if($res['month'] == $m1){
                                                 $hotel_m1 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m2){
                                                 $hotel_m2 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m3){
                                                 $hotel_m3 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m4){
                                                 $hotel_m4 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m5){
                                                 $hotel_m5 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m6){
                                                 $hotel_m6 += $res['units'];
                                             }
                                         }
                                     }
                                     array_push($tot_hotel,$hotel_m1, $hotel_m2,$hotel_m3, $hotel_m4,$hotel_m5,$hotel_m6);
                                     ?>
                            <canvas id="hotel_bar"></canvas>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-14">
    <div class="card border mb-3 p-2">
        <div class="row gutters-sm">
            <h2 class="align-items-center text-center">
                General Purpose&nbsp;<i class="fa fa-building" aria-hidden="true"></i>
            </h2>
            <div class="col-md-6">
                <div class="card border mb-3 p-2">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-hover" style="text-align: center;">
                            <thead style="font-weight: bold;">
                                <tr>
                                    <th>Consum</th>
                                    <th>Charge<br>(Rs/kWh)</th>
                                    <th>Fixed<br>Charge<br>(Rs/month)</th>
                                    <th>Max<br>Demand<br>Charge<br>(Rs/kVA)</th>
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
            </div>

            <div class="col-md-6">
                <div class="card border mb-3 p-2">
                    <h2 class="align-items-center text-center">
                        Usage
                        <?php
                                    $gen_m1 = $gen_m2 = $gen_m3 = $gen_m4 = $gen_m5 = $gen_m6 = 0;
                                     $tot_gen =  array();
                                     $usage = mysqli_query($link,"SELECT * FROM water_bill");
                                     while($res = mysqli_fetch_array($usage)){
                                         $usage_id = $res['user_id'];
                                        $use = mysqli_query($link,"SELECT category FROM water_details WHERE user_id = '$usage_id'");
                                        $result = mysqli_fetch_array($use);
                                         if($result['category'] == 'General Purpose 1'){
                                             if($res['month'] == $m1){
                                                 $gen_m1 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m2){
                                                 $gen_m2 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m3){
                                                 $gen_m3 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m4){
                                                 $gen_m4 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m5){
                                                 $gen_m5 += $res['units'];
                                             }
 
                                             else if($res['month'] == $m6){
                                                 $gen_m6 += $res['units'];
                                             }
                                         }
                                     }
                                     array_push($tot_gen,$gen_m1, $gen_m2,$gen_m3, $gen_m4,$gen_m5,$gen_m6);
                                     ?>
                        <canvas id="gen_bar"></canvas>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<style>
.pagination,
div.dataTables_wrapper div.dataTables_filter label,
div.dataTables_wrapper div.dataTables_length label,
div.dataTables_wrapper div.dataTables_filter,
table.dataTable td.dataTables_empty,
table.dataTable th.dataTables_empty,
div.dataTables_wrapper div.dataTables_info {
    font-size: 14px;
}

.page-link,
.page-link:hover {
    color: black;
    text-decoration: none;
}
</style>

<script src="../../vendor.bundle.base.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/sc-2.0.3/sp-1.2.2/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $('#paidTable').DataTable();
});

$(document).ready(function() {
    $('#imgTable').DataTable();
});

$(document).ready(function() {
    $('#pendingImgTable').DataTable();
});

$(document).ready(function() {
    $('#pendingTable').DataTable();
});

$(document).ready(function() {
    $('#pendingRegiTable').DataTable();
});

$(document).ready(function() {
    $('#approvedTable').DataTable();
});

$(document).ready(function() {
    $('#rejectedTable').DataTable();
});
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript">
var ctx = document.getElementById("chartjs_bar").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($tot_methods); ?>,
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
            data: <?php echo json_encode($tot_units); ?>,
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

<script type="text/javascript">
var ctx = document.getElementById("dom_bar").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($tot_months); ?>,
        datasets: [{
            backgroundColor: [
                "#ffc750",
                "#2ec551",
                "#ff407b",
                "#3B444B",
                "#25d5f2",
                "#ff004e"
            ],
            data: <?php echo json_encode($tot_dom); ?>,
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

<script type="text/javascript">
var ctx = document.getElementById("rel_bar").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($tot_months); ?>,
        datasets: [{
            backgroundColor: [
                "#ffc750",
                "#2ec551",
                "#ff407b",
                "#3B444B",
                "#25d5f2",
                "#ff004e"
            ],
            data: <?php echo json_encode($tot_rel); ?>,
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

<script type="text/javascript">
var ctx = document.getElementById("ind_bar").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($tot_months); ?>,
        datasets: [{
            backgroundColor: [
                "#ffc750",
                "#2ec551",
                "#ff407b",
                "#3B444B",
                "#25d5f2",
                "#ff004e"
            ],
            data: <?php echo json_encode($tot_ind); ?>,
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

<script type="text/javascript">
var ctx = document.getElementById("hotel_bar").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($tot_months); ?>,
        datasets: [{
            backgroundColor: [
                "#ffc750",
                "#2ec551",
                "#ff407b",
                "#3B444B",
                "#25d5f2",
                "#ff004e"
            ],
            data: <?php echo json_encode($tot_hotel); ?>,
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

<script type="text/javascript">
var ctx = document.getElementById("gen_bar").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($tot_months); ?>,
        datasets: [{
            backgroundColor: [
                "#ffc750",
                "#2ec551",
                "#ff407b",
                "#3B444B",
                "#25d5f2",
                "#ff004e"
            ],
            data: <?php echo json_encode($tot_gen); ?>,
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