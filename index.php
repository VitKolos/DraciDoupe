<!doctype html>
<html>
    <head>
		<meta name="robots" content="noindex, nofollow">
		<meta charset="utf-8">
		<title>Bajkerovo dračí doupě</title>
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
    </head>
    <body style="-webkit-transition-duration: 0.5s; transition-duration: 0.5s;">
        <div style="text-align:center"><br><div>
		<table style="display: inline-block; text-align:left; border-spacing: 20px 0px;">
		<?php
		$trvanlivostRelace = 60*60*24;
		ini_set('session.gc_maxlifetime',$trvanlivostRelace);
		session_start();
		if (isset($_SESSION['prihlaseni']) && isset($_SESSION['vypravec'])) {
				echo '<a href="new.php" class="button blue">Nový room</a><br><br>';
		}
		
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
			echo '<tr><td><a ';
			if ($vystup['hraci'] < $vystup['maxhraci']) {echo 'href="room.php?id=' . $vystup['id'] . '"';}
			echo 'class="button yes">' . $vystup['nazev'] . '</a> </td><td>Vypravěč: '.$vystup['vypravec'].' </td><td>Počet hráčů: '.$vystup['hraci'].'/'.$vystup['maxhraci'].'</td></tr>';
			$someroom = $vystup['id'];
		}
		$fp = fopen('notification.txt', 'r');
		$lastnottime = fread($fp, filesize("notification.txt"));
		fclose($fp);
		$allowedtime = $lastnottime + 60*60*24;
		if (!isset($someroom)) {
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