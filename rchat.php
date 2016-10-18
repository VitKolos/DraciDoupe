<?php
/*error_reporting(0);*/
	if (isset($_GET["id"]) && isset($_GET["hrac"])) {
		
	/*$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
	if($pos===false) {
	header("Location: index.php");
	exit;}
	
	else {*/

	require_once("databaze.php");
	$db = new PDO($dbset, $dbnick, $dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$parametry = array();
	
	$dotaz="";
	$vystup="";
	$dotaz = $db->prepare("SELECT * FROM rooms WHERE id=".$_GET["id"]);
	$dotaz->execute($parametry);
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		$id = $vystup["id"];
		$nazev = $vystup["nazev"];
		$vypravec = $vystup["vypravec"];
		$idvypravece = $vystup["idvypravece"];
		$zalozeno = $vystup["zalozeno"];
		$aktivita = $vystup["aktivita"];
		$cas = $vystup["cas"];
		$hraci = $vystup["hraci"];
		$maxhraci = $vystup["maxhraci"];
	}
	
	$dotaz="";
	$vystup="";
	$dotaz = $db->prepare("SELECT * FROM roomchat".$id." ORDER BY id ASC");
	$dotaz->execute($parametry);
	$chat = array();
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		$chat[] = array(
          'autor' => $vystup['autor'],
          'cas' => $vystup['timestamp'],
          'text' => $vystup['text'],
        );
	}
	$idhrace = $_GET["hrac"];
	require_once ("rchat-vypis.php");
	
	//}
	
	}
	
	else {
		header("Location: index.php");
		exit;
	}
?>
