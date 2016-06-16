 <?php
 // /getVorm.php?nimi=Tiia
 for($i=0; $i < $_GET['loenda']; $i++){
	echo "Tere, {$_REQUEST['nimi']}!<br/>\n";
 }
 ?>
 
 <pre>
 <?php print_r($_GET); ?>
 </pre>