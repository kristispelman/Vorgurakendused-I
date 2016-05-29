<?php include("header.php"); ?> 
<?php include("menyy.php"); ?> 

<p id="kuvavorm">
    <button type="button">Kuva lisamise vorm</button>
</p>

<form id="lisatoode"  method="post" action="funktsioonid.php">

    <p id="peidavorm">
		<button type="button">Peida lisamise vorm</button>
    </p>
    <table>
        <tr>
            <td>Nimetus</td>
            <td>
                <input type="text" name="nimetus" id="nimetus_id">
            </td>
		</tr>
		<tr>
			<td>Kategooria</td>
			<td> 
				<select name="kategooria" id="kategooria_id">
					<option value="valmistoode" selected>Valmistoode</option>
					<option value="tooraine">Tooraine</option>
					<option value="pakend">Pakend</option>
				</select>
			</td>
        </tr>
        <tr>
            <td>Kogus</td>
            <td>
                <input type="number" name="kogus" id="kogus_id">
            </td>
		</tr>
    </table>

    <p>
        <button type="submit">Lisa toode</button>
    </p>

</form>
		
<table id="tooed" class="tabel">
	<caption>Tooted</caption>
	<thead>
		<tr>
			<th>Nimetus</th>
			<th>Kategooria</th>
			<th>Kogus</th>
		<tr>
	</thead>
	<tbody>
		<?php include ("funktsioonid.php"); ?> 
		<?php foreach ($andmebaas as $index => $rida): ?>
        	<tr>
        		<td>
        			<?= htmlspecialchars($rida['nimetus']); ?>
        		</td>
				<td>
        			<?= htmlspecialchars($rida['kategooria']); ?>
        		</td>
        		<td>
        			<?= $rida['kogus']; ?>
        		</td>
        		<td>
        			<form method="post" action="funktsioonid.php">
        				<input type="hidden" name="kustuta" value="<?= $index; ?>">
        				<button type="submit">Kustuta toode</button>
        			</form>
        		</td>
        	</tr>
        <?php endforeach; ?>

	</tbody>
</table>

<script src="tooted.js"></script>

<?php include("footer.php"); ?>

