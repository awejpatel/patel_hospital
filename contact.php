<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$con = mysqli_connect("localhost","root","","myhmsdb");

if(isset($_POST['btnSubmit'])){
    $name    = mysqli_real_escape_string($con, $_POST['txtName']);
    $email   = mysqli_real_escape_string($con, $_POST['txtEmail']);
    $contact = mysqli_real_escape_string($con, $_POST['txtPhone']);
    $message = mysqli_real_escape_string($con, $_POST['txtMsg']);

    $result = mysqli_query($con,"insert into contact(name,email,contact,message) values('$name','$email','$contact','$message')");
    if($result){
        echo '<script>alert("Message sent successfully! We will get back to you shortly."); window.location.href="contact.html";</script>';
    } else {
        echo '<script>alert("Unable to send message. Please try again."); window.location.href="contact.html";</script>';
    }
}
?>
