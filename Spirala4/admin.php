<!DOCTYPE HTML>
<HTML>
<HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="CSS/zajednicki.css">	
	<link rel="stylesheet" type="text/css" href="CSS/logo.css">	
	<link rel="stylesheet" type="text/css" href="CSS/admin.css">	
	<TITLE>VK art</TITLE>
</HEAD>
<BODY>
    <div id="okvir">
		<div id="zaglavlje"> 
			<BR><BR><BR>
			<h1>Umjetnička galerija</h1>
			<div id="logo">
				<div class="v1"></div> 
				<div class="v2"></div> 
				<div class="k1"></div>
				<div class="k2"></div>
				<div class="a3"></div>
				<div class="a1"></div>
				<div class="a2"></div>
				<div class="r1"></div>
				<div class="r2"></div>
				<div class="r3"></div>
				<div class="r4"></div>
				<div class="r5"></div>
				<div class="t1"></div>
				<div class="t2"></div>			
			</div>	
		</div>
		<BR><BR><BR>
		
		<div id ="meniAdmmin">
		<form action="admin.php" method="post">
			<input class="button" type="submit" name="korisnici" value="Upravljanje korisnicima">
			<input class="button" type="submit" name="upravljanjeNovostima" value="Upravljanje novostima">	
			<input class="button" type="submit" name="novosti" value="Dodavanje novosti">		
			<input class="button" type="submit" name="logout" value="Odjava">	
		</form>
			<BR>
		</div><BR>
		<h2> Dobrodošao administratore!</h2>
		<?php
			session_start();
			$veza = new PDO("mysql:dbname=baza_wt;host=localhost;charset=utf8", "merisa", "merisa");
			$veza->exec("set names utf8");
			
			if(isset($_POST['novosti']) && $_SESSION['username'] == "admin")
			{
				header('location: unosNovosti.php');
			}
			if(isset($_POST['logout']) && $_SESSION['username'] == "admin")
			{
				unset($_SESSION['username']);
				unset($_SESSION['password']);
				session_destroy();

				$text = "Uspješno ste odjavljeni!";
				header('location: index.php');
			}
			
			if(isset($_POST['registracija']) && $_SESSION['username'] == "admin")
			{
				header('location: registracija.php');
			}
			if(isset($_POST['E']) && $_POST['korisnik'] != "")
			{
				$ime = $_POST['korisnik'];
				
				$id = 0;
				$rezultat = $veza->query("select id from autor where username = '$ime'");
				foreach($rezultat as $r)
					$id = $r['id'];
				
				if($id == 0)
					print "Nije pronađen korisnik datim imenom!<BR>";
				else
				{
					$un = $_POST['ime'];
					
					$rezultat2 = $veza->query("SELECT username FROM autor");
					$provjera = false;
					
					foreach($rezultat2 as $r)
						if ($r['username'] == $un) 
							$provjera = true;
					
					if($provjera)
						print "Već postoji korisnik sa izabranim username-om!<BR>";
					else
					{
						$pw = $_POST['pass'];
						$hash = password_hash($pw, PASSWORD_DEFAULT);
						if($_POST['ime'] != "" && $_POST['pass'] == "")
							$rezultat1 = $veza->exec("update autor set username = '$un' where id = '$id'");
						else if($_POST['ime'] == "" && $_POST['pass'] != "")
							$rezultat1 = $veza->exec("update autor set password = '$hash' where id = '$id'");
						else if($_POST['ime'] != "" && $_POST['pass'] != "")
							$rezultat1 = $veza->exec("update autor set password = '$hash', username = '$un' where id = '$id'");
						
						print "Podaci uspješno izmijenjeni!<BR>";
					}
				}
				
			}
			if(isset($_POST['izmjena']) && $_SESSION['username'] == "admin")
			{
				$rezultat = $veza->query("select id, username, password from autor");
				
				print "<form action=\"admin.php\" method=\"post\">
						<table border=\"1\" style=\"width:60%\">
						<tr><th>Username</th>
							<th>Password</th></tr>";
				foreach($rezultat as $r)
				{
					print "<tr><td>".$r['username']."</td>
							   <td>".$r['password']."</td></tr>";
				}
				
				print "</table><BR><BR><label>Unesite ime korisnika kojem želite izmijeniti podatke:</label><BR>
						<input type=\"text\" name=\"korisnik\">
						<BR><BR><label>Novo korisničko ime:</label><BR>
						<input type=\"text\" name=\"ime\">
						<BR><BR><label>Novi password:</label><BR>
						<input type=\"password\" name=\"pass\">
						<BR><BR>
						<input type=\"submit\" name=\"E\" value=\"Izmijeni\"> <BR><BR></form>";
			}
			if(isset($_POST['X']))
			{
				$ime = $_POST['korisnik'];
				
				$id = 0;
				$rezultat1 = $veza->query("select id from autor where username = '$ime'");
				foreach($rezultat1 as $r)
					$id = $r['id'];
					
				$rezultat2 = $veza->exec("delete from novost where autor_novosti = '$id'");
				$rezultat3 = $veza->exec("delete from autor where id = '$id'");
				
				print "<BR>Korisnik uspješno obrisan!<BR>";
					
			}
			if(isset($_POST['brisanje']) && $_SESSION['username'] == "admin")
			{
				$rezultat = $veza->query("select id, username, password from autor");
				
				print "<form action=\"admin.php\" method=\"post\">
						<table border=\"1\" style=\"width:60%\">
						<tr><th>Username</th>
							<th>Password</th></tr>";
				foreach($rezultat as $r)
				{
					print "<tr><td>".$r['username']."</td>
							   <td>".$r['password']."</td></tr>";
				}
				
				print "</table><BR><BR><label>Unesite ime korisnika kojeg želite obrisati ime:</label><BR>
						<input type=\"text\" name=\"korisnik\">
						<BR><BR>
						<input type=\"submit\" name=\"X\" value=\"Obriši\"> <BR><BR></form>";
			}
			if(isset($_POST['korisnici']) && $_SESSION['username'] == "admin")
			{
				$rezultat = $veza->query("select id, username, password from autor");
				
				print "<form action=\"admin.php\" method=\"post\">
						<table border=\"1\" style=\"width:60%\">
						<tr><th>Username</th>
							<th>Password</th></tr>";
				foreach($rezultat as $r)
				{
					print "<tr><td>".$r['username']."</td>
							   <td>".$r['password']."</td></tr>";
				}
				print "</table><BR><BR>
						<input type=\"submit\" name=\"registracija\" value=\"Novi korisnik\">
						<input type=\"submit\" name=\"brisanje\" value=\"Izbriši korisnika\">
						<input type=\"submit\" name=\"izmjena\" value=\"Izmjeni podatke o korisniku\">
						</form> <BR><BR><BR>";	
			}
			if(isset($_POST['edit']))
			{
				$id = $_POST['idNovosti'];
				$jedan = 1;
				$nula = 0;
				$rezultat = $veza->query("select otvorena_za_komentare from novost where id = '$id'");
				$otvorena = 0;
				
				foreach($rezultat as $r)
					$otvorena = $r['otvorena_za_komentare'];

				if($otvorena)
					$rezultat1 = $veza->exec("update novost set otvorena_za_komentare = '$nula' where id = '$id'");
				else
					$rezultat1 = $veza->exec("update novost set otvorena_za_komentare = '$jedan' where id = '$id'");
				print "Uspješno izmijenjeno!";
			}
			if(isset($_POST['promijeni']))
			{
				$rezultat = $veza->query("select id, naslov, otvorena_za_komentare from novost");
				
				print "<form action=\"admin.php\" method=\"post\">
						<table border=\"1\" style=\"width:60%\">
						<tr><th>ID</th>
							<th>Naslov</th>
							<th>Otvorena za komentare</th></tr>";
				foreach($rezultat as $r)
				{
					print "<tr><td>".$r['id']."</td>
								<td>".$r['naslov']."</td>";
					if($r['otvorena_za_komentare'])
						print "<td>DA</td></tr>";
					else 
						print "<td>NE</td></tr>";
				}
				print "</table><BR><BR><label>Unesite id novosti kojoj želite promijeniti mogućnost komentarisanja:</label><BR>
						<input type=\"text\" name=\"idNovosti\">
						<BR><BR>
						<input type=\"submit\" name=\"edit\" value=\"Promijeni\"> <BR><BR></form>";	
			}
			if(isset($_POST['del']))
			{
				$id = $_POST['id'];
				$rezultat1 = $veza->exec("delete from komentar where novost = '$id'");
				$rezultat2 = $veza->exec("delete from novost where id = '$id'");
				print "Novost uspješno obrisana!";
			}
			if(isset($_POST['obrisi']))
			{
				$rezultat = $veza->query("select id, naslov, otvorena_za_komentare from novost");
				
				print "<form action=\"admin.php\" method=\"post\">
						<table border=\"1\" style=\"width:60%\">
						<tr><th>ID</th>
							<th>Naslov</th>
							<th>Otvorena za komentare</th></tr>";
				foreach($rezultat as $r)
				{
					print "<tr><td>".$r['id']."</td>
								<td>".$r['naslov']."</td>";
					if($r['otvorena_za_komentare'])
						print "<td>DA</td></tr>";
					else 
						print "<td>NE</td></tr>";
				}
				print "</table><BR><BR><label>Unesite id novosti koju želite izbrisati:</label><BR>
						<input type=\"text\" name=\"id\">
						<BR><BR>
						<input type=\"submit\" name=\"del\" value=\"Obriši\"> <BR><BR></form>";	
			}
			if(isset($_POST['upravljanjeNovostima']) && $_SESSION['username'] == "admin")
			{
				$rezultat = $veza->query("select id, naslov, otvorena_za_komentare from novost");
				
				print "<form action=\"admin.php\" method=\"post\">
						<table border=\"1\" style=\"width:60%\">
						<tr><th>ID</th>
							<th>Naslov</th>
							<th>Otvorena za komentare</th></tr>";
				foreach($rezultat as $r)
				{
					print "<tr><td>".$r['id']."</td>
								<td>".$r['naslov']."</td>";
					if($r['otvorena_za_komentare'])
						print "<td>DA</td></tr>";
					else 
						print "<td>NE</td></tr>";
				}
				print "</table><BR><BR>
						<input type=\"submit\" name=\"obrisi\" value=\"Izbriši novost\">
						<input type=\"submit\" name=\"promijeni\" value=\"Mogućnost komentarisanja\">
						</form> <BR><BR><BR>";
						
				//komentari
				
				$rezultat1 = $veza->query("select id, tekst from komentar");
				
				print "<form action=\"admin.php\" method=\"post\">
						<table border=\"1\" style=\"width:60%\">
						<tr><th>ID</th>
							<th>Tekst</th>
							</tr>";
				foreach($rezultat1 as $r)
				{
					print "<tr><td>".$r['id']."</td>
								<td>".$r['tekst']."</td></tr>";
				}
				print "</table><BR><BR>
						<input type=\"submit\" name=\"obrisiKom\" value=\"Izbriši komentar\">
						</form> <BR><BR><BR>";
			}
			if(isset($_POST['obrisiKom']))
			{
				$rezultat1 = $veza->query("select id, tekst from komentar");
				
				print "<form action=\"admin.php\" method=\"post\">
						<table border=\"1\" style=\"width:60%\">
						<tr><th>ID</th>
							<th>Tekst</th>
							</tr>";
				foreach($rezultat1 as $r)
				{
					print "<tr><td>".$r['id']."</td>
								<td>".$r['tekst']."</td></tr>";
				}
				
				print "</table><BR><BR><label>Unesite id komentara koji želite izbrisati:</label><BR>
						<input type=\"text\" name=\"idKom\">
						<BR><BR>
						<input type=\"submit\" name=\"delKom\" value=\"Obriši\"> <BR><BR></form>";	
			}
			if(isset($_POST['delKom']))
			{
				$id = $_POST['idKom'];
				
				$rezultat = $veza->exec("delete from komentar where komentar_id = '$id'");
				$rezultat1 = $veza->exec("delete from komentar where id = '$id'");
				
				print "Komentar uspješno izbrisan!";
			}
		?>
		
	</div>	
</BODY>
</HTML>
		
		