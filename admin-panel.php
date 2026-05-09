<?php
session_start();
if (!isset($_SESSION['pid'])) { header("Location: index1.php"); exit(); }
include('func.php');
include('newfunc.php');
$con = mysqli_connect("localhost","root","","myhmsdb");
$pid      = (int)$_SESSION['pid'];
$username = mysqli_real_escape_string($con, $_SESSION['username']);
$email    = mysqli_real_escape_string($con, $_SESSION['email']);
$fname    = mysqli_real_escape_string($con, $_SESSION['fname']);
$gender   = mysqli_real_escape_string($con, $_SESSION['gender']);
$lname    = mysqli_real_escape_string($con, $_SESSION['lname']);
$contact  = mysqli_real_escape_string($con, $_SESSION['contact']);

if (isset($_POST['app-submit'])) {
    $doctor   = mysqli_real_escape_string($con,$_POST['doctor']);
    $docFees  = (int)$_POST['docFees'];
    $appdate  = mysqli_real_escape_string($con,$_POST['appdate']);
    $apptime  = mysqli_real_escape_string($con,$_POST['apptime']);
    $cur_date = date("Y-m-d");
    date_default_timezone_set('Asia/Kolkata');
    $cur_time  = date("H:i:s");
    $apptime1  = strtotime($apptime);
    $appdate1  = strtotime($appdate);
    if(date("Y-m-d",$appdate1)>=$cur_date){
        if((date("Y-m-d",$appdate1)==$cur_date && date("H:i:s",$apptime1)>$cur_time)||date("Y-m-d",$appdate1)>$cur_date){
            $chk=mysqli_query($con,"select apptime from appointmenttb where doctor='$doctor' and appdate='$appdate' and apptime='$apptime'");
            if(mysqli_num_rows($chk)==0){
                $q=mysqli_query($con,"insert into appointmenttb(pid,fname,lname,gender,email,contact,doctor,docFees,appdate,apptime,userStatus,doctorStatus) values($pid,'$fname','$lname','$gender','$email','$contact','$doctor','$docFees','$appdate','$apptime','1','1')");
                echo $q ? "<script>alert('Appointment successfully booked!');</script>" : "<script>alert('Unable to process. Please try again.');</script>";
            } else { echo "<script>alert('Doctor not available at this time. Choose a different slot.');</script>"; }
        } else { echo "<script>alert('Please select a future date and time.');</script>"; }
    } else { echo "<script>alert('Please select a future date.');</script>"; }
}
if(isset($_GET['cancel'])){
    $q=mysqli_query($con,"update appointmenttb set userStatus='0' where ID='".mysqli_real_escape_string($con,$_GET['ID'])."'");
    if($q) echo "<script>alert('Appointment successfully cancelled.');</script>";
}
function generate_bill(){
    $con=mysqli_connect("localhost","root","","myhmsdb");
    $pid=(int)$_SESSION['pid'];
    $bill_id=isset($_GET['ID'])?(int)$_GET['ID']:0;
    $output='';
    $q=mysqli_query($con,"select p.pid,p.ID,p.fname,p.lname,p.doctor,p.appdate,p.apptime,p.disease,p.allergy,p.prescription,a.docFees from prestb p inner join appointmenttb a on p.ID=a.ID and p.pid='$pid' and p.ID='$bill_id'");
    while($row=mysqli_fetch_array($q)){
        $output.='<label>Patient ID:</label> '.htmlspecialchars($row["pid"]).'<br/><br/>
        <label>Appointment ID:</label> '.htmlspecialchars($row["ID"]).'<br/><br/>
        <label>Patient Name:</label> '.htmlspecialchars($row["fname"]).' '.htmlspecialchars($row["lname"]).'<br/><br/>
        <label>Doctor:</label> '.htmlspecialchars($row["doctor"]).'<br/><br/>
        <label>Appointment Date:</label> '.htmlspecialchars($row["appdate"]).'<br/><br/>
        <label>Appointment Time:</label> '.htmlspecialchars($row["apptime"]).'<br/><br/>
        <label>Disease:</label> '.htmlspecialchars($row["disease"]).'<br/><br/>
        <label>Allergies:</label> '.htmlspecialchars($row["allergy"]).'<br/><br/>
        <label>Prescription:</label> '.htmlspecialchars($row["prescription"]).'<br/><br/>
        <label>Fees Paid:</label> ₹'.htmlspecialchars($row["docFees"]).'<br/>';
    }
    return $output;
}
if(isset($_GET["generate_bill"])){
    if(!file_exists("TCPDF/tcpdf.php")){ echo "<script>alert('PDF generation requires TCPDF library. Please install it in the TCPDF folder.'); window.history.back();</script>"; exit(); } require_once("TCPDF/tcpdf.php");
    $pdf=new TCPDF('P',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
    $pdf->SetCreator(PDF_CREATOR); $pdf->SetTitle("Bill — Patel Hospitals");
    $pdf->SetHeaderData('','',PDF_HEADER_TITLE,PDF_HEADER_STRING);
    $pdf->SetHeaderFont(array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
    $pdf->SetFooterFont(array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT,'5',PDF_MARGIN_RIGHT);
    $pdf->SetPrintHeader(false); $pdf->SetPrintFooter(false);
    $pdf->SetAutoPageBreak(true,10); $pdf->SetFont('helvetica','',12); $pdf->AddPage();
    $content='<br/><h2 align="center">Patel Hospitals</h2><br/><h3 align="center">Medical Bill</h3>'.generate_bill();
    $pdf->writeHTML($content); ob_end_clean(); $pdf->Output("bill.pdf",'I');
}
function get_specs(){
    $con=mysqli_connect("localhost","root","","myhmsdb");
    $q=mysqli_query($con,"select username,spec from doctb");
    $arr=array(); while($row=mysqli_fetch_assoc($q)) $arr[]=$row;
    return json_encode($arr);
}
// Count stats
$total_app = mysqli_num_rows(mysqli_query($con,"select ID from appointmenttb where pid='$pid'"));
$active_app = mysqli_num_rows(mysqli_query($con,"select ID from appointmenttb where pid='$pid' and userStatus=1 and doctorStatus=1"));
$total_pres = mysqli_num_rows(mysqli_query($con,"select ID from prestb where pid='$pid'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Patient Portal — Patel Hospitals</title>
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
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#" style="color:rgba(255,255,255,0.6);font-size:0.82rem;">
          <i class="fa fa-user-circle"></i> <?php echo htmlspecialchars($username); ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container-fluid" style="margin-top:24px; padding:0 28px;">

  <!-- Welcome Banner -->
  <div class="welcome-banner">
    <i class="fa fa-user-circle fa-2x"></i>
    <div>
      <h3>Welcome back, <?php echo htmlspecialchars($fname.' '.$lname); ?></h3>
      <p>Patient Portal &mdash; Book appointments, view history &amp; download prescriptions</p>
    </div>
  </div>

  <div class="row" style="margin:0;">

    <!-- SIDEBAR -->
    <div class="col-md-3" style="padding-right:20px; padding-left:0;">
      <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab">
          <i class="fa fa-tachometer" style="margin-right:9px;"></i> Dashboard
        </a>
        <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home" role="tab">
          <i class="fa fa-calendar-plus-o" style="margin-right:9px;"></i> Book Appointment
        </a>
        <a class="list-group-item list-group-item-action" href="#app-hist" id="list-pat-list" role="tab" data-toggle="list">
          <i class="fa fa-history" style="margin-right:9px;"></i> Appointment History
        </a>
        <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list">
          <i class="fa fa-file-text-o" style="margin-right:9px;"></i> Prescriptions
        </a>
      </div>

      <!-- Patient Info Card -->
      <div style="background:#fff; border-radius:14px; border:1px solid #ede9fe; padding:18px; margin-top:14px; box-shadow:0 3px 14px rgba(79,70,229,0.07);">
        <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#6b7280; text-transform:uppercase; margin-bottom:12px;">My Profile</div>
        <div style="font-size:0.82rem; color:#374151; margin-bottom:6px;"><i class="fa fa-envelope-o" style="color:#818cf8; margin-right:7px; width:14px;"></i><?php echo htmlspecialchars($email); ?></div>
        <div style="font-size:0.82rem; color:#374151; margin-bottom:6px;"><i class="fa fa-phone" style="color:#818cf8; margin-right:7px; width:14px;"></i><?php echo htmlspecialchars($contact); ?></div>
        <div style="font-size:0.82rem; color:#374151;"><i class="fa fa-venus-mars" style="color:#818cf8; margin-right:7px; width:14px;"></i><?php echo htmlspecialchars($gender); ?></div>
      </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="col-md-9" style="padding-left:0; padding-right:0;">
      <div class="tab-content" id="nav-tabContent">

        <!-- DASHBOARD -->
        <div class="tab-pane fade show active" id="list-dash" role="tabpanel">
          <!-- Stats -->
          <div class="stats-row">
            <div class="stat-card">
              <div class="stat-card-icon indigo"><i class="fa fa-calendar-check-o"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $total_app; ?></div>
                <div class="label">Total Appointments</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-card-icon green"><i class="fa fa-calendar"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $active_app; ?></div>
                <div class="label">Active</div>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-card-icon gold"><i class="fa fa-file-text-o"></i></div>
              <div class="stat-card-info">
                <div class="number"><?php echo $total_pres; ?></div>
                <div class="label">Prescriptions</div>
              </div>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="row" style="margin:0; gap:0;">
            <div class="col-md-4" style="padding:0 8px 0 0;">
              <div class="panel panel-white text-center" style="padding:28px 20px;">
                <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-calendar-plus-o fa-stack-1x fa-inverse"></i></span>
                <h4 class="StepTitle" style="margin-top:14px; margin-bottom:8px;">Book Appointment</h4>
                <p style="font-size:0.8rem; color:#6b7280; margin-bottom:14px;">Schedule a visit with a specialist</p>
                <script>function clickDiv(id){document.querySelector(id).click();}</script>
                <p class="links"><a href="#list-home" onclick="clickDiv('#list-home-list')">Book Now &rarr;</a></p>
              </div>
            </div>
            <div class="col-md-4" style="padding:0 4px;">
              <div class="panel panel-white text-center" style="padding:28px 20px;">
                <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-history fa-stack-1x fa-inverse"></i></span>
                <h4 class="StepTitle" style="margin-top:14px; margin-bottom:8px;">My Appointments</h4>
                <p style="font-size:0.8rem; color:#6b7280; margin-bottom:14px;">View &amp; manage your bookings</p>
                <p class="links"><a href="#app-hist" onclick="clickDiv('#list-pat-list')">View History &rarr;</a></p>
              </div>
            </div>
            <div class="col-md-4" style="padding:0 0 0 8px;">
              <div class="panel panel-white text-center" style="padding:28px 20px;">
                <span class="fa-stack fa-2x"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i></span>
                <h4 class="StepTitle" style="margin-top:14px; margin-bottom:8px;">Prescriptions</h4>
                <p style="font-size:0.8rem; color:#6b7280; margin-bottom:14px;">Download bills &amp; view prescriptions</p>
                <p class="links"><a href="#list-pres" onclick="clickDiv('#list-pres-list')">View &rarr;</a></p>
              </div>
            </div>
          </div>
        </div>

        <!-- BOOK APPOINTMENT -->
        <div class="tab-pane fade" id="list-home" role="tabpanel">
          <div class="card" style="border-radius:16px; border:1px solid #ede9fe;">
            <div class="card-body" style="padding:32px;">
              <h4 style="font-family:'Playfair Display',serif; margin-bottom:6px;">Book an Appointment</h4>
              <p style="font-size:0.83rem; color:#6b7280; margin-bottom:28px;">Fill in the details below to schedule a consultation</p>
              <form method="post" action="admin-panel.php">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Specialization</label>
                      <select name="spec" class="form-control" id="spec">
                        <option value="" disabled selected>Select Specialization</option>
                        <?php display_specs();?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Doctor</label>
                      <select name="doctor" class="form-control" id="doctor" required>
                        <option value="" disabled selected>Select Doctor</option>
                        <?php display_docs();?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Consultancy Fees (₹)</label>
                      <input class="form-control" type="text" name="docFees" id="docFees" readonly placeholder="Auto-filled on doctor selection"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Appointment Date</label>
                      <input type="date" class="form-control" name="appdate" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Preferred Time</label>
                      <select name="apptime" class="form-control" id="apptime" required>
                        <option value="" disabled selected>Select Time Slot</option>
                        <option value="08:00:00">8:00 AM</option>
                        <option value="10:00:00">10:00 AM</option>
                        <option value="12:00:00">12:00 PM</option>
                        <option value="14:00:00">2:00 PM</option>
                        <option value="16:00:00">4:00 PM</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6" style="display:flex; align-items:flex-end;">
                    <div class="form-group" style="width:100%;">
                      <input type="submit" name="app-submit" value="Confirm Appointment" class="btn btn-primary" style="width:100%; padding:12px;"/>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- APPOINTMENT HISTORY -->
        <div class="tab-pane fade" id="app-hist" role="tabpanel">
          <div style="background:#fff; border-radius:16px; border:1px solid #ede9fe; overflow:hidden; box-shadow:0 4px 20px rgba(79,70,229,0.06);">
            <div style="padding:22px 24px 16px; border-bottom:1px solid #f3f4f6;">
              <h4 style="font-family:'Playfair Display',serif; margin:0;">Appointment History</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr><th>Doctor</th><th>Fees (₹)</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php
                $result=mysqli_query($con,"select ID,doctor,docFees,appdate,apptime,userStatus,doctorStatus from appointmenttb where pid='$pid' ORDER BY appdate DESC;");
                while($row=mysqli_fetch_array($result)){?>
                <tr>
                  <td><i class="fa fa-user-md" style="color:#818cf8; margin-right:6px;"></i><?php echo htmlspecialchars($row['doctor']);?></td>
                  <td>₹<?php echo htmlspecialchars($row['docFees']);?></td>
                  <td><?php echo date("d M Y", strtotime($row['appdate']));?></td>
                  <td><?php echo date("g:i A", strtotime($row['apptime']));?></td>
                  <td>
                    <?php
                    if($row['userStatus']==1&&$row['doctorStatus']==1) echo '<span class="status-active"><i class="fa fa-check-circle"></i> Active</span>';
                    if($row['userStatus']==0&&$row['doctorStatus']==1) echo '<span class="status-cancelled">Cancelled by You</span>';
                    if($row['userStatus']==1&&$row['doctorStatus']==0) echo '<span class="status-cancelled">Cancelled by Doctor</span>';
                    ?>
                  </td>
                  <td>
                    <?php if($row['userStatus']==1&&$row['doctorStatus']==1){?>
                    <a href="admin-panel.php?ID=<?php echo(int)$row['ID'];?>&cancel=update" onclick="return confirm('Cancel this appointment?')">
                      <button class="btn btn-danger btn-sm">Cancel</button>
                    </a>
                    <?php }else{ echo '<span style="font-size:0.8rem;color:#9ca3af;">No action</span>'; }?>
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
              <h4 style="font-family:'Playfair Display',serif; margin:0;">My Prescriptions</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr><th>Doctor</th><th>Appt. ID</th><th>Date</th><th>Time</th><th>Diagnosis</th><th>Allergies</th><th>Prescription</th><th>Bill</th></tr>
                </thead>
                <tbody>
                <?php
                $result=mysqli_query($con,"select doctor,ID,appdate,apptime,disease,allergy,prescription from prestb where pid='$pid' ORDER BY appdate DESC;");
                while($row=mysqli_fetch_array($result)){?>
                <tr>
                  <td><?php echo htmlspecialchars($row['doctor']);?></td>
                  <td><span style="font-size:0.8rem; background:#eef0ff; padding:3px 8px; border-radius:5px;">#<?php echo htmlspecialchars($row['ID']);?></span></td>
                  <td><?php echo date("d M Y", strtotime($row['appdate']));?></td>
                  <td><?php echo date("g:i A", strtotime($row['apptime']));?></td>
                  <td><?php echo htmlspecialchars($row['disease']);?></td>
                  <td><?php echo htmlspecialchars($row['allergy']) ?: '<span style="color:#9ca3af;">None</span>'; ?></td>
                  <td><?php echo htmlspecialchars($row['prescription']);?></td>
                  <td>
                    <form method="get" style="margin:0;">
                      <input type="hidden" name="ID" value="<?php echo(int)$row['ID'];?>"/>
                      <button type="submit" name="generate_bill" class="btn btn-success btn-sm" style="white-space:nowrap;">
                        <i class="fa fa-download"></i> Bill
                      </button>
                    </form>
                  </td>
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

<script>
document.getElementById('spec').onchange = function(){
  let spec = this.value;
  [...document.getElementById('doctor').options].forEach((el,i,arr) => {
    arr[i].style.display = '';
    if(el.getAttribute('data-spec') != spec && i > 0) arr[i].style.display = 'none';
  });
  document.getElementById('doctor').value = '';
  document.getElementById('docFees').value = '';
};
document.getElementById('doctor').onchange = function(){
  var s = document.querySelector('[value="'+this.value+'"]');
  if(s) document.getElementById('docFees').value = s.getAttribute('data-value');
};
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
