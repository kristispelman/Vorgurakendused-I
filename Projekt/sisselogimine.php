<?php include("header.php"); ?>
<?php include("menyy.php"); ?>

<form method="get" action="vorm.php">
	<table class="tabel">
		<caption>Sisselogimise vorm</caption>
		<tr>
			<th>
				<label for="kasutajanimi_id">Kasutajanimi: </label>
			</th>
			<td>
				<input type="text" id="kasutajanimi_id" name="kasutajanimi" placeholder="sisesta kasutajanimi">
			</td>
		</tr>
		<tr>
			<th>
				<label for="parool_id">Parool: </label>
			</th>
			<td>
				<input type="password" id="parool_id" name="parool" placeholder="sisesta parool">
			</td>
		<tr>
			<td colspan="2">
				<label for="peameeles_id">Pea mind meeles
					<input type="checkbox" id="peameeles_id" name="peameeles"><!--NB! Tuleb määrata kehtivuse aeg; muidu kethib nii kaua kui cookie püsti-->
				</label>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<button type="submit">Logi sisse</button>
			</td>
		</tr>				
	</table>
</form>

<?php include("footer.php"); ?> 
