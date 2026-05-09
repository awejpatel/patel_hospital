<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Patel Hospitals — HMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="theme.css" />
  <style>
    body { background: #f0ede8; }
    .hms-page { min-height: 100vh; display: flex; padding-top: 70px; }
    .left-panel {
      width: 42%; min-height: calc(100vh - 70px);
      background: linear-gradient(160deg, var(--navy) 0%, var(--navy-mid) 50%, #133452 100%);
      position: relative; overflow: hidden;
      display: flex; flex-direction: column; justify-content: center; padding: 60px 52px;
    }
    .left-panel::before {
      content: ''; position: absolute; top: -100px; right: -100px;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(13,110,110,0.3) 0%, transparent 70%); pointer-events: none;
    }
    .left-badge {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(201,168,76,0.12); border: 1px solid rgba(201,168,76,0.3);
      border-radius: 20px; padding: 6px 16px; color: var(--gold);
      font-size: 12px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase;
      margin-bottom: 32px; width: fit-content;
    }
    .left-panel h2 {
      font-family: 'Cormorant Garamond', serif; font-size: clamp(36px, 3.5vw, 52px);
      font-weight: 700; color: var(--white); line-height: 1.15; margin-bottom: 20px;
    }
    .left-panel h2 em { font-style: normal; color: var(--gold); }
    .left-panel > p {
      font-size: 15px; font-weight: 300; color: rgba(255,255,255,0.6);
      line-height: 1.8; margin-bottom: 44px; max-width: 360px;
    }
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 44px; }
    .stat-card {
      background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);
      border-radius: 12px; padding: 18px 14px; text-align: center;
      backdrop-filter: blur(4px); transition: background 0.2s;
    }
    .stat-card:hover { background: rgba(255,255,255,0.09); }
    .stat-card .icon {
      width: 36px; height: 36px; background: linear-gradient(135deg, var(--teal), var(--teal-light));
      border-radius: 8px; display: flex; align-items: center; justify-content: center;
      font-size: 14px; color: white; margin: 0 auto 10px;
    }
    .stat-card strong { display: block; font-size: 22px; font-weight: 700; color: var(--white); font-family: 'Cormorant Garamond', serif; }
    .stat-card span { font-size: 10px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.45); }
    .accreditation { display: flex; align-items: center; gap: 12px; padding-top: 32px; border-top: 1px solid rgba(255,255,255,0.08); }
    .accreditation-dot { width: 8px; height: 8px; background: var(--teal-light); border-radius: 50%; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100% { box-shadow: 0 0 0 0 rgba(25,169,157,0.4); } 50% { box-shadow: 0 0 0 8px rgba(25,169,157,0); } }
    .accreditation span { font-size: 12px; color: rgba(255,255,255,0.5); letter-spacing: 0.5px; }
    .right-panel { flex: 1; display: flex; align-items: center; justify-content: center; padding: 48px 52px; background: var(--cream); }
    .register-box { width: 100%; max-width: 560px; }
    .register-box h3 { font-family: 'Cormorant Garamond', serif; font-size: 34px; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
    .register-box .subtext { font-size: 14px; color: var(--text-mid); font-weight: 300; margin-bottom: 36px; }
    .tab-switcher { display: flex; background: rgba(10,22,40,0.06); border-radius: 10px; padding: 5px; margin-bottom: 36px; gap: 4px; }
    .tab-btn { flex: 1; padding: 10px 8px; border: none; background: transparent; border-radius: 7px; font-size: 13px; font-weight: 500; color: var(--text-mid); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.25s; font-family: 'Outfit', sans-serif; }
    .tab-btn.active { background: var(--navy); color: var(--white); box-shadow: 0 2px 12px rgba(10,22,40,0.2); }
    .tab-btn:not(.active):hover { background: rgba(10,22,40,0.08); }
    .tab-pane-custom { display: none; }
    .tab-pane-custom.active { display: block; }
    .form-label-hms { font-size: 12px; font-weight: 600; letter-spacing: 0.8px; text-transform: uppercase; color: var(--text-mid); display: block; margin-bottom: 6px; }
    .form-control-hms { width: 100%; padding: 12px 16px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Outfit', sans-serif; color: var(--text-dark); background: white; transition: border-color 0.2s, box-shadow 0.2s; outline: none; margin-bottom: 16px; }
    .form-control-hms:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(13,110,110,0.1); }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px; }
    .gender-row { display: flex; gap: 20px; margin-bottom: 16px; align-items: center; }
    .gender-label { display: flex; align-items: center; gap: 7px; font-size: 14px; color: var(--text-mid); cursor: pointer; }
    .gender-label input { accent-color: var(--teal); }
    .form-footer-row { display: flex; align-items: center; justify-content: space-between; margin-top: 4px; flex-wrap: wrap; gap: 12px; }
    .signin-link { font-size: 13px; color: var(--teal); text-decoration: none; font-weight: 500; }
    .signin-link:hover { text-decoration: underline; }
    .pass-match { font-size: 12px; font-weight: 600; margin-bottom: 16px; min-height: 18px; }
    @media (max-width: 900px) { .left-panel { display: none; } .right-panel { padding: 40px 24px; } .form-grid { grid-template-columns: 1fr; } }
  </style>
  <script>
    function check() {
      var p = document.getElementById('password').value;
      var c = document.getElementById('cpassword').value;
      var msg = document.getElementById('message');
      if (!c) { msg.innerHTML = ''; return; }
      if (p === c) { msg.style.color = '#0d6e6e'; msg.innerHTML = '&#10003; Passwords match'; }
      else { msg.style.color = '#e63946'; msg.innerHTML = '&#10007; Passwords do not match'; }
    }
    function alphaOnly(event) { var key = event.keyCode; return ((key >= 65 && key <= 90) || key == 8 || key == 32); }
    function checklen() { var pass1 = document.getElementById("password"); if (pass1.value.length < 6) { alert("Password must be at least 6 characters long."); return false; } }
  </script>
</head>
<body>
<nav class="hms-nav">
  <a class="nav-brand" href="index.php">
    <div class="nav-brand-icon"><i class="fa fa-heartbeat"></i></div>
    <span class="nav-brand-text">Patel <span>Hospitals</span></span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php" class="active">Home</a></li>
    <li><a href="services.html">About Us</a></li>
    <li><a href="contact.html">Contact</a></li>
  </ul>
</nav>
<div class="hms-page">
  <div class="left-panel">
    <div class="left-badge"><i class="fa fa-plus-circle"></i> Est. 1985 &nbsp;&middot;&nbsp; 40 Years of Excellence</div>
    <h2>Your Health,<br>Our <em>Mission</em></h2>
    <p>Compassionate care combined with cutting-edge medicine. Trusted by hundreds of thousands of patients across the region.</p>
    <div class="stats-grid">
      <div class="stat-card"><div class="icon"><i class="fa fa-user-md"></i></div><strong>200+</strong><span>Specialists</span></div>
      <div class="stat-card"><div class="icon"><i class="fa fa-bed"></i></div><strong>500+</strong><span>Beds</span></div>
      <div class="stat-card"><div class="icon"><i class="fa fa-clock-o"></i></div><strong>24/7</strong><span>Emergency</span></div>
    </div>
    <div class="accreditation"><div class="accreditation-dot"></div><span>NABH Accredited &nbsp;&middot;&nbsp; ISO 9001:2015 Certified</span></div>
  </div>
  <div class="right-panel">
    <div class="register-box">
      <h3>Welcome Back</h3>
      <p class="subtext">Register or sign in to manage your hospital experience.</p>
      <div class="tab-switcher">
        <button class="tab-btn active" onclick="switchTab('patient', this)"><i class="fa fa-user-plus"></i> Patient</button>
        <button class="tab-btn" onclick="switchTab('doctor', this)"><i class="fa fa-stethoscope"></i> Doctor</button>
        <button class="tab-btn" onclick="switchTab('receptionist', this)"><i class="fa fa-user-circle"></i> Receptionist</button>
      </div>
      <div class="tab-pane-custom active" id="tab-patient">
        <form method="post" action="func2.php">
          <div class="form-grid">
            <div><label class="form-label-hms">First Name</label><input type="text" class="form-control-hms" placeholder="John" name="fname" onkeydown="return alphaOnly(event);" required /></div>
            <div><label class="form-label-hms">Last Name</label><input type="text" class="form-control-hms" placeholder="Patel" name="lname" onkeydown="return alphaOnly(event);" required /></div>
            <div><label class="form-label-hms">Email Address</label><input type="email" class="form-control-hms" placeholder="you@example.com" name="email" /></div>
            <div><label class="form-label-hms">Phone Number</label><input type="tel" minlength="10" maxlength="10" class="form-control-hms" placeholder="10-digit number" name="contact" /></div>
            <div><label class="form-label-hms">Password</label><input type="password" class="form-control-hms" placeholder="Min. 6 characters" id="password" name="password" onkeyup="check();" required /></div>
            <div><label class="form-label-hms">Confirm Password</label><input type="password" class="form-control-hms" id="cpassword" placeholder="Re-enter password" name="cpassword" onkeyup="check();" required /></div>
          </div>
          <div class="pass-match"><span id="message"></span></div>
          <div class="gender-row">
            <span class="form-label-hms" style="margin:0;">Gender:</span>
            <label class="gender-label"><input type="radio" name="gender" value="Male" checked /> Male</label>
            <label class="gender-label"><input type="radio" name="gender" value="Female" /> Female</label>
          </div>
          <div class="form-footer-row">
            <a href="index1.php" class="signin-link">Already have an account? Sign in &rarr;</a>
            <button type="submit" class="btn-primary-hms" name="patsub1" onclick="return checklen();"><i class="fa fa-check"></i> Create Account</button>
          </div>
        </form>
      </div>
      <div class="tab-pane-custom" id="tab-doctor">
        <form method="post" action="func1.php">
          <label class="form-label-hms">Username</label><input type="text" class="form-control-hms" placeholder="Doctor username" name="username3" required />
          <label class="form-label-hms">Password</label><input type="password" class="form-control-hms" placeholder="Your password" name="password3" required />
          <div class="form-footer-row" style="justify-content:flex-end; margin-top:8px;">
            <button type="submit" class="btn-primary-hms" name="docsub1"><i class="fa fa-sign-in"></i> Sign In</button>
          </div>
        </form>
      </div>
      <div class="tab-pane-custom" id="tab-receptionist">
        <form method="post" action="func3.php">
          <label class="form-label-hms">Username</label><input type="text" class="form-control-hms" placeholder="Receptionist username" name="username1" required />
          <label class="form-label-hms">Password</label><input type="password" class="form-control-hms" placeholder="Your password" name="password2" required />
          <div class="form-footer-row" style="justify-content:flex-end; margin-top:8px;">
            <button type="submit" class="btn-primary-hms" name="adsub"><i class="fa fa-sign-in"></i> Sign In</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<footer class="hms-footer">
  <div class="footer-bottom" style="max-width:100%;">
    <span>&copy; 2025 Patel Hospitals. All rights reserved.</span>
    <span>Built with <span style="color:var(--gold)">&#9829;</span> for better healthcare</span>
  </div>
</footer>
<script>
  function switchTab(name, btn) {
    document.querySelectorAll('.tab-pane-custom').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
  }
  window.addEventListener('scroll', () => { document.querySelector('.hms-nav').classList.toggle('scrolled', window.scrollY > 10); });
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
