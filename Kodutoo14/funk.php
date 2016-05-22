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
				$sql = "SELECT * FROM kspelman_kylastajad WHERE username='$user' AND passw=SHA1('$pass')";
				$result = mysqli_query($connection, $sql) or die("Päring ebaõnnestus");
				//Kui selle SELECT päringu tulemuses on vähemalt 1 rida (seda saab teada mysqli_num_rows funktsiooniga) siis lugeda kasutaja sisselogituks -> luua sessiooniväli 'user' ning suunata ta loomaaia vaatesse
				if (mysqli_num_rows($result) >= 1) {
					//muuta funktsiooni login() nii, et sisselogimise õnnestumisel salvestuks sessiooni ka kasutaja roll (14. nädal)
					$row = mysqli_fetch_assoc($result);
					$roll = $row['roll'];
					$_SESSION['roll'] = $roll;
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
	//Kunktsiooni täielikuks käivitumiseks peab kasutaja lisaks sisse logitusele olema ka admin rollis (muul juhul suunati loomaaia vaatesse) (14. nädal)
	if (empty($_SESSION['user']) || $_SESSION['roll'] != 'admin') {
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
/*Lisada funktsioon muuda(), mis on ülesehituselt väga sarnane funktsiooniga lisa() (võib teha koopia ja seda kohandada)
Kuid neil kahel funktsioonil on ka omad erinevused (14. nädal)*/
function muuda(){
/* Funktsiooni muuda() alguses (kui kasutaja on sisse logitud ja admin) kontrollitakse kas päringuga (POST = vormist või GET = link ) on saadetud looma id. 
Puudumisel suunatakse loomaaia vaatesse, olemasolul hangitakse looma info eelnevalt loodud funktsiooni hangi_loom abil mingisse muutujasse-*/
	global $connection;

	if (empty($_SESSION['user'])) {
		header("Location: ?page=login");
	}
	if ($_SESSION['roll'] != 'admin') {
		header("Location: ?page=loomad");
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['id'] ) && $_GET['id'] != "") {
		$id = $_GET['id'];
		$loom = hangi_loom(mysqli_real_escape_string($connection, $id));
	}
	else {
		header("Location: ?page=loomad");
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['muuda'])) {
	/*Vormiga saadetud info valideerimise käigus kirjutatakse looma infot hoidva massiivi välju uute väärtustega üle (nende olemasolul POST massiivis).
	Pildi üleslaadmise luhtmisel kuvatavat veateadet pole enam vaja, kuna pilti ei pruugita alati tahta muuta (14. nädal)*/
		$errors = array();
		if (empty($_POST['nimi'])) {
			$errors[] = "Palun sisesta nimi";
		}
		if (empty($_POST['puur'])) {
			$errors[] = "Palun sisesta puur";
		}
		if (empty($errors)) {
			$id = $_POST['muuda'];
			$loom = hangi_loom(mysqli_real_escape_string($connection, $id));
			$loom['nimi'] = mysqli_real_escape_string($connection, $_POST["nimi"]);
			$loom['puur'] = mysqli_real_escape_string($connection, $_POST["puur"]);
			$liik = upload("liik");
			if ($liik != "") {
				$loom['liik'] = $liik;
			}
			/*Vigade puudumisel käivitatakse update päring, kus määratakse kõigi väljade väärtused (looma info massiivis on selleks hetkeks iga väli mingi väärtusega esindatud) (14. nädal)*/
			$sql = "UPDATE kspelman_loomaaed SET nimi='".$loom['nimi']."', puur=".$loom['puur'].", liik='".$loom['liik']."' WHERE id=".$id;
				$result = mysqli_query($connection, $sql) or die("Päring ei õnnestunud");
				/*Kuna on ka juhuseid, kus vorm esitatakse seal midagi muutmata, suunata kasutaja alati pärast update päringu käivitamist tagasi loomaaia vaatesse. (14. nädal)*/
				header("location: ?page=loomad");
		}
	}
	include_once('views/editvorm.html');
}

//Lisada funktsioon hangi_loom($id), mis tagastab konkreetse looma info massiivi kujul (id väärtus sisendparameetris).Kui sellise id-ga looma baasis pole, suunata kasutaja loomaaia vaatesse. (14. nädal)
function hangi_loom($id) {
	global $connection;
	$sql = "SELECT * FROM kspelman_loomaaed WHERE id=".$id;
	$result = mysqli_query($connection, $sql) or die("Päring ebaõnnestus");
	if ($looma_andmed = mysqli_fetch_assoc($result)) {
		return $looma_andmed;
	}
	else {
		header("Location: ?page=loomad");
	}
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