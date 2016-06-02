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
	if (isset($_SERVER['REQUEST_METHOD']) &&  $_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = array();
			if (empty($_POST['user'])) {
				$errors[] = "Palun sisesta kasutajanimi!";
			}
			if (empty($_POST['pass'])) {
				$errors[] = "Palun sisesta parool!";
			}
			if (empty($errors)) {
				global $connection;
				$user = mysqli_real_escape_string($connection, $_POST["user"]);
				$pass = mysqli_real_escape_string($connection, $_POST["pass"]);
				$sql = "SELECT * FROM kspelman_kylastajad WHERE username='$user' AND passw=SHA1('$pass')";
				$result = mysqli_query($connection, $sql);
				if (mysqli_num_rows($result) >= 1) {
					$row = mysqli_fetch_assoc($result);
					$roll = $row['roll'];
					$_SESSION['roll'] = $roll;
					$_SESSION['user'] = $row['username'];
					header("Location: ?page=tooted");
				}
			}
	}
	include_once('views/login.html');
}
						
function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: http://enos.itcollege.ee/~kspelman/Projekt/ladu.php");
}

function lisa(){
	if (empty($_SESSION['user']) || $_SESSION['roll'] != 'admin') {
		header("Location: ?page=login");
	}
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$errors = array();
		if (empty($_POST['nimetus'])) {
			$errors[] = "Palun sisesta nimetus!";
		}
		if (empty($_POST['kategooria'])) {
			$errors[] = "Palun sisesta kategooria!";
		}
		if (empty($_POST['kogus'])) {
			$errors[] = "Palun sisesta kogus!";
		}	
		if (empty($_POST['kirjeldus'])) {
			$errors[] = "Palun sisesta kirjeldus!";
		}	
		if (empty($errors)) {
			global $connection;
			$nimetus = mysqli_real_escape_string($connection, htmlspecialchars($_POST["nimetus"]));
			$kategooria = mysqli_real_escape_string($connection, htmlspecialchars($_POST["kategooria"]));
			$kogus = mysqli_real_escape_string($connection, htmlspecialchars($_POST["kogus"]));
			$kirjeldus = mysqli_real_escape_string($connection, htmlspecialchars($_POST["kirjeldus"]));
			
			$sql = "INSERT INTO kspelman_tooted (nimetus, kategooria, kogus, kirjeldus, muutmisekuupaev) VALUES ('$nimetus','$kategooria', '$kogus', '$kirjeldus', curdate())";
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
		$errors = array();
		if (empty($_POST['nimetus'])) {
			$errors[] = "Palun sisesta nimetus!";
		}
		if (empty($_POST['kategooria'])) {
			$errors[] = "Palun sisesta kategooria!";
		}
		if (empty($_POST['kogus'])) {
			$errors[] = "Palun sisesta kogus!";
		}	
		if (empty($_POST['kirjeldus'])) {
			$errors[] = "Palun sisesta kirjeldus!";
		}
		if (empty($errors)) {
			global $connection;
			$id = $_POST['id'];
			$nimetus = $_POST['nimetus'];
			$kategooria = $_POST['kategooria'];
			$kogus = $_POST['kogus'];
			$kirjeldus = $_POST['kirjeldus'];
			$sql = "UPDATE kspelman_tooted SET nimetus='".$nimetus."', kategooria='".$kategooria."', kogus='".$kogus."', kirjeldus='".$kirjeldus."', muutmisekuupaev=curdate() WHERE id=".$id;
			$result = mysqli_query($connection, $sql) or die("Päring ebaõnnestus");
			header("Location: ?page=tooted");
			exit(0);
		}
	}
	include_once('views/editvorm.html');
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