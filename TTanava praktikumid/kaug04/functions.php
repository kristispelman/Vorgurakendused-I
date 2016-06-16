<?php
$pildid = array(
		array("big"=> "Pictures/caution.gif", "small"=> "Thumbs/caution_small.gif", 'alt'=>"silt"),
	array("big"=> "Pictures/closed.jpg", "small"=> "Thumbs/closed_small.jpg", 'alt'=>"silt"),
	array("big"=> "Pictures/fly.jpg", "small"=> "Thumbs/fly_small.jpg", 'alt'=>"silt"),
	array("big"=> "Pictures/fish.jpg", "small"=> "Thumbs/fish_small.jpg", 'alt'=>"silt"),
	array("big"=> "Pictures/sign.jpg", "small"=> "Thumbs/signThumb.jpg", 'alt'=>"silt")
		);


function galerii(){
	global $pildid; // globaalmuutuja lokaalskoopi
	include("views/galerii.html");
}

function login(){
	// väljade kontroll
		$errors=array();
		if (!empty($_POST)){
			if ( !empty($_POST['username']) ){
					// kasutajanimi olemas
			} else {
					// kasutajanimi puudu
					$errors['user'] = "kasutajanimi puudu!";
			}
			if ( !empty($_POST['passwd'])) {
					// parool olemas
			} else {
					// parool puudu
					$errors['pass'] = "parool puudu!";
			}

			if (empty($errors)){
				// väljad täidetud
				header("Location: kontroller.php?mode=galerii");
				exit(0);
			}
		}
		include("views/login.html");
}


function register(){
	$errors=array();
		if (!empty($_POST)){
			if ( !empty($_POST['username']) ){
					// kasutajanimi olemas
			} else {
					// kasutajanimi puudu
					$errors['user'] = "kasutajanimi puudu!";
			}
			if ( !empty($_POST['passwd']) ){
					// parool olemas
			} else {
					// parool puudu
					$errors['pass'] = "parool puudu!";
			}
			if ( !empty($_POST['passwd2']) ){
					// parool olemas
			} else {
					// parool puudu
					$errors['pass2'] = "parool puudu!";
			}

			if ( !empty($_POST['passwd']) && !empty($_POST['passwd2']) && $_POST['passwd2']!=$_POST['passwd'] ) {
					$errors['match'] = "paroolid ei klapi";
			}

			if (empty($errors)){
				// väljad täidetud
				header("Location: kontroller.php?mode=login");
				exit(0);
			}
		}
		include("views/register.html");
}

?>
