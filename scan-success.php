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
$qrcode	= (isset($_REQUEST['qrcode'])) ? trim($_REQUEST['qrcode']) : '';

$error	= "";
$success = "";

$found 	= numRows($con, "SELECT * FROM `class` WHERE `qrcode` = '$qrcode' ");
if($found == 0) {
	header( "Location: scan-fail.php" );
	exit;
}

$Date	= date("Y-m-d");
$Time	= date("H:i:s");

$SQL_list 	= "SELECT * FROM `class` WHERE `qrcode` = '$qrcode'  ";
$result 	= mysqli_query($con, $SQL_list) ;
$data		= mysqli_fetch_array($result);
$id_class	= $data["id_class"];
$id_subject	= $data["id_subject"];
$ipAddress	= $data["ipaddress"];

$found 	= numRows($con, "SELECT * FROM `attendance` WHERE `id_student` = '$id_student' AND `id_class` = '$id_class' ");
if($found) $error ="Already Scanned";

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


// Function to get the current WiFi SSID
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


if($ipAddress <> $ipaddress) $error ="Invalid wifi network";


if(!$error)
{
	$SQL_insert = " 	
		INSERT INTO `attendance`(`id_attendance`, `id_class`, `id_subject`, `id_student`, `checkin`, `ipaddress`, `created_date`) 
						VALUES (NULL, '$id_class', '$id_subject', '$id_student', NOW(), '$ipaddress', NOW() )
	";
										
	$result = mysqli_query($con, $SQL_insert);
	
	$success = "true";
}
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

<div class="w3-padding-16"></div>

<div class="w3-containerx" id="contact">
    <div class="w3-content w3-container w3-padding-16" style="max-width:450px">
			
		<div class="w3-section w3-center w3-xxlarge" >
			<div class="w3-center"><img src="images/success.jpg" class="w3-image" style="width:100%"></div>
		</div>
		
		<div class="w3-padding-small"></div>
		
		<?PHP if($success) { ?>
		<div class="w3-section w3-center w3-xlarge" >
			<b>Congrats, you<br>successfully attend<br>this class today !</b>
		</div>
		<?PHP } ?>
		
		<?PHP if($error) { ?>
		<div class="w3-section w3-center w3-xlarge" >
			<b>Sorry, <br><?PHP echo $error;?></b>
		</div>
		<?PHP } ?>
		
		
		<div class="w3-section w3-center w3-large w3-text-grey" >
			<?PHP echo $Date;?>
		</div>
		
		<div class="w3-padding-small"></div>
		
		<a href="main.php" class="w3-padding-large w3-wide w3-block w3-button w3-margin-bottom w3-round-large w3-red"><b><i class="fa fa-fw fa-chevron-left"></i> BACK</b></a>
	</div>
</div>
<!-- Content End -->



</body>
</html>
