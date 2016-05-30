<?php include("header.php"); ?>
<?php include("menyy.php"); ?>
		
<form method="POST" action="vorm.php" enctype="multipart/form-data">
	<table>
		<tr>
			<td>
				<label for="nimetus">Toote nimetus: </label>
				<input type="text" id="nimetus_id" name="nimetus" placeholder="sisesta toote nimetus">
			</td>
		</tr>
		<tr>
			<td>
				<label for="kategooria">Toote kategooria: </label> 
				<select id="kategooria_id" name="kategooria">
					<option value="valmistoode" selected>Valmistoode</option>
					<option value="tooraine">Tooraine</option>
					<option value="pakend">Pakend</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="kogus_id">Toote laojääk: </label>
				<input type="number" id="kogus_id" name="kogus" placeholder="sisesta laojääk">
			</td>
		</tr>
		<tr>
			<td>
				<label for="kuupaev_id">Toote registreerimise aeg: </label>
				<input type="date" id="kuupaev_id" name="kuupaev" placeholder="sisesta registreerimise aeg">
			</td>
		</tr>
		<tr>
			<td>
				<label for="kirjeldus_id">Toote kirjeldus: </label>
				<textarea id="kirjeldus_id" name="kirjeldus" cols="30" rows="5" placeholder="sisesta toote kirjeldus"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label for="pilt_id">Toote pilt: </label>
				<input type="file" id="pilt_id" name="pilt">
			</td>
		</tr>
	<table>
	<button type="submit">Lisa toode</button>
	<button type="reset">Tühjenda vorm</button><!--Selle asemele lsiada JS funktsioon olema -->
</form>

<?php include("footer.php"); ?> 