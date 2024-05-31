<?PHP
include("database.php");

$act 		= (isset($_POST['act'])) ? trim($_POST['act']) : '';

$level		= (isset($_POST['level'])) ? trim($_POST['level']) : '';
$id			= (isset($_POST['id'])) ? trim($_POST['id']) : '';
$name		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$phone		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';
$email		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$password	= (isset($_POST['password'])) ? trim($_POST['password']) : '';

$name		=	mysqli_real_escape_string($con, $name);

$error = "";
$success = false;

if($act == "register")
{	
	$found 	= numRows($con, "SELECT * FROM `$level` WHERE `email` = '$email' ");
	if($found) $error ="Email already registered";
}

if(($act == "register") && (!$error))
{	
	if($level == "student") {
		$SQL_insert = " 	
		INSERT INTO `student`(`student_id`, `name`, `email`, `phone`, `password`, `photo`) 
					VALUES ('$id', '$name', '$email', '$phone', '$password', '') ";
	} else {
		$SQL_insert = " 	
		INSERT INTO `lecturer`(`lecturer_id`, `name`, `email`, `phone`, `password`, `photo`, `office`, `location`, `status`) 
					VALUES ('$id', '$name', '$email', '$phone', '$password', '', '', '', '1') ";
	}
	$result = mysqli_query($con, $SQL_insert);
	$success = true;
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
  /*background-size: 100%;*/
  background-size: cover;
  background-image: url("images/back2.jpg");
  min-width: 100%;
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
		<a href="index.php" class="w3-right"><i class="fa fa-fw fa-times-circle fa-2x"></i></a> 
	</div>
</div>

<div class="w3-padding-16"></div>

<div class="w3-center"><img src="images/logo.png" class="w3-image" style="height:150px"></div>
	
<div class="w3-containerx" id="contact">
    <div class="w3-content w3-containerx " style="max-width:600px">
	<div class="w3-margin w3-padding " >	

		<div class="w3-padding"></div>
		
		<div class="w3-xlarge">
		<b>Create an Account</b>
		</div>
	
<?PHP if($error) { ?>
<div class="w3-panel w3-center w3-pale-red w3-display-container w3-animate-zoom">
	<h3>Error!</h3>
	<?PHP echo $error;?>
</div>	
<?PHP } ?>
	

<?PHP if($success) { ?>
<div class="w3-panel w3-center w3-border w3-border-red w3-round w3-display-container w3-animate-zoom">
  <h3>Congratulation!</h3>
  <p>Your registration has been successful!<br>You can now <a href="index.php"><b>Login</b>.</a> </p>
</div>
<?PHP  } else { ?>	
		<form action="" method="post" class="">

			<div class="w3-section" >
				<select class="w3-input w3-border w3-padding w3-round-large" name="level" required>
					<option value="student">Student</option>
					<option value="lecturer">Lecturer</option>
				</select>
			</div>
			
			<div class="w3-section" >
				<input class="w3-input w3-border w3-padding w3-round-large" type="text" name="id" placeholder="Id Student / Id Lecturer" maxlength="100" required>
			</div>
			
			<div class="w3-section" >
				<input class="w3-input w3-border w3-padding w3-round-large" type="text" name="name" placeholder="Full Name" maxlength="100" required>
			</div>
						
			<div class="w3-section" >
				<input class="w3-input w3-border w3-padding w3-round-large" type="email" name="email" placeholder="Email" maxlength="100" required>
			</div>
			
			<div class="w3-section" >
				<input class="w3-input w3-border w3-padding w3-round-large" type="text" name="phone" placeholder="Mobile Phone" maxlength="100" >
			</div>

			<div class="w3-section">
				<input class="w3-input w3-border w3-padding w3-round-large cpwdx" type="password" name="password" id="password" placeholder="Password" maxlength="40" required>
				<div class="w3-center w3-small">Password must at least be 6 characters</div>
			</div>

			<div class="w3-section">
				<input class="w3-input w3-border w3-padding w3-round-large cpwdx" type="password" name="repassword" id="repassword" placeholder="Confirm Password" maxlength="40" required>
				<div class="w3-padding w3-small"><input type="checkbox" onclick="myFunction()"> Show Password</div>
			</div>

			<script>
			function myFunction() {
			  var x = document.getElementById("password");
			  var y = document.getElementById("repassword");
			  if (x.type === "password") {
				x.type = "text";
				y.type = "text";
			  } else {
				x.type = "password";
				y.type = "password";
			  }
			}
			</script>



			<div class="w3-center">
				<input name="act" type="hidden" value="register">
				<button type="submit" class="w3-block w3-button  w3-margin-bottom w3-round-large w3-red"><b>REGISTER</b></button>
			</div>
		</form> 
		
		<div class="w3-center ">I agree with <a href="#" onclick="document.getElementById('idTerm').style.display='block'" class="w3-text-red">Terms and Conditions</a></div>
		
<?PHP  }  ?>	
		
		<hr style="margin: 5px 0 10px 0;">
		<div class="w3-center ">Already have an account? <a href="index.php" class="w3-text-red">Log In</a></div>
			
	</div>	
    </div>
</div>



<div class="w3-padding"></div>

<!--
<div class="w3-center w3-small w3-padding-24 w3-text-white">demo ver by BelajarPHP.com</div>
-->


</div>


<div id="idTerm" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idTerm').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
				
			<div class="w3-padding"></div>
			<b class="w3-large">Terms & Conditions</b>
			  
			<hr class="w3-clear">
			
			<p><b>QR Attendance</b> Lorem ipsum dolor sit amet. Vel delectus explicabo qui voluptatum blanditiis aut beatae quia et ipsam enim rem explicabo placeat. Ad minus mollitia hic officia alias ex temporibus dolores et totam autem non dolorum quae est vitae ratione et alias beatae. Aut rerum assumenda aut esse illo ut necessitatibus doloribus est omnis quam. Sit ipsa quam sed Quis nihil quo debitis eaque ut iusto repellat et veritatis labore aut ullam repellendus et nulla repellat.</p>			
			
			<div class="w3-padding-16"></div>
			
			<button type="button" onclick="document.getElementById('idTerm').style.display='none'"  class="w3-button w3-red w3-text-white w3-margin-bottom w3-round-xlarge">CLOSE</button>		
		</div>
	</div>
</div>	


</body>
</html>