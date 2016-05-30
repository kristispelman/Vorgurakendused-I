<?php include("header.php"); ?>
<?php include("menyy.php"); ?> 

<form method="post" action="vorm.php">
	<table class="tabel">
		<caption>Registreerimise vorm</caption>
		<tr>
			<th>
				<label for="kasutajanimi_id">Kasutajanimi:</label>
			</th>
			<td>
				<input type="text" id="kasutajanimi_id" name="kasutajanimi" placeholder="sisesta kasutajanimi"> <!-- vormi välja nimi saab php võtmeks-->
			</td>
		</tr>
		<tr>
			<th>
				<label for="parool1_id">Parool:</label>
			</th>
			<td>
				<input type="password" id="parool1_id" name="parool1" placeholder="sisesta parool">
			</td>
		</tr>
		<tr>
			<th>
				<label for="parool2_id">Parool uuesti:</label>
			</th>
			<td>
				<input type="password" id="parool2_id" name="parool2" placeholder="sisesta parool"> <!--kahte ühesugust elemendi nime ei tohi kasutada-->
			</td>
		</tr>
			<td colspan="2">
				<button type="submit">Registreeri</button>
			</td>
		</tr>				
	</table>
</form>

<?php include("footer.php"); ?> 