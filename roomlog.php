<?php

//kick out + databaze is getting data BEGIN

if (!isset($_GET["id"]) || !isset($_SESSION["prihlaseni"])) {
	header("Location: index.php");
	exit;
}

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

//kick out + databaze is getting data END
?>
<!doctype html>
<html>
    <head> 
		<meta name="robots" content="noindex, nofollow">
		<meta charset="utf-8">
		<?php if (isset($_GET["id"])) {echo "<title>".$nazev."</title>";} ?>
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
		<link rel="stylesheet" href="style.css">
    </head>
    <body style="-webkit-transition-duration: 0.5s; transition-duration: 0.5s;"><small id="zpet"><a href="index.php">Zpět</a></small>
        <div style="text-align:center"><br><div style="height:75vh">
			<?php
				if (isset($_GET["id"])) {
					$allowedztime = $zalozeno + 24 * 60 * 60;
					$allowedatime = $aktivita + 60 * 60;
					if (time() > $allowedztime) {
						zapis("DROP TABLE `room".$id."`");
						zapis("DROP TABLE `roomchat".$id."`");
						zapis("DELETE FROM rooms WHERE id='".$id."'");
						header("Location: index.php");
						exit;
					}
					if (time() > $allowedatime) {
						zapis("DROP TABLE `room".$id."`");
						zapis("DROP TABLE `roomchat".$id."`");
						zapis("DELETE FROM rooms WHERE id='".$id."'");
						header("Location: index.php");
						exit;
					}
						//u nezaregistrovaného hráče
						if (isset($_POST["nick"]) && isset($_POST["pohlavi"])) {
							echo '<style>#zpet{display:none;}</style>';
							$db = new PDO($dbset, $dbnick, $dbpass);
							$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$parametry = array();
							$dotaz = $db->prepare("SELECT * FROM room".$id." ORDER BY id ASC");
							$dotaz->execute($parametry);
							$enemy = false;
							for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
								if($vystup["jmeno"] == $_POST["nick"]){$enemy = true;}
							}
							$dotaz2 = $db->prepare("SELECT * FROM rooms WHERE id=".$id." ORDER BY id ASC");
							$dotaz2->execute($parametry);
							for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
								if($vystup2["vypravec"] == $_POST["nick"]){$enemy = true;}
							}
							if ($enemy) {echo "Chyba: Tento nick je už zvolen někým jiným."; echo '<meta http-equiv="refresh" content="1;url=room.php?id='.$id.'">';}
							else if (isset($_SESSION['forbidden']) && strpos($_SESSION['forbidden'], $id) !== false){echo "Chyba: Do tohoto roomu máš zakázaný přístup."; echo '<meta http-equiv="refresh" content="1;url=room.php?id='.$id.'">';}
							else {
							$_SESSION["nick"] = $_POST["nick"];
							$_SESSION["pohlavi"] = $_POST["pohlavi"];
							$akthraci = $hraci;
							$akthraci++;
							zapis('UPDATE `rooms` SET `hraci`='.$akthraci.' WHERE id = '.$id);
							echo "Odesláno!";
							$_SESSION["hrac"] = $id;
							zapis("INSERT INTO `room".$id."`(`jmeno`, `pohlavi`, `penize`, `cp`, `hp`) VALUES ('".$_POST["nick"]."', '".$_POST["pohlavi"]."', 100, 10, 1000)");
							
							$dotaz3="";
							$vystup3="";
							$dotaz3 = $db->prepare("SELECT * FROM room".$_GET["id"]." WHERE jmeno='".$_POST["nick"]."'");
							$dotaz3->execute($parametry);
							for ($i = 0; $vystup3 = $dotaz3->fetch(); $i++) {
								$_SESSION["idhrace"] = $vystup3["id"];
							}
							
							echo '<meta http-equiv="refresh" content="1;url=room.php?id='.$id.'">';
							}
						}
						else {
							$muz = " ";
							$zena = " ";
							if (isset($_SESSION["pohlavi"])) {if ($_SESSION["pohlavi"] == "muz") {$muz = " checked"; $zena = " ";}
							else if ($_SESSION["pohlavi"] == "zena") {$zena = " checked"; $muz = " ";}}
							echo '<form id="roomlog" action="room.php?id='.$id.'" method="post"><table style="text-align:left; display:inline-block;"><tr><td>Tvůj nick (jaký chceš): </td><td><input type="text" name="nick" value="'.$_SESSION["nick"].'"></td></tr><tr><td>Jsi:</td><td><input type="radio" name="pohlavi" value="muz"'.$muz.'> Muž  <input type="radio" name="pohlavi" value="zena"'.$zena.'> Žena</td></tr></table><br><input type="submit" value="Odeslat"></form>';
						}
				}	
			?>
		</div></div><br><br><br>
    </body>
</html>