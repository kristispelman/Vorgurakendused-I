<?php
if (empty($_COOKIE["teine"])) {
	setcookie("teine", time(), time()+60*1);
	echo "K�psis loodud! ".time();
} else {
	echo "K�psis oli olemas, v��rtus oli: ".$_COOKIE["teine"];
	echo "<br/>Hetke aeg on ".time(); //serveri kell
}
$_COOKIE["esimene"]="mingi asi";

// siin saaks kasutada
?>