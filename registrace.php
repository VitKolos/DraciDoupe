<!doctype html>
<html>
    <head>
	<meta name="robots" content="noindex, nofollow">
	<meta charset="utf-8">
        <title>Registrace</title>
    </head>
    <body>
        <div style="text-align:center"><div id="formular"><form action="registrace.php" method="post"><table style="text-align:left; display:inline-block;"><tr><td>Nick: </td><td><input type="text" name="nick"></td></tr><tr><td>Heslo: </td><td><input type="password" name="heslo"></td></tr><tr><td>Heslo znovu:</td><td><input type="password" name="hesloznovu"></td></tr></table><br><input type="submit" value="Odeslat"></form><br></div><br>
		<?php
		require_once("databaze.php");
		session_start();
		if (isset($_SESSION["prihlaseni"])) {echo '<meta http-equiv="refresh" content="0;url=index.php">';}
		if(isset($_POST["nick"]) && isset($_POST["heslo"]) && isset($_POST["hesloznovu"])){
			if($_POST["heslo"] == $_POST["hesloznovu"]) {
			$db = new PDO($dbset, $dbnick, $dbpass);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$parametry = array();
			$dotaz = $db->prepare("SELECT * FROM hraci ORDER BY id ASC");
			$dotaz->execute($parametry);
			$enemy = false;
			for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
				if($vystup["nick"] == $_POST["nick"]){$enemy = true;}
			}
			if ($enemy) {echo "Chyba: Tento nick je už zvolen někým jiným.";}
			else {
				zapis("INSERT INTO hraci(nick, heslo) VALUES ('".$_POST["nick"]."', '".md5($_POST["heslo"])."')");
				echo 'Výborně! <b><a href="login.php">Přihlásit se</a></b>';
					echo '<meta http-equiv="refresh" content="1;url=login.php?registrace='.$_POST["nick"].'">';
					echo '<style>#formular{display:none;}</style>';
				}
			}
			else {
				echo "Chyba: Hesla se liší!";
			}
		}
		?>
		</div>
		<br><br>
	</body>
</html>