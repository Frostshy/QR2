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
$act 		= (isset($_GET['act'])) ? trim($_GET['act']) : '';	

$id_lecturer= $_SESSION["id_lecturer"];
$id_student = (isset($_GET['id_student'])) ? trim($_GET['id_student']) : '';	
$search 	= (isset($_POST['search'])) ? trim($_POST['search']) : '';	

$sql_search = "";
if($search) $sql_search = "WHERE `name` LIKE '%$search%' ";

$success = "";

if($act == "del")
{
	$SQL_delete = " DELETE FROM `student` WHERE `id_student` =  '$id_student' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Successfully Delete";
	//print "<script>self.location='l-student.php';</script>";
}
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
				<b>Student List</b>
			</div>
		</div>
	</div>
</div>

<div class="w3-padding-32"></div>
<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "l-student.php"); }
?>

<!-- content -->	
<div class="w3-container " id="contact">
    <div class="w3-content w3-containerx " style="max-width:600px">	
			
		<div class="w3-padding-small"></div>
		
		<form action="" method="post" class="w3-row">			
			<input class="w3-col s10 w3-input w3-border w3-padding w3-round-large" type="text" name="search" value="<?PHP echo $search;?>" placeholder="Find name..">
			<button type="submit" class="w3-col s2 w3-button w3-round-large w3-red"><i class="fa fa-search"></i></button>
		</form>
		
		<div class="w3-padding-16"></div>

		<?PHP
		$bil = 0;
		$SQL_list = "SELECT * FROM `student` $sql_search";
		$result = mysqli_query($con, $SQL_list) ;
		while ( $data	= mysqli_fetch_array($result) )
		{
			$bil++;
			$id_student= $data["id_student"];
			$photo		= $data["photo"];
			if(!$photo) $photo = "noimage.png";
		?>			
			<div class="w3-card w3-white w3-round-large w3-padding-small" 	>
					
					<div class="w3-row">
						<div class="w3-col s3">
						<img src="upload/<?PHP echo $photo;?>" class="w3-image" style="width:80px">
						</div>
						<div class="w3-col s9 w3-padding-small">
							<b><?PHP echo $data["name"] ;?></b><br>
							<i class="far fa-envelope w3-margin-right"></i> <span class="w3-small"><?PHP echo $data["email"] ;?></span><br>
							<i class="fa fa-phone w3-margin-right"></i> <?PHP echo $data["phone"] ;?>							
							
							<span class="w3-right">															
								<a title="Delete" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-text-red"><i class="fa fa-fw fa-trash-alt fa-lg"></i></a>
							</span>
						</div>
					</div>			
			</div>
			
			<div class="w3-padding"></div>

<div id="idDelete<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="subject">
			<div class="w3-padding"></div>
			<b class="w3-large">Confirmation</b>
			  
			<hr class="w3-clear">			
			Are you sure to delete this record ?
			<div class="w3-padding-16"></div>
			
			<input type="hidden" name="id_student" value="<?PHP echo $data["id_student"];?>" >
			<input type="hidden" name="act" value="del" >
			<button type="button" onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'"  class="w3-button w3-gray w3-text-white w3-margin-bottom w3-round">CANCEL</button>
			
			<button type="submit" class="w3-right w3-button w3-red w3-text-white w3-margin-bottom w3-round">YES, CONFIRM</button>
		</form>
		</div>
	</div>
</div>			
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
		<a class="w3-col s3 w3-button w3-text-red" href="l-student.php">
			<i class="fa fa-user fa-2x"></i><br>Student
		</a>
		<a class="w3-col s3 w3-button" href="l-profile.php">
			<i class="fa fa-user-tie fa-2x"></i><br>Profile
		</a>
	</div>
</div>

</body>
</html>
