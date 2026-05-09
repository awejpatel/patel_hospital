<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$con = mysqli_connect("localhost","root","","myhmsdb");

// PATIENT LOGIN
if(isset($_POST['patsub'])){
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password2'];

    // Fetch patient by email only
    $result = mysqli_query($con, "select * from patreg where email='$email'");

    if(mysqli_num_rows($result) == 1){
        $row    = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $stored = $row['password'];

        // Support both hashed (new) and plaintext (legacy) passwords
        $valid = password_verify($password, $stored) || ($password === $stored);

        if($valid){
            $_SESSION['pid']      = $row['pid'];
            $_SESSION['username'] = $row['fname'] . " " . $row['lname'];
            $_SESSION['fname']    = $row['fname'];
            $_SESSION['lname']    = $row['lname'];
            $_SESSION['gender']   = $row['gender'];
            $_SESSION['contact']  = $row['contact'];
            $_SESSION['email']    = $row['email'];
            $_SESSION['role']     = 'patient';
            header("Location: admin-panel.php");
            exit();
        } else {
            echo "<script>alert('Invalid Email or Password. Please try again.'); window.location.href='index1.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid Email or Password. Please try again.'); window.location.href='index1.php';</script>";
        exit();
    }
}

// PAYMENT STATUS UPDATE
if(isset($_POST['update_data'])){
    $contact = mysqli_real_escape_string($con,$_POST['contact']);
    $status  = mysqli_real_escape_string($con,$_POST['status']);
    $result  = mysqli_query($con,"update appointmenttb set payment='$status' where contact='$contact'");
    if($result) header("Location:updated.php");
}

// ADD DOCTOR
if(isset($_POST['doc_sub'])){
    $doctor   = mysqli_real_escape_string($con,$_POST['doctor']);
    $dpassword= mysqli_real_escape_string($con,$_POST['dpassword']);
    $demail   = mysqli_real_escape_string($con,$_POST['demail']);
    $spec     = mysqli_real_escape_string($con, isset($_POST['spec']) ? $_POST['spec'] : 'General');
    $docFees  = (int)$_POST['docFees'];
    $result   = mysqli_query($con,"insert into doctb(username,password,email,spec,docFees) values('$doctor','$dpassword','$demail','$spec',$docFees)");
    if($result) header("Location:adddoc.php");
}

?>
