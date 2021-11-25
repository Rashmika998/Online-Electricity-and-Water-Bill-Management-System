<?php

require_once 'Admin-Header.php';
?>

<div class="row justify-content-center wrapper">
    <div class="col-lg-8 bg-white p-4">
        <h4 class="text-center font-weight-bold">Search Results</h4>
        <hr class="my-3" />
        <a href="View-Users.php" class="btn btn-danger "><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;Back</a><br><br>
        <div class="row content-center" style="font-size: 16px;">
            <form class="d-flex" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input class="form-control me-2" type="Search" name="name" placeholder="Search Username..."
                    aria-label="Search">&nbsp;&nbsp;
                <button class="btn btn-danger" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div><br>
        <?php
            $db = mysqli_connect("localhost","root","","ocawbms");
            if(isset($_POST['name'])){
                $uname = $_POST['name'];
                if($_SERVER["REQUEST_METHOD"] == "POST" ){
                    $records = mysqli_query($db,"SELECT user_id, gender, user_name FROM users WHERE user_name = '$uname'");
                    if($data=mysqli_fetch_array($records)){
                        ?>
        <table class="table table-striped table-hover" style="font-size: 14px;">
            <thead style="font-weight: bold;font-size: 16px;">
                <tr>
                    <td>UserName</td>
                    <td style="text-align: center;">Registered/Not Registered</td>
                    <td style="text-align: center;">Status</td>
                </tr>
            </thead>
            <tr>
                <td style="font-size: 14px;">
                    <?php
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
                    &nbsp;<?php echo $data['user_name'];?>
                </td>
                <td style="text-align: center;">
                    <?php
                    $uid = $data['user_id'];
                    $records_user = mysqli_query($db,"SELECT * FROM current_details WHERE user_id = '$uid'");
                    if($data_user=mysqli_fetch_array($records_user)){
                        ?>
                    <div><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i></div>
                </td>

                <td style="text-align: center;">
                    <?php
                        if($data_user['status'] == 'Approved'){
                            ?>
                    <a href="View-Registration.php?user_id=<?php echo $data['user_id']?>"
                        class="btn btn-success">Approved</>
                        <?php
                        }
                        else if($data_user['status'] == 'Rejected'){
                            ?>
                        <a href="View-Registration.php?user_id=<?php echo $data['user_id']?>"
                            class="btn btn-danger">Rejected</a>
                        <?php
                        }
                        else if($data_user['status'] == 'Pending'){
                            ?>
                        <a href="View-Registration.php?user_id=<?php echo $data['user_id']?>" class="btn btn-warning"
                            style="color: white;">Pending</a>
                        <?php
                        }

                        ?>
                </td>
                <?php
                    }
                    else{
                        ?>
                <div><i class="fa fa-times fa-2x" aria-hidden="true"></i></div>
                </td>

                <td style="text-align: center;">
                    <div class="btn btn-dark" style="color: white;">Not Registered</div>
                </td>
                <?php
                    }
                    ?>

                </td>
            </tr>
            <?php
              }

              else{
                  ?>
            <div class="row justify-content-center">Not Search Results Matched<br></div>
            
            <?php
              }
            }
        }

            ?>
        </table>
    </div>
</div>

<?php
require_once 'Admin-Footer.php';
?>