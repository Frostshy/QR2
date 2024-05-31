<?PHP
session_start();

include("database.php");
if( !verifyStudent($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$id_student	= $_SESSION["id_student"];

$SQL_list 	= "SELECT * FROM `student` WHERE `id_student` = '$id_student'  ";
$result 	= mysqli_query($con, $SQL_list) ;
$data		= mysqli_fetch_array($result);
$photo		= $data["photo"];
if(!$photo) $photo = "noimage.png";
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
  background-image: url("images/back2.jpg");
  min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}

input.cpwd {
  -webkit-text-security: circle;  
  /* circle , square , disk */
}

img[alt="www.000webhost.com"]{display:none}
</style>

<body class="">

	
<div class="w3-padding"></div>

<div class="w3-top">
	<div class="w3-card w3-white w3-content" style="max-width:600px">
		<div class="w3-row w3-xlarge w3-center w3-padding-small">
			<div class="w3-col s2">
				<a href="main.php"><i class="fa fa-fw fa-chevron-circle-left fa-lg w3-text-red"></i></a>
			</div>
			<div class="w3-col  s8">
				<b>Profile</b>
			</div>
		</div>
	</div>
</div>

<div class="w3-padding"></div>


<div class="w3-containerx" id="contact">
    <div class="w3-content w3-container w3-padding-16" style="max-width:450px">
		
		<div class="w3-padding-16"></div>
				
			 
			<div class="w3-section w3-center" >
				<img src="upload/<?PHP echo $photo; ?>" class="w3-circle w3-image" alt="image" style="width:100%;max-width:150px">
				<?PHP if($data["photo"] <>"") { ?>
				<?PHP }  ?>
			</div>
			
			<div class="w3-center w3-large" >				
				<b><?PHP echo $data["name"];?></b>
			</div>
			
			<div class="w3-padding" >
				<b>Student ID</b><br>
				<?PHP echo $data["student_id"];?>
			</div>
			
			<div class="w3-padding" >
				<b>Email</b><br>
				<?PHP echo $data["email"];?>
			</div>
			
			<div class="w3-padding" >
				<b>Contact No</b><br>
				<?PHP echo $data["phone"];?>
			</div>
			
			<div class="w3-padding"></div>

			<div class="w3-center">
				<a href="profile-edit.php" class="w3-padding-large w3-wide w3-block w3-button w3-margin-bottom w3-round-large w3-red"><b><i class="fa fa-fw fa-pen"></i> EDIT PROFILE</b></a>
			</div>
			
		
			<div class="w3-padding-16"></div>
				
	</div>
</div>
<!-- Content End -->

<div class="w3-bottom w3-card w3-white w3-padding-small" style="z-index=-10"> 
	<div class="w3-row w3-center">
		<a class="w3-col s3 w3-button" href="main.php">
			<i class="fa fa-home fa-2x"></i><br>Home
		</a>
		<a class="w3-col s3 w3-button" href="scan.php">
			<i class="fas fa-qrcode fa-2x"></i><br>Scan QR
		</a>
		<a class="w3-col s3 w3-button" href="history.php">
			<i class="fa fa-calendar-check fa-2x"></i><br>History
		</a>
		<a class="w3-col s3 w3-button w3-text-red" href="profile.php">
			<i class="fa fa-user fa-2x"></i><br>Profile
		</a>
	</div>
</div>

</body>
</html>
