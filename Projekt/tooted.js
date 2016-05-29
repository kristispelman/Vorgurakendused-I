/*Seatakse "Kuva lisamise vorm" nupule klikkimise sündmusehalduri, mis peidab vastava nupu ja toob nähtavale lisamise vormi*/
document.querySelector('#kuvavorm button').addEventListener('click',
    function () {
        document.getElementById('lisatoode').style.display = 'block';
        document.getElementById('kuvavorm').style.display = 'none';
    });

/*Seatakse "Peida lisamise vorm" nupule sündmusehaldur, mis peaidab vastava nupu ja teeb kuvamise nupu nähtavaks*/
document.querySelector('#peidavorm button').addEventListener('click',
    function () {
        document.getElementById('lisatoode').style.display = 'none';
        document.getElementById('kuvavorm').style.display = 'block';
    });

/*Seatakse "Lisa toode" nupule submittimise sündmusealdur*/
document.getElementById('lisatoode').addEventListener('submit',
    /*Kontrollitakse vormis olevaid väärtusi ja lisatakse toodete tabelisse*/
    function (event) {
        /*Loetakse kasutaja vormi sisestatud andmeid*/
        var nimetus = document.getElementById('nimetus').value;
		var kategooria = Number(document.getElementById('kategooria').value);
        var kogus = Number(document.getElementById('kogus').value);

        /*Kontrollitakse väärtuseid*/
        if (!nimetus || !kategooria || kogus < 0) {
            alert('Mittelubatud väärtused!');
            // Katkestatakse posititamine
            event.preventDefault();
            return;
        }
    });
