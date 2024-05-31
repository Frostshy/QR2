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

$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$student_id	= (isset($_POST['student_id'])) ? trim($_POST['student_id']) : '';
$name		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$email		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$phone		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';
$password	= (isset($_POST['password'])) ? trim($_POST['password']) : '';

$name		=	mysqli_real_escape_string($con, $name);

$success = "";

if($act == "edit")
{	
	$SQL_update = " 
	UPDATE
		`student`
	SET
		`name` = '$name',
		`student_id` = '$student_id',
		`email` = '$email',
		`phone` = '$phone',
		`password` = '$password'
	WHERE
		id_student = $id_student
	";
										
	$result = mysqli_query($con, $SQL_update);
	
	if(($_FILES["photo"]["error"] == 0) && (isset($_FILES['photo']))) {
		  $file_name = $_FILES['photo']['name'];
		  $file_size = $_FILES['photo']['size'];
		  $file_tmp = $_FILES['photo']['tmp_name'];
		  $file_type = $_FILES['photo']['type'];
		  
		  $fileNameCmps = explode(".", $file_name);
		  $file_ext = strtolower(end($fileNameCmps));
		  $new_file	= rand() . "." . $file_ext;
		  
		  if(empty($errors)==true) {
			 move_uploaded_file($file_tmp,"upload/".$new_file);
			 
			$query = "UPDATE `student` SET `photo`='$new_file' WHERE `id_student` = '$id_student'";			
			$result = mysqli_query($con, $query) or die("Error in query: ".$query."<br />".mysqli_error($con));
		  }else{
			 print_r($errors);
		  }  
	}
	
	$success = "Successfully Updated";
	
	//print "<script>self.location='profile.php';</script>";
}

if($act == "photo_del")
{
	$dat	= mysqli_fetch_array(mysqli_query($con, "SELECT `photo` FROM `student` WHERE `id_student`= '$id_student'"));
	unlink("upload/" .$dat['photo']);
	$rst_d 	= mysqli_query( $con, "UPDATE `student` SET `photo`='' WHERE `id_student` = '$id_student' " );
	print "<script>self.location='profile.php';</script>";
}

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

img[alt="www.000webhost.com"]{display:none}
</style>

<body class="">

	
<div class="w3-padding"></div>

<div class="w3-top">
	<div class="w3-card w3-white w3-content" style="max-width:600px">
		<div class="w3-row w3-xlarge w3-center w3-padding-small">
			<div class="w3-col s2">
				<a href="profile.php"><i class="fa fa-fw fa-chevron-circle-left fa-lg w3-text-red"></i></a>
			</div>
			<div class="w3-col  s8">
				<b>Profile Edit</b>
			</div>
		</div>
	</div>
</div>

<div class="w3-padding"></div>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "profile.php"); }
?>	
<!-- Content -->

<div class="w3-containerx" id="contact">
    <div class="w3-content w3-container w3-padding-16" style="max-width:450px">
		
		<div class="w3-padding-16"></div>
		
		<form action="" method="post" enctype = "multipart/form-data" >			
			 
			<div class="w3-section w3-center" >
				<img src="upload/<?PHP echo $photo; ?>" class="w3-circle w3-image" alt="image" style="width:100%;max-width:200px">
				<?PHP if($data["photo"] <>"") { ?>
				<br>
				<a class="w3-tag w3-red w3-round w3-small" href="?act=photo_del"><small>Remove</small></a>
				<?PHP }  ?>
			</div>
			
			<div class="w3-section" >
				<?PHP if($data["photo"] =="") { ?>
				<div class="custom-file">
					<input type="file" class="w3-input w3-border w3-round-large" name="photo" id="photo" accept=".jpeg, .jpg,.png,.gif">
					<small>  only JPEG, JPG, PNG or GIF allowed </small>
				</div>
				<?PHP } ?>
			</div>
			
			<div class="w3-section" >
				Student ID
				<input class="w3-input w3-border w3-padding w3-round-large" type="text" name="student_id" value="<?PHP echo $data["student_id"];?>" placeholder="Student ID" required>
			</div>
			
			<div class="w3-section" >
				Full Name
				<input class="w3-input w3-border w3-padding w3-round-large" type="text" name="name" value="<?PHP echo $data["name"];?>" placeholder="Full Name" maxlength="100" required>
			</div>
			
			<div class="w3-section" >
				Email
				<input class="w3-input w3-border w3-padding w3-round-large" type="email" name="email" value="<?PHP echo $data["email"];?>" placeholder="Email" required>
			</div>
			
			<div class="w3-section" >
				Contact No
				<input class="w3-input w3-border w3-padding w3-round-large" type="text" name="phone" value="<?PHP echo $data["phone"];?>" placeholder="Mobile Phone" required>
			</div>

			<div class="w3-section">
				Password
				<input class="w3-input w3-border w3-padding w3-round-large cpwdx" type="password" name="password" id="password" value="<?PHP echo $data["password"];?>" placeholder="Password" maxlength="40" required>
				<div class="w3-center w3-small">Password must at least be 6 characters</div>
			</div>
			
			<div class="w3-padding"></div>

			<div class="w3-center">
				<input name="act" type="hidden" value="edit">
				<button type="submit" class="w3-padding-large w3-block w3-button w3-margin-bottom w3-round-large w3-red"><b>SAVE CHANGES</b></button>
			</div>
		</form>
		
		<div class="w3-padding-16"></div>
				
	</div>
</div>
<!-- Content End -->



</body>
</html>
