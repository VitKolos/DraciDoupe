<?php

//kick out + databaze is getting data BEGIN

if (!isset($_GET["id"]) || !isset($_SESSION["prihlaseni"]) || !isset($_SESSION["hrac"])) {
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
    <body style="-webkit-transition-duration: 0.5s; transition-duration: 0.5s;">
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
					
					if (isset($_SESSION["hrac"]) && $_SESSION["hrac"] == $id) {
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
				}
				
			?>
		</div></div><br><br><br>
    </body>
</html>