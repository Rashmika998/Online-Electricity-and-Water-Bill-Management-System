
<?php
require_once '../../Config.php';
require_once 'User-Header.php';

$user_id = $_SESSION['uid'];

$sql = "SELECT * FROM current_details WHERE user_id='" . $user_id . "'";
$records = mysqli_query($link, $sql);
$data = mysqli_fetch_assoc($records);

$name = $data['name'];
$user_address = $data['user_address'];
$user_account = $data['user_account'];
$user_area = $data['user_area'];
$user_premises = $data['user_premises'];

$name_err = $address_err = $acc_err = $area_err = $premises_err = "";

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

    if (empty(trim($_POST["user_area"]))) {
        $area_err = "Please enter the Area Office as mentioned in the Bill!";
    } else {
        $user_area = trim($_POST["user_area"]);           
    }

    
    if (empty(trim($_POST["user_premises"]))) {
        $premises_err = "Please enter the Premises ID.";
    } else {
        $user_premises = trim($_POST["user_premises"]);
    }

    if (empty(trim($_POST["user_account"]))) {
        $acc_err = "Please enter the account number.";
    } elseif (strlen(trim($_POST["user_account"])) != 10){
        $acc_err = "Invalid Account Number. SHould consist with only 10 numbers";
    } else {
        $user_account = trim($_POST["user_account"]);
    }

    $updated_date = date("Y-m-d H:i:s");
    // Check input errors before inserting in database
    if (empty($name_err) && empty($address_err) && empty($area_err) && empty($premises_err) && empty($acc_err)) {

        $update= mysqli_query($link,"UPDATE current_details SET submitted_at='".$updated_date."' ,name ='".$name."',user_address = '".$user_address."'
        ,user_area = '".$user_area."',user_premises = '".$user_premises."',user_account = '".$user_account."',status = 'Pending',feedback = ''
         WHERE user_id = '".$user_id."'");
        
        $message = "Registered again for the current bill management system.";
        $activity = "INSERT INTO activity_log (user_id, message) VALUES ('$user_id', '$message')";
        
        if ($update) {
            mysqli_query($link,$activity);
                header("Location: User-Registered.php");;
                exit();
        } else {
                echo "Something went wrong when updating. Please try again later.";
        }
       // Close statement
        $stmt->close();
        
    }

    // Close connection
    $link->close();
}
?>
<div class="row justify-content-center wrapper">
    <div class="col-lg-7 bg-white p-4 pt-12">
        <h4 class="text-center font-weight-bold">Re-Registration for Electricity Bill Management</h4>
        <hr class="my-3" />
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="px-3 needs-validation"
            id="user_add">

            <p style="font-size: 14px;">*Please fill this form correctly this time to register for the electricity bill management system. All
                the information is related to manual bill and the values you entered last time were auto filled.</p>

            <div class="form-group">
                <label>Name of the Person</label>
                <input type="text" class="form-control" name="name" placeholder="Enter the Name"
                    value="<?php echo $data['name']; ?>" required>
                <span class="help-block"><?php echo $name_err; ?></span>
            </div><br>

            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="user_address" placeholder="Enter the Address"
                    value="<?php echo $data['user_address']; ?>" required>
                <span class="help-block"><?php echo $address_err; ?></span>
            </div><br>

            <div class="form-group">
                <label>Area Office</label>
                <input type="text" class="form-control" name="user_area" placeholder="Enter the Area Office"
                    value="<?php echo $data['user_area']; ?>" required>
                <span class="help-block"><?php echo $area_err; ?></span>
            </div><br>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Premises ID</label>
                    <input type="text" class="form-control" name="user_premises" placeholder="Enter the Premises ID"
                        value="<?php echo $data['user_premises']; ?>" required>
                    <span class="help-block"><?php echo $premises_err; ?></span>
                </div>

                <div class="form-group col-md-6">
                    <label>Electricity Account Number</label>
                    <input type="text" class="form-control" name="user_account" placeholder="Enter the Account Number"
                        value="<?php echo $data['user_account']; ?>" required>
                    <span class="help-block"><?php echo $acc_err; ?></span>
                </div>
            </div><br>

            <div class="form-group">
                <button class="btn btn-danger btn-lg btn-block myBtn" type="submit " name="submit">Re-Submit</button>
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