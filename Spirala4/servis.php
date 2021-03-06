<?php
function zag() {
    header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
    header('Content-Type: text/html');
    header('Access-Control-Allow-Origin: *');
}
function rest_get($request, $data) 
{
	$veza = new PDO("mysql:dbname=baza_wt;host=localhost;charset=utf8", "merisa", "merisa");
	$veza->exec("set names utf8");
	
	$x = $data['x'];
	$autor = $data['autor'];
	
	$rezultat = $veza->query("select id from autor where username = '$autor'");
	$id = 0;
	foreach($rezultat as $r)
		$id = $r['id'];
		
	$rezultat1 = $veza->query("select count(*) from novost where autor_novosti= '$id'");
	$ukupnoNovosti = 0;
	foreach($rezultat1 as $r)
		$ukupnoNovosti = $r['count(*)'];
	
	if($x > $ukupnoNovosti)
		print "Preveliko X. Autor ima ukupno ".$ukupnoNovosti." novosti!";
	else
	{
		$rezultat2 = $veza->prepare("SELECT * FROM novost WHERE autor_novosti=?");
		$rezultat2->bindValue(1, $id, PDO::PARAM_INT);
		$rezultat2->execute();
		$novosti = $rezultat2->fetchAll();
		
		$niz = array();
		for ($i = 0; $i < $x; $i++)
			array_push($niz, $novosti[$i]);
		
		print "{ \"novosti\": " . json_encode($niz) . "}";
	}	
}
function rest_post($request, $data) { }
function rest_delete($request) { }
function rest_put($request, $data) { }
function rest_error($request) { }

$method  = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

switch($method) {
    case 'PUT':
        parse_str(file_get_contents('php://input'), $put_vars);
        zag(); $data = $put_vars; rest_put($request, $data); break;
    case 'POST':
        zag(); $data = $_POST; rest_post($request, $data); break;
    case 'GET':
        zag(); $data = $_GET; rest_get($request, $data); break;
    case 'DELETE':
        zag(); rest_delete($request); break;
    default:
        header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
        rest_error($request); break;
}
?>
