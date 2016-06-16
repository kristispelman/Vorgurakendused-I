<?php 

echo "See muutuja '$asi' ei eksisteeri!";

$i=0;
while ($i<10){
	echo "tere!";
	$i++;
}

?>
<hr/>
<?php 
$asi = "olemas!";
if (isset($asi)){
	echo "See muutuja '$asi' ei eksisteeri!";

	$i=0;
	while ($i<10){
		echo "tere!";
		$i++;
	}
}
?>
