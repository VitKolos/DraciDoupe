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
	$nazev = $vystup["nazev"];
	$vypravec = $vystup["vypravec"];
	$idvypravece = $vystup["idvypravece"];
	$zalozeno = $vystup["zalozeno"];
	$aktivita = $vystup["aktivita"];
	$cas = $vystup["cas"];
	$hraci = $vystup["hraci"];
	$maxhraci = $vystup["maxhraci"];
	$allowedztime = $zalozeno + 24 * 60 * 60;
	$allowedatime = $aktivita + 60 * 60;
	if (time() > $allowedztime || time() > $allowedatime) {
		zapis("DROP TABLE `room".$id."`");
		zapis("DROP TABLE `roomchat".$id."`");
		zapis("DELETE FROM rooms WHERE id='".$id."'");
	}
}
?>