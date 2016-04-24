<?php
	session_start();
	require_once("head.html");
?>

<?php
	$fotod=array(
	1=>array("src"=>"pildid/nameless1.jpg", "alt"=>"nimetu 1", "id"=>"p1", "value"=>"1"),
	2=>array("src"=>"pildid/nameless2.jpg", "alt"=>"nimetu 2", "id"=>"p2", "value"=>"2"),
	3=>array("src"=>"pildid/nameless3.jpg", "alt"=>"nimetu 3", "id"=>"p3", "value"=>"3"),
	4=>array("src"=>"pildid/nameless4.jpg", "alt"=>"nimetu 4", "id"=>"p4", "value"=>"4"),
	5=>array("src"=>"pildid/nameless5.jpg", "alt"=>"nimetu 5", "id"=>"p5", "value"=>"5"),
	6=>array("src"=>"pildid/nameless6.jpg", "alt"=>"nimetu 6", "id"=>"p6", "value"=>"6")
	);
	if (isset($_GET["page"])&& $_GET["page"]!=""){
	$page = htmlspecialchars($_GET["page"]);
	} else {
	$page = "pealeht";
	}	
	switch($page){
	case "pealeht": include("pealeht.html"); break;
	case "galerii": include("galerii.html"); break;
	case "vote":
		if (isset($_SESSION["voted_for"])) {
			include("tulemus.html");
		} else {
			include("vote.html");
		}
		break;
	case "tulemus":
		$id=false;
		if (isset($_POST["foto"]) && isset($fotod[$_POST["foto"]])) {
			$id = htmlspecialchars($_POST["foto"]);
			if (!isset($_SESSION["voted_for"])) {
				$_SESSION["voted_for"] = $id;
			} else {
				echo "<p>Sa oled juba valiku teinud!</p>";
			}
		}
		include("tulemus.html");
		break;
	default: include("pealeht.html"); break;
	}
?>

<?php
	require_once("foot.html");
?>
