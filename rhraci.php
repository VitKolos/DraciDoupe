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
	$dotaz2="";
	$vystup2="";
	$dotaz2 = $db->prepare("SELECT * FROM room".$_GET["id"]);
	$dotaz2->execute($parametry);
	for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
		$barva = "white";
		if ($vystup2["pohlavi"]=="muz") {$barva = "blue";}
		if ($vystup2["pohlavi"]=="zena") {$barva = "red";}
			echo '<div style="color:white; display:inline-block; background-color:'.$barva.'";>'.htmlspecialchars($vystup2["jmeno"]).'</div>';
			echo ' – peníze: <div style="display:inline;" onclick="editpenize'.$vystup2["id"].'()">['.$vystup2["penize"].']</div>, útok: <div style="display:inline;" onclick="editcp'.$vystup2["id"].'()">['.$vystup2["cp"].']</div>, zdraví: <div style="display:inline;" onclick="edithp'.$vystup2["id"].'()">['.$vystup2["hp"].']</div>';
			echo '
			<script>
			function editpenize'.$vystup2["id"].'() {
				var x = prompt("Ahoj","Ano");
			}
			
			function editcp'.$vystup2["id"].'() {
				
			}
			
			function edithp'.$vystup2["id"].'() {
				
			}
			</script>
			';
			echo "<br>";
			$nejacihraci=true;
	}
	
	
	
	if (!$nejacihraci) {
		echo '<div style="color:grey; display:inline-block;">Žádní hráči</div>';
	}
	
	}
	
	else {
		header("Location: index.php");
		exit;
	}

?>