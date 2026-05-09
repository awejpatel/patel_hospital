<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Doctor Added — Patel Hospitals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="theme.css">
  <style>body{background:linear-gradient(160deg,var(--navy),var(--navy-mid));min-height:100vh;display:flex;align-items:center;justify-content:center;color:white;text-align:center;}</style>
</head>
<body>
  <div>
    <div style="font-size:60px;margin-bottom:20px;"><i class="fa fa-check-circle" style="color:var(--teal-light);"></i></div>
    <h3 style="font-family:'Cormorant Garamond',serif;font-size:2rem;margin-bottom:12px;">Doctor Added Successfully!</h3>
    <p style="color:rgba(255,255,255,0.6);margin-bottom:30px;">The new doctor has been registered in the system.</p>
    <!-- FIX: redirect to admin-panel1.php (receptionist panel) not func.php -->
    <a href="admin-panel1.php" class="btn-primary-hms" style="text-decoration:none;display:inline-flex;"><i class="fa fa-arrow-left"></i> Back to Admin Panel</a>
  </div>
</body>
</html>
