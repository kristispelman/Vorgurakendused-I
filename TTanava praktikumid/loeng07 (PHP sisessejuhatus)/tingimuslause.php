<?php

$loom = "kass";

if ($loom=="kala"){
	echo "kala ujub vees.";
} else if($loom=="hobune"){
	echo "Hobused s��vad heina";
} else if ($loom=="koer"){
	echo "koer n�rib konte";
}  else if ($loom=="kass"){
	echo "kass p��ab hiiri";
} else {
	echo "ma ei tea mis loom ta on";
}
echo "<br/>";

switch($loom){
	case "kala":
		echo "kala ujub vees.";
	break;
	case "hobune":
		echo "Hobused s��vad heina";
	break;
	case "koer":
		echo "koer n�rib konte";
	break;
	case "kass":
		echo "kass p��ab hiiri";
	break;
	default:
		echo "ma ei tea mis loom ta on";
	break;
}


?>