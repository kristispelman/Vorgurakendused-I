 <?php
 // /getVorm.php?nimi=Tiia
 
 // ?nimi=&loenda=
 
 if ( !empty($_GET['loenda']) && !empty($_GET['nimi'])) {
	 
		for($i=0; $i < $_GET['loenda']; $i++){
			echo "Tere, {$_REQUEST['nimi']}!<br/>\n";
		}
} else {
	echo "Info puudub v�i on t�itmata!";
 }
 ?>
 
 <pre>
 <?php print_r($_GET); ?>
 </pre>