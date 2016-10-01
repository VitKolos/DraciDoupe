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
?>