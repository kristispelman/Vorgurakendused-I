<?php

$a = 2;
$b = 6;

function liida() {
	global $a, $b, $c;
	$c = $a + $b;
	echo "$a + $b = $c";
}

liida();
echo "<br/>tulemus oli: $c";


?>