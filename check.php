<?php
require_once("databaze.php");
$db = new PDO($dbset, $dbnick, $dbpass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$parametry = array();
	
$dotaz="";
$vystup="";
$dotaz = $db->prepare("SELECT * FROM rooms");
$dotaz->execute($parametry);
for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
	$id = $vystup["id"];
	$zalozeno = $vystup["zalozeno"];
	$aktivita = $vystup["aktivita"];
	$allowedztime = $zalozeno + 24 * 60 * 60;
	$allowedatime = $aktivita + 60 * 60;
	if (time() > $allowedztime || time() > $allowedatime) {
		zapis("DROP TABLE `room".$id."`");
		zapis("DROP TABLE `roomchat".$id."`");
		zapis("DROP TABLE `roomsouboje".$id."`");
		zapis("DELETE FROM rooms WHERE id='".$id."'");
	}
}

$dotaz2="";
$vystup2="";
$dotaz2 = $db->prepare("SELECT * FROM rooms");
$dotaz2->execute($parametry);
for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
	$klic2 = $vystup2["klic"];
	$zalozeno2 = $vystup2["zalozeno"];
	$aktivita2 = $vystup2["aktivita"];
	$allowedztime2 = $zalozeno2 + 24 * 60 * 60;
	$allowedatime2 = $aktivita2 + 60 * 60;
	if (time() > $allowedztime2 || time() > $allowedatime2) {
		zapis("DROP TABLE `sroom".$klic2."`");
		zapis("DROP TABLE `sroomchat".$klic2."`");
		zapis("DROP TABLE `sroomsouboje".$klic2."`");
		zapis("DELETE FROM secretrooms WHERE klic='".$klic2."'");
	}
}
?>