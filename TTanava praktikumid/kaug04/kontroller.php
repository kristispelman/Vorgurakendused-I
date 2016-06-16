<?php
require_once("functions.php");

$mode="suvaline";
if ( isset($_GET['mode']) ){
	$mode=$_GET['mode'];
}

include("views/head.html");
/*
if ($mode=="galerii"){
	include("galerii.html");
} else if ($mode=="login"){
	include("login.html");
}*/
switch($mode){
	case "galerii":
		galerii();
	break;
	case "login":
		login();
	break;
	case "register":
			register();		
	break;
	case "pildivorm":
		include("views/pildivorm.html");
	break;
	default:
		include("views/pealeht.html");
	break;
}

include("views/foot.html");

?>

















