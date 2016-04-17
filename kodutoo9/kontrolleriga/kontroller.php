<?php
	require_once('head.html');
?>

<?php
	$fotod=array(
	array("src"=>"pildid/nameless1.jpg", "alt"=>"nimetu 1", "id"=>"p1", "value"=>"1"),
	array("src"=>"pildid/nameless2.jpg", "alt"=>"nimetu 2", "id"=>"p2", "value"=>"2"),
	array("src"=>"pildid/nameless3.jpg", "alt"=>"nimetu 3", "id"=>"p3", "value"=>"3"),
	array("src"=>"pildid/nameless4.jpg", "alt"=>"nimetu 4", "id"=>"p4", "value"=>"4"),
	array("src"=>"pildid/nameless5.jpg", "alt"=>"nimetu 5", "id"=>"p5", "value"=>"5"),
	array("src"=>"pildid/nameless6.jpg", "alt"=>"nimetu 6", "id"=>"p6", "value"=>"6")
	);
	if (isset($_GET["page"])&& $_GET["page"]!=""){
	$page = $_GET["page"];
	} else {
	$page = "pealeht";
	}	
	switch($page){
	case 'pealeht': include("pealeht.html"); break;
	case 'galerii': include("galerii.html"); break;
	case 'vote': include("vote.html"); break;
	case 'tulemus': include("tulemus.html"); break;
	default: include("pealeht.html"); break;
	}
?>

<?php
	require_once('foot.html');
?>
