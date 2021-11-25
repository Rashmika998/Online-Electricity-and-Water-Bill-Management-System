<?php
require_once '../../Config.php';
$user_name = $_SESSION['user_uname'];
$sql = "SELECT * FROM users WHERE user_name='" . $user_name . "'";
$records = mysqli_query($link, $sql);
$data = mysqli_fetch_assoc($records);
$uid = $data['user_id'];
?>

<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden;">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>

<head>

    <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            includedLanguages: 'en,si,ta',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
    </script>

    <link rel="stylesheet" type=text/css
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


    <link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">

    <title> <?= basename($_SERVER['PHP_SELF'], '.php') ?> </title>

</head>

<body style="overflow-x: hidden;">
    <div class="main_container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <h3>OEAWBMS-Water Bill</h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="User-Dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="User-Register.php">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Image-Upload.php">Upload-Image</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="User-Pay.php">Payments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Notifications.php">Notifications</a>
                        </li>

                    </ul>

                    <div class="d-flex">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item ">
                                <?php
                                $sql_noti = "SELECT * FROM notifications WHERE user_id='" . $uid . "'";
                                $records_noti = mysqli_query($link, $sql_noti);
                                $data_noti = mysqli_fetch_assoc($records_noti);
                                if($data_noti['view'] == 'No'){
                                    ?>
                                <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    style="display: inline-block;position: relative;"
                                    data-bs-target="#notificationModal">
                                    <i class="fa fa-bell" aria-hidden="true"></i>&nbsp;
                                    <span class="badge" style="position: absolute;top: 0;right: 0;">
                                        <div class="spinner-grow text-light" role="status"
                                            style="width: 10px;height: 10px;">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </span>
                                </a>
                                <!-- Modal -->
                                <div class="modal fade" id="notificationModal" tabindex="-1"
                                    aria-labelledby="notificationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="notificationModalLabel">
                                                    Notifications&nbsp;<i class="fa fa-bell" aria-hidden="true"></i>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <td>
                                                    <i class="fa fa-comment" aria-hidden="true"></i>&nbsp;You have new
                                                    notification!. <a href="Notifications.php"
                                                        style="text-decoration: none;">See it in here</a>
                                                </td>
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

                                else{
                                    ?>
                                <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    style="display: inline-block;position: relative;"
                                    data-bs-target="#notificationModal">
                                    <i class="fa fa-bell" aria-hidden="true"></i>
                                </a>
                                <!-- Modal -->
                                <div class="modal fade" id="notificationModal" tabindex="-1"
                                    aria-labelledby="notificationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="notificationModalLabel">
                                                    Notifications&nbsp;<i class="fa fa-bell" aria-hidden="true"></i>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

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
                            </li>
                            <div class="bg-primary" id="google_translate_element" style="padding-left: 35px;padding-right: 15px;color:white">Language
                            </div>
                            <li class="nav-item ">
                                <a class="nav-link "
                                    href="User-Logout.php"><?php echo $user_name;?>&nbsp;(Logout&nbsp;<i
                                        class="fa fa-sign-out" aria-hidden="true"></i>)</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <script>
        $('document').ready(function() {

            $('#google_translate_element').on("click", function() {

                // Change font family and color
                $("iframe").contents().find(
                        ".goog-te-menu2-item div, .goog-te-menu2-item:link div, .goog-te-menu2-item:visited div, .goog-te-menu2-item:active div"
                    ) //, .goog-te-menu2 *
                    .css({
                        'color': 'red',
                        'background-color': '#ff0800',
                        'font-family': 'sans-serif'
                    });

                // Change Google's default blue border
                $("iframe").contents().find('.goog-te-menu2').css('border', '1px solid red');

                $("iframe").contents().find('.goog-te-menu2').css('background-color', 'red');

                // Change the iframe's box shadow
                $(".goog-te-menu-frame").css({
                    '-moz-box-shadow': '0 3px 8px 2px #666666',
                    '-webkit-box-shadow': '0 3px 8px 2px #666',
                    'box-shadow': '0 3px 8px 2px #666'
                });
            });
        });
        </script>

        <style>
        /* OVERRIDE GOOGLE TRANSLATE WIDGET CSS BEGIN */
        div#google_translate_element div.goog-te-gadget-simple {
            border: none;
            background-color: #2A52BE;
            /*#e3e3ff*/
        }

        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value:hover {
            text-decoration: none;
        }

        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span {
            color: #aaa;
        }

        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span:hover {
            color: white;
        }

        .goog-te-gadget-icon {
            display: none !important;
            /*background: url("url for the icon") 0 0 no-repeat !important;*/
        }

        /* Remove the down arrow */
        /* when dropdown open */
        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="color: rgb(213, 213, 213);"] {
            display: none;
        }

        /* after clicked/touched */
        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="color: rgb(118, 118, 118);"] {
            display: none;
        }

        /* on page load (not yet touched or clicked) */
        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="color: rgb(155, 155, 155);"] {
            display: none;
        }

        /* Remove span with left border line | (next to the arrow) in Chrome & Firefox */
        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="border-left: 1px solid rgb(187, 187, 187);"] {
            display: none;
        }

        /* Remove span with left border line | (next to the arrow) in Edge & IE11 */
        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="border-left-color: rgb(187, 187, 187); border-left-width: 1px; border-left-style: solid;"] {
            display: none;
        }

        /* HIDE the google translate toolbar */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        /* OVERRIDE GOOGLE TRANSLATE WIDGET CSS END */
        </style>