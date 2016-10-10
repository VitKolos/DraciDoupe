<?php
$trvanlivostRelace = 60*60*24;
ini_set('session.gc_maxlifetime',$trvanlivostRelace);
session_start();

//kick out

if (!isset($_GET["id"]) || !isset($_SESSION["prihlaseni"])) {
	header("Location: index.php");
	exit;
}

//kick out end

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
		<?php if (isset($_GET["id"])) {echo "<title>".$nazev."</title>";} ?>
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
		<link rel="stylesheet" href="style.css">
    </head>
    <body style="-webkit-transition-duration: 0.5s; transition-duration: 0.5s;">
        <div style="text-align:center"><br><div style="height:75vh">
			<?php


				if (isset($_GET["id"])) {
					$allowedtime = $zalozeno + 24 * 60 * 60;
					if (time() > $allowedtime) {
						zapis("DROP TABLE `room".$id."`");
						zapis("DROP TABLE `roomchat".$id."`");
						zapis("DELETE FROM rooms WHERE id='".$id."'");
						header("Location: index.php");
						exit;
					}
					if (isset($_SESSION["owner"]) && $_SESSION["owner"] == $id) {
						//u ownera
						echo '
						<div style="text-align:center;" id="owner">
						<div style="display:inline-block; text-align:left; width:95%; height:90%;">
						<table style="width:100%; border-collapse: collapse; text-align:left; height:100%;">
						<tr><td><div id="info"></div></td></tr>
						<tr><td><div id="hraci"></div></td></tr>
						<tr><td><div id="chat"></div></td></tr>
						<tr><td style="border-bottom: none; vertical-align:center;"><form action="room.php" method="get">Zpráva:<br><textarea name="zprava" rows="1" style="width:99%; height:20px;">';
						if(isset($_GET["zprava"])) {echo $_GET["zprava"];}
						echo '</textarea></td></tr>
						<tr><td style="border-top: none; text-align:center;">Čas: <input type="text" name="cas" value="';
						if(isset($_GET["cas"])) {echo $_GET["cas"];} else {echo "10";}
						echo '" size="2" maxlength="2">   <input type="submit" value="Odeslat"></form></td></tr>
						</table>
						</div>
						</div>
<script>
function info() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("info").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "rinfo.php?id='.$id.'", true);
  xhttp.send();
}
setInterval(info, 1000);

function hraci() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("hraci").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "rhraci.php?id='.$id.'", true);
  xhttp.send();
}
setInterval(hraci, 1000);

/*function info() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("hraci").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "rhraci.php?id='.$id.'", true);
  xhttp.send();
}
setInterval(info, 1000);*/
</script>
						';
						
						
						
						
						
						
						

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