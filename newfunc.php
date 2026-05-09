<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$con = mysqli_connect("localhost","root","","myhmsdb");

// PAYMENT STATUS UPDATE
if(isset($_POST['update_data'])){
    $contact = mysqli_real_escape_string($con,$_POST['contact']);
    $status  = mysqli_real_escape_string($con,$_POST['status']);
    $result  = mysqli_query($con,"update appointmenttb set payment='$status' where contact='$contact'");
    if($result) header("Location:updated.php");
}

// FIX: returns distinct specs from doctb
function display_specs(){
    global $con;
    $result = mysqli_query($con,"select distinct spec from doctb order by spec");
    while($row = mysqli_fetch_array($result)){
        $spec = htmlspecialchars($row['spec']);
        echo '<option value="'.$spec.'">'.$spec.'</option>';
    }
}

if(!function_exists('display_docs')){
function display_docs(){
    global $con;
    $result = mysqli_query($con,"select * from doctb order by username");
    while($row = mysqli_fetch_array($result)){
        $username = htmlspecialchars($row['username']);
        $price    = htmlspecialchars($row['docFees']);
        $spec     = htmlspecialchars($row['spec']);
        echo '<option value="'.$username.'" data-value="'.$price.'" data-spec="'.$spec.'">'
             .$username.' ('.$spec.') - &#x20B9;'.$price.'</option>';
    }
}
}

if(isset($_POST['doc_sub'])){
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $result   = mysqli_query($con,"insert into doctb(username) values('$username')");
    if($result) header("Location:adddoc.php");
}
?>
