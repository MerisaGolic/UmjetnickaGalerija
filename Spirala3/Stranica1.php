<?php		
	ob_start();
	require_once('password.php');
	$text = "";
		
	if(isset($_POST['prijava'])) {
		$rezultat = file("CSV/login.csv");
		$podaci = explode(",", $rezultat[0]);
		$ime = $podaci[0];
		$sifra = $podaci[1];

		$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
		if ($_POST['username'] == $ime && password_verify('admin', $hash)) {

			session_start();
			$_SESSION['valid'] = true;
			$_SESSION['timeout'] = time();
			$_SESSION['username'] = $ime;	
			
			$text = "Uspješno ste prijavljeni!";	
			
			header('location: unosNovosti.php');
			
		} else {
			$text = "Pogrešni podaci!";
		}
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
				<li><a href="Stranica1.php" class="button">Početna stranica</a></li>
				<li><a href="Stranica2.html" class="button">Usluge</a></li>
				<li><a href="Stranica3.html" class="button">Kontakt</a></li>
				<li><a href="Stranica4.html" class="button">Linkovi</a></li>
			</ul>
			<BR>
		</div>
		
	    <div id="naslov">
			<BR>
			<h3 id="nov">Novosti</h3>
				<form action="Stranica1.php" method="post">
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
				<!--<form action="Stranica1.php" method="post">
					<input id="dugme" type="submit" name="sortiranje" value="Sortiraj novosti abecedno">
				</form>	-->
			</div>
			
			<BR>
			
			<BR>		
		
			<div id="novosti">
				<?php
				
					//ucitavanje novosti
					$novosti = file("CSV/novosti.csv");
					$brojac = 1;
				
					for ($i = sizeof($novosti)-1; $i >= 0; $i--)
					{
						$n = explode(",", $novosti[$i]); //naslov, slika, tekst, autor, vrijeme
						$src = "Slike/".($n[1]);
						print "<div class=\"novost\">	
									<p class=\"v\"></p>	
									<time class='t' datetime=\"$n[4]\"></time>
									<h3>$n[0]</h3>
									<BR>
									<p>$n[2]</p>
									<BR>
									<img src=$src alt=\"Slika\">
									<p class=\"autor\">$n[3]</p>
								</div>";
								
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