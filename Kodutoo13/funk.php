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

function kuva_puurid(){
	// siia on vaja funktsionaalsust
	if (empty($_SESSION['user'])) {
		header("Location: ?page=login");
	}
	global $connection;
	$p= mysqli_query($connection, "select distinct(puur) as puur from kspelman_loomaaed order by puur asc");
	$puurid=array();
	while ($r=mysqli_fetch_assoc($p)){
		$l=mysqli_query($connection, "SELECT * FROM kspelman_loomaaed WHERE  puur=".mysqli_real_escape_string($connection, $r['puur']));
		while ($row=mysqli_fetch_assoc($l)) {
			$puurid[$r['puur']][]=$row;
		}
	}
	include_once('views/puurid.html');
}

function logi(){
	// siia on vaja funktsionaalsust (13. nädalal)
	//Kontrollib, kas kasutaja on juba sisse logitud. Kui on, suunab loomade vaatesse (sisselogitud kasutaja ei pea ju uuesti sisse logima)
	if (isset($_POST['user'])) {
		include_once('views/puurid.html');
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
				$sql = "SELECT username, passw FROM kspelman_kylastajad WHERE username='$user' AND passw=SHA1('$pass')";
				$result = mysqli_query($connection, $sql) or die("Päring ebaõnnestus");
				//Kui selle SELECT päringu tulemuses on vähemalt 1 rida (seda saab teada mysqli_num_rows funktsiooniga) siis lugeda kasutaja sisselogituks -> luua sessiooniväli 'user' ning suunata ta loomaaia vaatesse
				if (mysqli_num_rows($result) >= 1) {
					$_SESSION['user'] = $user;
					header("Location: ?page=loomad");
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
	// siia on vaja funktsionaalsust (13. nädalal)		
	//Kontrollib, kas kasutaja on sisse logitud. Kui pole, suunab sisselogimise vaatesse
	if (empty($_SESSION['user'])) {
		header("Location: ?page=login");
	}
	//Kontrollib, kas kasutaja on üritanud juba vormi saata. Kas päring on tehtud POST (vormi esitamisel) või GET (lingilt tulles) meetodil, saab teada serveri infost, mis asub massiivist $_SERVER võtmega 'REQUEST_METHOD'
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
	/*Kui meetodiks oli POST, tuleb kontrollida, kas kõik vormiväljad olid täidetud ja tekitada vajadusel vastavaid veateateid (massiiv $errors). 
	Selleks, et kontrollida, kas faili väli täideti, tuleb kontrollida, kas selle välja nimega faili üleslaadminine õnnestus. Selleks on funktsioonide failis juba funktsioon upload($väljanimi), mis tagastab õnnestumisel faili asukoha, luhtumisel tühistringi ""*/
		$errors = array();
		if (empty($_POST['nimi'])) {
			$errors[] = "Palun sisesta nimi";
		}
		if (empty($_POST['puur'])) {
			$errors[] = "Palun sisesta puur";
		}
		$pilt = upload('liik');
		if ($pilt == "") {
			$errors[] = "Palun vali pilt";
		}
		//Kui vigu polnud, siis üritada see loom andmebaasitabelisse <sinu kasutajanimi/kood/>_loomaaed lisada.
		if (empty($errors)) {
			global $connection;
			$nimi = mysqli_real_escape_string($connection, htmlspecialchars($_POST["nimi"]));
			$puur = mysqli_real_escape_string($connection, htmlspecialchars($_POST["puur"]));
			$sql = "INSERT INTO kspelman_loomaaed (nimi, puur, liik) VALUES ('$nimi', '$puur', '$pilt')";
			$result = mysqli_query($connection, $sql) or die("Päring ebaõnnestus");
			//Kas looma lisamine õnnestus või mitte, saab teada kui kontrollida mis väärtuse tagastab mysqli_insert_id funktsioon. Kui väärtus on nullist suurem, suunata kasutaja loomade vaatessse
			if ($result){
				if (mysqli_insert_id($connection) > 0) {
					header("Location: ?page=loomad");
					exit(0);
				}	
			}
		}
	}
	include_once('views/loomavorm.html');
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

?>