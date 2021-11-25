<?php 
require_once '../../Config.php';
require_once 'User-Header.php';
?>

<div class="container h-100" style="padding-top: 140px;">
<div class="row h-100 align-items-center justify-content-center">
<div class="col-lg-6">
<div class="card border-dark shadow-lg">


    <div class="card-body">
        <h2>Successfully Uploaded!</h2><br>
        <p class="align-items-center text-center">You have succesfully uploaded the image of the meter for the month <?php echo date('F');?>! 
        Your durable bill is making and it may take few hours. You will recieve an email once the durable bill is prepared. Stay touch with your account.</p>
        <div class="align-items-center text-center">
        <a href="User-Dashboard.php"><button class="btn btn-danger">OK</button></a>
        </div>
        
    </div>
    </div>

</div>

</div>

</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php
require_once 'User-Footer.php';
?>