<?php
session_set_cookie_params(30);
session_start();
if (empty($_SESSION["esimene"])) {
	$_SESSION["esimene"]=time();
	echo "sessioon loodud! ".time();
} else {
	echo "sessioon oli olemas, vההrtus oli: ".$_SESSION["esimene"];
	echo "<br/>Hetke aeg on ".time();
}

?>