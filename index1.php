<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
// Redirect already logged-in patients
if(isset($_SESSION['pid'])) { header("Location: admin-panel.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Patient Login — Patel Hospitals</title>
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="theme.css">
  <style>
    body { background: linear-gradient(160deg, var(--navy) 0%, var(--navy-mid) 60%, #133452 100%); min-height: 100vh; }
    .login-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 90px 16px 40px; }
    .login-card {
      background: rgba(245,240,232,0.98); border-radius: 20px;
      box-shadow: 0 28px 72px rgba(0,0,0,0.35); padding: 52px 48px;
      max-width: 440px; width: 100%; position: relative;
    }
    .login-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, var(--teal), var(--teal-light), var(--gold));
      border-radius: 20px 20px 0 0;
    }
    .login-icon {
      width: 58px; height: 58px;
      background: linear-gradient(135deg, var(--teal), var(--teal-light));
      border-radius: 14px; display: flex; align-items: center; justify-content: center;
      margin-bottom: 22px; box-shadow: 0 8px 22px rgba(13,110,110,0.4);
    }
    .login-icon i { color: white; font-size: 1.5rem; }
    .login-card h2 { font-family: 'Cormorant Garamond', serif; font-size: 1.9rem; font-weight: 700; color: var(--navy); margin-bottom: 5px; }
    .login-card .sub { font-size: 0.85rem; color: var(--text-mid); margin-bottom: 32px; font-weight: 300; }
    .lbl { font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; color: var(--text-mid); display: block; margin-bottom: 6px; }
    .form-control { border: 1.5px solid #ddd; border-radius: 8px; padding: 12px 14px; font-size: 14px; transition: border-color 0.2s, box-shadow 0.2s; }
    .form-control:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(13,110,110,0.1); outline: none; }
    .back-link { display: flex; align-items: center; gap: 6px; font-size: 0.82rem; color: var(--text-mid); text-decoration: none; margin-top: 22px; justify-content: center; transition: color 0.2s; }
    .back-link:hover { color: var(--teal); text-decoration: none; }
    .back-link strong { color: var(--teal); }
  </style>
</head>
<body>
<nav class="hms-nav">
  <a class="nav-brand" href="index.php">
    <div class="nav-brand-icon"><i class="fa fa-heartbeat"></i></div>
    <span class="nav-brand-text">Patel <span>Hospitals</span></span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="services.html">About Us</a></li>
    <li><a href="contact.html">Contact</a></li>
  </ul>
</nav>

<div class="login-wrap">
  <div class="login-card">
    <div class="login-icon"><i class="fa fa-user-circle"></i></div>
    <h2>Patient Sign In</h2>
    <p class="sub">Access your dashboard to manage appointments</p>

    <form method="POST" action="func.php">
      <div class="form-group">
        <label class="lbl">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="you@example.com" required/>
      </div>
      <div class="form-group" style="margin-bottom:28px;">
        <label class="lbl">Password</label>
        <input type="password" class="form-control" name="password2" placeholder="Enter your password" required/>
      </div>
      <button type="submit" name="patsub" class="btn-primary-hms" style="width:100%; justify-content:center;">
        <i class="fa fa-sign-in"></i> Sign In
      </button>
    </form>

    <a href="index.php" class="back-link">
      <i class="fa fa-arrow-left"></i> Don't have an account? <strong>Register here</strong>
    </a>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
