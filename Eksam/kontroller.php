<?php
require_once("func.php");
connect_db();
session_start();

$mode="";
if (!empty($_GET['page'])){
	$mode=$_GET['page'];
}

include_once("views/head.html");
switch($mode){
	case "register":
		registreeri();
	break;
	case "login":
		logi();
	break;
	case "logout":
		$_SESSION = array();
		session_destroy();
		header("Location: ?"); // pealehele
	break;
	case "post":
		kuva_post();
	break;
	case "postit":
		post_it();
	break;
	default:
		$postitused = hangi_postitused();
		include("views/pealeht.html");
	break;
}
include_once("views/foot.html");
?>

