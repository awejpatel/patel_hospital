<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$con = mysqli_connect("localhost","root","","myhmsdb");
if(isset($_POST['docsub1'])){
    $dname = mysqli_real_escape_string($con,$_POST['username3']);
    $dpass = mysqli_real_escape_string($con,$_POST['password3']);
    $result= mysqli_query($con,"select * from doctb where username='$dname' and password='$dpass';");
    if(mysqli_num_rows($result)==1){
        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $_SESSION['dname'] = $row['username'];
        }
        header("Location:doctor-panel.php");
    } else {
        echo "<script>alert('Invalid Username or Password. Try Again!');window.location.href='index.php';</script>";
    }
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
?>
