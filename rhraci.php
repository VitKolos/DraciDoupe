<?php
	if (isset($_GET["id"])) {
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
		$zalozeno = $vystup["zalozeno"];
		$cas = $vystup["cas"];
		$hraci = $vystup["hraci"];
		$maxhraci = $vystup["maxhraci"];
	}
	$nejacihraci=false;
	$dotaz2="";
	$vystup2="";
	$dotaz2 = $db->prepare("SELECT * FROM room".$_GET["id"]);
	$dotaz2->execute($parametry);
	for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
		$barva = "white";
		if ($vystup2["pohlavi"]=="muz") {$barva = "blue";}
		if ($vystup2["pohlavi"]=="zena") {$barva = "red";}
			echo '<div style="color:white; display:inline-block; background-color:'.$barva.'";>'.$vystup2["jmeno"].'</div>';
			echo "<br>";
			$nejacihraci=true;
	}
	if (!$nejacihraci) {
		echo '<div style="color:grey; display:inline-block;">Žádní hráči</div>';
	}
	
	}
?>