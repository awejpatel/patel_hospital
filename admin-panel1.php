<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: index.php"); exit(); }

$con = mysqli_connect("localhost","root","","myhmsdb");
include('newfunc.php');

if(isset($_POST['docsub'])){
    $doctor  = mysqli_real_escape_string($con,$_POST['doctor']);
    $dpassword=mysqli_real_escape_string($con,$_POST['dpassword']);
    $demail  = mysqli_real_escape_string($con,$_POST['demail']);
    $spec    = mysqli_real_escape_string($con,$_POST['special']);
    $docFees = (int)$_POST['docFees'];
    $q = mysqli_query($con,"insert into doctb(username,password,email,spec,docFees)values('$doctor','$dpassword','$demail','$spec','$docFees')");
    if($q) echo "<script>alert('Doctor added successfully!');</script>";
}
if(isset($_POST['docsub1'])){
    $demail = mysqli_real_escape_string($con,$_POST['demail']);
    $q = mysqli_query($con,"delete from doctb where email='$demail';");
    echo $q ? "<script>alert('Doctor removed successfully!');</script>" : "<script>alert('Unable to delete. Check the email ID.');</script>";
}

// Stats
$doc_count  = mysqli_num_rows(mysqli_query($con,"select id from doctb"));
$pat_count  = mysqli_num_rows(mysqli_query($con,"select pid from patreg"));
$app_count  = mysqli_num_rows(mysqli_query($con,"select ID from appointmenttb"));
$active_app = mysqli_num_rows(mysqli_query($con,"select ID from appointmenttb where userStatus=1 and doctorStatus=1"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Admin Panel — Patel Hospitals</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<link rel="stylesheet" href="panel-style.css">
<script>
var check=function(){
  var match=document.getElementById('dpassword').value==document.getElementById('cdpassword').value;
  var el=document.getElementById('message');
  el.style.color=match?'#059669':'#be123c';
  el.innerHTML=match?'&#10003; Matched':'&#10007; Not matching';
};
function alphaOnly(event){var k=event.keyCode;return((k>=65&&k<=90)||k==8||k==32);}
</script>
</head>
<body style="padding-top:56px;">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-heartbeat"></i> Patel Hospitals</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out"></i> Logout</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container-fluid" style="margin-top:24px; padding:0 28px;">

  <div class="welcome-banner">
    <i class="fa fa-id-badge fa-2x"></i>
    <div>
      <h3>Receptionist Dashboard</h3>
      <p>Patel Hospitals Admin Portal &mdash; Manage patients, doctors &amp; appointments</p>
    </div>
  </div>

  <div class="row" style="margin:0;">

    <!-- SIDEBAR -->
    <div class="col-md-3" style="padding-right:20px; padding-left:0;">
      <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab">
          <i class="fa fa-tachometer" style="margin-right:9px;"></i>Dashboard
        </a>
        <a class="list-group-item list-group-item-action" href="#list-doc" id="list-doc-list" role="tab" data-toggle="list">
          <i class="fa fa-user-md" style="margin-right:9px;"></i>Doctor List
        </a>
        <a class="list-group-item list-group-item-action" href="#list-pat" id="list-pat-list" role="tab" data-toggle="list">
          <i class="fa fa-users" style="margin-right:9px;"></i>Patient List
        </a>
        <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list">
          <i class="fa fa-calendar" style="margin-right:9px;"></i>Appointments
        </a>
        <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list">
          <i class="fa fa-file-text-o" style="margin-right:9px;"></i>Prescriptions
        </a>
        <a class="list-group-item list-group-item-action" href="#list-settings" id="list-adoc-list" role="tab" data-toggle="list">
          <i class="fa fa-user-plus" style="margin-right:9px;"></i>Add Doctor
        </a>
        <a class="list-group-item list-group-item-action" href="#list-settings1" id="list-ddoc-list" role="tab" data-toggle="list">
          <i class="fa fa-user-times" style="margin-right:9px;"></i>Remove Doctor
        </a>
        <a class="list-group-item list-group-item-action" href="#list-mes" id="list-mes-list" role="tab" data-toggle="list">
          <i class="fa fa-envelope-o" style="margin-right:9px;"></i>Queries
        </a>
      </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="col-md-9" style="padding-left:0; padding-right:0;">
      <div class="tab-content" id="nav-tabContent">

        <!-- DASHBOARD -->
        <div class="tab-pane fade show active" id="list-dash" role="tabpanel">
          <div class="stats-row">
            <div class="stat-card">
              <div class="stat-card-icon indigo"><i class="fa fa-user-md"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $doc_count; ?></div>
                <div class="label">Doctors</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-card-icon gold"><i class="fa fa-users"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $pat_count; ?></div>
                <div class="label">Patients</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-card-icon green"><i class="fa fa-calendar-check-o"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $active_app; ?></div>
                <div class="label">Active Appts</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-card-icon red"><i class="fa fa-calendar"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $app_count; ?></div>
                <div class="label">Total Appts</div>
              </div>
            </div>
          </div>

          <div class="row" style="margin:0;">
            <div class="col-md-3" style="padding:0 8px 0 0;">
              <div class="panel text-center" style="padding:22px 16px;">
                <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-user-md fa-stack-1x fa-inverse"></i></span>
                <h4 class="StepTitle" style="margin:12px 0 6px;">Doctor List</h4>
                <p class="links"><a href="#list-doc" onclick="clickDiv('#list-doc-list')">View &rarr;</a></p>
              </div>
            </div>
            <div class="col-md-3" style="padding:0 4px;">
              <div class="panel text-center" style="padding:22px 16px;">
                <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-users fa-stack-1x fa-inverse"></i></span>
                <h4 class="StepTitle" style="margin:12px 0 6px;">Patient List</h4>
                <p class="links"><a href="#list-pat" onclick="clickDiv('#list-pat-list')">View &rarr;</a></p>
              </div>
            </div>
            <div class="col-md-3" style="padding:0 4px;">
              <div class="panel text-center" style="padding:22px 16px;">
                <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-calendar fa-stack-1x fa-inverse"></i></span>
                <h4 class="StepTitle" style="margin:12px 0 6px;">Appointments</h4>
                <p class="links"><a href="#list-app" onclick="clickDiv('#list-app-list')">View &rarr;</a></p>
              </div>
            </div>
            <div class="col-md-3" style="padding:0 0 0 8px;">
              <div class="panel text-center" style="padding:22px 16px;">
                <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-user-plus fa-stack-1x fa-inverse"></i></span>
                <h4 class="StepTitle" style="margin:12px 0 6px;">Add Doctor</h4>
                <p class="links"><a href="#list-settings" onclick="clickDiv('#list-adoc-list')">Add &rarr;</a></p>
              </div>
            </div>
          </div>
          <script>function clickDiv(id){document.querySelector(id).click();}</script>
        </div>

        <!-- DOCTOR LIST -->
        <div class="tab-pane fade" id="list-doc" role="tabpanel">
          <div style="background:#fff; border-radius:16px; border:1px solid #ede9fe; overflow:hidden; box-shadow:0 4px 20px rgba(79,70,229,0.06);">
            <div style="padding:22px 24px 16px; border-bottom:1px solid #f3f4f6;">
              <h4 style="font-family:'Playfair Display',serif; margin:0;">Registered Doctors</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead><tr><th>#</th><th>Doctor Name</th><th>Specialization</th><th>Email</th><th>Fees (₹)</th></tr></thead>
                <tbody>
                <?php
                $result=mysqli_query($con,"select id,username,spec,email,docFees from doctb");
                $i=1; while($row=mysqli_fetch_array($result)){?>
                <tr>
                  <td style="color:#9ca3af; font-size:0.82rem;"><?php echo $i++;?></td>
                  <td><i class="fa fa-user-md" style="color:#818cf8; margin-right:7px;"></i><?php echo htmlspecialchars($row['username']);?></td>
                  <td><span class="status-pending"><?php echo htmlspecialchars($row['spec']);?></span></td>
                  <td><?php echo htmlspecialchars($row['email']);?></td>
                  <td>₹<?php echo htmlspecialchars($row['docFees']);?></td>
                </tr>
                <?php }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- PATIENT LIST -->
        <div class="tab-pane fade" id="list-pat" role="tabpanel">
          <div style="background:#fff; border-radius:16px; border:1px solid #ede9fe; overflow:hidden; box-shadow:0 4px 20px rgba(79,70,229,0.06);">
            <div style="padding:22px 24px 16px; border-bottom:1px solid #f3f4f6;">
              <h4 style="font-family:'Playfair Display',serif; margin:0;">Registered Patients</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Gender</th><th>Email</th><th>Contact</th></tr></thead>
                <tbody>
                <?php
                $result=mysqli_query($con,"select pid,fname,lname,gender,email,contact from patreg");
                while($row=mysqli_fetch_array($result)){
                    echo "<tr>
                    <td><span style='font-size:0.8rem;background:#eef0ff;padding:3px 8px;border-radius:5px;'>#".htmlspecialchars($row['pid'])."</span></td>
                    <td>".htmlspecialchars($row['fname'])."</td>
                    <td>".htmlspecialchars($row['lname'])."</td>
                    <td>".htmlspecialchars($row['gender'])."</td>
                    <td>".htmlspecialchars($row['email'])."</td>
                    <td>".htmlspecialchars($row['contact'])."</td>
                    </tr>";
                }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- APPOINTMENTS -->
        <div class="tab-pane fade" id="list-app" role="tabpanel">
          <div style="background:#fff; border-radius:16px; border:1px solid #ede9fe; overflow:hidden; box-shadow:0 4px 20px rgba(79,70,229,0.06);">
            <div style="padding:22px 24px 16px; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
              <h4 style="font-family:'Playfair Display',serif; margin:0;">All Appointments</h4>
              <form action="appsearch.php" method="post" style="display:flex; gap:8px; margin:0;">
                <input type="text" name="app_contact" placeholder="Search by contact..." class="form-control" style="max-width:220px; margin:0;">
                <button type="submit" name="app_search_submit" class="btn btn-primary btn-sm">Search</button>
              </form>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead><tr><th>Appt#</th><th>Patient</th><th>Doctor</th><th>Fees (₹)</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
                <tbody>
                <?php
                $result=mysqli_query($con,"select ID,pid,fname,lname,doctor,docFees,appdate,apptime,userStatus,doctorStatus from appointmenttb ORDER BY appdate DESC;");
                while($row=mysqli_fetch_array($result)){?>
                <tr>
                  <td><span style="font-size:0.8rem;background:#eef0ff;padding:3px 8px;border-radius:5px;">#<?php echo htmlspecialchars($row['ID']);?></span></td>
                  <td><?php echo htmlspecialchars($row['fname']).' '.htmlspecialchars($row['lname']);?></td>
                  <td><?php echo htmlspecialchars($row['doctor']);?></td>
                  <td>₹<?php echo htmlspecialchars($row['docFees']);?></td>
                  <td><?php echo date("d M Y", strtotime($row['appdate']));?></td>
                  <td><?php echo date("g:i A", strtotime($row['apptime']));?></td>
                  <td>
                    <?php
                    if($row['userStatus']==1&&$row['doctorStatus']==1) echo '<span class="status-active">Active</span>';
                    if($row['userStatus']==0&&$row['doctorStatus']==1) echo '<span class="status-cancelled">Cancelled (Patient)</span>';
                    if($row['userStatus']==1&&$row['doctorStatus']==0) echo '<span class="status-cancelled">Cancelled (Doctor)</span>';
                    ?>
                  </td>
                </tr>
                <?php }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- PRESCRIPTIONS -->
        <div class="tab-pane fade" id="list-pres" role="tabpanel">
          <div style="background:#fff; border-radius:16px; border:1px solid #ede9fe; overflow:hidden; box-shadow:0 4px 20px rgba(79,70,229,0.06);">
            <div style="padding:22px 24px 16px; border-bottom:1px solid #f3f4f6;">
              <h4 style="font-family:'Playfair Display',serif; margin:0;">All Prescriptions</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead><tr><th>Doctor</th><th>Patient</th><th>Appt#</th><th>Date</th><th>Diagnosis</th><th>Allergy</th><th>Prescription</th></tr></thead>
                <tbody>
                <?php
                $result=mysqli_query($con,"select * from prestb ORDER BY appdate DESC");
                while($row=mysqli_fetch_array($result)){
                    echo "<tr>
                    <td>".htmlspecialchars($row['doctor'])."</td>
                    <td>".htmlspecialchars($row['fname'])." ".htmlspecialchars($row['lname'])."</td>
                    <td><span style='font-size:0.8rem;background:#eef0ff;padding:3px 8px;border-radius:5px;'>#".htmlspecialchars($row['ID'])."</span></td>
                    <td>".date("d M Y", strtotime($row['appdate']))."</td>
                    <td>".htmlspecialchars($row['disease'])."</td>
                    <td>".(htmlspecialchars($row['allergy']) ?: '<span style="color:#9ca3af;">None</span>')."</td>
                    <td>".htmlspecialchars($row['prescription'])."</td>
                    </tr>";
                }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ADD DOCTOR -->
        <div class="tab-pane fade" id="list-settings" role="tabpanel">
          <div class="card" style="max-width:580px; border-radius:16px; border:1px solid #ede9fe;">
            <div class="card-body" style="padding:32px;">
              <h4 style="font-family:'Playfair Display',serif; margin-bottom:6px;">Add New Doctor</h4>
              <p style="font-size:0.83rem; color:#6b7280; margin-bottom:24px;">Create a doctor account to grant portal access</p>
              <form method="post" action="admin-panel1.php">
                <div class="form-group">
                  <label>Doctor Name</label>
                  <input type="text" class="form-control" name="doctor" placeholder="Full name" required>
                </div>
                <div class="form-group">
                  <label>Specialization</label>
                  <select name="special" class="form-control" required>
                    <option value="" disabled selected>Select Specialization</option>
                    <option value="General">General</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="Pediatrician">Pediatrician</option>
                    <option value="Orthopedic">Orthopedic</option>
                    <option value="Dermatologist">Dermatologist</option>
                    <option value="ENT Specialist">ENT Specialist</option>
                    <option value="Ophthalmologist">Ophthalmologist</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Email ID</label>
                  <input type="email" class="form-control" name="demail" placeholder="doctor@example.com" required>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" onkeyup="check();" name="dpassword" id="dpassword" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" class="form-control" onkeyup="check();" name="cdpassword" id="cdpassword" required>
                      <span id="message" style="font-size:0.75rem; font-weight:600;"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Consultancy Fees (₹)</label>
                  <input type="number" class="form-control" name="docFees" placeholder="e.g. 500" required>
                </div>
                <button type="submit" name="docsub" class="btn btn-primary" style="width:100%; padding:12px; margin-top:8px;">
                  <i class="fa fa-user-plus"></i> Add Doctor
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- REMOVE DOCTOR -->
        <div class="tab-pane fade" id="list-settings1" role="tabpanel">
          <div class="card" style="max-width:480px; border-radius:16px; border:1px solid #ede9fe;">
            <div class="card-body" style="padding:32px;">
              <h4 style="font-family:'Playfair Display',serif; margin-bottom:6px;">Remove Doctor</h4>
              <p style="font-size:0.83rem; color:#6b7280; margin-bottom:24px;">Enter the email ID of the doctor to remove their account</p>
              <div style="background:#fff1f2; border:1px solid #fecdd3; border-radius:10px; padding:12px 16px; margin-bottom:20px; font-size:0.82rem; color:#9f1239;">
                <i class="fa fa-exclamation-triangle"></i> This action is irreversible. The doctor account will be permanently deleted.
              </div>
              <form method="post" action="admin-panel1.php">
                <div class="form-group">
                  <label>Doctor Email ID</label>
                  <input type="email" class="form-control" name="demail" placeholder="doctor@example.com" required>
                </div>
                <button type="submit" name="docsub1" class="btn btn-danger" style="width:100%; padding:12px;" onclick="return confirm('Permanently remove this doctor?')">
                  <i class="fa fa-user-times"></i> Remove Doctor
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- QUERIES -->
        <div class="tab-pane fade" id="list-mes" role="tabpanel">
          <div style="background:#fff; border-radius:16px; border:1px solid #ede9fe; overflow:hidden; box-shadow:0 4px 20px rgba(79,70,229,0.06);">
            <div style="padding:22px 24px 16px; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
              <h4 style="font-family:'Playfair Display',serif; margin:0;">Patient Queries</h4>
              <form action="messearch.php" method="post" style="display:flex; gap:8px; margin:0;">
                <input type="text" name="mes_contact" placeholder="Search by contact..." class="form-control" style="max-width:200px; margin:0;">
                <button type="submit" name="mes_search_submit" class="btn btn-primary btn-sm">Search</button>
              </form>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead><tr><th>Name</th><th>Email</th><th>Contact</th><th>Message</th></tr></thead>
                <tbody>
                <?php
                $result=mysqli_query($con,"select * from contact;");
                while($row=mysqli_fetch_array($result)){?>
                <tr>
                  <td><?php echo htmlspecialchars($row['name']);?></td>
                  <td><?php echo htmlspecialchars($row['email']);?></td>
                  <td><?php echo htmlspecialchars($row['contact']);?></td>
                  <td><?php echo htmlspecialchars($row['message']);?></td>
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
