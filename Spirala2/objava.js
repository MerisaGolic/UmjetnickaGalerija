window.onload = function () 
{
	var paragrafi = document.getElementsByClassName("v");
	var vrijeme = document.getElementsByClassName("t");

    for (var i = 0; i < vrijeme.length; i++) 
	{
		var x = izracunajVrijeme(new Date(vrijeme[i].getAttribute("datetime")));
		
		if (x == "text") 
			paragrafi[i].innerHTML = String(vrijeme[i].getAttribute("datetime"));
		else 
			paragrafi[i].innerHTML = x;
    }
}

function izracunajVrijeme(v)
{
	var mjesec = v.getMonth();
	var test = 0;

	if(mjesec == 3 || mjesec == 5 || mjesec == 8 || mjesec == 10) test = 1; //30
	else if(mjesec == 1) test = 3; //29
	else test = 2; //31
	
	var protekloSekundi = Math.floor((new Date() - v) / 1000);
	
	if(protekloSekundi < 60)
	{
		return "Objavljeno prije par sekundi.";
	}
	else if(protekloSekundi >= 60 && protekloSekundi < 3600)
	{
		var protekloMinuta = Math.floor(protekloSekundi/60);
		
		if(protekloMinuta >=5 && protekloMinuta <= 20)
			return "Objavljeno prije " + protekloMinuta + " minuta.";
		else if(protekloMinuta%10 == 1)
			return "Objavljeno prije " + protekloMinuta + " minutu.";
		else if(protekloMinuta%10 < 5 && protekloMinuta%10 > 1)
			return "Objavljeno prije " + protekloMinuta + " minute.";
		
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
		
		if(protekloSati >=5 && protekloSati <= 20)
			return "Objavljeno prije " + protekloSati+ " sati.";
		else if(protekloSati%10 < 5 && protekloSati%10 > 1)
			return "Objavljeno prije " + protekloSati + " sata.";
		else if(protekloSati%10 == 1)
			return "Objavljeno prije " + protekloSati + " sat.";
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
	var vrijeme = document.getElementsByClassName("t");
	var sada = new Date();

	var d = [];
	
	for(var i = 0; i < vrijeme.length; i++)
		d.push(new Date(vrijeme[i].getAttribute("datetime")));

	for( var j = 0; j < novosti.length; j++)
		novosti[j].style.display = 'block';

	if(izbor == "dan")
	{	
	    d.forEach(function(element, index)
		{
			if(element.getDate() != sada.getDate() || element.getMonth() != sada.getMonth() || element.getFullYear() != sada.getFullYear())
				novosti[index].style.display = 'none';
		});
	}
	else if(izbor == "sedmica")
	{
		var danas = new Date();
		danas.setMilliseconds(0);
		danas.setSeconds(0);
		danas.setMinutes(0);
		danas.setHours(0);
			
		var pomocna = danas.getDay() || 7;
		var ponedjeljak = danas.getTime()/1000;
			
		if(pomocna != 1)
			ponedjeljak = ponedjeljak - pomocna*86400 + 86400; //koliko je proteklo sekundi od ponedjeljka do sadasnjeg trenutka
		
		d.forEach(function(element, index)
		{	
			if(element.getTime()/1000 < ponedjeljak)
				novosti[index].style.display = 'none';
		});
	}
	else if(izbor == "mjesec")
	{
		d.forEach(function(element, index)
		{
			if(element.getMonth() != sada.getMonth() || element.getFullYear() != sada.getFullYear())
				novosti[index].style.display = 'none';
		});
	}
}