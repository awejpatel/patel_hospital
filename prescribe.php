<?php
session_start();
if (!isset($_SESSION['dname'])) { header("Location: index.php"); exit(); }
include('func1.php');
$con    = mysqli_connect("localhost","root","","myhmsdb");
$pid    = ''; $ID = ''; $appdate = ''; $apptime = '';
$fname  = ''; $lname = '';
$doctor = mysqli_real_escape_string($con, $_SESSION['dname']);

if(isset($_GET['ID'])){
    $ID_q = (int)$_GET['ID'];
    $row = mysqli_fetch_array(mysqli_query($con,"select pid,fname,lname,appdate,apptime from appointmenttb where ID='$ID_q'"));
    if($row){
        $pid=$row['pid']; $ID=$ID_q;
        $fname=$row['fname']; $lname=$row['lname'];
        $appdate=$row['appdate']; $apptime=$row['apptime'];
    }
}

if(isset($_POST['prescribe'])){
    $appdate2    = mysqli_real_escape_string($con,$_POST['appdate']);
    $apptime2    = mysqli_real_escape_string($con,$_POST['apptime']);
    $disease     = mysqli_real_escape_string($con,$_POST['disease']);
    $allergy     = mysqli_real_escape_string($con,$_POST['allergy']);
    $fname_db    = mysqli_real_escape_string($con,$_POST['fname']);
    $lname_db    = mysqli_real_escape_string($con,$_POST['lname']);
    $pid_db      = (int)$_POST['pid'];
    $ID_db       = (int)$_POST['ID'];
    $prescription= mysqli_real_escape_string($con,$_POST['prescription']);
    $q = mysqli_query($con,"insert into prestb(doctor,pid,ID,fname,lname,appdate,apptime,disease,allergy,prescription) values('$doctor','$pid_db','$ID_db','$fname_db','$lname_db','$appdate2','$apptime2','$disease','$allergy','$prescription')");
    if($q){
        echo "<script>alert('Prescription saved successfully!'); window.location='doctor-panel.php';</script>";
    } else {
        echo "<script>alert('Unable to save. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Write Prescription — Patel Hospitals</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<link rel="stylesheet" href="panel-style.css">
</head>
<body style="padding-top:56px;">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-heartbeat"></i> Patel Hospitals</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="doctor-panel.php"><i class="fa fa-arrow-left"></i> Back to Dashboard</a></li>
      <li class="nav-item"><a class="nav-link" href="logout1.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container" style="margin-top:30px; max-width:760px;">

  <div class="welcome-banner" style="margin-bottom:24px;">
    <i class="fa fa-pencil-square-o fa-2x"></i>
    <div>
      <h3>Write Prescription</h3>
      <p>Dr. <?php echo htmlspecialchars($doctor); ?> &mdash; Patient: <?php echo htmlspecialchars($fname.' '.$lname); ?></p>
    </div>
  </div>

  <!-- Patient Info -->
  <div style="background:#fff; border-radius:14px; border:1px solid #ede9fe; padding:18px 24px; margin-bottom:20px; display:flex; gap:24px; flex-wrap:wrap; box-shadow:0 3px 14px rgba(79,70,229,0.06);">
    <div>
      <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.2px; color:#6b7280; text-transform:uppercase; margin-bottom:4px;">Patient</div>
      <div style="font-weight:600; color:#1e1b4b;"><?php echo htmlspecialchars($fname.' '.$lname); ?></div>
    </div>
    <div>
      <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.2px; color:#6b7280; text-transform:uppercase; margin-bottom:4px;">Appointment ID</div>
      <div style="font-weight:600; color:#4f46e5;">#<?php echo htmlspecialchars($ID); ?></div>
    </div>
    <div>
      <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.2px; color:#6b7280; text-transform:uppercase; margin-bottom:4px;">Date</div>
      <div style="font-weight:600; color:#1e1b4b;"><?php echo $appdate ? date("d M Y", strtotime($appdate)) : '—'; ?></div>
    </div>
    <div>
      <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.2px; color:#6b7280; text-transform:uppercase; margin-bottom:4px;">Time</div>
      <div style="font-weight:600; color:#1e1b4b;"><?php echo $apptime ? date("g:i A", strtotime($apptime)) : '—'; ?></div>
    </div>
  </div>

  <div class="card" style="border-radius:16px; border:1px solid #ede9fe;">
    <div class="card-body" style="padding:32px;">
      <form method="post" action="prescribe.php">
        <div class="form-group">
          <label>Diagnosis / Disease <span style="color:#be123c;">*</span></label>
          <textarea class="form-control" name="disease" rows="3" placeholder="Describe the diagnosis or condition..." required style="resize:vertical;"></textarea>
        </div>
        <div class="form-group">
          <label>Allergies</label>
          <textarea class="form-control" name="allergy" rows="2" placeholder="List known allergies, or write 'None'" style="resize:vertical;"></textarea>
        </div>
        <div class="form-group">
          <label>Prescription &amp; Treatment Plan <span style="color:#be123c;">*</span></label>
          <textarea class="form-control" name="prescription" rows="5" placeholder="Medicines, dosage, instructions, follow-up..." required style="resize:vertical;"></textarea>
        </div>

        <input type="hidden" name="fname"   value="<?php echo htmlspecialchars($fname);?>"/>
        <input type="hidden" name="lname"   value="<?php echo htmlspecialchars($lname);?>"/>
        <input type="hidden" name="appdate" value="<?php echo htmlspecialchars($appdate);?>"/>
        <input type="hidden" name="apptime" value="<?php echo htmlspecialchars($apptime);?>"/>
        <input type="hidden" name="pid"     value="<?php echo (int)$pid;?>"/>
        <input type="hidden" name="ID"      value="<?php echo (int)$ID;?>"/>

        <div style="display:flex; gap:12px; margin-top:8px;">
          <button type="submit" name="prescribe" class="btn btn-primary" style="flex:1; padding:12px;">
            <i class="fa fa-save"></i> Save Prescription
          </button>
          <a href="doctor-panel.php" class="btn btn-outline-secondary" style="padding:12px 22px;">Cancel</a>
        </div>
      </form>
    </div>
  </div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
