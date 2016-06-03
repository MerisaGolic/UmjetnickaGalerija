<?php
	session_start();
	print "<form action=\"registracija.php\" method=\"post\">
				<label>Unesite korisničko ime:</label><BR>
				<input type=\"text\" name=\"korisnik\">
				<BR><BR>
				<label>Unesite password:</label><BR>
				<input type=\"password\" name=\"pass1\">
				<BR><BR>
				<label>Ponovite password:</label><BR>
				<input type=\"password\" name=\"pass2\">
				<BR><BR>
				<input type=\"submit\" name=\"registracija\" value=\"Dodaj korisnika\">
		   </form>";
		   
	if(isset($_POST['registracija']) && $_SESSION['username'] == 'admin')
	{
		if($_POST['korisnik'] != "" && $_POST['pass1'] != "" && $_POST['pass2'] != "")
		{
			$ime = $_POST['korisnik'];
			$pass1 = $_POST['pass1'];
			$pass2 = $_POST['pass2'];
			
			if($pass1 !=  $pass2)
				print "Passwordi se ne slažu! Unesite ponovo!";
			
			$veza = new PDO("mysql:dbname=baza_wt;host=localhost;charset=utf8", "merisa", "merisa");
			$veza->exec("set names utf8");
			
			$rezultat = $veza->query("SELECT username FROM autor");
			
			$provjera = false;
			
			foreach($rezultat as $r)
				if ($r['username'] == $ime) 
					$provjera = true;
			
			if($provjera)
				print "Već postoji korisnik sa izabranim username-om!";
			else
			{	
				$hash = password_hash($pass1, PASSWORD_DEFAULT);
				$rezultat1 = $veza->exec("INSERT INTO autor (username, password) VALUES ('$ime', '$hash')");
				print "Uspješna registracija";
				header('location: admin.php');
			}
		}
		else  print "Morate unijeti sve podatke!";
	}
	
?>