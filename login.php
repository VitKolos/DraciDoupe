<!doctype html>
<html>
    <head>
	<meta name="robots" content="noindex, nofollow">
	<meta charset="utf-8">
        <title>Přihlásit se</title>
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
    </head>
    <body>
        <div style="text-align:center">
		<?php if (isset($_GET["start"])) {echo '<div style="background-color:#90EE90; color:white;"><small><b>Vítejte v online hře Dračí doupě, kterou vytvořil Bajker006.<br>Nejprve se, prosím, přihlašte nebo zaregistrujte.</b></small></div><br>';} else{echo '<div style="text-align:left;"><small><a href="index.php">Zpět</a></small></div>';} ?>
		<?php session_start(); if(isset($_GET["id"]) && !isset($_SESSION["prihlaseni"])){echo 'Nejdřív se musíš přihlásit.';}
		if (isset($_SESSION["prihlaseni"]) && isset($_GET["odhlasit"])) {session_unset(); session_destroy(); echo "Byl jsi odhlášen.";} ?>
		<div id="login"><form action="<?php
		if(isset($_GET["klic"])) {echo "login.php?klic=".$_GET["klic"];}
		else if(isset($_GET["id"]) && isset($_GET["heslo"])) {echo "login.php?id=".$_GET["id"]."&heslo=".$_GET["heslo"];}
		else {echo "login.php";}
		?>" method="post"><table style="text-align:left; display:inline-block;"><tr><td>Nick: </td><td><input type="text" name="nick" <?php if(isset($_GET['registrace'])){echo 'value="'.$_GET["registrace"].'"';} ?> ></td></tr><tr><td>Heslo: </td><td><input type="password" name="heslo"></td></tr></table><br><input type="submit" class="button blue" value="Odeslat"></form><br>
<?php if(!isset($_GET['registrace'])){echo 'Ještě nemáš účet? <a href="registrace.php">Registrace.</a>';} ?>
</div><br>
		<?php
		require_once("databaze.php");
		if (isset($_SESSION["prihlaseni"]) && !isset($_GET["id"]) && !isset($_GET["heslo"]) && !isset($_GET["odhlasit"])) {header("Location: index.php"); exit;}
		if (!isset($_SESSION["prihlaseni"]) && isset($_POST["nick"]) && isset($_POST["heslo"])){
			$db = new PDO($dbset, $dbnick, $dbpass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$parametry = array();
			$dotaz = $db->prepare("SELECT * FROM hraci WHERE nick='".$_POST["nick"]."'");
			$dotaz->execute($parametry);
			for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
				$id = $vystup["id"];
				$nick = $vystup['nick'];
				$heslo = $vystup['heslo'];
				$vypravec = $vystup['vypravec'];
				$premiovy = $vystup['premiovy'];
			}
			if(isset($heslo) && $heslo == md5($_POST["heslo"])) {
				$_SESSION["prihlaseni"] = $id;
				$_SESSION["nick"] = $nick;
					if ($vypravec != 0) {$_SESSION["vypravec"] = 1;}
					if ($premiovy != 0) {$_SESSION["premiovy"] = 1;}
					echo 'Přihlášení proběhlo úspěšně! <b><a href="';
					if(isset($_GET["klic"])) {echo "sroom.php?klic=".$_GET["klic"];}
					else if(isset($_GET["id"]) && isset($_GET["heslo"])) {echo "login.php?id=".$_GET["id"]."&heslo=".$_GET["heslo"];}
					else {echo "index.php";}
					echo '">Jít dál.</a></b>';
					echo '<meta http-equiv="refresh" content="1;url=';
					if(isset($_GET["klic"])) {echo "sroom.php?klic=".$_GET["klic"];}
					else if(isset($_GET["id"]) && isset($_GET["heslo"])) {echo "login.php?id=".$_GET["id"]."&heslo=".$_GET["heslo"];}
					else {echo "index.php";}
					echo '">';
					echo '<style>#login{display:none;}</style>';
			}
			else {echo "Špatné heslo!";}
		}
		if (isset($_SESSION["prihlaseni"]) && isset($_GET["id"]) && isset($_GET["heslo"])){
			$db = new PDO($dbset, $dbnick, $dbpass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$parametry = array();
			$dotaz = $db->prepare("SELECT * FROM hesla WHERE id='".$_GET["id"]."'");
			$dotaz->execute($parametry);
			for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
				$heslo = $vystup['heslo'];
				$premiovy = $vystup['premiovy'];
				$doplnek = $vystup['doplnek'];
			}
			if (isset($heslo)) {
				if ($_GET["heslo"] == $heslo){
					$expirace = time() + 60*60*24*365;
					if ($doplnek == 0) {zapis('UPDATE `hraci` SET `vypravec`=1 WHERE id = '.$_SESSION["prihlaseni"]); $_SESSION["vypravec"] = 1;}
					if ($premiovy != 0) {zapis('UPDATE `hraci` SET `premiovy`=1 WHERE id = '.$_SESSION["prihlaseni"]); $_SESSION["premiovy"] = 1;}
					$dotaz = $db->prepare("DELETE FROM `hesla` WHERE id='".$_GET["id"]."'");
					$dotaz->execute($parametry);
					echo 'Výborně! <b><a href="index.php">Jít domů.</a></b>';
					echo '<meta http-equiv="refresh" content="1;url=index.php">';
					echo '<style>#login{display:none;}</style>';
				}
				else {echo "Špatné heslo vypravěče!";}
			}
			else {echo "Špatné heslo vypravěče!";}
		}
		?>
		</div>
		<br><br>
	</body>
</html>