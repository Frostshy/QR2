<?PHP
session_start();

include("database.php");
if( !verifyLecturer($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$id_lecturer= $_SESSION["id_lecturer"];

$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';		

$status		= (isset($_GET['status'])) ? trim($_GET['status']) : '';
$location	= (isset($_POST['location'])) ? trim($_POST['location']) : '';
$location	=  mysqli_real_escape_string($con, $location);

$success = "";

if($act == "editStatus")
{	
	$SQL_update = " 
		UPDATE `lecturer` SET `status` = '$status' WHERE `id_lecturer` = $id_lecturer
	";										
	$result = mysqli_query($con, $SQL_update);

	$success = "Status Successfully Updated";
}

if($act == "editLocation")
{	
	$SQL_update = " 
		UPDATE `lecturer` SET `location` = '$location' WHERE `id_lecturer` = $id_lecturer
	";										
	$result = mysqli_query($con, $SQL_update);

	$success = "Location Successfully Updated";
}

$SQL_list 	= "SELECT * FROM `lecturer` WHERE `id_lecturer` = '$id_lecturer'  ";
$result 	= mysqli_query($con, $SQL_list) ;
$data		= mysqli_fetch_array($result);
$name		= $data["name"];
$location	= $data["location"];
$status		= $data["status"];
?>
<!DOCTYPE html>
<html>
<title>QR Attendance</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
a:link {
  text-decoration: none;
}

body,h1,h2,h3,h4,h5,h6 {font-family: "Poppins", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  background-attachment:fixed;
  min-height:100%;
  background-color: rgba(255, 255, 255, 0.7);
  background-blend-mode: overlay;
}

.w3-bar .w3-button {
  padding: 16px;
}

img[alt="www.000webhost.com"]{display:none}
</style>

<body class="bgimg-1">

<div class="w3-top">
	<div class="w3-card w3-white w3-content" style="max-width:600px">
		<div class="w3-row w3-xlarge w3-padding-small">
			<div class="w3-col s2">
				<a href="l-main.php">&nbsp;&nbsp;<img src="images/logo.png"  height="45"></a>
			</div>
			<a href="l-sign-out.php" class="w3-right w3-margin-right"><i class="fa fa-fw fa-power-off fa-lg w3-text-red"></i></a>
		</div>
	</div>
</div>

<div class="w3-padding-32"></div>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "l-main.php"); }
?>	

<!-- content -->	
<div class="w3-container " id="contact">
    <div class="w3-content w3-containerx w3-center w3-padding" style="max-width:600px">	
			
		<div class="w3-padding w3-xlarge"><b>Hi, <?PHP echo $name;?></b></div>

	
		<div class="w3-padding-small"></div>	

		<div class="w3-center w3-padding-16 w3-large">
			<a href="l-qrcode.php" class="w3-padding-16 w3-button w3-block w3-round-large w3-red">
			<i class="fas fa-qrcode fa-2x"></i><br>
			<b>Class - QR Code</b></a>
		</div>
		
		<div class="w3-center w3-padding-16 w3-large">
			<a href="l-class.php" class="w3-padding-16 w3-button w3-block w3-round-large w3-red">
			<i class="fas fa-university fa-2x"></i><br>
			<b>Class</b></a>
		</div>
		
		<div class="w3-center w3-padding-16 w3-large">
			<a href="l-attendance.php" class="w3-padding-16 w3-button w3-block w3-round-large w3-red">
			<i class="fas fa-calendar-check fa-2x"></i><br>
			<b>Attendance List</b></a>
		</div>
		
	</div>
</div>

<!-- content end -->

<div class="w3-bottom w3-card w3-white w3-padding-small" style="z-index=-10"> 
	<div class="w3-row w3-center">
		<a class="w3-col s3 w3-button" href="l-class.php">
			<i class="fa fa-university fa-2x"></i><br>Class
		</a>
		<a class="w3-col s3 w3-button" href="l-subject.php">
			<i class="fas fa-book fa-2x"></i><br>Subject
		</a>
		<a class="w3-col s3 w3-button" href="l-student.php">
			<i class="fa fa-user fa-2x"></i><br>Student
		</a>
		<a class="w3-col s3 w3-button" href="l-profile.php">
			<i class="fa fa-user-tie fa-2x"></i><br>Profile
		</a>
	</div>
</div>

</body>
</html>
