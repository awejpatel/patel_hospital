<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$con = mysqli_connect("localhost","root","","myhmsdb");

// PATIENT REGISTRATION
if(isset($_POST['patsub1'])){
    $fname    = mysqli_real_escape_string($con,$_POST['fname']);
    $lname    = mysqli_real_escape_string($con,$_POST['lname']);
    $gender   = mysqli_real_escape_string($con,$_POST['gender']);
    $email    = mysqli_real_escape_string($con,$_POST['email']);
    $contact  = mysqli_real_escape_string($con,$_POST['contact']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $cpassword= mysqli_real_escape_string($con,$_POST['cpassword']);

    if($password == $cpassword){
        // FIX: check for duplicate email before inserting
        $dup = mysqli_query($con,"select pid from patreg where email='$email'");
        if(mysqli_num_rows($dup) > 0){
            echo "<script>alert('This email is already registered. Please sign in instead.'); window.location.href='index1.php';</script>";
            exit();
        }
        // FIX: hash password before storing
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $hashed_escaped = mysqli_real_escape_string($con, $hashed);
        $query = "insert into patreg(fname,lname,gender,email,contact,password,cpassword)
                  values('$fname','$lname','$gender','$email','$contact','$hashed_escaped','$hashed_escaped')";
        $result = mysqli_query($con,$query);
        if($result){
            $_SESSION['username'] = $fname." ".$lname;
            $_SESSION['fname']    = $fname;
            $_SESSION['lname']    = $lname;
            $_SESSION['gender']   = $gender;
            $_SESSION['contact']  = $contact;
            $_SESSION['email']    = $email;
            $_SESSION['pid']      = mysqli_insert_id($con);
            header("Location:admin-panel.php");
        } else {
            echo "<script>alert('Registration failed. Please try again.'); window.location.href='index.php';</script>";
        }
    } else {
        header("Location:error1.php");
    }
}

// PAYMENT STATUS UPDATE
if(isset($_POST['update_data'])){
    $contact = mysqli_real_escape_string($con,$_POST['contact']);
    $status  = mysqli_real_escape_string($con,$_POST['status']);
    $result  = mysqli_query($con,"update appointmenttb set payment='$status' where contact='$contact'");
    if($result) header("Location:updated.php");
}

// ADD DOCTOR (full fields)
if(isset($_POST['doc_sub'])){
    $doctor   = mysqli_real_escape_string($con,$_POST['doctor']);
    $dpassword= mysqli_real_escape_string($con,$_POST['dpassword']);
    $demail   = mysqli_real_escape_string($con,$_POST['demail']);
    $spec     = mysqli_real_escape_string($con, isset($_POST['spec']) ? $_POST['spec'] : 'General');
    $docFees  = (int)$_POST['docFees'];
    $result   = mysqli_query($con,"insert into doctb(username,password,email,spec,docFees) values('$doctor','$dpassword','$demail','$spec',$docFees)");
    if($result) header("Location:adddoc.php");
}

if(!function_exists('display_docs')){
function display_docs(){
    global $con;
    $result = mysqli_query($con,"select * from doctb");
    while($row = mysqli_fetch_array($result)){
        $username = htmlspecialchars($row['username']);
        $fees     = htmlspecialchars($row['docFees']);
        $spec     = htmlspecialchars($row['spec']);
        echo '<option value="'.$username.'" data-value="'.$fees.'" data-spec="'.$spec.'">'.$username.' ('.$spec.') - ₹'.$fees.'</option>';
    }
}
}
?>
