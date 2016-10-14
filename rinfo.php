<?php
error_reporting(0);
	if (isset($_GET["id"])) {
	
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
	
	if(isset($_GET["owner"])) {
	echo '<div style="float:left; display:inline;">'.htmlspecialchars($nazev).' – '.$hraci.'/'.$maxhraci.'</div><div style="float:right; color:white; display:inline; "><a href="room.php?id='.$id.'&delete"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#000000" d="M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19M8.46,11.88L9.87,10.47L12,12.59L14.12,10.47L15.53,11.88L13.41,14L15.53,16.12L14.12,17.53L12,15.41L9.88,17.53L8.47,16.12L10.59,14L8.46,11.88M15.5,4L14.5,3H9.5L8.5,4H5V6H19V4H15.5Z" /></svg></a><small>-</small>
<a href="room.php?id='.$id.'&delete&odhlasit"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#000000" d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13" /></svg></a><small>-</small>
</div>';
	}
	else {
		echo '<div style="float:left; display:inline;">'.htmlspecialchars($nazev).' – '.$hraci.'/'.$maxhraci.'</div><div style="float:right; color:white; display:inline; "><a href="room.php?id='.$id.'&quit"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#000000" d="M17,17.25V14H10V10H17V6.75L22.25,12L17,17.25M13,2A2,2 0 0,1 15,4V8H13V4H4V20H13V16H15V20A2,2 0 0,1 13,22H4A2,2 0 0,1 2,20V4A2,2 0 0,1 4,2H13Z" /></svg></a><small>-</small>
<a href="room.php?id='.$id.'&quit&odhlasit"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#000000" d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13" /></svg></a><small>-</small>
</div>';
	}
	
	}
	
	else {
		header("Location: index.php");
		exit;
	}
?>
