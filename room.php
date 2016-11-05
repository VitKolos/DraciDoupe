<?php
$trvanlivostRelace = 60*60*24;
ini_set('session.gc_maxlifetime',$trvanlivostRelace);
session_start();

//kick out + databaze is getting data BEGIN

	if (!empty($_GET["id"])) {
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
	}
	
if (!isset($nazev)) {
	header("Location: index.php");
	exit;
}

if (!isset($_GET["id"]) || !isset($_SESSION["prihlaseni"])) {
	header("Location: login.php");
	exit;
}
else if (isset($_SESSION["hrac"]) && $_SESSION["hrac"] == $_GET["id"]) {
	$req = "hrac.php";
	require_once($req);
}
else if (isset($_SESSION["owner"]) && $_SESSION["owner"] == $_GET["id"]) {
	$req = "vypravec.php";
	require_once($req);
}
else if ($_SESSION["prihlaseni"] == $idvypravece) {
	$_SESSION["owner"] = $_GET["id"];
	header("Location: room.php?id=".$_GET["id"]);
	exit;
}
else {
	$req = "roomlog.php";
	require_once($req);
}

//kick out + obsah + databaze is getting data END
?>