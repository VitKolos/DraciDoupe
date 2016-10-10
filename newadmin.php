<!doctype html>
<html>
    <head>
	<meta name="robots" content="noindex, nofollow">
	<meta charset="utf-8">
        <title>Přidat vypravěče</title>
    </head>
    <body>
        <div style="text-align:center">
		<form action="newadmin.php" method="post"><table style="text-align:left; display:inline-block;"><tr><td>Heslo: </td><td><input type="text" name="heslo"></td></tr><tr><td>Prémiový: </td><td><input type="checkbox" name="premiovy"></td></tr><tr><td>Doplněk: </td><td><input type="checkbox" name="doplnek"></td></tr><tr><td>Klíč: </td><td><input type="text" name="adminheslo"></td></tr></table><br><input type="submit" value="Odeslat"></form><br><br>
		<?php
		require_once("databaze.php");
		
		if (isset($_POST["adminheslo"]) && isset($_POST["heslo"])){
			if ($_POST["adminheslo"] == "Ábíčko je nej! :D") {
				if (isset ($_POST["premiovy"])) {
					$premiovy = 1;
				}
				else {
					$premiovy = 0;
				}
				if (isset ($_POST["doplnek"])) {
					$doplnek = 1;
				}
				else {
					$doplnek = 0;
				}
				zapis('INSERT INTO hesla(heslo, premiovy, doplnek) VALUES ("'.$_POST["heslo"].'", '.$premiovy.', '.$doplnek.')');
				require_once("databaze.php");
				$db = new PDO($dbset, $dbnick, $dbpass);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$parametry = array();
				$dotaz = $db->prepare("SELECT * FROM hesla WHERE heslo='".$_POST["heslo"]."'");
				$dotaz->execute($parametry);
				for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
					$id = $vystup['id'];
					$heslo = $vystup['heslo'];
				}
				echo 'Adresa je http://bajker006.wz.cz/game/login.php?id='.$id."&heslo=".$heslo."<br>Prémiový: ".$premiovy."<br>Doplněk: ".$doplnek;
			}
		}
		?>
		</div>
		<br><br>
	</body>
</html>