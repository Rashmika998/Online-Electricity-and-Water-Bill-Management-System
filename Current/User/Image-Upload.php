<?php
require_once 'User-Header.php';
$uid = $_SESSION['user_id'];
$uname = $_SESSION['user_uname'];

$sql_month = "SELECT * FROM bill_month";
$records_month = mysqli_query($link, $sql_month);
$data_month = mysqli_fetch_assoc($records_month);
$due_month = $data_month['month'];

$sql_record = "SELECT * FROM image_upload WHERE user_id='" . $uid . "' AND month = '$due_month' AND status != 'Rejected'";
$recordsDetails = mysqli_query($link, $sql_record);



$records_img = mysqli_query($link, "SELECT * FROM image_upload WHERE user_id = '$uid'");
$data_img = mysqli_fetch_assoc($records_img);

$sql_details = "SELECT * FROM current_details WHERE user_id='" . $uid . "'";
$records_details = mysqli_query($link, $sql_details);
$dataDetails = mysqli_fetch_array($records_details);
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />

<div class="row justify-content-center wrapper">
    <div class="col-lg-14 p-4 pt-12" style="background-color: #E5E4E2;">
        <div class="row gutters-sm">
            <div class="col-md-6"><br>
                <div class="card border shadow-lg mb-3 p-2">
                    <h2 class="align-items-center text-center">Previous Images & Bills</h2>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-striped table-hover" style="font-size: 14px;" id="newTable">
                                <thead style="font-weight: bold;font-size: 16px;">
                                    <tr>
                                        <th>Month</th>
                                        <th style="text-align: center;">Download Meter Image</th>
                                        <th style="text-align: center;">Bill</th>
                                        <th style="text-align: center;">Download Bill</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql_bill = "SELECT * FROM current_bill WHERE user_id='" . $uid . "'";
                                $records_bill = mysqli_query($link, $sql_bill);
                                while ($data_bill = mysqli_fetch_assoc($records_bill)) {
                                ?>
                                    <tr>
                                        <td>

                                            <?php
                                            $img_month = $data_bill['month'];
                                            $sql_img = "SELECT * FROM image_upload WHERE month='" . $img_month . "' AND status != 'Rejected'";
                                            $records_img_month = mysqli_query($link, $sql_img);
                                            $data_img_month = mysqli_fetch_assoc($records_img_month);

                                            $id = strval($data_bill['id']);
                                            echo $data_img_month['month']; ?>
                                        </td>
                                        <td style="text-align: center;"><a href="Download.php?user_id=<?php echo urlencode($data_img_month['user_id']); ?>&month=<?php echo urlencode($img_month); ?>"><?php $data_img_month['filename']; ?><i class="fa fa-file-image-o"></i></a></td>

                                        <td style="text-align: center;">
                                            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#photo<?php echo $id; ?>">View&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></button>

                                        </td>
                                        <div class="modal fade" id="photo<?php echo $id; ?>" tabindex="-1" aria-labelledby="photo<?php echo $id; ?>Label" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h4 class="modal-title" id="photo<?php echo $id; ?>Label" style="color: white;">
                                                            Bill</h4>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
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
                                                                <label>Name</label>
                                                                <input type="text" class="form-control" value="<?php echo $dataDetails['name'] ?>" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <input type="text" class="form-control" value="<?php echo $dataDetails['user_address'] ?>" disabled>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>Electricity Account Number</label>
                                                                    <input type="text" class="form-control" value="<?php echo $dataDetails['user_account'] ?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label>Category</label>
                                                                    <input type="text" class="form-control" value="<?php echo $dataDetails['category'] ?>" disabled>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>Meter Reading</label>
                                                                    <input type="text" class="form-control" value="<?php echo $data_bill['meter'] ?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label>Units Consumed for Month
                                                                        <?php echo date('F') ?></label>
                                                                    <input type="text" class="form-control" value="<?php echo $data_bill['units'] ?>" disabled>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>Charge For the
                                                                        Month(Rs.)</label>
                                                                    <input type="text" class="form-control" value="<?php echo $data_bill['charge'] ?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label>Total Amount Due (Rs.)</label>
                                                                    <input type="text" class="form-control" value="<?php echo $data_bill['total'] ?>" disabled>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>Updated</label>
                                                                    <input type="text" class="form-control" value="<?php echo $data_bill['updated_at'] ?>" disabled>

                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label>Due Date</label>
                                                                    <input type="date" class="form-control" value="<?php echo $data_bill['due'] ?>" disabled>
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
                                        <td style="text-align: center;"><a href="Pdf.php?user_id=<?php echo $uid; ?>&month=<?php echo $due_month; ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>

                                        <td style="text-align: center;">
                                            <?php
                                            if ($data_bill['status'] == 'Not Paid') {
                                            ?>
                                                <div class="btn btn-warning" style="color: white;">Not Paid</div>
                                            <?php
                                            } else if ($data_bill['status'] == 'Paid') {
                                            ?>
                                                <div class="btn btn-success" style="color: white;">Paid</div>
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
                        <!-- <h2 class="align-items-center text-center">Guide</h2>
                <div class="card mb-3 p-2">
                    <div class="card-body">
                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                    class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                    aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                    aria-label="Slide 3"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"
                                    aria-label="Slide 4"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="align-items-center text-center">
                                        <p style="font-size: 18px;">FIrst time using? Then better to see this guidance!
                                        </p style="font-size: 18px;">
                                    </div>
                                    <img src="../../images/new.png" class="d-block w-100" alt="...">

                                </div>
                                <div class="carousel-item">
                                    <div class="align-items-center text-center">
                                        <h4>First Step</h4>
                                        <p>Click a clear image of the current meter. (Please check whether the values
                                            are readable after taking it)</p>
                                    </div>
                                    <img src="../../images/meter.png" class="d-block w-100" alt="...">

                                </div>
                                <div class="carousel-item">
                                    <div class="align-items-center text-center">
                                        <h4>Second Step</h4>
                                        <p>Upload the taken image using Upload button.</p>
                                    </div>
                                    <img src="../../images/upload.png" class="d-block w-100" alt="...">

                                </div>
                                <div class="carousel-item">
                                    <div class="align-items-center text-center">
                                        <h4>Third Step</h4>
                                        <p>Adminstrators will inform about the durable payment after the confirmation.
                                            (If there are issues
                                            with the image uploaded, then you will be asked to upload it again.
                                        </p>
                                    </div>
                                    <img src="../../images/check.png" class="d-block w-100" alt="...">

                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                    </div>
                </div> -->
                    </div>
                </div>
            </div>
            <?php
            if ($dataDetails = mysqli_fetch_assoc($recordsDetails)) {
            ?>
                <div class="col-md-6"><br>
                    <div class="card border shadow-lg mb-3 p-2">
                        <h2 class="align-items-center text-center">Image Uploaded Successfully</h2>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Dear <?php echo $uname ?>!</strong> You have uploaded the meter image
                                    for <strong><?php echo $due_month; ?></strong>. You can download it from here.
                                    Your bill will be updated by the administrators soon. It will take few hours and
                                    you
                                    will recieve an email once it is updated. If you have any issues contact us.
                                </div>
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Image File Name</th>
                                            <th scope="col" style="text-align: center;">Download</th>

                                        </tr>
                                    </thead>
                                    <?php

                                    $sql_one = "SELECT * FROM image_upload WHERE user_id = '$uid' AND month = '$due_month'";
                                    $result_one = mysqli_query($link, $sql_one);
                                    if ($row = mysqli_fetch_array($result_one)) {
                                    ?>
                                        <td><i class="fa fa-file-image-o" aria-hidden="true"></i>&nbsp;<?php echo $row['filename']; ?></td>
                                        <td style="text-align: center;"><a href="Download.php?user_id=<?php echo urlencode($row['user_id']); ?>&month=<?php echo urlencode($due_month) ?>"><?php $row['filename']; ?><i class="fa fa-download"></i></a></td>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                    $sql_prev_bill = "SELECT * FROM current_bill WHERE user_id='" . $uid . "' AND month = '$due_month'";
                    $records_prev_bill = mysqli_query($link, $sql_prev_bill);
                    $data_prev_bill = mysqli_fetch_array($records_prev_bill);
                    if ($data_prev_bill['status'] == 'Paid') {
                    ?>
                        <div class="col-md-14">
                            <h2 class="align-items-center text-center">Bill Progress</h2>
                            <div class="card border shadow-lg  mb-3 p-2">
                                <div class="card-body align-items-center text-center btn bg-white">
                                    <div class="row">
                                        <div class="alert alert-success" role="alert">
                                            <h5 class="align-items-center text-center">Bill Payment is Done&nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i></h5>
                                            You have paid the bill for <?php echo $due_month; ?>.
                                            You will recieve an email about your payment information and you can
                                            see it from here as well.
                                            <a class="alert-link" href="Bill-Info.php" style="text-decoration: none;"><br>
                                                <h7 class="align-items-center text-center">View Payment&nbsp;<i class="fa fa-credit-card" aria-hidden="true"></i></h7>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            <?php
                    } else if ($dataDetails['status'] == 'Pending') {
            ?>
                <div class="col-md-14">
                    <h2 class="align-items-center text-center">Bill Progress</h2>
                    <div class="card border shadow-lg  mb-3 p-2">
                        <div class="card-body align-items-center text-center btn btn-light">
                            <div class="row">
                                <h5 class="align-items-center text-center">Your Payable Bill is
                                    Under Preparation by Administrators&nbsp;<i class="fa fa-file-text-o" aria-hidden="true"></i>

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
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    <?php
                    } else if ($dataDetails['status'] == 'Prepared') {
    ?>
        <div class="col-md-14">
            <h2 class="align-items-center text-center">Bill Progress</h2>
            <div class="card border shadow-lg  mb-3 p-2">
                <div class="card-body align-items-center text-center btn btn-light">
                    <div class="row">
                        <h5 class="align-items-center text-center">Your Payable Bill is Prepared
                            &nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i>

                        </h5><br>
                        <div class="align-items-center text-center">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div><br>
                        <p>Your payable bill is prepared.
                            Please settle the bill charge before the due date given in the bill.
                            Extra charges may apply if the charge
                            is not settled within the due date. If you have any issues regarding the
                            bill please contact us.
                            <a href="Bill-Info.php" style="text-decoration: none;"><Br>
                                <h7 class="align-items-center text-center">View Bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></h7>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php
                    }
                } else {
                    $state = "";
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $user_id = $uid;
                        $filename = $_FILES['file']['name'];
                        $month = $_POST['month'];
                        if ($filename == null) {
                            $success = 2;
                        } else {
                            $tmpname = $_FILES['file']['tmp_name'];
                            $file_size = $_FILES['file']['size'];
                            $file_type = $_FILES['file']['type'];

                            $ext = pathinfo($filename, PATHINFO_EXTENSION);

                            $fp      = fopen($tmpname, 'r');
                            $content = fread($fp, filesize($tmpname));
                            $content = addslashes($content);
                            fclose($fp);
                            if ($ext == "png" || $ext == "PNG" || $ext == "JPG" || $ext == "jpg" || $ext == "jpeg" || $ext == "JPEG") {
                                $sql = "INSERT INTO image_upload (user_id, month, filename, image, filetype, size) VALUES ('$user_id', '$month','$filename','$content', '$file_type','$file_size')";


                                if ($month != $due_month) {
                                    echo '<br/> <div class="alert alert-warning alert-dismissible fade show" role="alert" style="top:60px;left:0;right:0;position:fixed;"><strong>';
                                    echo 'Sorry the billing month you have submitted is incorrect! Submit it the image again by choosing the correct month. If you have any issues please contact us.';
                                    echo ' </strong> <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"> </button> </div>';
                                } else {
                                    if (mysqli_query($link, $sql)) {
                                        $success = 1;
                                        $message = "Uploaded the meter image for $due_month.";
                                        $activity = "INSERT INTO activity_log (user_id, message) VALUES ('$uid', '$message')";
                                        mysqli_query($link, $activity);
                                        mysqli_close($link);
                                        echo '<br/> <div class="alert alert-success alert-dismissible fade show" role="alert" style="top:60px;left:0;right:0;position:fixed;"><strong>';
                                        echo 'You have successfully uploaded the image for <strong>' . $due_month . '</strong>';
                                        echo ' </strong> <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"> </button> </div>';
                                        //header("Location:Image-Uploaded.php");
                                    } else {
                                        mysqli_close($link);
                                        $success = 2;
                                    }
                                }
                            } else {
                                mysqli_close($link);
                                $state = 'File Format might not be supported, please check and try again';
                            }
                        }
                        // $link->close();

                    }
    ?>
    <div class="col-md-6"><br>
        <div class="card border shadow-lg mb-3 p-2">
            <h2 class="align-items-center text-center">Upload</h2>
            <div class="card-body">
                <div class="col-md-12">
                    <p class="align-items-center text-center">Upload your Meter Image here by
                        clicking&nbsp;<i class="fa fa-download" aria-hidden="true"></i> icon.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Billing Month for the Image</label>
                            <input type="month" class="form-control" name="month" required>
                        </div>
                        <div class="card mb-3 p-2 align-items-center text-center"><br>
                            <label for="file-upload" class="outer">
                                <div id="start">
                                    <input type='number' value="$uid" name="user_id" hidden>
                                    <label for="select">
                                        <div class="row">
                                            <div class="col md-6">
                                                <i class="fa fa-download fa-5x" aria-hidden="true"></i>
                                                <div>Select a file</div>
                                            </div>
                                            <div class="col md-6">
                                                <a href="Take-Photo.php"><i class="fa fa-camera fa-5x" aria-hidden="true"></i></a>
                                                <div>Take photo</div>
                                            </div>
                                        </div>
                                    </label>
                                    <input type='file' id="select" style="display:none" name="file">

                                </div>
                                <br><br>
                            </label>
                        </div>
                        <div class="align-items-center text-center">
                            <p id="chosenfile"></p>
                            <button type="submit" name="btn-upload" class="btn
                                                btn-danger">Upload</button>
                            <!-- <input type="file" accept="image/*" capture="camera"> -->

                        </div>
                    </form><br>

                    <div class="alert alert-dark alert-dismissible fade show" role="alert">
                        <strong>Dear <?php echo $uname ?>!</strong> You have not still uploaded the meter
                        image
                        for <strong><?php echo $due_month; ?></strong>.
                        Please upload it within the time period or else you will be charge for delaying
                        it!!!.
                        If you have any issues
                        regarding uploading the meter image, see the guidance or contact us.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModal1">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Upload Status</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Upload Failed : Please select the file correctly!
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="Image-Upload.php"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></a>
                </div>

            </div>
        </div>
    </div>

    <!-- The Modal  Fail-->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Upload Status</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    You have Successfully Uploaded the Image!
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="User-Dashboard.php"><button type="button" class="btn btn-success">OK</button></a>
                </div>

            </div>
        </div>
    </div>

    <?php

                    if ($state != null) {
                        echo '<br/> <div class="alert alert-danger alert-dismissible fade show uploader" role="alert" >';
                        echo $state;
                        echo ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>';
                        echo '<br>';
                    }

    ?>
<?php
                }

?>

    </div>
</div>
</div>


<!-- jQuery -->
<script src="../../jquery/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<script>
    var input = document.getElementById('select');
    var infoArea = document.getElementById('chosenfile');

    input.addEventListener('change', showFileName);

    function showFileName(event) {

        // the change event gives us the input it occurred in 
        var input = event.srcElement;

        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input.files[0].name;

        // use fileName however fits your app best, i.e. add it into a div
        infoArea.textContent = 'Selected File: ' + fileName;
    }
</script>

<script src="../../vendor.bundle.base.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/sc-2.0.3/sp-1.2.2/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#newTable').DataTable();
    });
</script>

<script>
    $(document).on("click", ".myBill", function() {
        var bill = $(this).data('bill');

        document.getElementById("bill").innerHTML = bill;
    });
</script>

<?php
require_once 'User-Footer.php';
?>