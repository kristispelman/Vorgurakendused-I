<?php
$pildid = array(
		array("big"=> "Pictures/caution.gif", "small"=> "Thumbs/caution_small.gif", 'alt'=>"silt"),
	array("big"=> "Pictures/closed.jpg", "small"=> "Thumbs/closed_small.jpg", 'alt'=>"silt"),
	array("big"=> "Pictures/fly.jpg", "small"=> "Thumbs/fly_small.jpg", 'alt'=>"silt"),
	array("big"=> "Pictures/fish.jpg", "small"=> "Thumbs/fish_small.jpg", 'alt'=>"silt"),
	array("big"=> "Pictures/sign.jpg", "small"=> "Thumbs/signThumb.jpg", 'alt'=>"silt")
		);

function yhenda(){
	global $link;

	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$link = mysqli_connect($host, $user, $pass, $db) or die("andmebaasi ühenduse probleem");
	mysqli_query($link, "SET CHARACTER SET UTF8") or die("utf8 probleem");
}


function galerii(){
	global $pildid; // globaalmuutuja lokaalskoopi
	include("views/galerii.html");
}

function login(){
	global $link;
	// väljade kontroll
		$errors=array();
		if (!empty($_POST)){
			if ( !empty($_POST['username']) ){
					// kasutajanimi olemas
					$u = mysqli_real_escape_string($link, $_POST['username']);
			} else {
					// kasutajanimi puudu
					$errors['user'] = "kasutajanimi puudu!";
			}
			if ( !empty($_POST['passwd'])) {
					// parool olemas
					$p = mysqli_real_escape_string($link, $_POST['passwd']);
			} else {
					// parool puudu
					$errors['pass'] = "parool puudu!";
			}

			if (empty($errors)){
				// väljad täidetud
				$result = mysqli_query($link, "SELECT id, kasutaja, roll FROM ttanav3_kasutajad WHERE kasutaja = '$u' AND parool = SHA1('$p')");
				if ($result && $user = mysqli_fetch_assoc($result)){
					$_SESSION['user']=$user; // $_SESSION['user']['id'], $_SESSION['user']['roll'], $_SESSION['user']['kasutaja']
					header("Location: kontroller.php?mode=galerii");
					exit(0);
				} else {
					$errors['viga'] = "vale info!";
				}	
			}
		}
		include("views/login.html");
}


function register(){
	global $link;
	$errors=array();
		if (!empty($_POST)){
			if ( !empty($_POST['username']) ){
					// kasutajanimi olemas
					$u = mysqli_real_escape_string($link, $_POST['username']);
			} else {
					// kasutajanimi puudu
					$errors['user'] = "kasutajanimi puudu!";
			}
			if ( !empty($_POST['passwd']) ){
					// parool olemas
					$p = mysqli_real_escape_string($link, $_POST['passwd']);
			} else {
					// parool puudu
					$errors['pass'] = "parool puudu!";
			}
			if ( empty($_POST['passwd2']) ){// parool puudu
					$errors['pass2'] = "parool puudu!";
			}

			if ( !empty($_POST['passwd']) && !empty($_POST['passwd2']) && $_POST['passwd2']!=$_POST['passwd'] ) {
					$errors['match'] = "paroolid ei klapi";
			}

			if (empty($errors)){
				// väljad täidetud
				$result = mysqli_query($link, "INSERT INTO ttanav3_kasutajad (parool, kasutaja) VALUES (SHA1('$p'), '$u')");
				if ($result){
					header("Location: kontroller.php?mode=login");
					exit(0);
				} else {
					$errors['viga']="baasi viga!";
				}
			}
		}
		include("views/register.html");
}














?>
