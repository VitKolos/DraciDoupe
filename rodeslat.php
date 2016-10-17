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
?>