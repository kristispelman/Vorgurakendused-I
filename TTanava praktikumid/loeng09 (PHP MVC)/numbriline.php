<?php if (!empty($_GET["q"]) && is_numeric( $_GET["q"] ) ): ?>
		<table border="1">
			<?php for($r=0; $r<$_GET["q"]; $r++):?>
				<tr>
					<?php for($c=0; $c<$_GET["q"]; $c++):?>
						<td>
							<?php echo "$r - $c"; ?>
						</td>
					<?php endfor; ?>
				</tr>
			<?php endfor; ?>
		</table>
<?php else: ?>
	<p>Palun sisesta number</p>
<?php endif; ?>

<form action="numbriline.php" method="GET">
	<input type="number" name="q"/>
	<input type="submit" name="s" value="esita!"/>
</form>
