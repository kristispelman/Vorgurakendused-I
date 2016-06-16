<?php

if (!empty($_POST)){
	if (!empty($_POST["q"])) {
		// lähme googlesse
		$q = urlencode( $_POST['q'] ); //et saaks otsingusõnas kasutada nt &-märki
		header("Location: https://www.google.ee?#q={$q}"); //q asendatakse otsingusõnaga
		exit(0);
	} else {
		echo "Palun siseta otsingusõna!";
	}
}


?>

<form action="minuGoogle.php" method="POST">
	<input type="text" name="q"/>
	<input type="submit" name="s" value="otsi Googlest"/>
</form>