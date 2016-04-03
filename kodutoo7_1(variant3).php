<?php
$string = "KRISTI";
function keeraTagurpidi($string) {
  for ($i=0; $i < strlen($string); $i++) {
    $uus_string[$i] = $string[strlen($string) - $i - 1];
    echo $uus_string[$i];
  }
}
echo keeraTagurpidi($string);
?>