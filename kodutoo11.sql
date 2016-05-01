/*Luua uus tabel 'loomaaed', kus on järgnevad väljad: id - täisarv, automaatselt suurenev primaarvõti, nimi - tekstiline väärtus, vanus - täisarv, liik - tesktiline väärtus, puur - täisarv*/
CREATE TABLE kspelman_loomaaed (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	nimi VARCHAR(50),
	vanus INTEGER,
	liik VARCHAR(50),
	puur INTEGER
);

/*Täita eelnevalt loodud tabel vähemalt 5 reaga. Sisestamisel valida andmed nii, et mõned loomad jagavad samat puuri ja mõnest liigist on mitu looma.*/
INSERT INTO kspelman_loomaaed( id, nimi, vanus, liik, puur ) 
VALUES (1, 'Rudolf', 4, 'põder', 15 ), ( 2, 'Bella', 8, 'hobune', 10 ), ( 3, 'Ronja', 7, 'hobune', 21 ), ( 4, 'Steffi', 6, 'tiiger', 16) , (5,  'Lonni', 5, 'lõvi', 16)

/*Hankida kõigi mingis ühes kindlas puuris elavate loomade nimi ja puuri number*/
SELECT nimi, puur FROM kspelman_loomaaed WHERE puur=16;

/*Hankida vanima ja noorima looma vanused*/
SELECT MAX(vanus) AS Vanim, MIN(vanus) AS Noorim FROM kspelman_loomaaed;

/*Hankida puuri number koos selles elavate loomade arvuga*/
SELECT puur AS 'Puuri number', count(*) AS 'Loomade arv' FROM kspelman_loomaaed GROUP BY puur;

/*Suurendada kõiki tabelis olevaid vanuseid 1 aasta võrra)*/
UPDATE kspelman_loomaaed SET vanus=vanus+1; 