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
						
						
						
						echo '
						<div style="text-align:center;" id="room">
						<div style="display:inline-block; text-align:left; width:95%; height:90%;">
						<table style="width:100%; border-collapse: collapse; text-align:left; height:100%;">
						<tr><td><div id="info"></div></td></tr>
						<tr><td><div id="chat"></div></td></tr>
						<tr><td style="border-bottom: none; vertical-align:center;"><form action="room.php" method="get">Zpráva:<br><textarea name="zprava" rows="1" style="width:99%; height:20px;">';
						if(isset($_GET["zprava"])) {echo $_GET["zprava"];}
						echo '</textarea></td></tr>
						<tr><td style="border-top: none; text-align:center;"><input type="submit" value="Odeslat"></form></td></tr>
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

function chat() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("chat").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "rchat.php?id='.$id.'", true);
  xhttp.send();
}
setInterval(chat, 1000);
</script>
						';
						
						
						
						if (isset($_GET["quit"]) && !isset($_GET["odhlasit"])) {
							zapis("DELETE FROM room".$id." WHERE jmeno='".$_SESSION["nick"]."'");
							unset($_SESSION['hrac']);
							echo "<br>Room byl opuštěn.<style>#room{display:none;}</style>";
							$akthraci = $hraci;
							$akthraci--;
							zapis('UPDATE `rooms` SET `hraci`='.$akthraci.' WHERE id = '.$id);
							echo '<meta http-equiv="refresh" content="1;url=index.php">';
						}
						if (isset($_GET["quit"]) && isset($_GET["odhlasit"])) {
							zapis("DELETE FROM room".$id." WHERE jmeno='".$_SESSION["nick"]."'");
							unset($_SESSION['hrac']);
							echo "<br>Room byl opuštěn.<style>#room{display:none;}</style>";
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