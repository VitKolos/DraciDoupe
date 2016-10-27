<!doctype html>
<html>
    <head>
		<meta charset="utf-8">
		<title>Bajkerovo dračí doupě</title>
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
    </head>
    <body style="-webkit-transition-duration: 0.5s; transition-duration: 0.5s;">
		<meta http-equiv="refresh" content="10">
        <div style="text-align:center"><br><div>
		<table style="display: inline-block; text-align:left; border-spacing: 20px 0px;">
		<h1 style="padding:0px; margin:0px;">Bajkerovo dračí doupě</h1>
		<?php
		$trvanlivostRelace = 60*60*24;
		ini_set('session.gc_maxlifetime',$trvanlivostRelace);
		session_start();
		if (isset($_SESSION['prihlaseni']) && isset($_SESSION['vypravec'])) {
				echo '<br><a href="new.php" class="button blue">Nový room</a>';
		}
		?>
		
		<br><br><a href="login.php?odhlasit" title="Odhlásit se" class="button logout" style="position:fixed; top:25px; right:25px;"><svg style="width:24px;height:24px" viewBox="0 0 24 16"><path fill="#000000" d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13" /></svg></a>
		
		<?php
		if (!isset($_SESSION['prihlaseni'])) {
			header("Location: login.php?start");
			exit;
		}
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
			echo 'class="button yes" style="display:block;">' . htmlspecialchars($vystup['nazev']) . '</a> </td><td>Vypravěč: '.htmlspecialchars($vystup['vypravec']).' </td><td>Počet hráčů: '.$vystup['hraci'].'/'.$vystup['maxhraci'].'</td></tr>';
			$someroom = $vystup['id'];
		}
		$dotaz2="";
		$vystup2="";
		$dotaz2 = $db->prepare("SELECT * FROM secretrooms WHERE viditelny=1 ORDER BY id DESC");
		$dotaz2->execute($parametry);
		for ($i = 0; $vystup2 = $dotaz2->fetch(); $i++) {
			echo '<tr><td style="text-align:center;"><a ';
			if ($vystup2['hraci'] < $vystup2['maxhraci']) {echo 'href="sroom.php?id=' . $vystup2['id'] . '"';}
			echo 'class="button black" style="display:block;">' . htmlspecialchars($vystup2['nazev']) . '</a> </td><td>Vypravěč: '.htmlspecialchars($vystup2['vypravec']).' </td><td>Počet hráčů: '.$vystup2['hraci'].'/'.$vystup2['maxhraci'].'</td></tr>';
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
		</div></div><br><br><br>
    </body>
</html>