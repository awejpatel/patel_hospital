<?php
$con = mysqli_connect("localhost","root","","myhmsdb");
include("newfunc.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Doctor Details</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<?php
if(isset($_POST['doctor_search_submit'])){
    $email  = mysqli_real_escape_string($con,$_POST['doctor_contact']);
    $result = mysqli_query($con,"select * from doctb where email='$email'");
    $row    = mysqli_fetch_array($result);
    if(empty($row['username']) && empty($row['email'])){
        echo "<script>alert('No entries found!');window.location.href='admin-panel1.php';</script>";
    } else {
        echo "<div class='container-fluid' style='margin-top:50px;'><div class='card'><div class='card-body' style='background-color:#342ac1;color:#fff;'>
        <table class='table table-hover'>
        <thead><tr><th>Username</th><th>Email</th><th>Consultancy Fees</th></tr></thead>
        <tbody><tr>
        <td>".htmlspecialchars($row['username'])."</td>
        <td>".htmlspecialchars($row['email'])."</td><td>".htmlspecialchars($row['docFees'])."</td>
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
