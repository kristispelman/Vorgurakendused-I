<?php
	require_once('head.html');
?>
<?php
	$fotod=array(
	array("src"=>"pildid/nameless1.jpg", "alt"=>"nimetu 1", "id"=>"p1", "value"=>"1"),
	array("src"=>"pildid/nameless2.jpg", "alt"=>"nimetu 2", "id"=>"p2", "value"=>"2"),
	array("src"=>"pildid/nameless3.jpg", "alt"=>"nimetu 3", "id"=>"p3", "value"=>"3"),
	array("src"=>"pildid/nameless4.jpg", "alt"=>"nimetu 4", "id"=>"p4", "value"=>"4"),
	array("src"=>"pildid/nameless5.jpg", "alt"=>"nimetu 5", "id"=>"p5", "value"=>"5"),
	array("src"=>"pildid/nameless6.jpg", "alt"=>"nimetu 6", "id"=>"p6", "value"=>"6")
	);
?>
<h3>Vali oma lemmik :)</h3>
<form action="tulemus.php" method="GET">
	<?php
		foreach($fotod as $foto) {
			echo 
				"<p>
				<label for={$foto["id"]}>
					<img src = \"{$foto["src"]}\" alt=\"{$foto["alt"]}\" height=\"100\" />
				</label>
				<input type=\"radio\" value=\"{$foto["value"]}\" id=\"{$foto["id"]}\" name=\"foto\"/>
				</p>";	
		}
	?>
	<br/>
	<input type="submit" value="Valin!"/>
</form>
<?php
	require_once('foot.html');
?>
