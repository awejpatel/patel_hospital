<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logged Out — Patel Hospitals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="theme.css">
  <style>body{background:linear-gradient(160deg,var(--navy),var(--navy-mid));min-height:100vh;display:flex;align-items:center;justify-content:center;color:white;text-align:center;}</style>
</head>
<body>
  <div>
    <div style="font-size:60px;margin-bottom:20px;"><i class="fa fa-sign-out" style="color:var(--gold);"></i></div>
    <h3 style="font-family:'Cormorant Garamond',serif;font-size:2rem;margin-bottom:12px;">You have been logged out.</h3>
    <p style="color:rgba(255,255,255,0.6);margin-bottom:30px;">Thank you for using Patel Hospitals HMS.</p>
    <a href="index1.php" class="btn-primary-hms" style="text-decoration:none;display:inline-flex;"><i class="fa fa-sign-in"></i> Back to Login</a>
  </div>
</body>
</html>
