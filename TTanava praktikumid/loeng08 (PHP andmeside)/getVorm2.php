 <?php
 // /getVorm.php?nimi=Tiia
 
 // ?nimi=&loenda=
 
 if ( isset($_GET['loenda']) && isset($_GET['nimi'])) {
	 if ( $_GET['loenda'] != "" && $_GET['nimi'] != "") {
		for($i=0; $i < $_GET['loenda']; $i++){
			echo "Tere, {$_REQUEST['nimi']}!<br/>\n";
		}
	} else {
		echo "1 või mitu välja oli täitmata!";
	}
} else {
	echo "Info puudub!";
 }
 ?>
 
 <pre>
 <?php print_r($_GET); ?>
 </pre>