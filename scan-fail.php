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
?>
<!DOCTYPE html>
<html>
<title>QR Attendance</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
a:link {
  text-decoration: none;
}

body,h1,h2,h3,h4,h5,h6 {font-family: "Poppins", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

.w3-bar .w3-button {
  padding: 16px;
}


img[alt="www.000webhost.com"]{display:none}
</style>

<body class="bgimg-1">

<div class="w3-padding"></div>

<div class="w3-top">
	<div class="w3-card w3-white w3-content" style="max-width:600px">
		<div class="w3-row w3-xlarge w3-center w3-padding-small">
			<div class="w3-col s2">
				<a href="main.php"><i class="fa fa-fw fa-chevron-circle-left fa-lg w3-text-red"></i></a>
			</div>
			<div class="w3-col  s8">
				<b>Scan QR</b>
			</div>
		</div>
	</div>
</div>

<div class="w3-padding-32"></div>

<div class="w3-containerx" id="contact">
    <div class="w3-content w3-container w3-padding-16" style="max-width:450px">
			
		<div class="w3-section w3-center w3-xxlarge" >
			<div class="w3-center"><img src="images/fail.jpg" class="w3-image" style="width:200px"></div>
		</div>
		
		<div class="w3-padding-small"></div>
		
		<div class="w3-section w3-center w3-xlarge" >
			<b>Sorry, your<br>attendance failed<br> to be recorded!</b>
		</div>
		
		
		<div class="w3-section w3-center w3-large w3-text-grey" >
			Please try again
		</div>
		
		<div class="w3-padding-32"></div>
		
		<a href="scan.php" class="w3-padding-large w3-wide w3-block w3-button w3-margin-bottom w3-round-large w3-red"><b><i class="fa fa-fw fa-chevron-left"></i> BACK</b></a>
	</div>
</div>
<!-- Content End -->



</body>
</html>
