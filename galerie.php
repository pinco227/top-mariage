<?php
require_once('config.php');

$cerereSQL = 'SELECT * FROM `categorii` WHERE `nume`="Galerie Foto"';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {
	$pagimgx = explode(".", $rand['pagimg']);
	if ($pagimgx[1] == 'swf') {
		$pagimg =
			'
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="609" height="239" title="Galerie Foto">
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

$cerereSQL = 'SELECT * FROM `categorii` WHERE `nume`="Galerie Foto" ';
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

echo '<p align="center"><font size="5"><b>Galerie Imagini</b></font></p>
	<p align="center"><img src="images/a.gif" alt=""></p>';

$intrari_totale2 = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `articole` WHERE `pag`="Galerie Foto"'));
if ($intrari_totale2 == 0) {
	echo '';
} else {
	$cerereSQL = 'SELECT * FROM `articole` WHERE `pag`="Galerie Foto"';
	$rezultat = mysqli_query($conexiune, $cerereSQL);
	while ($rand = mysqli_fetch_assoc($rezultat)) {
		echo '
							<p align="center"><font size="4"><b>' . $rand['titlu'] . '</b></font></p>
							<p align="justify">' . $rand['continut'] . '</p>
							<p>&nbsp;</p>
						';
	}
}

$rezultate_maxime = 12;
$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `imagini` WHERE `pentru`="galerie"'));

if ($intrari_totale == 0) {
	echo '<br><center><font color="darkred"><b>Nu exista inca nici un produs in baza de date !</b></font></center>';
} else {
	if (!isset($_GET['p'])) $pagina = 1;
	else $pagina = $_GET['p'];
	$nr = 0;
	$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
	$cerereSQL = 'SELECT * FROM `imagini` WHERE `pentru`="galerie" ORDER BY `nume` ASC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
	$rezultat = mysqli_query($conexiune, $cerereSQL);
	$pagini_totale = ceil($intrari_totale / $rezultate_maxime);
	if ($pagina > $pagini_totale) echo 'Pagina nu exista !';
	else {
		if ($pagini_totale > 0) {
			echo
			'<table width="100%" cellspacing="10" cellpadding="0" border="0">
					<tr>';

			while ($rand = mysqli_fetch_assoc($rezultat)) {
				$nr++;
				echo
				'<td align="center" width="185">
							<a href="galerie/' . $rand['path'] . '" rel="lightbox[galerie]" title="' . $rand['nume'] . '"><img src="galerie/thumb/' . $rand['path'] . '" width="100" alt=""></a><br>
							<a href="galerie/' . $rand['path'] . '" rel="lightbox[galerie]" title="' . $rand['nume'] . '"><u>' . $rand['nume'] . '</u></a>
						</td>';
				if ($nr % 3 == 0) echo '</tr><tr>';
			}

			echo '</tr></table>';

			if ($pagini_totale == 1) echo '<div align=left> </div>';
			else {

				echo '<div align="center">';

				for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
					if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
					else echo '<a href="galerie.php?p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
				}
				echo '</div>';
				echo '<table width="100%"><tr>
							<td align="left">';
				if ($pagina > 1) {
					$inapoi = ($pagina - 1);
					echo '<a href="galerie.php?p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
				}
				echo '</td>
							<td align="right">';
				if ($pagina < $pagini_totale) {
					$inainte = ($pagina + 1);
					echo '<a href="galerie.php?p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
				}
				echo '</td>
						  </tr></table>';
			}
		}
	}
}
echo '<p align="center"><img src="images/b.gif" alt=""></p>';

include('footer.php');
