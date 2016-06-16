<?php
function connect_db(){
  global $link;
  $host="localhost";
  $user="test";
  $pass="t3st3r123";
  $db="test";
  $link = mysqli_connect($host, $user, $pass, $db) or die("Ühenduse loomine ebaõnnestus!");
  mysqli_query($link, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ");
}

// Uue kasutaja registreerimine

function registreeri(){
	global $link;
	if(!empty($_POST)){
		$errors=array();
		if (empty($_POST['username'])){
			$errors[]="kasutajanimi sisestamata!";
		}
		if (empty($_POST['passwd'])){
			$errors[]="Parool sisestamata!";
		}
		if (empty($_POST['passwd2'])){
			$errors[]="Korduv parool sisestamata!";
		}
		if(!empty($_POST['passwd']) && !empty($_POST['passwd2']) && $_POST['passwd']!=$_POST['passwd2']) {
			// mõlemad on olemas, aga ei võrdu
			$errors[]="Paroolid erinevad!";
		}
		if (empty($errors)){
			// turva
			$user=mysqli_real_escape_string($link,$_POST['username']);
			$pass=mysqli_real_escape_string($link,$_POST['passwd']);
			
			$sql="INSERT INTO kspelman_kasutajad(username, passwd) VALUES ('$user', SHA1('$pass'))";
			$result = mysqli_query($link, $sql);
			if ($result){
				// kõik ok, 
				$_SESSION['message']="Registreerimine õnnestus!";
				header("Location: ?page=login");
				exit(0);
			} else {
				$errors[]="Registreerimine ebaõnnestus!";
			}
		}
	}
	include("views/register.html");
}

// Sisse logimine

function logi(){
	global $link;
	if(!empty($_POST)){
		$errors=array();
		if (empty($_POST['username'])){
			$errors[]="kasutajanimi vajalik!";
		}
		if (empty($_POST['passwd'])){
			$errors[]="parool vajalik!";
		}
		
		if (empty($errors)){
			$user=mysqli_real_escape_string($link,$_POST['username']);
			$pass=mysqli_real_escape_string($link,$_POST['passwd']);		
			$sql="SELECT id, username, role FROM kspelman_kasutajad WHERE username = '$user' AND passwd = SHA1('$pass')";
			$result = mysqli_query($link, $sql);
			if ($result && $user = mysqli_fetch_assoc($result)){ 
				$_SESSION['user']=$user; 
				header("Location: ?");
				exit(0);
			} else {
				$errors[]="Sisse logimine ebaõnnestus!";
			}
		}
	}
	include("views/login.html");
}

// Uue postituse lisamine

function post_it(){
	global $link;
	
	if (empty($_SESSION['user'])){
		header("Location: ?page=login");
		exit(0);
	}
		
	if(!empty($_POST)){
		$errors=array();
		if (empty($_POST['title'])){
			$errors[]="Palun sisesta pealkiri!";
		}
		if (empty($_POST['content'])){
			$errors[]="Palun sisesta sisu!";
		}
		
		if (empty($errors)){
			$title=mysqli_real_escape_string($link,$_POST['title']);
			$content=mysqli_real_escape_string($link,$_POST['content']);
			$user=mysqli_real_escape_string($link,$_SESSION['user']['id']);
			
			$sql="INSERT INTO kspelman_postitused (title, content, kasutaja_id, postedat) VALUES ('$title', '$content', $user, NOW() )";
			$result = mysqli_query($link, $sql);
			if ($result){ 
				$id = mysqli_insert_id($link);
				$_SESSION['message']="Uus postitus lisatud!";
				header("Location: ?page=post&id=$id");
				exit(0);
			} else {
				$errors[]="Postituse lisamine ebaõnnestus!";
			}
		}
	}
	include("views/sub_post.html");
}

// Konkreetse postituse andmete vaatamine

function kuva_post() {
	global $link;
	$post=array();
	$jama=false;
	if (!empty($_GET['id'])) {
		$id = mysqli_real_escape_string($link,$_GET['id']);
		$sql = "SELECT p.*, k.username as postitaja FROM kspelman_postitused p, kspelman_kasutajad k WHERE p.id=$id AND k.id=p.kasutaja_id";
		$result = mysqli_query($link, $sql);
		if ($result && mysqli_num_rows($result)>0){ 
			$post=mysqli_fetch_assoc($result);
		}else {
			$jama=true;
		}
	} else {
		$jama=true;
	}
	
	if ($jama) {
		$_SESSION['message']="Sellist postitust pole!";
		header("Location: ?");
		exit(0);
	}

	include("views/postitus.html");

}

// Postituste nimekirja kuvamiseks

function hangi_postitused(){

	global $link;
	
	if (empty($_SESSION['user'])){
		header("Location: ?page=login");
		exit(0);
	}
	
	$tulemused=array();
	$sql = "SELECT p.*, k.username as postitaja FROM kspelman_postitused p, kspelman_kasutajad k WHERE k.id=p.kasutaja_id";
	$result = mysqli_query($link, $sql);
	
	while ($r=mysqli_fetch_assoc($result)){
		$tulemused[]=$r;
	}
	return $tulemused;
}
	

?>