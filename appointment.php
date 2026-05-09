<?php
// appointment.php — handles appointment booking from admin-panel (receptionist)
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$con = mysqli_connect("localhost","root","","myhmsdb");
include('newfunc.php');

if(isset($_POST['entry_submit'])){
    $fname   = mysqli_real_escape_string($con,$_POST['fname']);
    $lname   = mysqli_real_escape_string($con,$_POST['lname']);
    $email   = mysqli_real_escape_string($con,$_POST['email']);
    $contact = mysqli_real_escape_string($con,$_POST['contact']);
    $doctor  = mysqli_real_escape_string($con,$_POST['doctor']);
    $payment = mysqli_real_escape_string($con,$_POST['payment']);

    // Look up doctor fees
    $dr = mysqli_fetch_array(mysqli_query($con,"select docFees from doctb where username='$doctor'"));
    $docFees = $dr ? (int)$dr['docFees'] : 0;

    // Get or create patient record
    $pat = mysqli_fetch_array(mysqli_query($con,"select pid from patreg where contact='$contact'"));
    if($pat){
        $pid = (int)$pat['pid'];
    } else {
        // Create minimal patient record
        mysqli_query($con,"insert into patreg(fname,lname,email,contact,gender,password,cpassword) values('$fname','$lname','$email','$contact','Unknown','','')");
        $pid = (int)mysqli_insert_id($con);
    }

    $appdate = date("Y-m-d"); // default today; receptionist can modify
    $apptime = "10:00:00";

    $q = mysqli_query($con,"insert into appointmenttb(pid,fname,lname,gender,email,contact,doctor,docFees,appdate,apptime,payment,userStatus,doctorStatus)
        values($pid,'$fname','$lname','Unknown','$email','$contact','$doctor',$docFees,'$appdate','$apptime','$payment',1,1)");
    if($q){
        echo "<script>alert('Appointment created successfully!'); window.location.href='admin-panel1.php';</script>";
    } else {
        echo "<script>alert('Error creating appointment: ".mysqli_error($con)."'); window.history.back();</script>";
    }
} else {
    header("Location: admin-panel1.php");
}
?>
