<?php
require_once('funktsioonid.php');
session_start();
connect_db();
$page="avaleht";
if (isset($_GET['page']) && $_GET['page']!=""){
	$page=htmlspecialchars($_GET['page']);
}
include_once('views/head.html');
switch($page){
	case "login":
		logi();
	break;
	case "tooted":
		kuva_tooted();
	break;
	case "logout":
		logout();
	break;
	case "lisa":
		lisa();
	break;
	case "kustutamine":
		kustuta();
	break;
	case "kuva_toode":
		kuva_toode();
	break;
	case "muutmine":
		muuda();
	break;
	default:
		include_once('views/avaleht.html');
	break;
}
include_once('views/foot.html');
?>