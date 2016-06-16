<?php
session_start(); // ei saa lõpetada asja, mida pole alustatud!

// muuda sessiooni küpsis kehtetuks
if(isset($_COOKIE[session_name()])) {
setcookie(session_name(), '',
time()-42000, '/');
}
// tühjenda sessiooni massiiv
$_SESSION = array();
// lõpeta sessioon
session_destroy();

header("Location: pood.php");

?>