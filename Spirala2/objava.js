window.onload = function () 
{
	var vrijeme = document.getElementsByClassName("v");

    for (var i = 0; i < vrijeme.length; i++) 
	{
		var x = izracunajVrijeme(new Date(vrijeme[i].innerHTML));
		if (x == "text") 
			vrijeme[i].innerHTML = vrijeme[i].innerHTML;
		else 
			vrijeme[i].innerHTML = x;
    }
}

function izracunajVrijeme(v)
{
	var mjesec = v.getMonth();
	var test = 0;
	
	if(mjesec == 3 || mjesec == 5 || mjesec == 8 || mjesec == 10) test = 1;
	else if(mjesec == 1) test = 3;
	else test = 2;
	
	var protekloSekundi = Math.floor((new Date() - v) / 1000);
	
	if(protekloSekundi < 60)
	{
		return "Objavljeno prije par sekundi";
	}
	else if(protekloSekundi >= 60 && protekloSekundi < 3600)
	{
		var protekloMinuta = Math.floor(protekloSekundi/60);
		
		if(protekloMinuta%10 == 1)
			return "Objavljeno prije " + protekloMinuta + " minutu.";
		else if(protekloMinuta%10 < 5 && protekloMinuta%10 > 0)
			return "Objavljeno prije " + protekloMinuta + " minute.";
		else
			return "Objavljeno prije " + protekloMinuta + " minuta.";
		//minutu: 1, 21, 31, 41, 51
		//minute: 2, 3, 4, 22, 23, 24
		//minuta: 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ,16, 17, 18, 19, 20
	}
	else if(protekloSekundi >=3600 && protekloSekundi < 86400)
	{
		var protekloSati = Math.floor(protekloSekundi/3600);
		//sat: 1, 21
		//sata: 2, 3, 4, 22, 23
		//sati: 5, 6, 7 , 8, 9 ,10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20
		if(protekloSati%10 == 1)
			return "Objavljeno prije " + protekloSati + " sat.";
		else if(protekloSati%10 < 5 && protekloSati%10 > 0)
			return "Objavljeno prije " + protekloSati + " sata.";
		else 
			return "Objavljeno prije " + protekloSati+ " sati.";
	}
	else if(protekloSekundi >= 86400 && protekloSekundi < 604800)
	{
		var protekloDana = Math.floor(protekloSekundi/86400);
		//dan: 1
		//dana:2, 3, 4, 5, 6 
		if(protekloDana == 1)
			return "Objavljeno prije 1 dan.";
		else
			return "Objavljeno prije " + protekloDana + " dana."
	}
	else if(protekloSekundi >= 604800 && test == 1 && protekloSekundi < 2592000) // za 30 dana 
	{
		var protekloSedmica = Math.floor(protekloSekundi/604800);
		//sedmicu: 1
		//sedmice:2,3,4
		if(protekloSedmica == 1)
			return "Objavljeno prije 1 sedmicu.";
		else 
			return "Objavljeno prije " + protekloSedmica + " sedmice.";
	}
	else if(protekloSekundi >= 604800 && test == 2 && protekloSekundi < 2678400) // za 31 dan
	{
		var protekloSedmica = Math.floor(protekloSekundi/604800);
		//sedmicu: 1
		//sedmice:2,3,4
		if(protekloSedmica == 1)
			return "Objavljeno prije 1 sedmicu.";
		else 
			return "Objavljeno prije " + protekloSedmica + " sedmice.";
	}
	else if(protekloSekundi >= 604800 && test == 3 && protekloSekundi < 2505600) // za februar 29
	{
		var protekloSedmica = Math.floor(protekloSekundi/604800);
		//sedmicu: 1
		//sedmice:2,3,4
		if(protekloSedmica == 1)
			return "Objavljeno prije 1 sedmicu.";
		else 
			return "Objavljeno prije " + protekloSedmica + " sedmice.";
	}
	
	return "text";
}

function Razvrstaj()
{
	var izbor = document.getElementById("dropdown").value;
    var novosti = document.getElementsByClassName("novost");
	var vrijeme = document.getElementsByClassName("v");
	var podstring = ["sek", "min", "sat", "dan", "sedmic", ":"];
	
	for(i = 0; i < novosti.length; i++)
			novosti[i].style.display = 'block';
		
	if(izbor == "dan")
	{
		
		for(i = 0; i < vrijeme.length; i++)
			if (vrijeme[i].innerHTML.indexOf(podstring[3]) > -1 || vrijeme[i].innerHTML.indexOf(podstring[4]) > -1 || vrijeme[i].innerHTML.indexOf(podstring[5]) > -1)
				novosti[i].style.display = 'none';     
	}
	else if(izbor == "sedmica")
	{

		for(i = 0; i < vrijeme.length; i++)
			if(vrijeme[i].innerHTML.indexOf(podstring[4]) > -1 || vrijeme[i].innerHTML.indexOf(podstring[5]) > -1)
				novosti[i].style.display = 'none';  
	}
	else if(izbor == "mjesec")
	{
		var mjesec = new Date().getMonth();
		var godina = new Date().getYear();
		
		for(i = 0; i < vrijeme.length; i++)
			if(vrijeme[i].innerHTML.indexOf(podstring[5]) > -1 && new Date(vrijeme[i].innerHTML).getMonth() != mjesec && new Date(vrijeme[i].innerHTML).getYear() == godina)
				novosti[i].style.display = 'none';		
	}
	else if(izbor == "sve")
	{
		for(i = 0; i < novosti.length; i++)
			novosti[i].style.display = 'block';
	}

}