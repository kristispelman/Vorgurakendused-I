window.onload=function(){
	gal = document.getElementById('galerii');
	if(gal!=null){
		// galerii olemas
		pildid=gal.getElementsByTagName('img');
		for(i=0; i<pildid.length; i++){
			pildid[i].onclick=function(){
				showDetails(this);
				return false;
			}
		}		
	}
}

window.onresize=function() {
	suurpilt=document.getElementById("suurpilt");
	suurus(suurpilt);
}

function showDetails(img){
	hoidja = document.getElementById('hoidja');
	if(hoidja != null){
		suur = document.getElementById('suurpilt');
		suur.src = img.parentNode.href;
		suur.onload = function(){
			suurus(this);
		}
		document.getElementById('inf').innerHTML = img.alt;
		hoidja.style.display="block";
	}
}

function hideDetails(){
	document.getElementById('hoidja').style.display="none";
}


function suurus(el){
  el.removeAttribute("height"); // eemaldab suuruse
  el.removeAttribute("width");
  if (el.width>window.innerWidth || el.height>window.innerHeight){  // ainult liiga suure pildi korral
    if (window.innerWidth >= window.innerHeight){ // lai aken
      el.height=window.innerHeight*0.9; // 90% kõrgune
      if (el.width>window.innerWidth){ // kas element läheb ikka üle piiri?
        el.removeAttribute("height");
        el.width=window.innerWidth*0.9;
      }
    } else { // kitsas aken
      el.width=window.innerWidth*0.9;   // 90% laiune
      if (el.height>window.innerHeight){ // kas element läheb ikka üle piiri?
        el.removeAttribute("width");
        el.height=window.innerHeight*0.9;
      }
    }
  }
}
