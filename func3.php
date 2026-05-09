<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$con = mysqli_connect("localhost","root","","myhmsdb");

// RECEPTIONIST LOGIN
if(isset($_POST['adsub'])){
    $username = mysqli_real_escape_string($con,$_POST['username1']);
    $password = mysqli_real_escape_string($con,$_POST['password2']);
    $result   = mysqli_query($con,"select * from admintb where username='$username' and password='$password'");
    if(mysqli_num_rows($result) == 1){
        $_SESSION['username'] = $username;
        header("Location:admin-panel1.php");
    } else {
        echo "<script>alert('Invalid Username or Password. Try Again!'); window.location.href='index.php';</script>";
    }
}

// PAYMENT STATUS UPDATE
if(isset($_POST['update_data'])){
    $contact = mysqli_real_escape_string($con,$_POST['contact']);
    $status  = mysqli_real_escape_string($con,$_POST['status']);
    $result  = mysqli_query($con,"update appointmenttb set payment='$status' where contact='$contact'");
    if($result) header("Location:updated.php");
}

if(!function_exists('display_docs')){
function display_docs(){
    global $con;
    $result = mysqli_query($con,"select * from doctb order by username");
    while($row = mysqli_fetch_array($result)){
        $username = htmlspecialchars($row['username']);
        $fees     = htmlspecialchars($row['docFees']);
        $spec     = htmlspecialchars($row['spec']);
        echo '<option value="'.$username.'" data-value="'.$fees.'" data-spec="'.$spec.'">'.$username.' ('.$spec.') - &#x20B9;'.$fees.'</option>';
    }
}
}

// ADD DOCTOR (minimal — used by old admin panel form)
if(isset($_POST['doc_sub'])){
    $name   = mysqli_real_escape_string($con,$_POST['name']);
    $result = mysqli_query($con,"insert into doctb(username) values('$name')");
    if($result) header("Location:adddoc.php");
}
?>
