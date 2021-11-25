<?php
require_once 'User-Header.php';

$uid = $_SESSION['user_id'];  
$sql_bill = "SELECT * FROM current_bill WHERE user_id='" . $uid . "'";
$records_bill = mysqli_query($link, $sql_bill);

$sql_details = "SELECT * FROM current_details WHERE user_id='" . $uid . "'";
$records_details = mysqli_query($link, $sql_details);
$data_details = mysqli_fetch_array($records_details);
?>

<div class="row justify-content-center wrapper">
    <div class="col-lg-14 p-4 pt-12" style="background-color: #E5E4E2;">
        <div class="row gutters-sm">
            <div class="col-md-5">
            
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
                                        <p style="font-size: 18px;">FIrst time using online payment? Then better to see
                                            this guidance!
                                        </p style="font-size: 18px;">
                                    </div>
                                    <img src="../../images/how.png" class="d-block w-100" alt="...">

                                </div>
                                <div class="carousel-item">
                                    <div class="align-items-center text-center">
                                        <h4>First Step</h4>
                                        <p>Use the payment field provided in this page and select which methods through
                                            the payment is going
                                            to be done.
                                        </p>
                                    </div>
                                    <img src="../../images/pay-methods.png" class="d-block w-100" alt="...">

                                </div>
                                <div class="carousel-item">
                                    <div class="align-items-center text-center">
                                        <h4>Second Step</h4>
                                        <p>Once all the card details are provided, click 'Pay' button to do the payment
                                            successfully.</p>
                                    </div>
                                    <img src="../../images/pay.png" class="d-block w-100" alt="...">

                                </div>
                                <div class="carousel-item">
                                    <div class="align-items-center text-center">
                                        <h4>Third Step</h4>
                                        <p>An email will be sent to the user email account about the confirmation of the
                                            payment.
                                        </p>
                                    </div>
                                    <img src="../../images/email.png" class="d-block w-100" alt="...">

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

            <div class="col-md-7">
                <h2 class="align-items-center text-center">Bill Information</h2>
                <div class="card mb-3 p-2">
                    <div class="card-body">
                        <?php
                        if($data_bill = mysqli_fetch_array($records_bill)){
                            ?>
                        <div class="px-3 needs-validation">
                            <div class="form-row">
                                <diV class="form-group col-md-2"><img src="../../images/ceb_bill.png"></diV>
                                <div class="form-group col-md-10 p-2">
                                    <br>
                                    <h4 style="text-align: center;">Ceylon Electricity Board Statement of Electricity
                                        Account<h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="<?php echo $data_details['name'] ?>"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $data_details['user_address'] ?>" disabled>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Electricity Account Number</label>
                                    <input type="text" class="form-control"
                                        value="<?php echo $data_details['user_account'] ?>" disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Category</label>
                                    <input type="text" class="form-control"
                                        value="<?php echo $data_details['category'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Meter Reading</label>
                                    <input type="text" class="form-control" value="<?php echo $data_bill['meter'] ?>"
                                        disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Units Consumed for Month
                                        <?php echo date('F')?></label>
                                    <input type="text" class="form-control" value="<?php echo $data_bill['units'] ?>"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Charge for Electricity Consumed (Rs.) For the Month</label>
                                    <input type="text" class="form-control" value="<?php echo $data_bill['charge'] ?>"
                                        disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Total Amount Due (Rs.)</label>
                                    <input type="text" class="form-control" value="<?php echo $data_bill['total'] ?>"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Updated</label>
                                    <input type="text" class="form-control"
                                        value="<?php echo $data_bill['updated_at']?>" disabled>

                                </div>

                                <div class="form-group col-md-6">
                                    <label>Due Date</label>
                                    <input type="date" class="form-control" value="<?php echo $data_bill['due'] ?>"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group">

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

<?php
require_once 'User-Footer.php';
?>