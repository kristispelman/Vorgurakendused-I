<?php
	$kassid = array( 
		array("nimi"=>"Miisu", "vanus"=>2, "omanik"=>"M. Maasikas", "värvus"=>"must", "pilt"=>"http://www.warrenphotographic.co.uk/photography/bigs/38896-Black-cat-sitting-white-background.jpg"), 
		array("nimi"=>"Tom", "vanus"=>1, "omanik"=>"K. Kusta", "värvus"=>"valge", "pilt"=>"http://www.warrenphotographic.co.uk/photography/bigs/03596-White-cat-white-background.jpg"),
		array("nimi"=>"Tiuks", "vanus"=>3, "omanik"=>"V. Mannik", "värvus"=>"punane", "pilt"=>"http://www.warrenphotographic.co.uk/photography/bigs/15739-Red-Burmese-male-cat-white-background.jpg")
	);
	
	foreach($kassid as $kass){
	include("kassid.html");
	}
 
?>
