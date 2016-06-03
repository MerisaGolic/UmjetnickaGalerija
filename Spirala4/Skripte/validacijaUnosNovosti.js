function validiraj(ulaz)
{
	if(ulaz.name == "naslov")
	{
		if(ulaz.value == "")
		{
			ulaz.style.backgroundColor = "red";
		}
		else
			ulaz.style.backgroundColor = "white";
	}
	else if(ulaz.name == "tekst")
	{
		if(ulaz.value == "")
		{
			ulaz.style.backgroundColor = "red";
		}
		else
			ulaz.style.backgroundColor = "white";
	}
}

function ProvjeriPozivni(ulaz)
{
	var drzava = document.getElementById('kodDrzave').value.toLowerCase(); // Selektovana dzava
	
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "https://restcountries.eu/rest/v1/alpha?codes=" + drzava, true);
	
	ajax.onreadystatechange = function() {// Anonimna funkcija
		
		if (ajax.readyState == 4 && ajax.status == 404)
			document.getElementById("rezultat").innerHTML = "Greska: nepoznat URL";
		
		
		var json = JSON.parse(ajax.responseText);
		var pozivni = json[0].callingCodes;
		var uneseni = document.getElementById('telefon').value;
		
		if(uneseni.indexOf(pozivni) != 0)
		{
			ulaz.style.backgroundColor = "red";
			document.getElementById("validacijaTelefona").value = "F";
		}
		else if(uneseni.match(/^[0-9]+$/) == null)
		{
			ulaz.style.backgroundColor = "red";
		    document.getElementById("validacijaTelefona").value = "F";
		}
		else 
		{
			ulaz.style.backgroundColor = "white";
			document.getElementById("validacijaTelefona").value = "T";
		}
	}

	ajax.send();
	
}