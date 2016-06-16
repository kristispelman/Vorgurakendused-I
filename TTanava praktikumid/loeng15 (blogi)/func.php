<?php
function connect_db(){
  global $L;
  $host="localhost";
  $user="test";
  $pass="t3st3r123";
  $db="test";
  $L = mysqli_connect($host, $user, $pass, $db) or die("ei saa mootoriga �hendust");
  mysqli_query($L, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($L));
}


function reg(){
	global $L;
	if(!empty($_POST)){
		$errors=array();
		if (empty($_POST['username'])){
			$errors[]="kasutajanimi vajalik!";
		}
		if (empty($_POST['passwd'])){
			$errors[]="parool vajalik!";
		}
		if (empty($_POST['passwd2'])){
			$errors[]="parooli peab 2 korda panema!";
		}
		if(!empty($_POST['passwd']) && !empty($_POST['passwd2']) && $_POST['passwd']!=$_POST['passwd2']) {
			// mõlemad on olemas, aga ei võrdu
			$errors[]="paroolid peavad olema samad!";
		}
		if (empty($errors)){
			// turva
			$user=mysqli_real_escape_string($L,$_POST['username']);
			$pass=mysqli_real_escape_string($L,$_POST['passwd']);
			
			$sql="INSERT INTO Bkasutajad (username, passwd) VALUES ('$user', SHA1('$pass'))";
			$result = mysqli_query($L, $sql);
			if ($result){
				// kõik ok, 
				$_SESSION['message']="Registreerumine õnnestus, logi sisse";
				header("Location: ?page=login");
				exit(0);
			} else {
				$errors[]="Registreerumine luhtus, proovi hiljem jälle...";
			}
		}
	}
	include("views/register.html");
}

function logi(){
	global $L;
	if(!empty($_POST)){
		$errors=array();
		if (empty($_POST['username'])){
			$errors[]="kasutajanimi vajalik!";
		}
		if (empty($_POST['passwd'])){
			$errors[]="parool vajalik!";
		}
		
		if (empty($errors)){
			// turva
			$user=mysqli_real_escape_string($L,$_POST['username']);
			$pass=mysqli_real_escape_string($L,$_POST['passwd']);
			
			$sql="SELECT id, username, role FROM Bkasutajad WHERE username = '$user' AND passwd = SHA1('$pass')";
			$result = mysqli_query($L, $sql);
			if ($result && $user = mysqli_fetch_assoc($result)){ 
				// kõik ok, muutjas $user on massiiv
				$_SESSION['user']=$user; // $_SESSION['user']['id']
				$_SESSION['message']="Login õnnestus";
				header("Location: ?");
				exit(0);
			} else {
				$errors[]="login luhtus, kas oli õige info?";
			}
		}
	}
	include("views/login.html");
}


function post_it(){
	global $L;
	
	// kontorllime, kas on logimata või logitud tavakasutaja
	if (empty($_SESSION['user']) || (!empty($_SESSION['user']) && $_SESSION['user']['role']!="poster")){
		$_SESSION['message']="Postitamiseks puuduvad õigused";
		header("Location: ?");
		exit(0);
	}
	
	if(!empty($_POST)){
		$errors=array();
		if (empty($_POST['title'])){
			$errors[]="pealkiri vajalik!";
		}
		if (empty($_POST['content'])){
			$errors[]="postituse sisu vajalik!";
		}
		
		if (empty($errors)){
			// turva
			$title=mysqli_real_escape_string($L,$_POST['title']);
			$content=mysqli_real_escape_string($L,$_POST['content']);
			$user=mysqli_real_escape_string($L,$_SESSION['user']['id']);
			
			$sql="INSERT INTO Bpostitused (title, content, kasutaja_id, postedat) VALUES ('$title', '$content', $user, NOW() )";
			$result = mysqli_query($L, $sql);
			if ($result){ 
				// kõik ok
				$id = mysqli_insert_id($L);
				$_SESSION['message']="postitamine õnnestus";
				header("Location: ?page=post&id=$id");
				exit(0);
			} else {
				$errors[]="postitamine luhtus";
			}
		}
	}
	include("views/sub_post.html");
}


// konkreetse posituse andmete vaatamiseks
function kuva_post() {
	global $L;
	$post=array();
	$jama=false;
	if (!empty($_GET['id'])) {
		$id = mysqli_real_escape_string($L,$_GET['id']);
		$sql = "SELECT p.*, k.username as postitaja FROM Bpostitused p, Bkasutajad k WHERE p.id=$id AND k.id=p.kasutaja_id";
		$result = mysqli_query($L, $sql);
		// kontorllime, kas vähemalt üks rida olemas
		if ($result && mysqli_num_rows($result)>0){ 
			$post=mysqli_fetch_assoc($result);
		}else {
			$jama=true;
		}
	} else {
		$jama=true;
	}
	
	if ($jama) {
		$_SESSION['message']="Sellist postitust ei eksisteeri";
		header("Location: ?");
		exit(0);
	}

	include("views/postitus.html");

}

// selleks, et postitusi esilehel kuvada
function hangi_postitused(){
	global $L;
	$tulemused=array();
	$sql = "SELECT p.*, k.username as postitaja FROM Bpostitused p, Bkasutajad k WHERE k.id=p.kasutaja_id";
	$result = mysqli_query($L, $sql);
	while ($r=mysqli_fetch_assoc($result)){
		$tulemused[]=$r;
	}
	return $tulemused;
}


// kuvab konkreetse kasutaja postitused tema nimel klikkides
function kuva_postitused(){
	global $L;
	$postitused=array();
	$jama=false;
	if (!empty($_GET['user'])) {
		$user = mysqli_real_escape_string($L,$_GET['user']);
		$sql = "SELECT p.*, k.username as postitaja FROM Bpostitused p, Bkasutajad k WHERE k.id=p.kasutaja_id AND k.username='$user' ";
		$result = mysqli_query($L, $sql);
		while ($r=mysqli_fetch_assoc($result)){
			$postitused[]=$r;
		}
	} else {
		$jama=true;
	}
	if ($jama) {
		$_SESSION['message']="Sellist kasutajat ei eksisteeri";
		header("Location: ?");
		exit(0);
	}

	include("views/postitused.html");
}






?>