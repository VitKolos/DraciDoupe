<?php
/*error_reporting(0);*/
	
		
	$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
	if($pos===false) {
	header("Location: index.php");
	exit;}
	
	else {

	require_once("databaze.php");
	
	if (isset($_GET["id"]) && isset($_GET["hrac"])) {
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
	$jezprava=false;
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
		$jezprava=true;
	}
	$idhrace = $_GET["hrac"];
	require_once ("rchat-vypis.php");
	
	if (!$jezprava) {
		echo '<small style="color:grey;">Něco napiš! :)</small>';
	}
	}
	
	//secret
	
	else if (isset($_GET["klic"]) && isset($_GET["hrac"])) {
	$db = new PDO($dbset, $dbnick, $dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$parametry = array();
	
	$dotaz="";
	$vystup="";
	$dotaz = $db->prepare("SELECT * FROM secretrooms WHERE klic='".$_GET["klic"]."'");
	$dotaz->execute($parametry);
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		$id = $vystup["id"];
		$klic = $vystup["klic"];
		$nazev = $vystup["nazev"];
		$vypravec = $vystup["vypravec"];
		$idvypravece = $vystup["idvypravece"];
		$zalozeno = $vystup["zalozeno"];
		$aktivita = $vystup["aktivita"];
		$cas = $vystup["cas"];
		$hraci = $vystup["hraci"];
		$maxhraci = $vystup["maxhraci"];
	}
	$jezprava=false;
	$dotaz="";
	$vystup="";
	$dotaz = $db->prepare("SELECT * FROM sroomchat".$klic." ORDER BY id ASC");
	$dotaz->execute($parametry);
	$chat = array();
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		$chat[] = array(
          'autor' => $vystup['autor'],
          'cas' => $vystup['timestamp'],
          'text' => $vystup['text'],
        );
		$jezprava=true;
	}
	$idhrace = $_GET["hrac"];
	require_once ("rchat-svypis.php");
	
	if (!$jezprava) {
		echo '<small style="color:grey;">Něco napiš! :)</small>';
	}
	}
	
	else {
		header("Location: index.php");
		exit;
	}
	
	}
?>
