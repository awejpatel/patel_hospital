<?php
session_start();
if (!isset($_SESSION['dname'])) { header("Location: index.php"); exit(); }
include('func1.php');
$con    = mysqli_connect("localhost","root","","myhmsdb");
$doctor = mysqli_real_escape_string($con, $_SESSION['dname']);

if(isset($_GET['cancel'])){
    $q = mysqli_query($con,"update appointmenttb set doctorStatus='0' where ID='".mysqli_real_escape_string($con,$_GET['ID'])."'");
    if($q) echo "<script>alert('Appointment cancelled.');</script>";
}

// Stats
$total_app  = mysqli_num_rows(mysqli_query($con,"select ID from appointmenttb where doctor='$doctor'"));
$active_app = mysqli_num_rows(mysqli_query($con,"select ID from appointmenttb where doctor='$doctor' and userStatus=1 and doctorStatus=1"));
$today_app  = mysqli_num_rows(mysqli_query($con,"select ID from appointmenttb where doctor='$doctor' and appdate=CURDATE() and userStatus=1 and doctorStatus=1"));
$total_pres = mysqli_num_rows(mysqli_query($con,"select ID from prestb where doctor='$doctor'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Doctor Portal — Patel Hospitals</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<link rel="stylesheet" href="panel-style.css">
</head>
<body style="padding-top:56px;">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-heartbeat"></i> Patel Hospitals</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out"></i> Logout</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
      <input class="form-control mr-sm-2" type="text" placeholder="Search patient by contact..." name="contact" style="min-width:220px;">
      <button type="submit" class="btn btn-outline-light my-2 my-sm-0" name="search_submit">Search</button>
    </form>
  </div>
</nav>

<div class="container-fluid" style="margin-top:24px; padding:0 28px;">

  <div class="welcome-banner">
    <i class="fa fa-user-md fa-2x"></i>
    <div>
      <h3>Welcome, Dr. <?php echo htmlspecialchars($_SESSION['dname']); ?></h3>
      <p>Doctor Portal &mdash; Manage appointments, write prescriptions &amp; view records</p>
    </div>
  </div>

  <div class="row" style="margin:0;">

    <!-- SIDEBAR -->
    <div class="col-md-3" style="padding-right:20px; padding-left:0;">
      <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" href="#list-dash" role="tab" data-toggle="list">
          <i class="fa fa-tachometer" style="margin-right:9px;"></i>Dashboard
        </a>
        <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list">
          <i class="fa fa-calendar" style="margin-right:9px;"></i>Appointments
        </a>
        <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list">
          <i class="fa fa-file-text-o" style="margin-right:9px;"></i>Prescription List
        </a>
      </div>

      <!-- Doctor Info Card -->
      <div style="background:#fff; border-radius:14px; border:1px solid #ede9fe; padding:18px; margin-top:14px; box-shadow:0 3px 14px rgba(79,70,229,0.07);">
        <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#6b7280; text-transform:uppercase; margin-bottom:10px;">Today's Summary</div>
        <div style="display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f3f4f6;">
          <div style="width:32px; height:32px; background:#eef0ff; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#4f46e5; font-size:0.9rem;"><i class="fa fa-calendar-check-o"></i></div>
          <div>
            <div style="font-size:1.1rem; font-weight:700; color:#1e1b4b;"><?php echo $today_app; ?></div>
            <div style="font-size:0.7rem; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Today's Appointments</div>
          </div>
        </div>
        <div style="display:flex; align-items:center; gap:10px; padding:8px 0;">
          <div style="width:32px; height:32px; background:#f0fdf4; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#059669; font-size:0.9rem;"><i class="fa fa-users"></i></div>
          <div>
            <div style="font-size:1.1rem; font-weight:700; color:#1e1b4b;"><?php echo $active_app; ?></div>
            <div style="font-size:0.7rem; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Active Patients</div>
          </div>
        </div>
      </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="col-md-9" style="padding-left:0; padding-right:0;">
      <div class="tab-content" id="nav-tabContent">

        <!-- DASHBOARD -->
        <div class="tab-pane fade show active" id="list-dash" role="tabpanel">
          <div class="stats-row">
            <div class="stat-card">
              <div class="stat-card-icon indigo"><i class="fa fa-calendar"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $total_app; ?></div>
                <div class="label">Total Appointments</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-card-icon green"><i class="fa fa-calendar-check-o"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $active_app; ?></div>
                <div class="label">Active</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-card-icon gold"><i class="fa fa-sun-o"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $today_app; ?></div>
                <div class="label">Today</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-card-icon red"><i class="fa fa-file-text-o"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $total_pres; ?></div>
                <div class="label">Prescriptions</div>
              </div>
            </div>
          </div>

          <div class="row" style="margin:0;">
            <div class="col-md-6" style="padding:0 8px 0 0;">
              <div class="panel text-center" style="padding:28px 20px;">
                <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-calendar fa-stack-1x fa-inverse"></i></span>
                <h4 class="StepTitle" style="margin:14px 0 8px;">View Appointments</h4>
                <p style="font-size:0.8rem; color:#6b7280; margin-bottom:14px;">See all patient bookings &amp; manage slots</p>
                <script>function clickDiv(id){document.querySelector(id).click();}</script>
                <p class="links"><a href="#list-app" onclick="clickDiv('#list-app-list')">View Appointments &rarr;</a></p>
              </div>
            </div>
            <div class="col-md-6" style="padding:0 0 0 8px;">
              <div class="panel text-center" style="padding:28px 20px;">
                <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i></span>
                <h4 class="StepTitle" style="margin:14px 0 8px;">Prescriptions</h4>
                <p style="font-size:0.8rem; color:#6b7280; margin-bottom:14px;">Review prescriptions you've written</p>
                <p class="links"><a href="#list-pres" onclick="clickDiv('#list-pres-list')">View Prescriptions &rarr;</a></p>
              </div>
            </div>
          </div>
        </div>

        <!-- APPOINTMENTS -->
        <div class="tab-pane fade" id="list-app" role="tabpanel">
          <div style="background:#fff; border-radius:16px; border:1px solid #ede9fe; overflow:hidden; box-shadow:0 4px 20px rgba(79,70,229,0.06);">
            <div style="padding:22px 24px 16px; border-bottom:1px solid #f3f4f6;">
              <h4 style="font-family:'Playfair Display',serif; margin:0;">My Appointments</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr><th>Patient</th><th>Gender</th><th>Contact</th><th>Date</th><th>Time</th><th>Status</th><th>Cancel</th><th>Prescribe</th></tr>
                </thead>
                <tbody>
                <?php
                $result=mysqli_query($con,"select pid,ID,fname,lname,gender,email,contact,appdate,apptime,userStatus,doctorStatus from appointmenttb where doctor='$doctor' ORDER BY appdate DESC;");
                while($row=mysqli_fetch_array($result)){?>
                <tr>
                  <td>
                    <div style="font-weight:600; font-size:0.88rem;"><?php echo htmlspecialchars($row['fname']).' '.htmlspecialchars($row['lname']);?></div>
                    <div style="font-size:0.77rem; color:#6b7280;"><?php echo htmlspecialchars($row['email']);?></div>
                  </td>
                  <td><?php echo htmlspecialchars($row['gender']);?></td>
                  <td><?php echo htmlspecialchars($row['contact']);?></td>
                  <td><?php echo date("d M Y", strtotime($row['appdate']));?></td>
                  <td><?php echo date("g:i A", strtotime($row['apptime']));?></td>
                  <td>
                    <?php
                    if($row['userStatus']==1&&$row['doctorStatus']==1) echo '<span class="status-active">Active</span>';
                    if($row['userStatus']==0&&$row['doctorStatus']==1) echo '<span class="status-cancelled">Cancelled (Patient)</span>';
                    if($row['userStatus']==1&&$row['doctorStatus']==0) echo '<span class="status-cancelled">Cancelled</span>';
                    ?>
                  </td>
                  <td>
                    <?php if($row['userStatus']==1&&$row['doctorStatus']==1){?>
                    <a href="doctor-panel.php?ID=<?php echo(int)$row['ID'];?>&cancel=true" onclick="return confirm('Cancel this appointment?')">
                      <button class="btn btn-danger btn-sm">Cancel</button>
                    </a>
                    <?php }else{ echo '<span style="font-size:0.8rem;color:#9ca3af;">—</span>'; }?>
                  </td>
                  <td>
                    <?php if($row['userStatus']==1&&$row['doctorStatus']==1){?>
                    <a href="prescribe.php?ID=<?php echo(int)$row['ID'];?>&pid=<?php echo(int)$row['pid'];?>">
                      <button class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Prescribe</button>
                    </a>
                    <?php }else{ echo '<span style="font-size:0.8rem;color:#9ca3af;">—</span>'; }?>
                  </td>
                </tr>
                <?php }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- PRESCRIPTION LIST -->
        <div class="tab-pane fade" id="list-pres" role="tabpanel">
          <div style="background:#fff; border-radius:16px; border:1px solid #ede9fe; overflow:hidden; box-shadow:0 4px 20px rgba(79,70,229,0.06);">
            <div style="padding:22px 24px 16px; border-bottom:1px solid #f3f4f6;">
              <h4 style="font-family:'Playfair Display',serif; margin:0;">Prescriptions Written</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr><th>Patient</th><th>Appt#</th><th>Date</th><th>Diagnosis</th><th>Allergies</th><th>Prescription</th></tr>
                </thead>
                <tbody>
                <?php
                $result=mysqli_query($con,"select * from prestb where doctor='$doctor' ORDER BY appdate DESC;");
                while($row=mysqli_fetch_array($result)){?>
                <tr>
                  <td>
                    <div style="font-weight:600;"><?php echo htmlspecialchars($row['fname']).' '.htmlspecialchars($row['lname']);?></div>
                    <div style="font-size:0.77rem; color:#6b7280;">PID: <?php echo htmlspecialchars($row['pid']);?></div>
                  </td>
                  <td><span style="font-size:0.8rem;background:#eef0ff;padding:3px 8px;border-radius:5px;">#<?php echo htmlspecialchars($row['ID']);?></span></td>
                  <td><?php echo date("d M Y", strtotime($row['appdate']));?></td>
                  <td><?php echo htmlspecialchars($row['disease']);?></td>
                  <td><?php echo htmlspecialchars($row['allergy']) ?: '<span style="color:#9ca3af;">None</span>'; ?></td>
                  <td><?php echo htmlspecialchars($row['prescription']);?></td>
                </tr>
                <?php }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
