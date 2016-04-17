<?php
	require_once('head.html');
?>
<h3>Valiku tulemus</h3>
<?php 
	if (isset($_GET["foto"])&& $_GET["foto"]!="") {
		echo'<p>Valisid pildi numbriga '.($_GET["foto"]).'</p>';
    } else {
		echo '<p>Pilt on valimata!</p>';
	}	
?>
<?php
	require_once('foot.html');
?>


