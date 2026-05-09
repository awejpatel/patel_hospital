<?php
$con = mysqli_connect("localhost","root","","myhmsdb");
include("newfunc.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>User Messages</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<?php
if(isset($_POST['mes_search_submit'])){
    $contact = mysqli_real_escape_string($con,$_POST['mes_contact']);
    $result  = mysqli_query($con,"select * from contact where contact='$contact'");
    $row     = mysqli_fetch_array($result);
    if(empty($row['name']) && empty($row['contact'])){
        echo "<script>alert('No entries found! Please enter valid details');window.location.href='admin-panel1.php';</script>";
    } else {
        echo "<div class='container-fluid' style='margin-top:50px;'><div class='card'><div class='card-body' style='background:linear-gradient(135deg,#1e1b4b,#3730a3);color:#fff;'>
        <table class='table table-hover'>
        <thead><tr><th>User Name</th><th>Email</th><th>Contact</th><th>Message</th></tr></thead>
        <tbody><tr>
        <td>".htmlspecialchars($row['name'])."</td><td>".htmlspecialchars($row['email'])."</td>
        <td>".htmlspecialchars($row['contact'])."</td><td>".htmlspecialchars($row['message'])."</td>
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
