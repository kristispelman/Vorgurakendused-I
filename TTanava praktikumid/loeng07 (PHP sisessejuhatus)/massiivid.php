<?php

$loomad= array("esimene"=>"kass", 22 =>"koer", "hobune");

$loomad[]="lammas"; // automaatselt massivi lıpus, numbrilise vıtmega
$loomad["viimane"]="tuvi"; // ettem‰‰rtud vıtmega v‰li 
$loomad[2]="paabulind";

echo "Esimene loom oli: ".$loomad["esimene"];
echo "<br/>mingi loom oli ka: ".$loomad[22];

echo "<br/>veoloom: ".$loomad[23];

$kass = array( "toidud" => array( "kala", "piim",
"rohi"), "nimi" => "miisu" , "vanus"=> 12);
echo "<br/>kassi toit on: ".$kass["toidud"][1]; // piim


foreach($kass as $v6ti => $vaartus) {
echo "<br/>$v6ti on $vaartus";
}
echo "<hr/><pre>";
print_r($kass);
echo "<pre>";

?>