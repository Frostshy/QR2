<?PHP
$SQL_list 	= "SELECT * FROM `student` WHERE `id_student` = '$id_student'  ";
$result 	= mysqli_query($con, $SQL_list) ;
$data		= mysqli_fetch_array($result);
?>
<!-- Navbar (sit on top) -->
<div class="w3-top" style="z-index=0">
	<div class="w3-bar w3-white w3-card" id="myNavbar">
		&nbsp;<a href="main.php"><img src="images/logo.png" height="65"></a>
		<a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
		  <i class="fa fa-bars"></i>
		</a>
	</div>
</div>

<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-red w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
	<a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>

	<div class="w3-padding ">
	<b><?PHP echo	$name;?></b>
	</div>
	<hr>
	
	<a href="main.php" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa fa-fw fa-home"></i> Main</a>
	<a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa fa-fw fa-user-circle"></i> Profile</a>
	<a href="sign-out.php" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa fa-fw fa-power-off"></i> Logout</a>
</nav>