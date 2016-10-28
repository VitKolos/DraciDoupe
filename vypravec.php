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
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<?php if (isset($_GET["id"])) {echo "<title>".htmlspecialchars($nazev)."</title>";} ?>
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
		<link rel="stylesheet" href="style.css">
			<script>
	function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
	</script>
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
						<tr><td><div id="hraci" onclick="upravit()"><div style="text-align:center;"><svg width="40px" height="40px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-default"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(0 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(30 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.08333333333333333s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(60 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.16666666666666666s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(90 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.25s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(120 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.3333333333333333s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(150 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.4166666666666667s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(180 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.5s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(210 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.5833333333333334s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(240 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.6666666666666666s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(270 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.75s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(300 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.8333333333333334s" repeatCount="indefinite"/></rect><rect  x="46.5" y="40" width="7" height="20" rx="5" ry="5" fill="#00b2ff" transform="rotate(330 50 50) translate(0 -30)">  <animate attributeName="opacity" from="1" to="0" dur="1s" begin="0.9166666666666666s" repeatCount="indefinite"/></rect></svg></div></div></td></tr>
						<tr><td style="border-bottom: none;"><div id="chat" style="max-height:40vh; overflow:scroll; overflow-x: hidden;"><div style="text-align:center;"></div></div></td></tr>
						<tr><td style="border-top: none; text-align:center;"><div id="rolovat" onclick="roluj()"><svg style="width:24px;height:24px" viewBox="0 0 24 24">     <path fill="#000000" d="M11,4H13V16L18.5,10.5L19.92,11.92L12,19.84L4.08,11.92L5.5,10.5L11,16V4Z" /> </svg><svg style="width:24px;height:24px" viewBox="0 0 24 24">     <path fill="#000000" d="M11,4H13V16L18.5,10.5L19.92,11.92L12,19.84L4.08,11.92L5.5,10.5L11,16V4Z" /> </svg><svg style="width:24px;height:24px" viewBox="0 0 24 24">     <path fill="#000000" d="M11,4H13V16L18.5,10.5L19.92,11.92L12,19.84L4.08,11.92L5.5,10.5L11,16V4Z" /> </svg><svg style="width:24px;height:24px" viewBox="0 0 24 24">     <path fill="#000000" d="M11,4H13V16L18.5,10.5L19.92,11.92L12,19.84L4.08,11.92L5.5,10.5L11,16V4Z" /> </svg><svg style="width:24px;height:24px" viewBox="0 0 24 24">     <path fill="#000000" d="M11,4H13V16L18.5,10.5L19.92,11.92L12,19.84L4.08,11.92L5.5,10.5L11,16V4Z" /> </svg></div></td></tr>
						<tr><td style="border-bottom: none; vertical-align:center;">Zpráva:<br><input id="text" onKeyDown="if(event.keyCode==13) submit();" name="zprava" style="width:99%; height:20px;" autofocus>';
						/*if(isset($_GET["zprava"])) {echo $_GET["zprava"];}*/
						echo '</td></tr>
						<tr><td style="border-top: none; text-align:center;">Čas: <input type="text" id="cas" onKeyDown="if(event.keyCode==13) {submit();} if(event.keyCode==32 || event.keyCode==16 || event.keyCode==17) {zamerit();}" name="cas" value="10';
						/*if(isset($_GET["cas"])) {echo $_GET["cas"];} else {echo "10";}*/
						echo '" size="2" maxlength="2">  <!--<input type="hidden" name="id" value="'.$id.'">--> <button type="button" onclick="submit()" style="font-size:1.5rem" id="submit">Odeslat</button><br><div id="roll"></div><div id="odstavec"></div><div style="background-color:#93ff68; border-radius: 15px;"><div id="tick" style="display:none;"><svg style="width:30px;height:30px" viewBox="0 0 24 24">     <path fill="#000000" d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9M10,16V19.08L13.08,16H20V4H4V16H10M16.5,8L11,13.5L7.5,10L8.91,8.59L11,10.67L15.09,6.59L16.5,8Z" /> </svg></div><div id="timetick" style="display:none;"><svg style="width:30px;height:30px" viewBox="0 0 24 24">     <path fill="#000000" d="M20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4C12.76,4 13.5,4.11 14.2,4.31L15.77,2.74C14.61,2.26 13.34,2 12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12M7.91,10.08L6.5,11.5L11,16L21,6L19.59,4.58L11,13.17L7.91,10.08Z" /> </svg></div><div id="submitwrites" style="display:inline;"></div></div><div id="submitchyba" style="display:inline;"></div></td></tr>
						</table>
						</div>
						</div>
						
						<div style="text-align:center; display:none;" id="upravit">
							<div style="display:inline-block; text-align:left; width:95%; height:90%;">
								<table style="width:100%; border-collapse: collapse; text-align:left; height:100%; background-color:white; color:black;">
									<tr><td><div id="zrusit" onclick="zpetupr()" style="cursor:pointer;"><svg style="width:24px;height:24px" viewBox="0 0 24 24">
    <path fill="#555555" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
</svg><div style="display:inline; color:#555555;"> Zrušit</div></div><br></td></tr>
									<tr><td><div id="divupravit"></div></td></tr>
								</table>
							</div>
						</div>
<script>
function zamerit(){
	document.getElementById("text").focus();
}

function kick(id) {
	pokracovat = confirm("Opravdu chcete kicknout tohoto hráče?");
	if (pokracovat) {
	document.getElementById("editsubmittext").style.display = "inline";
	document.getElementById("editsubmittext").innerHTML = "Úpravy se odesílají na server.";
	document.getElementById("zrusit").style.display = "none";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		zpetupr();
		document.getElementById("odstavec").innerHTML =  "<br>";
		document.getElementById("submitwrites").innerHTML =  "Hráč byl kicknut.";
    }
	};
	xhttp.open("GET", "rodeslat.php?id='.$id.'&hrac="+id+"&kick", true);
	xhttp.send();	
	}
}

function editvar(typ, id, hodnota) {
	if (typ != "" && id != "" && hodnota != "" && !isNaN(hodnota)) {
		document.getElementById("editsubmittext").style.display = "inline";
		document.getElementById("editsubmittext").innerHTML = "Úpravy se odesílají na server.";
		document.getElementById("zrusit").style.display = "none";
	var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		document.getElementById("editsubmittext").style.display = "none";
		document.getElementById("editsubmitbtn").style.display = "inline";
		document.getElementById("editsubmitbtn").focus();
    }
  };
  xhttp.open("GET", "rodeslat.php?id='.$id.'&hrac="+id+"&typ="+typ+"&hodnota="+hodnota+"&edit", true);
  xhttp.send();
	}
}

function upravit() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divupravit").innerHTML = this.responseText;
	  	document.getElementById("upravit").style.display = "block";
		document.getElementById("zrusit").style.display = "block";
    }
	};
	xhttp.open("GET", "rhraci.php?id='.$id.'&upravit", true);
	xhttp.send();
	document.getElementById("room").style.display = "none";
}

function zpetupr() {
    document.getElementById("divupravit").innerHTML = "";
	document.getElementById("upravit").style.display = "none";
	document.getElementById("room").style.display = "block";
}

function roluj() {
   document.getElementById("chat").scrollTop = document.getElementById("chat").scrollHeight;
}

function submit() {
  var time = document.getElementsByName("cas")[0].value;
  var message = document.getElementsByName("zprava")[0].value;
  if (!isNaN(time) && time != "" && time < 25) {
	  if (message != "") {
		document.getElementById("timetick").style.display = "none";
		document.getElementById("tick").style.display = "none";
		document.getElementById("odstavec").innerHTML =  "<br>";
		document.getElementById("submitwrites").innerHTML =  "Odesílání...";
		document.getElementById("submitchyba").innerHTML = "";
		document.getElementsByName("zprava")[0].value = "";
		  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		var d = new Date();
		var hodiny = d.getHours();
		if (hodiny < 10) {hodiny = "0" + hodiny;}
		var minuty = d.getMinutes();
		if (minuty < 10) {minuty = "0" + minuty;}
		document.getElementById("timetick").style.display = "none";
		document.getElementById("tick").style.display = "inline";
		document.getElementById("submitwrites").innerHTML =  /*" \"" + escapeHtml(message) + "\" – " + */hodiny + ":" + minuty;
		document.getElementById("submitchyba").innerHTML = "";
		setTimeout(function(){ document.getElementById("chat").scrollTop = document.getElementById("chat").scrollHeight;},1001);
    }
  };
  xhttp.open("POST", "rodeslat.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("id='.$id.'&autor=0&cas="+time+"&zprava="+message);
	  }
	  else {
		document.getElementById("timetick").style.display = "none";
		document.getElementById("tick").style.display = "none";
		document.getElementById("odstavec").innerHTML =  "<br>";
		document.getElementById("submitwrites").innerHTML =  "Odesílání času...";
		document.getElementById("submitchyba").innerHTML = "";
		  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		var d = new Date();
		var hodiny = d.getHours();
		if (hodiny < 10) {hodiny = "0" + hodiny;}
		var minuty = d.getMinutes();
		if (minuty < 10) {minuty = "0" + minuty;}
		document.getElementById("tick").style.display = "none";
		document.getElementById("timetick").style.display = "inline";
		document.getElementById("odstavec").innerHTML =  "<br>";
		document.getElementById("submitwrites").innerHTML = " Čas změněn v " + hodiny + ":" + minuty;
		document.getElementById("submitchyba").innerHTML = "";
    }
  };
  xhttp.open("POST", "rodeslat.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("id='.$id.'&autor=0&cas="+time);
	  }
  }
  else {
	document.getElementById("submitchyba").innerHTML = "<br>Špatný čas!";
	document.getElementById("timetick").style.display = "none";
	document.getElementById("tick").style.display = "none";
	document.getElementById("odstavec").innerHTML =  "";
	document.getElementById("submitwrites").innerHTML =  "";
	document.getElementsByName("cas")[0].value = "10";
  }
  
}

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

function hlidatrolovani(){
	if(document.getElementById("chat").scrollTop === (document.getElementById("chat").scrollHeight - document.getElementById("chat").offsetHeight)) {
		document.getElementById("rolovat").setAttribute("style", "height: 0; opacity:0;");
	}
	else {
		document.getElementById("rolovat").setAttribute("style", "height: 39px; opacity:1;");
	}
}
setInterval(hlidatrolovani, 10);

function chat() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("chat").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "rchat.php?id='.$id.'&hrac=0", true);
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
		document.body.style.backgroundColor = "#333333";
		document.body.style.color = "#ffffff";
		break;
		
		case 5:
		document.body.style.backgroundColor = "#666666";
		document.body.style.color = "#ffffff";
		break;
		
		case 6:
		document.body.style.backgroundColor = "#999999";
		document.body.style.color = "#000000";
		break;
		
		case 7:
		document.body.style.backgroundColor = "#CCCCCC";
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
		document.body.style.backgroundColor = "#ffffff";
		document.body.style.color = "#000000";
		break;
		
		case 17:
		document.body.style.backgroundColor = "#CCCCCC";
		document.body.style.color = "#000000";
		break;
		
		case 18:
		document.body.style.backgroundColor = "#999999";
		document.body.style.color = "#ffffff";
		break;
		
		case 19:
		document.body.style.backgroundColor = "#666666";
		document.body.style.color = "#ffffff";
		break;
		
		case 20:
		document.body.style.backgroundColor = "#333333";
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

function title() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.title = "'.$nazev.' – " + this.responseText;
	  if (this.responseText=="/") {
		  window.location = "index.php";
	  }
    }
  };
  xhttp.open("GET", "rget.php?id='.$id.'&players", true);
  xhttp.send();
}
setInterval(title, 1000);

</script>
						';
						
						
						
						
						
						
						
						}
						if (isset($_GET["delete"]) && !isset($_GET["odhlasit"])) {
							zapis("DROP TABLE `room".$id."`");
							zapis("DROP TABLE `roomchat".$id."`");
							zapis("DELETE FROM rooms WHERE id='".$id."'");
							unset($_SESSION['owner']);
							echo '<br>Room byl zrušen.<br><a href="index.php">OK</a><style>#room{display:none;}</style>';
							echo '<meta http-equiv="refresh" content="1;url=index.php">';
						}
						if (isset($_GET["delete"]) && isset($_GET["odhlasit"])) {
							zapis("DROP TABLE `room".$id."`");
							zapis("DROP TABLE `roomchat".$id."`");
							zapis("DELETE FROM rooms WHERE id='".$id."'");
							unset($_SESSION['owner']);
							echo '<br>Room byl zrušen.<br><a href="login.php?odhlasit">OK</a><style>#room{display:none;}</style>';
							echo '<meta http-equiv="refresh" content="1;url=login.php?odhlasit">';
						}
					}
				}
			?>
		</div></div><br><br><br>
    </body>
</html>