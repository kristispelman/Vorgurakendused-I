<?php
require_once("func.php");
session_start();
baasi_yhendus();

$mode="";
if (!empty($_GET["mode"])){
	$mode=$_GET["mode"];
}
include_once("head.html");
switch($mode){
	case "loomad":
		kuva_loomad();
	break;
	case "loom":
		kuva_loom();
	break;
	case  "login":
		fake_login();
	break;
	case "logout":
		logout();
	break;
	case "lisa":
		lisa();
	break;
	default:
		include_once("vaated/v2rav.html");
	break;
}
include_once("foot.html");
?>

