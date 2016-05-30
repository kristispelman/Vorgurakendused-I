<?php

/*andmebaasi sisse lugemine*/
$baas = 'andmebaas.txt';
$andmebaas = file_get_contents($baas);/*muutujasse $andmebaas laetakse failiinfo tekstina sisse*/
$andmebaas = json_decode($andmebaas, true); /*tekstilise sisu salvestatakse json formaati, mis võimaldab sinna massiivi lisada*/
	
if ($_SERVER['REQUEST_METHOD'] =='POST') {
		
	/*kustutamine*/
	if (isset($_POST['kustuta'])){ /*kontrollitakse, kas post massiivi muutujas on indeks "kustuta"*/
		$kustuta = intval($_POST['kustuta']); /*saadud väärtuse muudetakse numbriliseks*/
		unset($andmebaas[$kustuta]); /*kustutatakse andmebaasi massiivist vastaval indeksil olev element*/
		
	/*lisamine*/
	} else {
		$nimetus = $_POST['nimetus'];
		$kategooria = $_POST['kategooria'];
		$kogus = intval($_POST['kogus']); /*brauser saadab serverisse alati teksti, seetõttu tekstiline sisu muudetakse numbriliseks*/
			
		if ($nimetus == '' || $kategooria == '' || $kogus < 0){
			header('Content-type: text/plain; charset="utf-8"');
			echo 'Mittelubatud väärtused!';
			exit;
		}
			
		/*andmebaasi massiivi sisuks lisatakse teine massiiv võti-väärtus paarid*/
		$andmebaas[] = array(
			'nimetus' => $nimetus,
			'kategooria' => $kategooria, 
			'kogus' => $kogus
		);  
	}
	/*andmebaasi salvestamine*/
	$andmebaas = json_encode($andmebaas); /*andmebaasi massiiv salvestatakse tagasi teksti kujule*/
	file_put_contents($baas, $andmebaas); /*muutujast $andmebaas laetakse andmed tagasi faili*/
		
	header('location: tooted.php'); /*brauser suunatakse tagasi esialgsele lehele*/

}

?>
