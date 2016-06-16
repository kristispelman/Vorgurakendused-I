<?php
function login(){
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		// esimest korda lehel
		header('WWW-Authenticate: Basic realm="My Realm"');
		header('HTTP/1.0 401 Unauthorized');
 		die('login tühistatud');	
		
	} else {
		// proovis sisse logida, kontrolli väärtuseid
		if ($_SERVER['PHP_AUTH_USER']=="user" && $_SERVER['PHP_AUTH_PW']=="password") {
			// õige info
			return "<p>Tere {$_SERVER['PHP_AUTH_USER']}.</p><p>Sisestasid õige parooli: {$_SERVER['PHP_AUTH_PW']}</p>";
		} else {
			// vale info
			header('WWW-Authenticate: Basic realm="My Realm"');
			header('HTTP/1.0 401 Unauthorized');
  		die("<p><b>Vale info:</b><br/>U: {$_SERVER['PHP_AUTH_USER']}<br/>P: {$_SERVER['PHP_AUTH_PW']}</p>");
		}
	}
}


$text="";
$mode="";
if (isset($_GET['mode'])){
	$mode=$_GET['mode'];
	}

switch($mode){
	default:
		$text="<p>avalik lehekülg, <a href=\"?mode=privaatne\">sisene</a></p>";
	break;
	case "privaatne":
			$text=login();
			$text.= "<p>piiratud ligipääsuga leht</p>";
	break;	
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Http  auth</title>
</head>
<body>
<?php echo $text; ?>

</body>
</html>

