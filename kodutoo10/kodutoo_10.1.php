<!doctype html>
<html>
  <head>
      <meta charset="utf-8"></meta>
      <title>Ülesanne 8.1</title>
      <?php
        $kommentaar = ""; 
		if (isset($_POST["kommentaar"]) && $_POST["kommentaar"]!="") {
        $kommentaar = htmlspecialchars($_POST["kommentaar"]);
        }
        $taustavarvus="#fff"; 
		if (isset($_POST["taustavarvus"]) && $_POST["taustavarvus"]!="") {
        $taustavarvus = htmlspecialchars($_POST["taustavarvus"]);
        }
        $tekstivarvus = "#7f7f7f"; 
		if (isset($_POST["tekstivarvus"]) && $_POST["tekstivarvus"]!="") {
        $tekstivarvus = htmlspecialchars($_POST["tekstivarvus"]);
        }
        $piirjoonevarvus = "#7f7f7f"; 
		if (isset($_POST["piirjoonevarvus"]) && $_POST["piirjoonevarvus"]!="") {
        $piirjoonevarvus = htmlspecialchars($_POST["piirjoonevarvus"]);
        }
        $piirjoonestiil = "solid"; 
		if (isset($_POST["piirjoonestiil"]) && $_POST["piirjoonestiil"]!="") {
        $piirjoonestiil = htmlspecialchars($_POST["piirjoonestiil"]);
        }
		$piirjoonelaius = "1px"; 
		if (isset($_POST["piirjoonelaius"]) && $_POST["piirjoonelaius"]!="") {
        $piirjoonelaius  = htmlspecialchars($_POST["piirjoonelaius"]."px");
        }
        $piirjooneraadius = "5px";
		if (isset($_POST["piirjooneraadius"]) && $_POST["piirjooneraadius"]!="") {
        $piirjooneraadius = htmlspecialchars($_POST["piirjooneraadius"]."px");
        }
		?>
    	<style>
        #aken {
			width: 275px;
			height: 100px;
			margin-bottom: 10px;
			padding: 10px;
			background-color: <?php echo $taustavarvus; ?>;
			color: <?php echo $tekstivarvus; ?>;
			border-width: <?php echo $piirjoonelaius; ?>;
			border-style: <?php echo $piirjoonestiil; ?>;
			border-color: <?php echo $piirjoonevarvus; ?>;
			border-radius: <?php echo $piirjooneraadius; ?>;
        }
		</style>
	</head>
	<body>
	  <div id = "aken">
		<?php echo $kommentaar; ?>
	  </div>
	  <form method="post">
		<textarea type="text" name="kommentaar"  placeholder="sisesta siia saadetav info" cols="40" rows="10"><?php if(!empty($_POST["kommentaar"])) echo htmlspecialchars($_POST["kommentaar"]); ?></textarea><br/><br/>
			Tausta värvus: <input type="color" name="taustavarvus" <?php if(!empty($_POST["taustavarvus"])) echo "value=\"".htmlspecialchars($_POST["taustavarvus"])."\" "; ?>/><br/><br/>
			Teksti värvus: <input type="color" name="tekstivarvus" <?php if(!empty($_POST["tekstivarvus"])) echo "value=\"".htmlspecialchars($_POST["tekstivarvus"])."\" ";?>/><br/><br/>
			Piirjoone värvus: <input type="color" name="piirjoonevarvus" <?php if(!empty($_POST["piirjoonevarvus"])) echo "value=\"".htmlspecialchars($_POST["piirjoonevarvus"])."\" "; ?>/><br/><br/>
			Piirjoone stiil: 
			<select name="piirjoonestiil">
				<option value="solid" <?php if(!empty($_POST["piirjoonestiil"]) && $_POST["piirjoonestiil"] == "solid") echo "selected"; ?>>solid</option>
				<option value="double" <?php if(!empty($_POST["piirjoonestiil"]) && $_POST["piirjoonestiil"] == "double") echo "selected"; ?>>double</option>
				<option value="dotted" <?php if(!empty($_POST["piirjoonestiil"]) && $_POST["piirjoonestiil"] == "dotted") echo "selected"; ?>>dotted</option>
				<option value="none" <?php if(!empty($_POST["piirjoonestiil"]) && $_POST["piirjoonestiil"] == "none") echo "selected"; ?>>none</option>
			</select><br/><br/>
			Piirjoone laius: <input type="number" name="piirjoonelaius"<?php if(!empty($_POST["piirjoonelaius"]) && is_numeric($_POST["piirjoonelaius"])) echo "value=\"".htmlspecialchars($_POST["piirjoonelaius"])."\" "; ?>/><br/><br/>
			Piirjoona raadius nurkades: <input type="number" name="piirjooneraadius"<?php if(!empty($_POST["piirjooneraadius"]) && is_numeric($_POST["piirjooneraadius"])) echo "value=\"".htmlspecialchars($_POST["piirjooneraadius"])."\" "; ?>/><br/><br/>
    </div>
    <input type="submit" value="Esita" />
  </form>
</body>
</html>