<?php
	$tingimus = true;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>HTML toorik</title>
		
	</head>
	<body>
		<p>see tekst kuvatakse alati</p>
		<?php if($tingimus): ?>
			<p>see tekst kuvatakse siis kui tingimus kehtib</p>
		<?php endif; ?>
		<p>see tekst kuvatakse alati</p>
		<?php if($tingimus){ ?>
			<p>see tekst kuvatakse siis kui tingimus kehtib</p>
		<?php } ?>
	</body>
</html>