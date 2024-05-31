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
$today	= date("Y-m-d");
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

body,h1, h2,h3,h4,h5,h6 {font-family: "Poppins", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  min-height: 100%;
  background-image: url(images/banner.jpg);
  background-color: rgba(255, 255, 255, 0.8);
  background-blend-mode: overlay;
  background-attachment:fixed;
}

.w3-bar .w3-button {
  padding: 16px;
}


</style>

<body class="bgimg-1">


<div class="" >

<div class="w3-top">
	<div class="w3-card w3-white w3-content" style="max-width:600px">
		<div class="w3-row w3-xlarge w3-center w3-padding-small">
			<div class="w3-col s2">
				<a href="l-main.php"><i class="fa fa-fw fa-chevron-circle-left fa-lg w3-text-red"></i></a>
			</div>
			<div class="w3-col  s8">
				<b>Class - QR CODE</b>
			</div>
		</div>
	</div>
</div>

<div class="w3-padding-32"></div>

<div class="w3-center "><b>Class for Today</b></div>
	
<div class="w3-padding"></div>


<!-- Content -->

<?PHP
$bil = 0;
$SQL_list = "SELECT * FROM `class`,`subject` WHERE class.id_subject = subject.id_subject AND class.id_lecturer = $id_lecturer AND `date` = '$today' ";
$result = mysqli_query($con, $SQL_list) ;
while ( $data	= mysqli_fetch_array($result) )
{
	$bil++;
	$id_class= $data["id_class"];
	$time_start	= date_create($data["time_start"]);
	$time_end	= date_create($data["time_end"]);
	$time_start = date_format($time_start,"H:i");
	$time_end 	= date_format($time_end,"H:i");
?>			
<div class="w3-container w3-padding-12" id="contact">
    <div class="w3-content w3-container w3-card w3-white w3-round-large w3-padding-small" style="max-width:600px">
			
			<div class="w3-padding">
				<div class="w3-row">
					<div class="w3-col s3">Subject : </div>
					<div class="w3-col s9"><b><?PHP echo $data["subject"] ;?></b></div>
					<div class="w3-col s3">Date : </div>
					<div class="w3-col s9"><?PHP echo $data["date"] ;?></div>
					<div class="w3-col s3">Time : </div>
					<div class="w3-col s9"><?PHP echo $time_start . " - "  . $time_end;?></div>
				</div>
				<hr style="margin: 10px 0 10px 0">
				<div class="w3-center">							
					<a href="l-qrcode-detail.php?id_class=<?PHP echo $id_class;?>" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-red w3-round"><i class="fa fa-fw fa-qrcode fa-lg"></i> QR CODE</a>
				</div>
			</div>
			
    </div>
</div>
<div class="w3-padding"></div>

<?PHP } ?>

<div class="w3-padding-16"></div>

</div>

<div class="w3-padding-64"></div>
	

</body>
</html>
