<?php
$con = mysqli_connect("localhost","root","","myhmsdb");
include("newfunc.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Appointment Search</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<?php
if(isset($_POST['app_search_submit'])){
    $contact = mysqli_real_escape_string($con,$_POST['app_contact']);
    $result  = mysqli_query($con,"select * from appointmenttb where contact='$contact';");
    $row     = mysqli_fetch_array($result);
    if(empty($row['fname']) && empty($row['contact'])){
        echo "<script>alert('No entries found! Please enter valid details');window.location.href='admin-panel1.php';</script>";
    } else {
        $appstatus = "Unknown";
        if($row['userStatus']==1 && $row['doctorStatus']==1) $appstatus="Active";
        if($row['userStatus']==0 && $row['doctorStatus']==1) $appstatus="Cancelled by Patient";
        if($row['userStatus']==1 && $row['doctorStatus']==0) $appstatus="Cancelled by Doctor";
        echo "<div class='container-fluid' style='margin-top:50px;'><div class='card'><div class='card-body' style='background-color:#342ac1;color:#fff;'>
        <table class='table table-hover'>
        <thead><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Contact</th><th>Doctor</th><th>Fees</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
        <tbody><tr>
        <td>".htmlspecialchars($row['fname'])."</td><td>".htmlspecialchars($row['lname'])."</td>
        <td>".htmlspecialchars($row['email'])."</td><td>".htmlspecialchars($row['contact'])."</td>
        <td>".htmlspecialchars($row['doctor'])."</td><td>".htmlspecialchars($row['docFees'])."</td>
        <td>".htmlspecialchars($row['appdate'])."</td><td>".htmlspecialchars($row['apptime'])."</td>
        <td>$appstatus</td>
        </tr></tbody></table>
        <center><a href='admin-panel1.php' class='btn btn-light'>Back to Dashboard</a></center>
        </div></div></div>";
    }
}
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
