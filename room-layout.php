<!doctype html>
<html>
    <head>
		<meta name="robots" content="noindex, nofollow">
		<meta charset="utf-8">
		<title>Jméno roomu</title>
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="http://pre12.deviantart.net/b248/th/pre/f/2013/247/e/3/dragon_icon_by_ferocefv-d6krb7y.png" />
    </head>
    <body style="-webkit-transition-duration: 0.5s; transition-duration: 0.5s;">
        <br>
		<style>
		table, th, td {
			border: 3px solid #e5e5e5;
		}
		body {
			font-size: 150%;
		}
		#info{
			font-weight: 1000;
		}
		#chat .$ja{
			text-transform: uppercase;
		}
		#chat .owner{
			font-weight: bold;
		}
		</style>
		<div style="text-align:center;">
		<div style="display:inline-block; text-align:left; width:95%; height:90%;">
		<table style="width:100%; border-collapse: collapse; text-align:left; height:100%;">
		<tr><td><div id="info"></div></td></tr>
		<tr><td><div id="hraci"></div></td></tr>
		<tr><td><div id="chat"></div></td></tr>
		<tr><td style="border-bottom: none; vertical-align:center;"><form action="room-layout.php" method="get">Zpráva:<br><textarea name="zprava" rows="1" style="width:99%; height:20px;"><?php if(isset($_GET["zprava"])) {echo $_GET["zprava"];} ?></textarea></td></tr>
		<tr><td style="border-top: none; text-align:center;">Čas: <input type="text" name="cas" value="<?php if(isset($_GET["cas"])) {echo $_GET["cas"];} else {echo "10";} ?>" size="2" maxlength="2">   <input type="submit" value="Odeslat"></form></td></tr>
		</table>
		</div>
		</div><br><br><br>
    </body>
</html>