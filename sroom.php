<?php
$trvanlivostRelace = 60*60*24;
ini_set('session.gc_maxlifetime',$trvanlivostRelace);
session_start();

//kick out + databaze is getting data BEGIN
	require_once("databaze.php");
	
	if (!empty($_GET["id"])) {
	$db = new PDO($dbset, $dbnick, $dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$parametry = array();
	
	$dotaz="";
	$vystup="";
	$dotaz = $db->prepare("SELECT * FROM secretrooms WHERE id=".$_GET["id"]);
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
	}
	
	else if (!empty($_GET["klic"])) {
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
	}
	
if (!isset($nazev)) {
	header("Location: index.php");
	exit;
}
if (!isset($_SESSION["prihlaseni"]) && !isset($_GET["klic"])) {
	header("Location: login.php");
	exit;
}
else if (!isset($_SESSION["prihlaseni"]) && isset($_GET["klic"])) {
	header("Location: login.php?klic=".$_GET["klic"]);
	exit;
}
else if (isset($_GET["id"]) && ((isset($_SESSION["hrac"]) && $_SESSION["hrac"] == "s".$id) || (isset($_SESSION["owner"]) && $_SESSION["owner"] == "s".$id))){
	header("Location: sroom.php?klic=".$klic);
	exit;
}
//obsah BEGIN
else if (isset($_SESSION["hrac"]) && $_SESSION["hrac"] == "s".$id) {
	$req = "shrac.php";
	require_once($req);
}
else if (isset($_SESSION["owner"]) && $_SESSION["owner"] == "s".$id) {
	$req = "svypravec.php";
	require_once($req);
}
else if ($_SESSION["prihlaseni"] == $idvypravece) {
	$_SESSION["owner"] = "s".$id;
	header("Location: sroom.php?klic=".$klic);
	exit;
}
else {
	$req = "sroomlog.php";
	require_once($req);
}


$pos = strpos($_SERVER['PHP_SELF'], "sroom.php");
/*echo $pos;*/
//kick out + obsah + databaze is getting data END
?>