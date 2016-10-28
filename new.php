<!doctype html>
<html>
    <head>
	<meta name="robots" content="noindex, nofollow">
	<meta charset="utf-8">
        <title>Nový room</title>
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
		<?php
		session_start();
if (!isset($_SESSION["vypravec"])) {header("Location: index.php"); exit;}
?>
    </head>
    <body>
	<small><a href="index.php">Zpět</a></small>
        <div style="text-align:center"><h1 style="font-size:3rem;">Nový room</h1><div id="novy-room"><form action="new.php" method="post"><table style="text-align:left; display:inline-block;"><tr><td>Název: </td><td><input type="text" name="nazev"></td></tr><tr><td>Tvůj nick (jaký chceš): </td><td><input type="text" name="owner" <?php if(isset($_SESSION['nick'])){echo 'value="'.$_SESSION["nick"].'"';} ?> ></td></tr>
		<tr><td>Zaheslovaný:</td><td><input type="checkbox" name="zaheslovany" id="zaheslovany" onchange="ukazat()"></td></tr>
		<tr id="tajnytr" style="color:#ccc;"><td>Tajný:</td><td><input type="checkbox" name="tajny" id="tajny" disabled></td></tr>
		<tr id="heslotr" style="color:#ccc;"><td>Heslo: </td><td><input type="text" name="heslo" id="heslo" disabled></td></tr></table><br><input class="button blue" type="submit" value="Odeslat"></form></div><br><br>
		<script>
		function ukazat() {
			document.getElementById("tajny").disabled = false;
			document.getElementById("heslo").disabled = false;
			document.getElementById("zaheslovany").setAttribute("onchange","schovat()");
			document.getElementById("tajnytr").style.color="#000";
			document.getElementById("heslotr").style.color="#000";
		}
		function schovat() {
			document.getElementById("tajny").disabled = true;
			document.getElementById("tajny").checked = false;
			document.getElementById("heslo").disabled = true;
			document.getElementById("heslo").value = "";
			document.getElementById("zaheslovany").setAttribute("onchange","ukazat()");
			document.getElementById("tajnytr").style.color="#ccc";
			document.getElementById("heslotr").style.color="#ccc";
		}
		</script>
		<?php
		require_once ("databaze.php");
		if (isset($_SESSION["premiovy"])) {
			$maxhraci = 50;
		}
		else {
			$maxhraci = 5;
		}
		if (isset($_POST['nazev']) && isset($_POST['owner']) && ($_POST['nazev'] =="" || strlen($_POST['nazev'])>20 || $_POST['owner'] =="" || strlen($_POST['owner'])>20)) {
			echo '<div style="background-color:red; color:white;"><b>Špatně zadané údaje!</b></div>';
		}
		else if (isset($_POST['nazev']) && $_POST['nazev'] !="" && isset($_POST['owner']) && $_POST['owner'] !="" && !isset($_POST['zaheslovany'])) {
			$stejnynazev = false;
			$stejnyowner = false;
			$db = new PDO($dbset, $dbnick, $dbpass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$parametry = array();
			$dotaz="";
			$vystup="";
			$dotaz = $db->prepare("SELECT * FROM secretrooms");
			$dotaz->execute($parametry);
			for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
				if ($vystup["klic"] == md5($_POST['heslo'])) {$stejnyklic = true;}
				if ($vystup["nazev"] == $_POST['nazev']) {$stejnynazev = true;}
				if ($vystup["owner"] == $_POST['owner']) {$stejnyowner = true;}
			}
			if (!$stejnyowner && !$stejnynazev) {
			$_SESSION["nick"] = $_POST['owner'];
			zapis ("INSERT INTO rooms(nazev, vypravec, idvypravece, zalozeno, aktivita, cas, hraci, maxhraci) VALUES ('".$_POST['nazev']."', '".$_POST['owner']."', '".$_SESSION['prihlaseni']."', ".time().", ".time().", 10, 0, ".$maxhraci.")");
			$db = new PDO($dbset, $dbnick, $dbpass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$parametry = array();
			$dotaz = $db->prepare("SELECT * FROM rooms WHERE nazev='".$_POST["nazev"]."'");
			$dotaz->execute($parametry);
			for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
				$roomid = $vystup['id'];
			}
			$_SESSION["owner"] = $roomid;
			zapis('CREATE TABLE `'.$dbname.'`.`room'.$roomid.'` ( `id` INT NOT NULL AUTO_INCREMENT , `jmeno` TEXT CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL , `pohlavi` TEXT CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL , `penize` INT NOT NULL , `cp` INT NOT NULL , `hp` INT NOT NULL, PRIMARY KEY (id) ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_czech_ci');
			zapis('CREATE TABLE `'.$dbname.'`.`roomchat'.$roomid.'` ( `id` INT NOT NULL AUTO_INCREMENT , `autor` int(11) NOT NULL , `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP , `text` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL , PRIMARY KEY (id) ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_czech_ci');
			echo 'Hotovo! <b><a href="room.php?id='.$roomid.'">Pokračovat.</a></b><meta http-equiv="refresh" content="1;url=room.php?id='.$roomid.'"><style>#novy-room{display:none;}</style>';
			}
			else if ($stejnynazev) {
				echo "Zadejte jiný název roomu.";
			}
			else if ($stejnyowner) {
				echo "Zadejte jiný nick.";
			}
		}
		else if (isset($_POST['nazev']) && $_POST['nazev'] !="" && isset($_POST['owner']) && $_POST['owner'] !="" && isset($_POST['zaheslovany']) && isset($_POST['tajny']) && isset($_POST['heslo']) && $_POST['heslo'] !="") {
			//tajny
			$stejnyklic = false;
			$stejnynazev = false;
			$stejnyowner = false;
			$db = new PDO($dbset, $dbnick, $dbpass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$parametry = array();
			$dotaz="";
			$vystup="";
			$dotaz = $db->prepare("SELECT * FROM secretrooms");
			$dotaz->execute($parametry);
			for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
				if ($vystup["klic"] == md5($_POST['heslo'])) {$stejnyklic = true;}
				if ($vystup["nazev"] == $_POST['nazev']) {$stejnynazev = true;}
				if ($vystup["owner"] == $_POST['owner']) {$stejnyowner = true;}
			}
			if (!$stejnyklic && !$stejnyowner && !$stejnynazev && strlen($_POST['heslo'])>=5) {
			$_SESSION["nick"] = $_POST['owner'];
			zapis ("INSERT INTO secretrooms(klic, nazev, vypravec, idvypravece, zalozeno, aktivita, cas, hraci, maxhraci, viditelny) VALUES ('".md5($_POST['heslo'])."', '".$_POST['nazev']."', '".$_POST['owner']."', '".$_SESSION['prihlaseni']."', ".time().", ".time().", 10, 0, ".$maxhraci.", 0)");
			$db = new PDO($dbset, $dbnick, $dbpass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$parametry = array();
			$dotaz = $db->prepare("SELECT * FROM secretrooms WHERE nazev='".$_POST["nazev"]."'");
			$dotaz->execute($parametry);
			for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
				$klic = $vystup['klic'];
				$roomid = $vystup['id'];
			}
			$_SESSION["owner"] = "s".$roomid;
			zapis('CREATE TABLE `'.$dbname.'`.`sroom'.$klic.'` ( `id` INT NOT NULL AUTO_INCREMENT , `jmeno` TEXT CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL , `pohlavi` TEXT CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL , `penize` INT NOT NULL , `cp` INT NOT NULL , `hp` INT NOT NULL, PRIMARY KEY (id) ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_czech_ci');
			zapis('CREATE TABLE `'.$dbname.'`.`sroomchat'.$klic.'` ( `id` INT NOT NULL AUTO_INCREMENT , `autor` int(11) NOT NULL , `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP , `text` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL , PRIMARY KEY (id) ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_czech_ci');
			echo 'Hotovo!<br>Adresa roomu: http://bajker006.wz.cz/game/sroom.php?klic='.$klic.'<br>Heslo: '.$_POST['heslo'].'<br><a href="room.php?id='.$roomid.'">Přejít na room</a><style>#novy-room{display:none;}</style>';
			}
			else if ($stejnynazev) {
				echo "Zadejte jiný název roomu.";
			}
			else if ($stejnyowner) {
				echo "Zadejte jiný nick.";
			}
			else if ($stejnyklic || strlen($_POST['heslo'])<5) {
				echo "Zadejte jiné heslo. Toto je příliš jednoduché.";
			}
		}
		else if (isset($_POST['nazev']) && $_POST['nazev'] !="" && isset($_POST['owner']) && $_POST['owner'] !="" && isset($_POST['zaheslovany']) && !isset($_POST['tajny']) && isset($_POST['heslo']) && $_POST['heslo']!="") {
			//verejny
			$stejnyklic = false;
			$stejnynazev = false;
			$stejnyowner = false;
			$db = new PDO($dbset, $dbnick, $dbpass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$parametry = array();
			$dotaz="";
			$vystup="";
			$dotaz = $db->prepare("SELECT * FROM secretrooms");
			$dotaz->execute($parametry);
			for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
				if ($vystup["klic"] == md5($_POST['heslo'])) {$stejnyklic = true;}
				if ($vystup["nazev"] == $_POST['nazev']) {$stejnynazev = true;}
				if ($vystup["owner"] == $_POST['owner']) {$stejnyowner = true;}
			}
			if (!$stejnyklic && !$stejnyowner && !$stejnynazev && strlen($_POST['heslo'])>=5) {
			$_SESSION["nick"] = $_POST['owner'];
			zapis ("INSERT INTO secretrooms(klic, nazev, vypravec, idvypravece, zalozeno, aktivita, cas, hraci, maxhraci, viditelny) VALUES ('".md5($_POST['heslo'])."', '".$_POST['nazev']."', '".$_POST['owner']."', '".$_SESSION['prihlaseni']."', ".time().", ".time().", 10, 0, ".$maxhraci.", 1)");
			$db = new PDO($dbset, $dbnick, $dbpass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$parametry = array();
			$dotaz = $db->prepare("SELECT * FROM secretrooms WHERE nazev='".$_POST["nazev"]."'");
			$dotaz->execute($parametry);
			for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
				$klic = $vystup['klic'];
				$roomid = $vystup['id'];
			}
			$_SESSION["owner"] = "s".$roomid;
			zapis('CREATE TABLE `'.$dbname.'`.`sroom'.$klic.'` ( `id` INT NOT NULL AUTO_INCREMENT , `jmeno` TEXT CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL , `pohlavi` TEXT CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL , `penize` INT NOT NULL , `cp` INT NOT NULL , `hp` INT NOT NULL, PRIMARY KEY (id) ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_czech_ci');
			zapis('CREATE TABLE `'.$dbname.'`.`sroomchat'.$klic.'` ( `id` INT NOT NULL AUTO_INCREMENT , `autor` int(11) NOT NULL , `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP , `text` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL , PRIMARY KEY (id) ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_czech_ci');
			echo 'Hotovo!<br>Adresa roomu: http://bajker006.wz.cz/game/sroom.php?klic='.$klic.'<br>Heslo: '.$_POST['heslo'].'<br><small>Heslo si prosím někam zapište.</small><br><a href="sroom.php?klic='.$klic.'">Přejít na room</a><style>#novy-room{display:none;}</style>';
			}
			else if ($stejnynazev) {
				echo "Zadejte jiný název roomu.";
			}
			else if ($stejnyowner) {
				echo "Zadejte jiný nick.";
			}
			else if ($stejnyklic || strlen($_POST['heslo'])<5) {
				echo "Zadejte jiné heslo. Toto je příliš jednoduché.";
			}
		}
		else if (isset($_POST['nazev']) && isset($_POST['owner']) && isset($_POST['zaheslovany']) && $_POST['heslo']=="") {
			echo "Zapoměli jste nastavit heslo.";
		}
		?>
		</div>
		<br><br>
	</body>
</html>