window.onload = function() {
	var mummud = document.querySelectorAll('div.bead');
	for (var i = 0; i < mummud.length; i++) {
		mummud[i].onclick = function() {
			if (this.style.cssFloat == "right") {
				this.style.cssFloat = "left"; 
			} else {
				this.style.cssFloat = "right";			
			}
		}
	}
}


		









