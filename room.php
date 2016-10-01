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
	}
?>
<!doctype html>
<html>
    <head> 
		<meta name="robots" content="noindex, nofollow">
		<meta charset="utf-8">
		<?php if (isset($_GET["id"])) {echo "<title>".$nazev."</title>";} else{echo '<meta http-equiv="refresh" content="0;url=new.php">';} ?>
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
    </head>
    <body style="-webkit-transition-duration: 0.5s; transition-duration: 0.5s;">
        <div style="text-align:center"><br><div style="height:75vh">
			<?php
			$trvanlivostRelace = 60*60*24;
			ini_set('session.gc_maxlifetime',$trvanlivostRelace);
			session_start();
				if (!isset($_SESSION["prihlaseni"])){echo '<meta http-equiv="refresh" content="0;url=login.php">';}
				if (isset($_GET["id"])) {
					if ($zalozeno < time()) {
						zapis("DROP TABLE `room".$id."`");
						zapis("DROP TABLE `roomchat".$id."`");
						zapis("DELETE FROM rooms WHERE id='".$id."'");
						echo '<meta http-equiv="refresh" content="0;url=index.php">';
					}
					if (isset($_SESSION["owner"]) && $_SESSION["owner"] == $id) {
						//u ownera
						echo '<a href="room.php?id='.$id.'&delete">Zrušit room</a><br>';
						echo '<a href="room.php?id='.$id.'&delete&odhlasit">Zrušit room a odhlásit se</a>';
						if (isset($_GET["delete"]) && !isset($_GET["odhlasit"])) {
							zapis("DROP TABLE `room".$id."`");
							zapis("DROP TABLE `roomchat".$id."`");
							zapis("DELETE FROM rooms WHERE id='".$id."'");
							unset($_SESSION['owner']);
							echo "<br>Room byl zrušen.";
							echo '<meta http-equiv="refresh" content="1;url=index.php">';
						}
						if (isset($_GET["delete"]) && isset($_GET["odhlasit"])) {
							zapis("DROP TABLE `room".$id."`");
							zapis("DROP TABLE `roomchat".$id."`");
							zapis("DELETE FROM rooms WHERE id='".$id."'");
							unset($_SESSION['owner']);
							echo "<br>Room byl zrušen.";
							echo '<meta http-equiv="refresh" content="1;url=login.php?odhlasit">';
						}
					}
					else if (isset($_SESSION["hrac"]) && $_SESSION["hrac"] == $id) {
						//u zaregistrovaného hráče
						echo '<a href="room.php?id='.$id.'&quit">Opustit room</a><br>';
						echo '<a href="room.php?id='.$id.'&quit&odhlasit">Opustit room a odhlásit se</a>';
						if (isset($_GET["quit"]) && !isset($_GET["odhlasit"])) {
							zapis("DELETE FROM room".$id." WHERE jmeno='".$_SESSION["nick"]."'");
							unset($_SESSION['hrac']);
							echo "<br>Room byl opuštěn.";
							$akthraci = $hraci;
							$akthraci--;
							zapis('UPDATE `rooms` SET `hraci`='.$akthraci.' WHERE id = '.$id);
							echo '<meta http-equiv="refresh" content="1;url=index.php">';
						}
						if (isset($_GET["quit"]) && isset($_GET["odhlasit"])) {
							zapis("DELETE FROM room".$id." WHERE jmeno='".$_SESSION["nick"]."'");
							unset($_SESSION['hrac']);
							echo "<br>Room byl opuštěn.";
							$akthraci = $hraci;
							$akthraci--;
							zapis('UPDATE `rooms` SET `hraci`='.$akthraci.' WHERE id = '.$id);
							echo '<meta http-equiv="refresh" content="1;url=login.php?odhlasit">';
						}
					}
					else {
						//u nezaregistrovaného hráče
						if (isset($_POST["nick"]) && isset($_POST["pohlavi"])) {
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
							else {
							$_SESSION["nick"] = $_POST["nick"];
							$_SESSION["pohlavi"] = $_POST["pohlavi"];
							$akthraci = $hraci;
							$akthraci++;
							zapis('UPDATE `rooms` SET `hraci`='.$akthraci.' WHERE id = '.$id);
							echo "Odesláno!";
							$_SESSION["hrac"] = $id;
							zapis("INSERT INTO `room".$id."`(`jmeno`, `pohlavi`, `penize`, `cp`, `hp`) VALUES ('".$_POST["nick"]."', '".$_POST["pohlavi"]."', 100, 10, 1000)");
							echo '<meta http-equiv="refresh" content="1;url=room.php?id='.$id.'">';
							}
						}
						else {
							$muz = " ";
							$zena = " ";
							if (isset($_SESSION["pohlavi"])) {if ($_SESSION["pohlavi"] == "muz") {$muz = " checked"; $zena = " ";}
							else if ($_SESSION["pohlavi"] == "zena") {$zena = " checked"; $muz = " ";}}
							echo '<form action="room.php?id='.$id.'" method="post"><table style="text-align:left; display:inline-block;"><tr><td>Tvůj nick (jaký chceš): </td><td><input type="text" name="nick" value="'.$_SESSION["nick"].'"></td></tr><tr><td>Jsi:</td><td><input type="radio" name="pohlavi" value="muz"'.$muz.'> Muž  <input type="radio" name="pohlavi" value="zena"'.$zena.'> Žena</td></tr></table><br><input type="submit" value="Odeslat"></form>';
						}
					}
				}
				
			?>
		</div></div><br><br><br>
    </body>
</html>