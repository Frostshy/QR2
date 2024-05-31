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
	
$id_subject = (isset($_POST['id_subject'])) ? trim($_POST['id_subject']) : '0';	
$date_find 	= (isset($_POST['date_find'])) ? trim($_POST['date_find']) : date("Y-m-d");	

$sql_date = "";
if($date_find) $sql_date = "AND attendance.created_date = '$date_find' ";

$sql_subject = "";
$sql_subject = "AND attendance.id_subject = '$id_subject' ";
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
  background-image: url(images/banner.jpg);
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
		<div class="w3-row w3-xlarge w3-center w3-padding-small">
			<div class="w3-col s2">
				<a href="l-main.php"><i class="fa fa-fw fa-chevron-circle-left fa-lg w3-text-red"></i></a>
			</div>
			<div class="w3-col  s8">
				<b>Attendance History</b>
			</div>
		</div>
	</div>
</div>

<div class="w3-padding-32"></div>

<!-- content -->	
<div class="w3-container " id="contact">
    <div class="w3-content w3-containerx " style="max-width:600px">	
			
		<div class="w3-padding-small"></div>
		
		<form action="" method="post" class="w3-row">			
			
			<select class="w3-select w3-border w3-round w3-padding" name="id_subject" required>
				<option value="">- Select Subject - </option>
			<?PHP 
			$rst = mysqli_query($con , "SELECT * FROM `subject` WHERE `id_lecturer` = $id_lecturer");
			while ($dat = mysqli_fetch_array($rst) )
			{
			?>
				<option value="<?PHP echo $dat["id_subject"];?>" <?PHP if($dat["id_subject"] ==  $id_subject) echo "selected";?>><?PHP echo $dat["subject"];?></option>
			<?PHP } ?>
			</select>
			
			
			<input class="w3-col s10 w3-input w3-border w3-padding w3-round-large" type="date" name="date_find" value="<?PHP echo $date_find;?>" placeholder="">

			<button type="submit" class="w3-col s2 w3-button w3-round-large w3-red"><i class="fa fa-search"></i></button>
		</form>
		
		<div class="w3-padding-16"></div>

		<?PHP
		$bil = 0;
		$SQL_list = "SELECT * FROM `attendance`,`class`,`student` WHERE attendance.id_student = student.id_student AND attendance.id_class = class.id_class AND class.id_lecturer = $id_lecturer $sql_date $sql_subject";
		
		$result = mysqli_query($con, $SQL_list) ;
		while ( $data	= mysqli_fetch_array($result) )
		{
			$bil++;
			$time_start	= date_create($data["time_start"]);
			$time_end	= date_create($data["time_end"]);
			$time_start = date_format($time_start,"H:i");
			$time_end 	= date_format($time_end,"H:i");
		?>			
			<div class="w3-card w3-white w3-round-large w3-padding-small" 	>
					
				<div class="w3-row">
					<div class="w3-col s3">Student : </div>
					<div class="w3-col s9"><b><?PHP echo $data["name"] ;?></b></div>
					<div class="w3-col s3">Date : </div>
					<div class="w3-col s9"><?PHP echo $data["date"] ;?></div>
					<div class="w3-col s3">Time : </div>
					<div class="w3-col s9"><?PHP echo $time_start . " - "  . $time_end;?></div>
					<div class="w3-col s3">Checkin : </div>
					<div class="w3-col s9"><b><?PHP echo $data["checkin"] ;?></b> <i class="fa fa-fw fa-check w3-text-green"></i></div>
				</div>
			
			</div>
			<div class="w3-padding-small"></div>
		<?PHP } ?>
		
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
		<a class="w3-col s3 w3-button " href="l-student.php">
			<i class="fa fa-user fa-2x"></i><br>Student
		</a>
		<a class="w3-col s3 w3-button" href="l-profile.php">
			<i class="fa fa-user-tie fa-2x"></i><br>Profile
		</a>
	</div>
</div>

</body>
</html>
