<?php

//kick out + databaze is getting data BEGIN

if (!isset($_GET["id"]) || !isset($_SESSION["prihlaseni"]) || !isset($_SESSION["vypravec"]) || $_SESSION["owner"] != $_GET["id"]) {
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
		<?php if (isset($_GET["id"])) {echo "<title>".htmlspecialchars($nazev)."</title>";} ?>
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
					if (isset($_SESSION["owner"]) && $_SESSION["owner"] == $id) {
						//u ownera
						if(!isset($_GET["delete"])) {
						echo '
						<div style="text-align:center;" id="room">
						<div style="display:inline-block; text-align:left; width:95%; height:90%;">
						<table style="width:100%; border-collapse: collapse; text-align:left; height:100%; background-color:white; color:black;">
						<tr><td><div id="info"><div style="text-align:center;"><svg width="40px" height="40px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-default"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(0 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(30 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.08333333333333333s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(60 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.16666666666666666s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(90 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.25s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(120 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.3333333333333333s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(150 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.4166666666666667s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(180 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.5s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(210 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.5833333333333334s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(240 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.6666666666666666s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(270 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.75s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(300 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.8333333333333334s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(330 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.9166666666666666s" repeatCount="indefinite"/></rect></svg></div></div></td></tr>
						<tr><td><div id="hraci"><div style="text-align:center;"><svg width="40px" height="40px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-default"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(0 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(30 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.08333333333333333s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(60 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.16666666666666666s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(90 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.25s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(120 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.3333333333333333s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(150 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.4166666666666667s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(180 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.5s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(210 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.5833333333333334s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(240 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.6666666666666666s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(270 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.75s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(300 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.8333333333333334s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(330 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.9166666666666666s" repeatCount="indefinite"/></rect></svg></div></div></td></tr>
						<tr><td><div id="chat" style="max-height:1000px"><div style="text-align:center;"><svg width="40px" height="40px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-default"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(0 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(30 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.08333333333333333s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(60 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.16666666666666666s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(90 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.25s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(120 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.3333333333333333s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(150 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.4166666666666667s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(180 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.5s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(210 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.5833333333333334s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(240 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.6666666666666666s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(270 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.75s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(300 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.8333333333333334s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(330 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.9166666666666666s" repeatCount="indefinite"/></rect></svg></div></div></td></tr>
						<tr><td style="border-bottom: none; vertical-align:center;"><form action="room.php" method="get">Zpráva:<br><textarea name="zprava" rows="1" style="width:99%; height:20px;">';
						/*if(isset($_GET["zprava"])) {echo $_GET["zprava"];}*/
						echo '</textarea></td></tr>
						<tr><td style="border-top: none; text-align:center;">Čas: <input type="text" name="cas" value="';
						if(isset($_GET["cas"])) {echo $_GET["cas"];} else {echo "10";}
						echo '" size="2" maxlength="2">  <input type="hidden" name="id" value="'.$id.'"> <input type="submit" value="Odeslat"></form></td></tr>
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
  xhttp.open("GET", "rinfo.php?id='.$id.'&owner", true);
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

function barva() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		var cas = this.responseText;
		cas = Number(cas);
		switch (cas) {
			
		case 0:
		document.body.style.backgroundColor = "#000000";
		document.body.style.color = "#ffffff";
		break;
		
		case 1:
		document.body.style.backgroundColor = "#000000";
		document.body.style.color = "#ffffff";
		break;
		
		case 2:
		document.body.style.backgroundColor = "#000000";
		document.body.style.color = "#ffffff";
		break;
		
		case 3:
		document.body.style.backgroundColor = "#000000";
		document.body.style.color = "#ffffff";
		break;
		
		case 4:
		document.body.style.backgroundColor = "#555555";
		document.body.style.color = "#ffffff";
		break;
		
		case 5:
		document.body.style.backgroundColor = "#555555";
		document.body.style.color = "#ffffff";
		break;
		
		case 6:
		document.body.style.backgroundColor = "#AAAAAA";
		document.body.style.color = "#000000";
		break;
		
		case 7:
		document.body.style.backgroundColor = "#AAAAAA";
		document.body.style.color = "#000000";
		break;
		
		case 8:
		document.body.style.backgroundColor = "#ffffff";
		document.body.style.color = "#000000";
		break;
		
		case 9:
		document.body.style.backgroundColor = "#ffffff";
		document.body.style.color = "#000000";
		break;
		
		case 10:
		document.body.style.backgroundColor = "#ffffff";
		document.body.style.color = "#000000";
		break;
		
		case 11:
		document.body.style.backgroundColor = "#ffffff";
		document.body.style.color = "#000000";
		break;
		
		case 12:
		document.body.style.backgroundColor = "#ffffff";
		document.body.style.color = "#000000";
		break;
		
		case 13:
		document.body.style.backgroundColor = "#ffffff";
		document.body.style.color = "#000000";
		break;
		
		case 14:
		document.body.style.backgroundColor = "#ffffff";
		document.body.style.color = "#000000";
		break;
		
		case 15:
		document.body.style.backgroundColor = "#ffffff";
		document.body.style.color = "#000000";
		break;
		
		case 16:
		document.body.style.backgroundColor = "#AAAAAA";
		document.body.style.color = "#000000";
		break;
		
		case 17:
		document.body.style.backgroundColor = "#AAAAAA";
		document.body.style.color = "#000000";
		break;
		
		case 18:
		document.body.style.backgroundColor = "#555555";
		document.body.style.color = "#ffffff";
		break;
		
		case 19:
		document.body.style.backgroundColor = "#555555";
		document.body.style.color = "#ffffff";
		break;
		
		case 20:
		document.body.style.backgroundColor = "#000000";
		document.body.style.color = "#ffffff";
		break;
		
		case 21:
		document.body.style.backgroundColor = "#000000";
		document.body.style.color = "#ffffff";
		break;
		
		case 22:
		document.body.style.backgroundColor = "#000000";
		document.body.style.color = "#ffffff";
		break;
		
		case 23:
		document.body.style.backgroundColor = "#000000";
		document.body.style.color = "#ffffff";
		break;
		
		case 24:
		document.body.style.backgroundColor = "#000000";
		document.body.style.color = "#ffffff";
		break;
		

		}
    }
  };
  xhttp.open("GET", "rget.php?id='.$id.'&time", true);
  xhttp.send();
}
setInterval(barva, 1000);


</script>
						';
						
						
						if (isset($_GET["zprava"]) && isset($_GET["cas"])) {
							if (is_numeric($_GET["cas"]) && $_GET["cas"] != "" && $_GET["cas"] < 25) {
								zapis("UPDATE `rooms` SET `cas` = '".$_GET["cas"]."' WHERE `id` = ".$id);
								
								if ($_GET["zprava"] != "") {
									
								}
							}
							
							else {
								echo "Zadejte platný čas!";
							}
						}
						
						
						
						
						}
						if (isset($_GET["delete"]) && !isset($_GET["odhlasit"])) {
							zapis("DROP TABLE `room".$id."`");
							zapis("DROP TABLE `roomchat".$id."`");
							zapis("DELETE FROM rooms WHERE id='".$id."'");
							unset($_SESSION['owner']);
							echo "<br>Room byl zrušen.<style>#room{display:none;}</style>";
							echo '<meta http-equiv="refresh" content="1;url=index.php">';
						}
						if (isset($_GET["delete"]) && isset($_GET["odhlasit"])) {
							zapis("DROP TABLE `room".$id."`");
							zapis("DROP TABLE `roomchat".$id."`");
							zapis("DELETE FROM rooms WHERE id='".$id."'");
							unset($_SESSION['owner']);
							echo "<br>Room byl zrušen.<style>#room{display:none;}</style>";
							echo '<meta http-equiv="refresh" content="1;url=login.php?odhlasit">';
						}
					}
				}
			?>
		</div></div><br><br><br>
    </body>
</html>