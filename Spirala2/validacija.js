function validiraj(ulaz)
{
	if(ulaz.name == "name")
	{
		if(ulaz.value == "")
		{
			ulaz.style.backgroundColor = "red";
		}
		else
			ulaz.style.backgroundColor = "white";
	}
	else if(ulaz.name == "email")
	{
		if(!validirajEmail(ulaz.value))
			ulaz.style.backgroundColor = "red";
		else
			ulaz.style.backgroundColor = "white";
	}
	else if(ulaz.name = "poruka")
	{
		var ime = document.getElementsByName("name");
		var email = document.getElementsByName("email");
		
		if(ime[0].value == "" || email[0].value == "")
		{
			ulaz.value = "";
			ulaz.placeholder = "Morate prvo unijeti ime i e-mail adresu!";
		}
		else 
			ulaz.placeholder = "";
	}
}

function validirajEmail(email)
{
	console.log(email);
	var regex = /^[^\s@]+\@[^\s@]+\.[^\s@]+$/g;
	
	return regex.test(email);
}