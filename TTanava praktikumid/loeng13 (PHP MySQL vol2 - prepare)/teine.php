<?php
$user = "test";
$pass = "t3st3r123";
$db = "test";
$host = "localhost";
$link = mysqli_connect($host, $user, $pass, $db) or die("ei saanud ühendatud");

mysqli_query($link, "SET CHARACTER SET UTF8")or die( $sql. " - ". mysqli_error($link));

// ettevalmistus
$stmt = mysqli_prepare($link, "SELECT name, age, color, owner_id FROM cats  WHERE owner_id < ? and age > ?");
// seome muutujad
mysqli_stmt_bind_param($stmt, "ii", $owner, $older);
$owner=3;
$older=2;
// käivita!
mysqli_stmt_execute($stmt);
// võta väärtused
mysqli_stmt_bind_result($stmt, $r['name'], $r['age'], $r['color'], $r['owner']);
// võta rida
//mysqli_stmt_fetch($stmt);


?>

<pre><?php // print_r($r);?></pre>
<p>omanik &lt; 3  && vanus &gt; 2</p>
<table border="1">
	<?php while (mysqli_stmt_fetch($stmt)): ?>
		<tr>
			<?php foreach($r as $field):?>
				<td>
					<?php echo $field; ?>
				</td>
			<?php endforeach; ?>
		</tr>
<?php endwhile; ?>
</table>

<?php
$owner=2;
$older=20;
// käivita!
mysqli_stmt_execute($stmt);

?>
<p>omanik &lt; 2  && vanus &gt; 20</p>
<table border="1">
	<?php while (mysqli_stmt_fetch($stmt)): ?>
		<tr>
			<?php foreach($r as $field):?>
				<td>
					<?php echo $field; ?>
				</td>
			<?php endforeach; ?>
		</tr>
<?php endwhile; ?>
</table>