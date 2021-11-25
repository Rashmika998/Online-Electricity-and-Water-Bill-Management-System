<?php

require_once 'Admin-Header.php';
function allAdmins(){
    $db = new mysqli('localhost', 'root', '', 'ocawbms');
    $all = mysqli_query($db, "SELECT * FROM admin WHERE type='Electricity'");
    $all_users = mysqli_num_rows($all);
    return $all_users;
  }
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />

<div class="row justify-content-center wrapper">
    <div class="col-lg-8 bg-white p-4">
        <h4 class="text-center font-weight-bold">All Admins(<?php echo allAdmins()?>)</h4>
        <a class="btn btn-dark" style="float: right;" href="Admin-Add.php">Add Admin <i class="fa fa-plus" aria-hidden="true"></i>
        </a><br>
        <hr class="my-3" />
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover" style="font-size: 14px;" id="myTable">
                <thead style="font-weight: bold;font-size: 16px;">
                    <tr>
                        <td style="text-align: center;">UserName</td>
                        <td>Full Name</td>
                        <td style="text-align: center;">NIC Number</td>
                        <td style="text-align: center;">Contact</td>
                        <td >Email</td>
                    </tr>
                </thead>
                <?php
            $records = mysqli_query($link,"SELECT * FROM admin WHERE type='Electricity'");

            while($data=mysqli_fetch_array($records)){
                ?>
                <tr >
                    <td style="text-align: center;">
                        <?php
                    if($data['gender'] == "Male"){?>
                        <img src="https://img.icons8.com/color/60/000000/administrator-male--v1.png" />
                        <?php
                    }

                    else if($data['gender'] == "Female"){?>
                        <img src="https://img.icons8.com/color/60/000000/administrator-female.png" />
                        <?php
                    }

                    else{?>
                        <img src="https://img.icons8.com/material-rounded/60/000000/user.png" />
                        <?php
                    }

                    ?>
                        &nbsp;<br><?php echo $data['admin_username'];?>
                    </td>
                    <td ><?php echo $data['admin_fullname'];?></td>
                    <td style="text-align: center;"><?php echo $data['admin_nic'];?></td>
                    <td style="text-align: center;"><?php echo $data['admin_contact'];?></td>
                    <td><?php echo $data['admin_email'];?></td>
                <?php
            }

        ?>
            </table>
        </div>
    </div>
</div>

<style>
.page-link,
.page-link:hover {
    color: #002366;
    text-decoration: none;
}
</style>

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