<?php

function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function kuva_tooted(){
	
	if (empty($_SESSION['user'])) {
	header("Location: ?page=login");
	}
	global $connection;
	$p= mysqli_query($connection, "select * from kspelman_tooted");
	$tooted=array();
		
	while ($row=mysqli_fetch_assoc($p)) {
		$tooted[]=$row;
	}
	
	include_once('views/tooted.html');
}

function logi(){
	// siia on vaja funktsionaalsust (13. nädalal)
	//Kontrollib, kas kasutaja on juba sisse logitud. Kui on, suunab loomade vaatesse (sisselogitud kasutaja ei pea ju uuesti sisse logima)
	if (isset($_POST['user'])) {
		include_once('views/tooted.html');
	}
	//Kontrollib, kas kasutaja on üritanud juba vormi saata. Kas päring on tehtud POST (vormi esitamisel) või GET (lingilt tulles) meetodil, saab teada serveri infost, mis asub massiivist $_SERVER võtmega 'REQUEST_METHOD'
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		//Kui meetodiks oli POST, kontrollida kas vormiväljad olid täidetud. Vastavalt vajadusele tekitada veateateid (massiiv $errors)
		if (isset($_POST['user']) && isset($_POST['pass'])) {
			if ($_POST['user'] == "" || $_POST['pass'] == "") {
				$errors[] = "Palun sisesta kasutajanimi ja salasõna";
			} else {
				//Kui kõik väljad olid täidetud, üritada andmebaasitabelist <sinu kasutajanimi/kood/>_kylalised selekteerida külalist, kelle kasutajanimi ja parool on vastavad
				global $connection;
				$user = mysqli_real_escape_string($connection,htmlspecialchars($_POST['user']));
				$pass = mysqli_real_escape_string($connection,htmlspecialchars($_POST['pass']));		
				$sql = "SELECT * FROM kspelman_kylastajad WHERE username='$user' AND passw=SHA1('$pass')";
				$result = mysqli_query($connection, $sql) or die("Päring ebaõnnestus");
				//Kui selle SELECT päringu tulemuses on vähemalt 1 rida (seda saab teada mysqli_num_rows funktsiooniga) siis lugeda kasutaja sisselogituks -> luua sessiooniväli 'user' ning suunata ta loomaaia vaatesse
				if (mysqli_num_rows($result) >= 1) {
					//muuta funktsiooni login() nii, et sisselogimise õnnestumisel salvestuks sessiooni ka kasutaja roll (14. nädal)
					$row = mysqli_fetch_assoc($result);
					$roll = $row['roll'];
					$_SESSION['roll'] = $roll;
					$_SESSION['user'] = $user;
					header("Location: ?page=tooted");
				} else {
						$errors[] = "Kasutajanimi või parool on vale";	
				}					
			}
		}			
	}
	include_once('views/login.html');
}
						
function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?page=login");
}

function lisa(){

	if (empty($_SESSION['user']) || $_SESSION['roll'] != 'admin') {
		header("Location: ?page=login");
	}
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
	
		$errors = array();
		if (empty($_POST['nimetus'])) {
			$errors[] = "Palun sisesta nimetus";
		}
		if (empty($_POST['kategooria'])) {
			$errors[] = "Palun sisesta kategooria";
		}
		
		if (empty($errors)) {
			global $connection;
			$nimetus = mysqli_real_escape_string($connection, htmlspecialchars($_POST["nimetus"]));
			$kategooria = mysqli_real_escape_string($connection, htmlspecialchars($_POST["kategooria"]));
			
			$sql = "INSERT INTO kspelman_tooted (nimetus,kategooria) VALUES ('$nimetus','$kategooria')";
			$result = mysqli_query($connection, $sql) or die("Päring ebaõnnestus");
			
			if ($result){
				if (mysqli_insert_id($connection) > 0) {
					header("Location: ?page=tooted");
					exit(0);
				}	
			}
		}
	}
	include_once('views/tootevorm.html');
}

function muuda(){

	global $connection;

	if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['id'] ) && $_GET['id'] != "") {
		$id = $_GET['id'];	
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nimetus'])) {
		$nimetus = $_POST['nimetus'];
		$id = $_POST['id'];
		$kategooria = $_POST['kategooria'];
		$sql = "UPDATE kspelman_tooted SET nimetus='".$nimetus."', kategooria='".$kategooria."' WHERE id=".$id;
		$result = mysqli_query($connection, $sql) or die("Päring ei õnnestunud");
		header("Location: ?page=tooted");
		exit(0);
	}

	include_once('views/editvorm.html');
}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$extension = end(explode(".", $_FILES[$name]["name"]));
	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pildid/" . $_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

function kustuta(){
	if (empty($_SESSION['user']) || $_SESSION['roll'] != 'admin') {
		header("Location: ?page=login");
	}
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		
			global $connection;
			$id = mysqli_real_escape_string($connection, htmlspecialchars($_POST["tooteId"]));
			
			$sql = "DELETE FROM kspelman_tooted WHERE id = ('$id')";
			$result = mysqli_query($connection, $sql) or die("Päring ebaõnnestus");
			
			if ($result){
				
				header("Location: ?page=tooted");
				exit(0);
					
			}
		}
	}

?>