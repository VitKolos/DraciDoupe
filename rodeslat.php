<?php
require_once("settings.php");

function zapis ($sql) {
	global $dbset;
	global $dbnick;
	global $dbpass;
	$db="";
	$dotaz="";
	$parametry="";
	$db = new PDO($dbset, $dbnick, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->query($sql);
}
error_reporting(0);
$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
zapis("SET NAMES utf8");
if ($pos !== false && isset($_POST["id"])) {
	if(isset($_POST["cas"]) && isset($_POST["autor"]) && $_POST["autor"]==0 && !isset($_POST["zprava"])) {
		zapis("UPDATE `rooms` SET `aktivita` = '".time()."' WHERE `id` = ".$_POST["id"]);
		zapis("UPDATE `rooms` SET `cas` = '".$_POST["cas"]."' WHERE `id` = ".$_POST["id"]);
	}
	else if (isset($_POST["cas"]) && isset($_POST["autor"]) && $_POST["autor"]==0 && isset($_POST["zprava"])) {
		zapis("UPDATE `rooms` SET `aktivita` = '".time()."' WHERE `id` = ".$_POST["id"]);
		zapis("UPDATE `rooms` SET `cas` = '".$_POST["cas"]."' WHERE `id` = ".$_POST["id"]);
		zapis("INSERT INTO `roomchat".$_POST["id"]."`(`autor`, `text`) VALUES ('".$_POST["autor"]."', '".$_POST["zprava"]."')");
	}
	else if (!isset($_POST["cas"]) && isset($_POST["autor"]) && $_POST["autor"]!=0 && isset($_POST["zprava"])) {
		zapis("UPDATE `rooms` SET `aktivita` = '".time()."' WHERE `id` = ".$_POST["id"]);
		zapis("INSERT INTO `roomchat".$_POST["id"]."`(`autor`, `text`) VALUES ('".$_POST["autor"]."', '".$_POST["zprava"]."')");
	}
}
if ($pos !== false && isset($_GET["id"])) {
	if (isset($_GET["edit"]) && isset($_GET["hrac"]) && isset($_GET["typ"]) && isset($_GET["hodnota"])) {
		zapis("UPDATE `room".$_GET["id"]."` SET `".$_GET["typ"]."` = '".$_GET["hodnota"]."' WHERE `id` = ".$_GET["hrac"]);
		
		$db = new PDO($dbset, $dbnick, $dbpass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$parametry = array();
		$dotaz="";
		$vystup="";
		$dotaz = $db->prepare("SELECT * FROM room".$_GET["id"]." WHERE id=".$_GET["hrac"]);
		$dotaz->execute($parametry);
		for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
			$jmenohrace = $vystup["jmeno"];
		}
		
		zapis("INSERT INTO `roomchat".$_GET["id"]."`(`autor`, `text`) VALUES ('0', ' ### [".$jmenohrace.": ".$_GET["typ"]." = ".$_GET["hodnota"]."]')");
	}
}
if ($pos !== false && isset($_GET["id"])) {
	if (isset($_GET["kick"]) && isset($_GET["hrac"])) {
		zapis("DELETE FROM `room".$_GET["id"]."` WHERE `id` = ".$_GET["hrac"]);
	}
}
if ($pos !== false && isset($_GET["id"])) {
	if (isset($_GET["novy"]) && isset($_GET["jmeno"])) {
		zapis("INSERT INTO `room".$_GET["id"]."`(`jmeno`, `pohlavi`, `skutecny`, `penize`, `cp`, `hp`) VALUES ('".$_GET["jmeno"]."', '', 0, 100, 10, 1000)");
	}
}
if ($pos !== false && isset($_GET["id"])) {
	if (isset($_GET["bojovat"]) && isset($_GET["hrac1"]) && isset($_GET["hrac2"])) {
		zapis("INSERT INTO `roomsouboje".$_GET["id"]."`(`hrac1`, `hrac2`) VALUES ('".$_GET["hrac1"]."', '".$_GET["hrac2"]."')");
	}
}

//secret

if ($pos !== false && isset($_POST["klic"])) {
	if(isset($_POST["cas"]) && isset($_POST["autor"]) && $_POST["autor"]==0 && !isset($_POST["zprava"])) {
		zapis("UPDATE `secretrooms` SET `aktivita` = '".time()."' WHERE `klic` = '".$_POST["klic"]."'");
		zapis("UPDATE `secretrooms` SET `cas` = '".$_POST["cas"]."' WHERE `klic` = '".$_POST["klic"]."'");
	}
	else if (isset($_POST["cas"]) && isset($_POST["autor"]) && $_POST["autor"]==0 && isset($_POST["zprava"])) {
		zapis("UPDATE `secretrooms` SET `aktivita` = '".time()."' WHERE `klic` = '".$_POST["klic"]."'");
		zapis("UPDATE `secretrooms` SET `cas` = '".$_POST["cas"]."' WHERE `klic` = '".$_POST["klic"]."'");
		zapis("INSERT INTO `sroomchat".$_POST["klic"]."`(`autor`, `text`) VALUES ('".$_POST["autor"]."', '".$_POST["zprava"]."')");
	}
	else if (!isset($_POST["cas"]) && isset($_POST["autor"]) && $_POST["autor"]!=0 && isset($_POST["zprava"])) {
		zapis("UPDATE `secretrooms` SET `aktivita` = '".time()."' WHERE `klic` = '".$_POST["klic"]."'");
		zapis("INSERT INTO `sroomchat".$_POST["klic"]."`(`autor`, `text`) VALUES ('".$_POST["autor"]."', '".$_POST["zprava"]."')");
	}
}
if ($pos !== false && isset($_GET["klic"])) {
	if (isset($_GET["edit"]) && isset($_GET["hrac"]) && isset($_GET["typ"]) && isset($_GET["hodnota"])) {
		zapis("UPDATE `sroom".$_GET["klic"]."` SET `".$_GET["typ"]."` = '".$_GET["hodnota"]."' WHERE `id` = ".$_GET["hrac"]);
		
		$db = new PDO($dbset, $dbnick, $dbpass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$parametry = array();
		$dotaz="";
		$vystup="";
		$dotaz = $db->prepare("SELECT * FROM sroom".$_GET["klic"]." WHERE id=".$_GET["hrac"]);
		$dotaz->execute($parametry);
		for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
			$jmenohrace = $vystup["jmeno"];
		}
		
		zapis("INSERT INTO `sroomchat".$_GET["klic"]."`(`autor`, `text`) VALUES ('0', ' ### [".$jmenohrace.": ".$_GET["typ"]." = ".$_GET["hodnota"]."]')");
	}
}
if ($pos !== false && isset($_GET["klic"])) {
	if (isset($_GET["kick"]) && isset($_GET["hrac"])) {
		zapis("DELETE FROM `sroom".$_GET["klic"]."` WHERE `id` = ".$_GET["hrac"]);
	}
}

?>