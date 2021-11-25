<?php
require_once '../../Config.php';

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

  $name_err = $username_err = $new_password_err = $email_err = $confirm_password_err = $confirm_password_err = $nic_err = $contact_err = "";

?>

<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden;">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">

    <title>Admin Panel | <?= basename($_SERVER['PHP_SELF'], '.php') ?> </title>

</head>

<body style="overflow-x: hidden;">

    <div class="main_container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <h3>OEAWBMS-WATER BILL</h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="Admin-Dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="View-Users.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="View-Bills.php">Bills</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="View-Admins.php">Admins</a>
                        </li>
                        
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="Electricity-Tariffs.php">Electricity-Tariffs</a>
                        </li> -->
                    </ul>

                    <div class="d-flex">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item ">
                                <!-- First modal dialog -->
                                <div class="modal fade p-2" id="modal" aria-hidden="true" aria-labelledby="..."
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark" style="color: white;">
                                                <h5 class="modal-title">Profile - <?php echo $_SESSION['admin_uname'];?></h5>
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                                                    style="color: white;" aria-label="Close"><i class="fa fa-times"
                                                        aria-hidden="true"></i></button>
                                            </div>
                                            <div class="d-flex flex-column align-items-center text-center">
                                                
                                                <?php
                    if($data['gender'] == "Male"){?>
                                                <img
                                                    src="https://img.icons8.com/color/120/000000/administrator-male--v1.png" />
                                                <?php
                    }

                    else if($data['gender'] == "Female"){?>
                                                <img
                                                    src="https://img.icons8.com/color/120/000000/administrator-female.png" />
                                                <?php
                    }

                    else{?>
                                                <img src="https://img.icons8.com/material-rounded/120/000000/user.png" />
                                                <?php
                    }

                    ?>
                                            </div><br><br>
                                            <div class="col-md-14" style="padding-right: 15px;padding-left: 15px;">
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <h6 class="mb-0">Full Name</h6>
                                                            </div>
                                                            <div class="col-sm-9 text-secondary">
                                                                <?php echo $data['admin_fullname'] ?>
                                            </div>
                                        </div>
                                        <hr>
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
                                                <?php echo $data['admin_nic'] ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email Address</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $data['admin_email'] ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Contact Number</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?php echo $data['admin_contact'] ?>
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
                    <div class="modal-footer">
                        <!-- Toogle to second dialog -->
                        <button class="btn btn-success" data-bs-target="#modal2" data-bs-toggle="modal"
                            data-bs-dismiss="modal">Edit Profile&nbsp;<i class="fa fa-pencil-square-o"
                                aria-hidden="true"></i></button>

                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editPasswordModal" data-bs-dismiss="modal">
                            Change Password&nbsp;<i class="fa fa-unlock-alt" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
    </div>
    <!-- Second modal dialog -->
    <div class="modal fade" id="modal2" aria-hidden="true" aria-labelledby="..." tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark" style="color: white;">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" style="color: white;"
                        aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>

                </div>
                <div class="modal-body" style="text-align: left;">
                    <form action="Edit.php" method="POST" class="px-3 needs-validation">

                        <div class="form-group">
                            <label>Admin Fullname</label>
                            <input type="text" class="form-control" name="admin_fullname"
                                value="<?php echo $data['admin_fullname']; ?>">
                            <span class="help-block"><?php echo $name_err; ?></span>
                        </div><br>

                        <div class="form-group">
                            <label>Admin Username</label>
                            <input type="text" class="form-control" name="admin_username"
                                value="<?php echo $data['admin_username']; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div><br>
                        <div class="form-group">
                            <label>Gender</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div><br>

                        <div class="form-group">
                            <label>NIC Number</label>
                            <input type="text" class="form-control" name="admin_nic"
                                value="<?php echo $data['admin_nic'] ?>">
                            <span class="help-block"><?php echo $nic_err; ?></span>

                        </div><br>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="admin_email" placeholder="Enter Email"
                                value="<?php echo $data['admin_email']; ?>">
                            <span class="help-block"><?php echo $email_err; ?></span>
                        </div><br>

                        <div class="form-group">
                            <label>Contact No</label>
                            <input type="text" class="form-control" name="admin_contact"
                                placeholder="Enter a Contact Number" value="<?php echo $data['admin_contact']; ?>">
                            <span class="help-block"><?php echo $contact_err; ?></span>
                        </div><br>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save changes</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark" style="color: white;">
                    <h5 class="modal-title" id="editPasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" style="color: white;"
                        aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div class="modal-body" style="text-align: left;">
                    <form action="Edit-Password.php" method="POST" class="px-3 needs-validation">

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control">
                            <span class="help-block"><?php echo $new_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control">
                            <span class="help-block"><?php echo $confirm_password_err; ?></span>
                        </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">Save changes</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Open first dialog -->
    <a class="btn btn-primary" data-bs-toggle="modal" href="#modal" role="button">
        <?php echo $_SESSION['admin_uname'];?>
        <?php
                    if($data['gender'] == "Male"){?>
        <img src="https://img.icons8.com/color/40/000000/administrator-male--v1.png" />
        <?php
                    }

                    else if($data['gender'] == "Female"){?>
        <img src="https://img.icons8.com/color/40/000000/administrator-female.png" />
        <?php
                    }

                    else{?>
        <img src="https://img.icons8.com/material-rounded/40/000000/user.png" />
        <?php
                    }

                    ?></a>

    </li>
    <li class="nav-item ">
        <a class="nav-link " href="Admin-Logout.php">&nbsp;Logout&nbsp;<i class="fa fa-sign-out"
                aria-hidden="true"></i></a>
    </li>
    </ul>
    </div>
    <!-- <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->
    </div>
    </div>
    </nav>
    <script src="../../vendor.bundle.base.js"></script>
    <script>
    $(function() {
        setNavigation();
    });

    function setNavigation() {
        var path = window.location.pathname;
        path = path.replace(/\/$/, "");
        path = decodeURIComponent(path);

        $(".navbar a").each(function() {
            var href = $(this).attr('href');
            if (path.substring(0, href.length) === href) {
                $(this).closest('li').addClass('active');
            }
        });

    }
    </script>