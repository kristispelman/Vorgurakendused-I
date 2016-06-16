<?php
session_start();
if (!isset($_SESSION["korv"])) { // tagame, et korv on olemas
	$_SESSION["korv"] = array();
}
$kaubad = array("kampsun", "müts", "püksid", "saapad");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>HTML toorik</title>
		
	</head>
	<body>
		<?php foreach($_SESSION["korv"] as $id=>$kogus):?>
			<p><?php echo $kaubad[$id]; ?> <?php echo $kogus; ?>tk.</p>
		<?php endforeach; ?>
		<p>mine vaata <a href="pood.php">poodi</a> </p>
		<p><a href="sesslopp.php">tühjenda korv!</a></p>
	</body>
</html>