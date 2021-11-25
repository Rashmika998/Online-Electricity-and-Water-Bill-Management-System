<?php
require_once 'User-Header.php';
$uid = $_SESSION['user_id'];
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
<div class="row justify-content-center wrapper">
    <div class="col-lg-12 bg-white p-4">
        <div class="row gutters-sm">

            <div class=" col-md-6 mb-3">
                <div class="card border shadow-lg p-2">
                    <h4 class="text-center font-weight-bold">Activity Log</h4>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-striped table-hover" style="font-size: 14px;" id="actTable">
                                <thead>
                                    <tr>
                                        <th >Activity</th>
                                    </tr>
                                </thead>
                                <?php
            $activity = "SELECT * FROM activity_log WHERE user_id='" . $uid . "'";
            $record_activity = mysqli_query($link, $activity);

            while($data_activity = mysqli_fetch_array($record_activity)){
                ?>
                                <tr>
                                    <td>
                                    <i class="fa fa-comment" aria-hidden="true"></i>&nbsp;<?php echo $data_activity['updated'];?>&nbsp;&nbsp;&nbsp;<?php echo $data_activity['message']; ?>
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

            <div class=" col-md-6 mb-3">
                <div class="card border shadow-lg p-2">
                    <h4 class="text-center font-weight-bold">Notifications</h4>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-striped table-hover" style="font-size: 14px;" id="notiTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Month</th>
                                        <th style="text-align: center;">Message</th>
                                        <th style="text-align: center;">Updated</th>
                                    </tr>
                                </thead>
                                <?php
            $noti = "SELECT * FROM notifications WHERE user_id='" . $uid . "'";
            $record_noti = mysqli_query($link, $noti);

            while($data_notification = mysqli_fetch_array($record_noti)){
                ?>
                                <tr>
                                    <td>
                                        <?php echo $data_notification['month']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data_notification['message']; ?>
                                    </td>
                                    <td><?php echo $data_notification['date_time']; ?></td>
                                </tr>
                                <?php
                $update = "UPDATE notifications SET view = 'Yes' WHERE user_id = '$uid'";
                mysqli_query($link,$update);
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

<script src="../../vendor.bundle.base.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/sc-2.0.3/sp-1.2.2/datatables.min.js">
</script>
<script>
$(document).ready(function() {
    $('#notiTable').DataTable();
});
$(document).ready(function() {
    $('#actTable').DataTable();
});
</script>

<?php
require_once 'User-Footer.php';