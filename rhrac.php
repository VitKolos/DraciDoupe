<?php
error_reporting(0);
	if (isset($_GET["id"]) && isset($_GET["hrac"])) {
	
	$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
	if($pos===false) {
	header("Location: index.php");
	exit;}

	require_once("databaze.php");
	$db = new PDO($dbset, $dbnick, $dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$parametry = array();
	
	$dotaz="";
	$vystup="";
	$dotaz = $db->prepare("SELECT * FROM room".$_GET["id"]." WHERE id=".$_GET["hrac"]);
	$dotaz->execute($parametry);
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		$jmeno = $vystup["jmeno"];
		$penize = $vystup["penize"];
		$cp = $vystup["cp"];
		$hp = $vystup["hp"];
	}
	
	echo $jmeno." – peníze: ".$penize.", útok: ".$cp.", zdraví: ".$hp;
	
	}
	
	//secret
	
	else if (isset($_GET["klic"]) && isset($_GET["hrac"])) {
	
	$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
	if($pos===false) {
	header("Location: index.php");
	exit;}

	require_once("databaze.php");
	$db = new PDO($dbset, $dbnick, $dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$parametry = array();
	
	$dotaz="";
	$vystup="";
	$dotaz = $db->prepare("SELECT * FROM sroom".$_GET["klic"]." WHERE id=".$_GET["hrac"]);
	$dotaz->execute($parametry);
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		$jmeno = $vystup["jmeno"];
		$penize = $vystup["penize"];
		$cp = $vystup["cp"];
		$hp = $vystup["hp"];
	}
	
	echo $jmeno." – peníze: ".$penize.", útok: ".$cp.", zdraví: ".$hp;
	
	}
	
	else {
		header("Location: index.php");
		exit;
	}
?>
