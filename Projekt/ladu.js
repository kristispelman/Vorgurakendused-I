document.getElementById('toode').addEventListener('submit',
    function (event) {
        var kogus = Number(document.getElementById('kogus_id').value);
		var nimetus = document.getElementById('nimetus_id').value;
		var kategooria = document.getElementById('kategooria_id').value;
		var kirjeldus = document.getElementById('kirjeldus_id').value;
		if (!nimetus) {
			alert('Palun sisesta nimetus!');
			event.preventDefault();
            return;
        }
		else if (!kategooria) {
			alert('Palun sisesta kategooria!');
			event.preventDefault();
            return;
        }
		else if (!kogus) {
			alert('Palun sisesta kogus!');
			event.preventDefault();
            return;
        }
		else if (kogus <= 0) {
            alert('Kogus ei saa olla negatiivne või 0!');
            event.preventDefault();
            return;
        }
		else if (!kirjeldus) {
			alert('Palun sisesta kirjeldus!');
			event.preventDefault();
            return;
        }
    });
	
