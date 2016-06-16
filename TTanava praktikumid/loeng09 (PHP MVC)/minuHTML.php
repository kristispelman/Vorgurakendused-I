<?php
// ebaturvaline
	if (!empty($_POST["q"])) {
		echo $_POST["q"];
	}
?>
<hr/>
<?php
// turvaline
	if (!empty($_POST["q"])) {
		echo htmlspecialchars($_POST["q"]);
	}
?>

<form action="minuHTML.php" method="POST">
	<textarea name="q"></textarea>
	<input type="submit" name="s" value="esita!"/>
</form>

<!-- <img src="http://i.telegraph.co.uk/multimedia/archive/02182/kitten_2182000b.jpg" alt="mingi"/> -->