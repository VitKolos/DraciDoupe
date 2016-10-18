
<?php if (is_array($chat) || is_object($chat)): ?>

<?php foreach ($chat as $bublina): ?>
<?php
echo '<div ';
if ($bublina['autor'] == $idhrace) {
	echo 'class="owner"';
}
echo ' style="display:inline; color:#555555;">&#60;';
if ($bublina['autor'] == 0 && $idhrace != 0) {
	 echo strtoupper(htmlspecialchars($vypravec));
}
else if ($bublina["autor"] == 0 && $idhrace == 0) {
	echo htmlspecialchars($vypravec);
}
else {
	$dotaz="";
	$vystup="";
	$dotaz = $db->prepare("SELECT * FROM room".$id." WHERE id=".$bublina['autor']);
	$dotaz->execute($parametry);
	for ($i = 0; $vystup = $dotaz->fetch(); $i++) {
		echo htmlspecialchars($vystup["jmeno"]);
	}
	
}
echo "&#62;</div>&#32;";
?>
<?php echo htmlspecialchars($bublina['text']); ?> <em style="float:right;"><small style="color:grey;">(<?php 
$datum = date("Y-m-d");
$datumzpravy = substr($bublina['cas'],0,4) . "-" . substr($bublina['cas'],5,2) . "-" . substr($bublina['cas'],8,2);
if ($datum != $datumzpravy) {
	echo substr($bublina['cas'],8,2) . ". " . substr($bublina['cas'],5,2) . ". " . substr($bublina['cas'],0,4) . " v ";
}
echo substr($bublina['cas'],11,2) . ":" . substr($bublina['cas'],14,2); ?>)</small></em>
<br>
<?php endforeach; ?>
    <?php else: ?>
    <?php echo $chat; ?>
    <?php endif ?>
	<?php $dotaz->closeCursor();
    $db = null; ?>
