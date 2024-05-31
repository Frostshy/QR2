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

$id_subject	= (isset($_REQUEST['id_subject'])) ? trim($_REQUEST['id_subject']) : '0';

$code		= (isset($_POST['code'])) ? trim($_POST['code']) : '';
$subject	= (isset($_POST['subject'])) ? trim($_POST['subject']) : '';

$code		= mysqli_real_escape_string($con, $code);
$subject	= mysqli_real_escape_string($con, $subject);

$success = "";

if($act == "add")
{	
	$SQL_insert = " 
	INSERT INTO `subject`(`id_subject`, `id_lecturer`, `code`, `subject`) 
				VALUES (NULL, '$id_lecturer', '$code', '$subject')";		
										
	$result = mysqli_query($con, $SQL_insert);
	
	$success = "Successfully Add";
	
	//print "<script>self.location='c-subject.php';</script>";
}

if($act == "edit")
{	
	$SQL_update = " UPDATE
						`subject`
					SET
						`code` = '$code',
						`subject` = '$subject'
					WHERE `id_subject` =  '$id_subject'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	$success = "Successfully Update";
	//print "<script>self.location='c-subject.php';</script>";
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `subject` WHERE `id_subject` =  '$id_subject' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Successfully Delete";
	//print "<script>self.location='c-subject.php';</script>";
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
				<b>Manage Subject</b>
			</div>
		</div>
	</div>
</div>

	
<div class="w3-padding-48"></div>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "l-subject.php"); }
?>	
<!-- Content -->

<?PHP
$bil = 0;
$SQL_list = "SELECT * FROM `subject` WHERE `id_lecturer` = $id_lecturer";
$result = mysqli_query($con, $SQL_list) ;
while ( $data	= mysqli_fetch_array($result) )
{
	$bil++;
	$id_subject= $data["id_subject"];
?>			
<div class="w3-container w3-padding-12" id="contact">
    <div class="w3-content w3-container w3-card w3-white w3-round-large w3-padding-small" style="max-width:600px">
			
			<div class="w3-padding">
				<div class="w3-row">
					<div class="w3-col s3">Code : </div>
					<div class="w3-col s9"><b><?PHP echo $data["code"] ;?></b></div>
					<div class="w3-col s3">Subject : </div>
					<div class="w3-col s9"><?PHP echo $data["subject"] ;?></div>
				</div>
				<hr style="margin: 10px 0 10px 0">
				<span class="w3-right">							
					<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class=""><i class="fa fa-edit fa-lg w3-margin-right"></i></a>
					<a title="Delete" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-text-red"><i class="fa fa-fw fa-trash-alt fa-lg"></i></a>
				</span>
			</div>
			
    </div>
</div>
<div class="w3-padding"></div>



<div id="idEdit<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idEdit<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Update Subject</b>
			<hr>
				
				<div class="w3-section" >
					Subject Code *
					<input class="w3-input w3-border w3-round" type="text" name="code" value="<?PHP echo $data["code"]; ?>" placeholder="">
				</div>
				
				<div class="w3-section" >
					Subject *
					<input class="w3-input w3-border w3-round" type="text" name="subject" value="<?PHP echo $data["subject"]; ?>" placeholder="" required>
				</div>
			  
			<hr class="w3-clear">
			<input type="hidden" name="id_subject" value="<?PHP echo $data["id_subject"];?>" >
			<input type="hidden" name="act" value="edit" >
			<button type="submit" class="w3-button w3-wide w3-red w3-text-white w3-margin-bottom w3-round-large"><b>SAVE CHANGES</b></button>
		</form>
		</div>
	</div>
<div class="w3-padding-24"></div>
</div>


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
			
			<input type="hidden" name="id_subject" value="<?PHP echo $data["id_subject"];?>" >
			<input type="hidden" name="act" value="del" >
			<button type="button" onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'"  class="w3-button w3-gray w3-text-white w3-margin-bottom w3-round">CANCEL</button>
			
			<button type="submit" class="w3-right w3-button w3-red w3-text-white w3-margin-bottom w3-round">YES, CONFIRM</button>
		</form>
		</div>
	</div>
</div>
<?PHP } ?>

<div class="w3-padding-16"></div>

</div>

<div class="w3-padding-64"></div>

<div id="idAdd" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idAdd').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>
	  
      <div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Add Subject</b>
			<hr>

				<div class="w3-section" >
					Subject Code *
					<input class="w3-input w3-border w3-round" type="text" name="code" value="" placeholder="" required>
				</div>
			
				<div class="w3-section" >
					Subject *
					<input class="w3-input w3-border w3-round" type="text" name="subject" value="" placeholder="" required>
				</div>

			  <hr class="w3-clear">
			  
			  <div class="w3-section" >
				<input name="act" type="hidden" value="add">
				<button type="submit" class="w3-button w3-wide w3-red w3-text-white w3-round-large"><b>SUBMIT</b></button>
			  </div>
			</div>  
		</form> 
         
      </div>
<div class="w3-padding-24"></div>
</div>
	

<style>
.element {
  position: fixed;
  /*z-index: 999;*/
  right: 10px;
  bottom: 5%;
  margin-top: -2.5em;
}
</style>
<div class="element">
<a onclick="document.getElementById('idAdd').style.display='block'; w3_close()" class="w3-xlarge"><i class="fa fa-fw fa-4x fa-plus-circle w3-text-red w3-white w3-circle" style="width:100px"></i></a>
</div>	
	

</body>
</html>
