<!doctype html>
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="10">
		<title>Bajkerovo dračí doupě</title>
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
    </head>
    <body>
		<script>
		function check() {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
				}
			};
			xhttp.open("GET", "check.php", true);
			xhttp.send();
		}
		check();
		setInterval(check, 5000);
		</script>
        <div style="text-align:center"><br>
		<h1 class="index-hdr index-hdr-m" style="padding:0px; margin:0px;">Bajkerovo dračí doupě</h1>
		<?php
		$trvanlivostRelace = 60*60*24;
		ini_set('session.gc_maxlifetime',$trvanlivostRelace);
		session_start();
		if (isset($_SESSION['prihlaseni']) && isset($_SESSION['vypravec'])) {
				echo '<br><a href="new.php" class="button blue">Nový room</a>';
		}
		?>
		
		<br><br>
		<table class="prehled prehled-m" style="display: inline-block; text-align:left; border-spacing: 20px 0px;">
		<?php
		require_once("databaze.php");
		$db = new PDO($dbset, $dbnick, $dbpass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$parametry = array();
		
		
		$dotaz="";
		$vystup="";
		$dotaz = $db->prepare("SELECT * FROM rooms ORDER BY id DESC");
		$dotaz->execute($parametry);
		for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
			echo '<tr><td style="text-align:center;"><a ';
			if ($vystup['hraci'] < $vystup['maxhraci']) {echo 'href="room.php?id=' . $vystup['id'] . '"';}
			echo ' class="button yes" style="display:block;">' . htmlspecialchars($vystup['nazev']) . '</a> </td><td style="text-align:center;">Vypravěč: '.htmlspecialchars($vystup['vypravec']).' </td><td style="text-align:center;">Počet hráčů: '.$vystup['hraci'].'/'.$vystup['maxhraci'].'</td></tr>';
			$someroom = $vystup['id'];
		}
		$dotaz2="";
		$vystup2="";
		$dotaz2 = $db->prepare("SELECT * FROM secretrooms WHERE viditelny=1 ORDER BY id DESC");
		$dotaz2->execute($parametry);
		for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
			echo '<tr><td style="text-align:center;"><a ';
			if ($vystup2['hraci'] < $vystup2['maxhraci']) {echo 'href="sroom.php?id=' . $vystup2['id'] . '"';}
			echo 'class="button black" style="display:block;">' . htmlspecialchars($vystup2['nazev']) . '</a> </td><td style="text-align:center;">Vypravěč: '.htmlspecialchars($vystup2['vypravec']).' </td><td style="text-align:center;">Počet hráčů: '.$vystup2['hraci'].'/'.$vystup2['maxhraci'].'</td></tr>';
			$someroom2 = $vystup2['id'];
		}
		$fp = fopen('notification.txt', 'r');
		$lastnottime = fread($fp, filesize("notification.txt"));
		fclose($fp);
		$allowedtime = $lastnottime + 60*60*24;
		if (!isset($someroom) && !isset($someroom2)) {
			echo 'Nikdo není online.';
			if (time() > $allowedtime) {
				echo ' <a href="index.php?zprava">Poslat vypravěčům zprávu.</a>';
			}
		}
		if (isset($_GET['zprava'])) {
			if (time() > $allowedtime) {
				mail('Bajkerovo draci doupe <bajkerovo.doupe@seznam.cz>', 'Dračí doupě volá!', 'Dračí doupě volá! Běž na http://bajker006.wz.cz/game/new.php a založ nový room.',"From: Bajkerovo draci doupe <bajkerovo.doupe@seznam.cz>\nMIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit");
				echo '<br>Zpráva odeslána.<meta http-equiv="refresh" content="3;url=index.php">';
				$fp = fopen('notification.txt', 'w');
				fwrite($fp, time());
				fclose($fp);
			}
		}
		?>
		</table>
		<div id="index"><br>
		<?php
		if (isset($_SESSION['prihlaseni'])) {
			echo '<a href="login.php?odhlasit" title="Odhlásit se" class="button logout logout-m" style="top:25px; right:25px;"><svg style="width:24px;height:24px" viewBox="0 0 24 16"><path fill="#000" d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13" /></svg> <span id="logout-text" >Odhlásit se</span></a>';
		}
		else {
			echo '<a href="login.php?start" title="Přihlásit se" class="button login login-m" style="top:25px; right:25px;"><svg style="width:24px;height:24px" viewBox="0 0 24 16"><path fill="green" d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13" /></svg> <span id="login-text" style="color:black;">Přihlásit se</span></a>';
		}
		?>
		<a href="mailto:bajker006@gmail.com" title="Nahlásit chybu" class="button no" style="top:25px; left:25px;">Nahlásit chybu</a>
		<a href="https://github.com/VitKolos/DraciDoupe/commits" title="Novinky" class="button blue" style="top:100px; left:25px;">Novinky ve hře</a><br><br>
		<a href="https://github.com/VitKolos/DraciDoupe" style="top:115px; left:290px; width:32px;"><svg id="octicon" height="32" version="1.1" fill="#ccc" viewBox="0 0 16 16" width="32"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg></a>
		<style>#octicon:hover{fill:grey;}</style>
		</div>
		</div>
    </body>
</html>