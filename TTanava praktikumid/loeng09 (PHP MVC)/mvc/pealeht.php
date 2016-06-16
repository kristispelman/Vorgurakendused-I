<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>minuleht</title>
		<style>
			body {background:skyblue;}
			#menu {margin:0px; padding:0px; background:goldenrod;}
			#menu li {display:inline-block;}
			#menu a {color: black; font-weight:bold; display:inline-block; padding: 5px; text-decoration:none;}
			#menu a:hover {color:maroon;}
			#wrap {
				width:600px; margin:auto; background:white;
			}
			#content{padding:10px;}
		</style>
	</head>
	<body>
		<div id="wrap">
			<ul id="menu">
				<li><a href="pealeht.php">pealeht</a></li>
				<li><a href="pealeht.php">pealeht</a></li>
			</ul>
			<div id="content">
					<form action="kontroller.php?mode=kontroll" method="POST">
						<input type="text" name="nimi" <?php if(!empty($_POST["nimi"])) echo "value=\"".htmlspecialchars($_POST["nimi"])."\" "; ?> /> nimi <br/>
						
						<input type="number" name="vanus" <?php if(!empty($_POST["vanus"]) && is_numeric($_POST["vanus"])) echo "value=\"".htmlspecialchars($_POST["vanus"])."\" "; ?>/> vanus<br/>
						
						Sugu: <br/>
						<label><input type="radio" name="sugu" value="m" <?php if(!empty($_POST["sugu"]) && $_POST["sugu"]=="m") echo "checked"; ?>/> M</label><br/>
						<label><input type="radio" name="sugu" value="n" <?php if(!empty($_POST["sugu"]) && $_POST["sugu"]=="n") echo "checked"; ?>/> N</label><br/>
						
						<input type="text" name="kood" <?php if(!empty($_POST["kood"])) echo "value=\"".htmlspecialchars($_POST["kood"])."\" "; ?>/> Kood<br/>
						<textarea name="komm"><?php if(!empty($_POST["komm"])) echo htmlspecialchars($_POST["komm"]); ?></textarea><br/>
						<input type="submit" value="registreeru"/>
					</form>
					
					<?php if (!empty($errors)):?>
						<?php foreach($errors as $e):?>
							<p style="color:red"><?php echo $e; ?></p>
						<?php endforeach;?>
					<?php endif;?>
			</div>
		</div>
	</body>
</html>