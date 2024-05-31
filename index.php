<?PHP
session_start();
?>
<?PHP
include("database.php");

$act 		= (isset($_POST['act'])) ? trim($_POST['act']) : '';
$level 		= (isset($_POST['level'])) ? trim($_POST['level']) : '';
$email 		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$password 	= (isset($_POST['password'])) ? trim($_POST['password']) : '';

$error = "";

if($act == "login")
{	
	$SQL_login 	= " SELECT * FROM `$level` WHERE `email` = '$email' AND `password` = '$password' ";

	$result = mysqli_query($con, $SQL_login);
	$data	= mysqli_fetch_array($result);

	$valid = mysqli_num_rows($result);

	if($valid > 0)
	{
		$_SESSION["email"] 		= $email;
		$_SESSION["password"] 	= $password;
		
		if($level =="student"){
			$_SESSION["id_student"] = $data["id_student"];		
			header("Location:main.php");
		}
		if($level =="lecturer"){
			$_SESSION["id_lecturer"] = $data["id_lecturer"];		
			header("Location:l-main.php");
		}
	}else{
		$error = "Invalid Login";
		header("refresh:1;url=index.php");
	}
}
?>
<!DOCTYPE html>
<html>
<title>QR Attendance</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

<div class="" >

<div class="w3-containerx w3-top" id="contact">
    <div class="w3-content w3-container w3-padding-16" style="max-width:600px">		 
		<a href="index_app.php" class="w3-right"><i class="fa fa-fw fa-times-circle fa-2x"></i></a> 
	</div>
</div>

<div class="w3-padding-16"></div>

<div class="w3-center"><img src="images/logo.png" class="w3-image" style="height:150px"></div>
	
<div class="w3-containerx " id="contact">
    <div class="w3-content w3-containerx " style="max-width:600px">
	<div class="w3-margin w3-padding " >		
		
		<div class="w3-xlarge w3-text-red w3-center"><b>Welcome Back!</b></div>
		
		<div class="w3-padding-16"></div>
		<div class="w3-large"><b>Sign In	</b></div>
	
	<?PHP if($error) { ?>
		<div class="w3-center w3-border w3-border-red w3-round" id="contact">
				<div class="w3-large">Error! </div>
				<?PHP echo $error;?>
		</div>	
	<?PHP } ?>
	

		<form action="" method="post" class="">		

			<div class="w3-section" >
				<input class="w3-input w3-border w3-padding w3-round-large" type="email" name="email" placeholder="Email" required>
			</div>
			
			<div class="w3-section">
				<input class="w3-input w3-border w3-padding w3-round-large cpwdx" type="password" name="password" id="password" placeholder="Password" required>
				<div class="w3-padding w3-small"><input type="checkbox" onclick="myFunction()"> Show Password</div>
			</div>
			  
			<script>
			function myFunction() {
			  var x = document.getElementById("password");
			  if (x.type === "password") {
				x.type = "text";
			  } else {
				x.type = "password";
			  }
			}
			</script>
			
			<div class="w3-section" >
				<select class="w3-input w3-border w3-padding w3-round-large" name="level" required>
					<option value="student">Student</option>
					<option value="lecturer">Lecturer</option>
				</select>
			</div>
				
			<div class="w3-padding-16"></div>
			  
			<div class="w3-center">
			<input name="act" type="hidden" value="login">
			<button type="submit" class="w3-paddingx w3-block w3-button w3-large w3-margin-bottom w3-round-large w3-red"><b>Login</b></button>
			</div>
		</form>
		
		<div class="w3-center ">Don't have an account? <a href="register.php" class="w3-text-red">Sign Up</a></div>
		
		<div class="w3-padding-16"></div>
				
    </div>
	</div>
</div>


</div>

</body>
</html>
