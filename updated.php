<?php
session_start();
$panel = isset($_SESSION['pid']) ? 'admin-panel.php' : (isset($_SESSION['dname']) ? 'doctor-panel.php' : 'admin-panel1.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Updated — Patel Hospitals</title>
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="theme.css">
  <style>body{background:linear-gradient(160deg,var(--navy),var(--navy-mid));min-height:100vh;display:flex;align-items:center;justify-content:center;color:white;text-align:center;}</style>
</head>
<body>
  <div>
    <div style="font-size:60px;margin-bottom:20px;"><i class="fa fa-check-circle" style="color:var(--teal-light);"></i></div>
    <h3 style="font-family:'Cormorant Garamond',serif;font-size:2rem;margin-bottom:12px;">Record Updated Successfully!</h3>
    <p style="color:rgba(255,255,255,0.6);margin-bottom:30px;">The payment status has been updated in the system.</p>
    <a href="<?php echo $panel; ?>" class="btn-primary-hms" style="text-decoration:none;display:inline-flex;"><i class="fa fa-arrow-left"></i> Go to Dashboard</a>
  </div>
</body>
</html>
