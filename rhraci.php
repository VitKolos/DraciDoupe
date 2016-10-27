<link rel="stylesheet" href="style.css">
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
		$zalozeno = $vystup["zalozeno"];
		$cas = $vystup["cas"];
		$hraci = $vystup["hraci"];
		$maxhraci = $vystup["maxhraci"];
	}
	$nejacihraci=false;
	
	if (!isset($_GET["upravit"])) {
	$dotaz2="";
	$vystup2="";
	$dotaz2 = $db->prepare("SELECT * FROM room".$_GET["id"]);
	$dotaz2->execute($parametry);
	for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
		$barva = "white";
		if ($vystup2["pohlavi"]=="muz") {$barva = "blue";}
		if ($vystup2["pohlavi"]=="zena") {$barva = "red";}
			echo '<div style="color:white; display:inline-block; background-color:'.$barva.'";>'.htmlspecialchars($vystup2["jmeno"]).'</div>';
			echo ' – peníze: '.$vystup2["penize"].', útok: '.$vystup2["cp"].', zdraví: '.$vystup2["hp"];
			echo "<br>";
			$nejacihraci=true;
	}
	
	}
	else if (isset($_GET["upravit"])) {
	$dotaz2="";
	$vystup2="";
	$dotaz2 = $db->prepare("SELECT * FROM room".$_GET["id"]);
	$dotaz2->execute($parametry);
	for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
		$barva = "white";
		if ($vystup2["pohlavi"]=="muz") {$barva = "blue";}
		if ($vystup2["pohlavi"]=="zena") {$barva = "red";}
			echo '<div style="color:white; display:inline-block; background-color:'.$barva.'";>'.htmlspecialchars($vystup2["jmeno"]).'</div>';
			echo ' – peníze: <input type="text" name="penize" size="3" value="'.$vystup2["penize"].'" onchange="editvar(this.name, '.$vystup2["id"].', this.value)"> útok: <input type="text" size="3" name="cp" value="'.$vystup2["cp"].'" onchange="editvar(this.name, '.$vystup2["id"].', this.value)"> zdraví: <input type="text" size="3" name="hp" value="'.$vystup2["hp"].'" onchange="editvar(this.name, '.$vystup2["id"].', this.value)"> <div style="display:inline;" onclick="kick('.$vystup2["id"].')"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#ff0000" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" /></svg></div>';
			echo "<br>";
			$nejacihraci=true;
	}
	echo '<div style="text-align:center;" id="editsubmit"><small id="editsubmittext" style="color:grey;">Pro odeslání stiskni ENTER nebo klikni zde.</small><br><button type="button" onclick="zpetupr()" class="button blue" id="editsubmitbtn" style="display:none;">Ukončit editaci</button></div>';
	}
	
	
	
	if (!$nejacihraci) {
		echo '<div style="color:grey; display:inline-block;">Žádní hráči</div><style>#editsubmit{display:none;}</style>';
	}
	
	}
	
	//secret
	
	else if (isset($_GET["klic"])) {
		
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
	$dotaz = $db->prepare("SELECT * FROM secretrooms WHERE klic='".$_GET["klic"]."'");
	$dotaz->execute($parametry);
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		$id = $vystup["id"];
		$klic = $vystup["klic"];
		$nazev = $vystup["nazev"];
		$vypravec = $vystup["vypravec"];
		$zalozeno = $vystup["zalozeno"];
		$cas = $vystup["cas"];
		$hraci = $vystup["hraci"];
		$maxhraci = $vystup["maxhraci"];
	}
	$nejacihraci=false;
	
	if (!isset($_GET["upravit"])) {
	$dotaz2="";
	$vystup2="";
	$dotaz2 = $db->prepare("SELECT * FROM sroom".$_GET["klic"]);
	$dotaz2->execute($parametry);
	for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
		$barva = "white";
		if ($vystup2["pohlavi"]=="muz") {$barva = "blue";}
		if ($vystup2["pohlavi"]=="zena") {$barva = "red";}
			echo '<div style="color:white; display:inline-block; background-color:'.$barva.'";>'.htmlspecialchars($vystup2["jmeno"]).'</div>';
			echo ' – peníze: '.$vystup2["penize"].', útok: '.$vystup2["cp"].', zdraví: '.$vystup2["hp"];
			echo "<br>";
			$nejacihraci=true;
	}
	
	}
	else if (isset($_GET["upravit"])) {
	$dotaz2="";
	$vystup2="";
	$dotaz2 = $db->prepare("SELECT * FROM sroom".$_GET["klic"]);
	$dotaz2->execute($parametry);
	for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
		$barva = "white";
		if ($vystup2["pohlavi"]=="muz") {$barva = "blue";}
		if ($vystup2["pohlavi"]=="zena") {$barva = "red";}
			echo '<div style="color:white; display:inline-block; background-color:'.$barva.'";>'.htmlspecialchars($vystup2["jmeno"]).'</div>';
			echo ' – peníze: <input type="text" name="penize" size="3" value="'.$vystup2["penize"].'" onchange="editvar(this.name, '.$vystup2["id"].', this.value)"> útok: <input type="text" size="3" name="cp" value="'.$vystup2["cp"].'" onchange="editvar(this.name, '.$vystup2["id"].', this.value)"> zdraví: <input type="text" size="3" name="hp" value="'.$vystup2["hp"].'" onchange="editvar(this.name, '.$vystup2["id"].', this.value)"> <div style="display:inline;" onclick="kick('.$vystup2["id"].')"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#ff0000" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" /></svg></div>';
			echo "<br>";
			$nejacihraci=true;
	}
	echo '<div style="text-align:center;" id="editsubmit"><small id="editsubmittext" style="color:grey;">Pro odeslání stiskni ENTER nebo klikni zde.</small><br><button type="button" onclick="zpetupr()" class="button blue" id="editsubmitbtn" style="display:none;">Ukončit editaci</button></div>';
	}
	
	
	
	if (!$nejacihraci) {
		echo '<div style="color:grey; display:inline-block;">Žádní hráči</div><style>#editsubmit{display:none;}</style>';
	}
	
	}
	
	else {
		header("Location: index.php");
		exit;
	}

?>