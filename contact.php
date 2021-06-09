<?php
require_once('config.php');

$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Contact"';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {
	$pagimgx = explode(".", $rand['pagimg']);
	if ($pagimgx[1] == 'swf') {
		$pagimg =
			'
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="609" height="239" title="Despre Noi">
				<param name="movie" value="' . $rand['pagimg'] . '" />
				<param name="quality" value="high" />
				<embed src="' . $rand['pagimg'] . '" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="609" height="239"></embed>
			</object>
		';
	} else {
		$pagimg =
			'
			<img src="' . $rand['pagimg'] . '" width="609" height="239" alt="">
		';
	}
}

$cerereSQL = 'SELECT * FROM `categorii` WHERE `nume`="Contact" ';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {
	$title = $rand['nume'] . ' - ' . $rand['descriere'];
}
include('header.php');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$cerereSQL = 'SELECT * FROM `anunturi` ORDER BY `id` DESC';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {
	$Now = strtotime(date('d.m.Y'));
	$Action = strtotime($rand['data']);

	$dateDiff = $Now - $Action;
	$Days = floor($dateDiff / (60 * 60 * 24));

	if ($Days <= $rand['durata']) {
		$continut = mb_strimwidth($rand['continut'], 0, 600, " ...");
		echo '
			<p align="justify"><a href="anunturi.php?id=' . $rand['id'] . '"><font color="darkred" size="3"><b>' . $rand['titlu'] . '</b></font></a><font color="black"><i> [din ' . $rand['data'] . ']</i></font><br>
			' . $continut . ' <a href="anunturi.php?id=' . $rand['id'] . '">[continuare ...]</a><br>
			<center><a href="anunturi.php?id=' . $rand['id'] . '"><img src="anunturi/' . $rand['imagine'] . '" alt=""></a></center><hr></hr></p>
		';
	} else {
		echo '';
	}
}

echo '<p align="center"><img src="images/a.gif" alt=""></p>';

$intrari_totale2 = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `articole` WHERE `pag`="Contact"'));
if ($intrari_totale2 == 0) {
	echo '';
} else {
	$cerereSQL = 'SELECT * FROM `articole` WHERE `pag`="Contact"';
	$rezultat = mysqli_query($conexiune, $cerereSQL);
	while ($rand = mysqli_fetch_assoc($rezultat)) {
		echo '
				<p align="center"><font size="4"><b>' . $rand['titlu'] . '</b></font></p>
				<p align="justify">' . $rand['continut'] . '</p>
				<p>&nbsp;</p>
			';
	}
}

$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `imagini` WHERE `pentru`="contact"'));
if ($intrari_totale == 0) {
	echo '';
} else {
	echo
	'
				<table width="100%" cellspacing="10" cellpadding="0" border="0">
					<tr>
			';
	$nr = 0;
	$cerereSQL = 'SELECT * FROM `imagini` WHERE `pentru`="contact"';
	$rezultat = mysqli_query($conexiune, $cerereSQL);
	while ($rand = mysqli_fetch_assoc($rezultat)) {
		$nr++;
		echo
		'<td align="center" width="185">
							<a href="contact/' . $rand['path'] . '" rel="lightbox[Contact]" title="' . $rand['nume'] . '"><img src="contact/thumb/' . $rand['path'] . '" height="100" alt=""></a>
						</td>';
		if ($nr % 3 == 0) echo '</tr><tr>';
	}
	echo
	'
					</tr>
				</table>
			';
}
if (isset($_POST['send'])) {
	echo '<p align="center"><font color="darkgreen"><b>E-mail-ul dumneavoastra a fost trimis! In scurt timp veti primi un raspuns !</b></font></p>';

	$catre = 'topmariage@yahoo.com';
	$data_trimitere = date('d-m-Y H:i:s');
	$subiect = $_POST['subiect'] . ' - de la ' . $_POST['nume'];
	$mesaj = $_POST['mesaj'];

	$headere = "MIME-Version: 1.0\r\n";
	$headere .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headere .= "From: <" . $_POST['mail'] . ">\r\n";

	mail($catre, $subiect, $mesaj, $headere);
} else {
	echo '';
}

echo
'
	<form name="contact" action="contact.php" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td align="center">
								<font size="4"><b><i>Formular de contact</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="left"><b>Nume:</b><br><input type="text" size="60" name="nume">
							</td>
						</tr>
						<tr>
							<td align="left"><b>E-mail:</b><br><input type="text" size="60" name="mail">
							</td>
						</tr>
						<tr>
							<td align="left"><b>Subiect:</b><br><input type="text" size="60" name="subiect">
							</td>
						</tr>
						<tr>
							<td align="left"><b>Mesaj:</b><br>
								<textarea id="mesaj" name="mesaj" style="height: 170px; width: 500px;"></textarea>
								<script language="javascript1.2">
								  generate_wysiwyg(\'mesaj\');
								</script>
							</td>   
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="send" type="submit" value="Trimite !"></td>
						</tr>
					</table>
			</form>
';

echo '<p align="center"><img src="images/b.gif" alt=""></p>';

include('footer.php');
