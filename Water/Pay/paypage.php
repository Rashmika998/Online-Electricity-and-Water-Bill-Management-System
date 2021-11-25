<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ==" crossorigin="anonymous" defer></script>
    <title>DLMS</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <h5 class="text-dark navbar-nav">Paying Gateway</h5>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
             <li class="nav-item active"> <a class="nav-link" href="../includes/logout.inc.php"><i class="fas fa-sign-out-alt"></i>Logout <span class="sr-only">(current)</span></a></li>
        </ul>
    </nav>
    <div class="container" >
    <div class="parent-div d-flex align-items-center justify-content-center" style="height: 60vh;">
    <div class="card text-center card border-0">
      <p><?php echo $_SESSION['Title'];?></p>
    <form action="./charge.php" method="post" id="payment-form">
            <div class="form-row">
            <input type="text" name="name" class="form-control mb-3 StripeElement StripeElement--empty" value="<?php
            echo $_SESSION['name'];
            ?>" disabled>
            <input type="email" name="email" class="form-control mb-3 StripeElement StripeElement--empty" value="<?php
            echo $_SESSION['email'];
            ?>" disabled>
            <input type="text" name="amount" class="form-control mb-3 StripeElement StripeElement--empty" value="<?php
            echo $_SESSION['amount'];
            ?>.00 LKR" disabled>
                <div id="card-element" class="form-control">
                <!-- a Stripe Element will be inserted here. -->
                </div>
                <!-- Used to display form errors -->
                <div id="card-errors" role="alert"></div>
            </div>
            <div class="form-row">
                <button>Confirm Payment</button>
            </div>
        </form>
      
    </div>
    </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://js.stripe.com/v3"></script>
<script src="./js/charge.js"></script>
</body>
</html>