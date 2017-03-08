<?php
error_reporting(0);
	if (isset($_GET["id"]) && isset($_GET["hrac"])) {
		
	/*$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
	if($pos===false) {
	header("Location: index.php");
	exit;}*/
	
	require_once("databaze.php");
	$db = new PDO($dbset, $dbnick, $dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$parametry = array();
	
	$dotaz="";
	$vystup="";
	$dotaz = $db->prepare("SELECT * FROM roomsouboje".$_GET["id"]." WHERE hotovo=0");
	$dotaz->execute($parametry);
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		if ($vystup["hrac1"] == $_GET["hrac"] || $vystup["hrac2"] == $_GET["hrac"]) {
			$dotaz2="";
			$vystup2="";
			$dotaz2 = $db->prepare("SELECT * FROM room".$_GET["id"]." WHERE id=".$vystup["hrac1"]);
			$dotaz2->execute($parametry);
			for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
				$cp1 = $vystup2["cp"];
				$hp1 = $vystup2["hp"];
			}
			$dotaz3="";
			$vystup3="";
			$dotaz3 = $db->prepare("SELECT * FROM room".$_GET["id"]." WHERE id=".$vystup["hrac2"]);
			$dotaz3->execute($parametry);
			for ($i = 0; $vystup3 = $dotaz3->fetch(); $i++) {
				$cp2 = $vystup3["cp"];
				$hp2 = $vystup3["hp"];
			}
			echo $vystup["id"]."&".$cp1."&".$hp1."&".$cp2."&".$hp2;
			echo " ";
			$cp1 = "";
			$hp1 = "";
			$cp2 = "";
			$hp2 = "";
		}
	}
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
	$dotaz = $db->prepare("SELECT * FROM roomsouboje".$_GET["klic"]." WHERE hotovo=0");
	$dotaz->execute($parametry);
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		if ($vystup["hrac1"] == $_GET["hrac"] || $vystup["hrac2"] == $_GET["hrac"]) {
			$dotaz2="";
			$vystup2="";
			$dotaz2 = $db->prepare("SELECT * FROM room".$_GET["klic"]." WHERE id=".$vystup["hrac1"]);
			$dotaz2->execute($parametry);
			for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
				$cp1 = $vystup2["cp"];
				$hp1 = $vystup2["hp"];
			}
			$dotaz3="";
			$vystup3="";
			$dotaz3 = $db->prepare("SELECT * FROM room".$_GET["klic"]." WHERE id=".$vystup["hrac2"]);
			$dotaz3->execute($parametry);
			for ($i = 0; $vystup3 = $dotaz3->fetch(); $i++) {
				$cp2 = $vystup3["cp"];
				$hp2 = $vystup3["hp"];
			}
			echo $vystup["id"]."&".$cp1."&".$hp1."&".$cp2."&".$hp2;
			echo " ";
			$cp1 = "";
			$hp1 = "";
			$cp2 = "";
			$hp2 = "";
		}
	}
	}
	
	else {
		header("Location: index.php");
		exit;
	}

?>