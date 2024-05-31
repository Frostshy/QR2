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

$id_class = (isset($_GET['id_class'])) ? trim($_GET['id_class']) : '';

$SQL_list = "SELECT * FROM `class`,`subject` WHERE class.id_subject = subject.id_subject AND class.id_class = $id_class";
$result	= mysqli_query($con, $SQL_list) ;
$data	= mysqli_fetch_array($result);
$qrcode	= $data["qrcode"];
$time_start	= date_create($data["time_start"]);
$time_end	= date_create($data["time_end"]);
$time_start = date_format($time_start,"H:i");
$time_end 	= date_format($time_end,"H:i");

function getLocalIpAddress() {
    // Check if the server is running on a Windows OS
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // Execute the `ipconfig` command and capture the output
        $output = shell_exec('ipconfig');
        // Check if the output was successfully captured
        if ($output !== null) {
            // Use a regular expression to find the IPv4 address in the output
            preg_match('/Wireless LAN adapter Wi-Fi:.*?\n.*?IPv4 Address[^\d]*([\d\.]+)/s', $output, $matches);
            // Return the found IP address or a failure message
            return isset($matches[1]) ? $matches[1] : 'IP address not found';
        }
    } else {
        // For Unix-based systems (Linux, macOS), execute the `ifconfig` command
        $output = shell_exec('/sbin/ifconfig');
        // Check if the output was successfully captured
        if ($output !== null) {
            // Use a regular expression to find the IPv4 address in the output
            preg_match('/wlan0: .*?inet ([\d\.]+)/s', $output, $matches);
            // Return the found IP address or a failure message
            return isset($matches[1]) ? $matches[1] : 'IP address not found';
        }
    }
    // If the operating system is unrecognized, return a failure message
    return 'IP address not found';
} 

// update current lecturer IP Address
//$ipaddress = getLocalIpAddress();


function getWifiSSID() {
    // Check if the server is running on a Windows OS
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // Execute the `netsh wlan show interfaces` command and capture the output
        $output = shell_exec('netsh wlan show interfaces');
        // Check if the output was successfully captured
        if ($output !== null) {
            // Use a regular expression to find the SSID in the output
            preg_match('/\s+SSID\s+:\s(.*)\s*/', $output, $matches);
            // Return the found SSID or a failure message
            return isset($matches[1]) ? $matches[1] : 'SSID not found';
        }
    } else {
        // For Unix-based systems (Linux, macOS), try using `nmcli` first
        $output = shell_exec('nmcli -t -f active,ssid dev wifi | egrep \'^yes\'');
        // Check if the output was successfully captured
        if ($output !== null && !empty($output)) {
            // Parse the SSID from the output
            $ssid = trim(explode(":", $output)[1]);
            return !empty($ssid) ? $ssid : 'SSID not found';
        } else {
            // As a fallback, use `iwgetid` command
            $output = shell_exec('iwgetid -r');
            // Return the SSID or a failure message
            return !empty($output) ? trim($output) : 'SSID not found';
        }
    }
    // If the operating system is unrecognized, return a failure message
    return 'SSID not found';
}

// Get the current WiFi SSID
//$ipaddress = getWifiSSID();

// Display the current WiFi SSID
//echo "Current WiFi SSID: " . $wifiSSID;


function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$ipaddress = getUserIpAddr();

$SQL_update = "UPDATE `class` SET `ipaddress` = '$ipaddress' WHERE `id_class` =  '$id_class'";	
$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
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
				<a href="l-qrcode.php"><i class="fa fa-fw fa-chevron-circle-left fa-lg w3-text-red"></i></a>
			</div>
			<div class="w3-col  s8">
				<b>SCAN THIS QRCODE</b>
			</div>
		</div>
	</div>
</div>

	
<div class="w3-padding-48"></div>

<!-- Content -->

			
<div class="w3-container" id="contact">
    <div class="w3-content w3-container w3-card w3-white w3-round-large w3-padding-small" style="max-width:600px">
			
			<img src="https://quickchart.io/qr?text=<?PHP echo $qrcode;?>&size=500" class="w3-image">
			<hr>
			<div class="w3-padding">
				<div class="w3-row">
					<div class="w3-col s3">Subject : </div>
					<div class="w3-col s9"><b><?PHP echo $data["subject"] ;?></b></div>
					<div class="w3-col s3">Date : </div>
					<div class="w3-col s9"><b><?PHP echo $data["date"] ;?></b></div>
					<div class="w3-col s3">Time : </div>
					<div class="w3-col s9"><b><?PHP echo $time_start . " - "  . $time_end;?></b></div>
				</div>
			</div>
			
    </div>
</div>
<div class="w3-padding"></div>


<div class="w3-padding-16"></div>

</div>

<div class="w3-padding-64"></div>
	

</body>
</html>
