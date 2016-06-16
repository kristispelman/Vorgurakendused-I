<?php
function connect_db(){
  global $L;
  $host="localhost";
  $user="test";
  $pass="t3st3r123";
  $db="test";
  $L = mysqli_connect($host, $user, $pass, $db) or die("ei saa mootoriga ühendust");
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
				// kÃµik ok, 
				$_SESSION['message']="Registreerumine õnnestus, logi sisse";
				header("Location: ?page=login");
				exit(0);
			} else {
				$errors[]="Registreerumine luhtus, proovi hiljem jälle...";
			}
		}
	}
	include_once("views/head.html");
	include("views/register.html");
	include_once("views/foot.html");
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
				// kÃµik ok, muutjas $user on massiiv
				$_SESSION['user']=$user; // $_SESSION['user']['id']
				$_SESSION['message']="Login õnnestus";
				header("Location: ?");
				exit(0);
			} else {
				$errors[]="login luhtus, kas oli õige info?";
			}
		}
	}
	include_once("views/head.html");
	include("views/login.html");
	include_once("views/foot.html");
}


function post_it(){
	global $L;
	
	// logimata võµi logitud tavakasutaja
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
				// kÃµik ok
				$id = mysqli_insert_id($L);
				$_SESSION['message']="postitamine õnnestus";
				header("Location: ?page=post&id=$id");
				exit(0);
			} else {
				$errors[]="postitamine luhtus";
			}
		}
	}
	include_once("views/head.html");
	include("views/sub_post.html");
	include_once("views/foot.html");
}

function edit_post() {

global $L;
if (!empty($_GET['id'])) {
	$id = mysqli_real_escape_string($L, $_GET['id']);
	$sql = "SELECT * FROM Bpostitused WHERE id=$id ";
		$result = mysqli_query($L, $sql);
		if ($result && mysqli_num_rows($result)>0){
			$post=mysqli_fetch_assoc($result);
		}else {
			$_SESSION['message']="Sellist postitust ei eksisteeri";
			header("Location: ?");
			exit(0);
		}
	// logimata vÃµi logitud tavakasutaja
	if (empty($_SESSION['user']) || (!empty($_SESSION['user']) && $post['kasutaja_id']!= $_SESSION['user']['id'])  ){
		$_SESSION['message']="muutmiseks puuduvad õigused";
		header("Location: ?");
		exit(0);
	}
	
	if(!empty($_POST)){
		$errors=array();
		if (empty($_POST['title'])){
			$errors[]="pealkiri vajalik!";
		} else {
			$post['title']=$_POST['title'];
		}
		if (empty($_POST['content'])){
			$errors[]="postituse sisu vajalik!";
		} else {
			$post['content']=$_POST['content'];
		}
		
		if (empty($errors)){
			// turva
			$title=mysqli_real_escape_string($L, $post['title']);
			$content=mysqli_real_escape_string($L, $post['content']);
			$sql="UPDATE Bpostitused SET title='$title', content='$content' WHERE id=$id";
			$result = mysqli_query($L, $sql);
			if ($result){ 
				// kÃµik ok
				$_SESSION['message']="muutmine õnnestus";
				header("Location: ?page=post&id=$id");
				exit(0);
			} else {
				$errors[]="muutmine luhtus";
			}
		}
	}
} else {
	$_SESSION['message']="Postitus määramata";
	header("Location: ?");
	exit(0);
} 
	include_once("views/head.html");
	include("views/edit_post.html");
	include_once("views/foot.html");

}


// kommentaari lisamine
function tee_komment($pid){
global $L;

if (!empty($_POST)){
	if (empty($_SESSION['user'])) {
		$_SESSION['message']="Kommenteerimiseks pead olema sisse logitud ";
		header("Location: ?page=post&id=$pid");
		exit(0);
	}
				if (empty($_POST['content'])){
					$errors[]="kommentaari sisu ei saa olla tühi";
				} else {
					// tekitame kommentaari
					$cont = mysqli_real_escape_string($L, $_POST['content']);
					$uid = mysqli_real_escape_string($L, $_SESSION['user']['id']);
					
					$sql = "INSERT INTO Bkommentaarid (kasutaja_id, postitus_id, content, postedat) VALUES ($uid, $pid, '$cont', NOW() )";
					$res= mysqli_query($L, $sql);
					if ($res){
						$_SESSION['message']="Kommenteerimine õnnestus :) ";
					} else {
						$_SESSION['message']="Kommenteerimine ebaõnnestus :( ";
					}
					header("Location: ?page=post&id=$pid");
					exit(0);
				}
			}
}

// kõikide kommentaaride kuvamine postituse juures
function hangi_kommentaarid($pid){
	global $L;
	$kommid=array();
	$sql = "SELECT c.*, k.username as kommenteerija FROM Bkommentaarid c, Bkasutajad k WHERE postitus_id=$pid AND k.id = c.kasutaja_id";
	$result = mysqli_query($L, $sql);
	while ($r=mysqli_fetch_assoc($result)){
		$kommid[]=$r;
	}
	return $kommid;
}

function kuva_post() {
	global $L;
	$post=array();
	$jama=false;
	if (!empty($_GET['id'])) {
		$id = mysqli_real_escape_string($L,$_GET['id']);
		$sql = "SELECT p.*, k.username as postitaja FROM Bpostitused p, Bkasutajad k WHERE p.id=$id AND k.id=p.kasutaja_id";
		$result = mysqli_query($L, $sql);
		if ($result && mysqli_num_rows($result)>0){
			$post=mysqli_fetch_assoc($result);
			// uus kommentaar?
			tee_komment($id);
			// eksisteerivad kommentaarid?
			$kommid = hangi_kommentaarid($id);
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
	include_once("views/head.html");
	include("views/postitus.html");
	include_once("views/foot.html");

}


function hangi_postitused(){
	global $L;
	$tulemused=array();
	$sql = "SELECT p.*, k.username as postitaja, (SELECT count(*) FROM Bkommentaarid WHERE postitus_id = p.id ) as komme FROM Bpostitused p, Bkasutajad k WHERE k.id=p.kasutaja_id ORDER BY postedat DESC LIMIT 10";
	$result = mysqli_query($L, $sql);
	while ($r=mysqli_fetch_assoc($result)){
		$tulemused[]=$r;
	}
	return $tulemused;
}



function kuva_postitused(){
	global $L;
	$postitused=array();
	$jama=false;
	if (!empty($_GET['user'])) {
		$user = mysqli_real_escape_string($L,$_GET['user']);
		$sql = "SELECT p.*, k.username as postitaja, (SELECT count(*) FROM Bkommentaarid WHERE postitus_id = p.id ) as komme FROM Bpostitused p, Bkasutajad k WHERE k.id=p.kasutaja_id AND k.username='$user' ";
		$result = mysqli_query($L, $sql);
		while ($r=mysqli_fetch_assoc($result)){
			$postitused[]=$r;
		}
		if (empty($postitused)){
			$jama=true;
		}
	} else {
		$jama=true;
	}
	if ($jama) {
		$_SESSION['message']="Kas kasutaja puudu, ta ei eksisteeru või tal pole postitusi...";
		header("Location: ?");
		exit(0);
	}
	include_once("views/head.html");
	include("views/postitused.html");
	include_once("views/foot.html");
}






?>
