<?php		
	ob_start();
	require_once('password.php');
	$text = "";
		
	if(isset($_POST['prijava'])) 
	{
		$ime = $_POST['username'];
		$sifra = $_POST['password'];
		
		$veza = new PDO("mysql:dbname=baza_wt;host=localhost;charset=utf8", "merisa", "merisa");
		$veza->exec("set names utf8");
			
		$rezultat = $veza->query("SELECT username, password FROM autor");
		
		$nadjen = false;
		
		foreach($rezultat as $r)
			if($r['username'] == $ime && password_verify($sifra, $r['password']))
				$nadjen = true;
			
		if($nadjen)	
		{
			session_start();
			$_SESSION['valid'] = true;
			$_SESSION['timeout'] = time();
			$_SESSION['username'] = $ime;	
			
			$text = "Uspješno ste prijavljeni!";	
			if($ime == 'admin')
				header('location: admin.php');
			else
				header('location: unosNovosti.php');
				
		} 
		else $text = "Pogrešni podaci!";
	}
	ob_end_clean();
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="CSS/Stranica1.css"> 
	<link rel="stylesheet" type="text/css" href="CSS/zajednicki.css">
	<link rel="stylesheet" type="text/css" href="CSS/logo.css">	
	<script src="Skripte/objava.js" type="text/javascript"></script>
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
		
		<div id ="meni">
			<ul>
				<li><a href="index.php" class="button">Početna stranica</a></li>
				<li><a href="Stranica2.html" class="button">Usluge</a></li>
				<li><a href="Stranica3.html" class="button">Kontakt</a></li>
				<li><a href="Stranica4.html" class="button">Linkovi</a></li>
			</ul>
			<BR>
		</div>
		
	    <div id="naslov">
			<BR>
			<h3 id="nov">Novosti</h3>
				<form action="index.php" method="post">
					<h5>Login:</h5> 
					<input id="korisnik" type="text" name="username" placeholder="Username">
					<input id="sifra" type="password" name="password" placeholder="Password">
					<input id="dugme" type="submit" name="prijava" value="Prijava">
					<h5><?php echo $text; ?></h5>
				</form>			
			<BR>
			<div>
				<select id="dropdown" onchange="Razvrstaj()">	
						<option value="sve">Sve novosti</option>
						<option value="dan">Današnje novosti</option>
						<option value="sedmica">Novosti ove sedmice</option>
						<option value="mjesec">Novosti ovog mjeseca</option>
				</select>
				<BR>
				<BR>
				<form id="sortiranje" action="index.php" method="post">
					<input id="dugme" type="submit" name="sortiranjeABC" value="Sortiraj novosti abecedno">
					<input id="dugme" type="submit" name="sortiranjeVrijeme" value="Sortiraj po vremenu objavljivanja">
				</form>
			</div>
			
			<BR>
			<BR>		
		
			<div id="novosti">
				<?php					
					
					$veza = new PDO("mysql:dbname=baza_wt;host=localhost;charset=utf8", "merisa", "merisa");
					$veza->exec("set names utf8");
					
					//dodavanje komentara
					if(isset($_POST['dodajKomentar']) && $_POST['noviKomentar'] != "")
					{
						$tekst = $_POST['noviKomentar'];
						$novostID = $_GET['novost'];
						
						$upit = $veza->exec("insert into komentar set novost='$novostID', tekst='$tekst', vrijeme = NOW()");
					}
					//dodavanje podkomentara
					if(isset($_POST['dodajKomNaKom']) && $_POST['komNAkom'] != "")
					{
						$tekst = $_POST['komNAkom'];
						$novostID = $_GET['novost'];
						$odgovor = $_POST['idkomentara'];
						
						$upit = $veza->exec("insert into komentar set novost='$novostID', tekst='$tekst', vrijeme = NOW(), komentar_id='$odgovor'");
					}
					//ucitavanje novosti
					$rezultat = $veza->query("select id, naslov, slika, tekst, autor_slike, autor_novosti, UNIX_TIMESTAMP(vrijeme) vrijeme1, otvorena_za_komentare from novost order by vrijeme desc");
					
					if (isset($_POST['sortiranjeABC']))
						$rezultat = $veza->query("select id, naslov, slika, tekst, autor_slike, autor_novosti, UNIX_TIMESTAMP(vrijeme) vrijeme1, otvorena_za_komentare from novost order by naslov asc");
					else if (isset($_POST['sortiranjeVrijeme']))
						$rezultat = $veza->query("select id, naslov, slika, tekst, autor_slike, autor_novosti, UNIX_TIMESTAMP(vrijeme) vrijeme1, otvorena_za_komentare from novost order by vrijeme desc");
					
					$brojac = 1;
					
					if(isset($_GET['autor']))
					{
						$aut = $_GET['autor'];
						$rezultat = $veza->query("select id, naslov, slika, tekst, autor_slike, autor_novosti, UNIX_TIMESTAMP(vrijeme) vrijeme1, otvorena_za_komentare from novost where autor_novosti = '$aut' order by vrijeme desc");
					}
					foreach($rezultat as $n)
					{
						date_default_timezone_set('Europe/Sarajevo');
						$src = "Slike/".($n['slika']);
						$id = $n['id'];
						$datum = date("Y-m-d H:i:s", $n['vrijeme1']);
						
						$naslov = $n['naslov'];
						$tekst = $n['tekst'];
						$autor = $n['autor_slike'];
						$autorNovosti= $n['autor_novosti'];
						$otvorena_za_komentare = $n['otvorena_za_komentare'];
						
						print "<div class=\"novost\">	
									<p class=\"v\"></p>
									<a class=\"detaljanPrikaz\" href='index.php?novost=$id'>Detaljan prikaz novosti</a>
									<time class='t' datetime=$datum ></time>
									<h3>$naslov</h3>
									<BR>
									<p>$tekst</p>
									<BR>
									<img src=$src alt=\"Slika\">
									<p class=\"autor\">$autor</p><BR><BR>";
						//prikaz komentara
						if(isset($_GET['novost']) && $otvorena_za_komentare && $_GET['novost'] == $id)
						{
							$idNovosti = $_GET['novost'];
							$komentari = $veza->query("select id, tekst, novost from komentar where novost = '$idNovosti' AND komentar_id IS NULL");
							$i = true;
							foreach($komentari as $kom)
							{						
								if($i)
								{
									print "<p class=\"detaljanPrikaz\">Komentari:</p><BR>";
									$i = false;
								}
								print "<p class=\"komentar\">".$kom['tekst']."</p><BR>";
									   
								$komID = $kom['id'];
								$podkomentari = $veza->query("select tekst from komentar where komentar_id = '$komID'");
								//prvo ispisi sve podkomentare
								foreach($podkomentari as $pk)
									print "<p class=\"podkomentar\">".$pk['tekst']."</p><BR>";
								print "<a class=\"detaljanPrikaz\" href='index.php?novost=$id&odgovor_na_komentar=".$kom['id']."'>Odgovori na komentar</a>
									   <BR>";
								
								//pa ispisi prostor za ostavljanje podkomentara
								if(isset($_GET['odgovor_na_komentar']) && $_GET['odgovor_na_komentar'] == $kom['id'] )
									print "<form action=\"index.php?novost=$id\" method=\"post\">
											<input class=\"komentar\" type=\"text\" name=\"komNAkom\" placeholder=\"Unesite odgovor ovdje...\">
											<input class=\"komentar\" type=\"submit\" name=\"dodajKomNaKom\" value=\"Komentariši\">
											<input type=\"hidden\" name=\"idkomentara\" value=\"$komID\">
											</form><BR><BR>";
							}
							print "<form action=\"index.php?novost=$id\" method=\"post\">
											<input class=\"komentar\" type=\"text\" name=\"noviKomentar\" placeholder=\"Unesite novi kometar ovdje...\">
											<input class=\"komentar\" type=\"submit\" name=\"dodajKomentar\" value=\"Komentariši\">
											</form><BR><BR>";
							
							//autor novosti
							$an = $veza->query("select username from autor where id='$autorNovosti'");
							foreach($an as $autorn)
							print "<BR><a class=\"autorNovosti\" href='index.php?autor=$autorNovosti'>".$autorn['username']."</a><BR>";
						}
						if(isset($_GET['novost']) && !$otvorena_za_komentare && $_GET['novost'] == $id)
						{
							print "<p class=\"komentar\">Novost nije otvorena za komentare!</p>";
							//autor novosti
							$an = $veza->query("select username from autor where id='$autorNovosti'");
							foreach($an as $autorn)
							print "<BR><a class=\"autorNovosti\" href='index.php?autor=$autorNovosti'>".$autorn['username']."</a><BR>";
						}					
							
						print "</div>";
								
						if( $brojac%2 == 0 )
							print "<BR class=\"clear\"/>
							       <BR class=\"clear\"/>";
						$brojac++;
					}
					
				?>	
				<BR class="clear"/>
				<BR class="clear"/>
			</div>
		</div>	
	</div>				
</BODY>
</HTML>