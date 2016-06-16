<?php
require_once("func.php");
connect_db();
session_start();

$mode="";
if (!empty($_GET['page'])){
	$mode=$_GET['page'];
}


switch($mode){
	case "register":
		reg();
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
	case "posts":
		kuva_postitused();
	break;
	case "postit":
		post_it();
	break;
	case "edit":
		edit_post();
	break;
	default:
		$postitused = hangi_postitused();
		include("views/head.html");
		include("views/pealeht.html");
		include("views/foot.html");
	break;
}
?>
