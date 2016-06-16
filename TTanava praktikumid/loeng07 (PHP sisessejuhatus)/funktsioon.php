<?php

function loenda_loomad($mitu=3){
	for($i=1; $i <= $mitu ; $i++) {
		echo "\n<p>see on $i. loom</p>";
	}
}

loenda_loomad();
 echo "<hr/>";
loenda_loomad(10)

?>