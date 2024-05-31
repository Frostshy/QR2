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
  line-height: 1.3;
}


.w3-merah,.w3-hover-merah:hover{color:#fff!important;background-color:#fe0000!important}

img[alt="www.000webhost.com"]{display:none}
</style>

<body class="">

<div class="w3-containerx " id="contact">
    <div class="w3-content w3-containerx " style="max-width:600px">
	<div class="w3-margin w3-padding " >
		

		<div class="w3-padding-32"></div>
		<div class="w3-center"><img src="images/logo.png" class="w3-image"></div>
		<div class="w3-center w3-xlarge w3-padding-16"><b>QR Attendance<br>System</b></div>
		<div class="w3-padding-32"></div>
		
		<a href="index.php" class="w3-padding-large w3-block w3-button w3-round-large w3-red"><b>Let's Get Started</b></a>
    </div>
	</div>
</div>

<?PHP 
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

function getExternalIpAddr() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.ipify.org');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}



?>

<div class="w3-center"><?PHP echo 'IP - '.getExternalIpAddr();?></div>




</body>
</html>
