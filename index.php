<?php
require_once('config.php');

$cerereSQL = 'SELECT * FROM `categorii` WHERE `nume`="Home"';
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
$cerereSQL = 'SELECT * FROM `categorii` WHERE `nume`="Home" ';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {
	$title = 'Top Mariage - ' . $rand['descriere'];
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

$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `imagini` WHERE `pentru`="home"'));
if ($intrari_totale == 0) {
	$intrari_totale2 = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `articole` WHERE `pag`="Home"'));
	if ($intrari_totale2 == 0) {
		echo '';
	} else {
		$cerereSQL = 'SELECT * FROM `articole` WHERE `pag`="Home"';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo '
				<p align="center"><font size="4"><b>' . $rand['titlu'] . '</b></font></p>
				<p align="justify">' . $rand['continut'] . '</p>
				<p>&nbsp;</p>
			';
		}
	}
} else {
	echo '
	<table width="600" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="center">
			<div id="articole">
			';
	$intrari_totale2 = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `articole` WHERE `pag`="Home"'));
	if ($intrari_totale2 == 0) {
		echo '';
	} else {
		$cerereSQL = 'SELECT * FROM `articole` WHERE `pag`="Home"';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo '
							<p align="center"><font size="4"><b>' . $rand['titlu'] . '</b></font></p>
							<p align="justify">' . $rand['continut'] . '</p>
							<p>&nbsp;</p>
						';
		}
	}
	echo
	'
			</div>
			';

	$cerereSQL = 'SELECT * FROM `imagini` WHERE `pentru`="home"';
	$rezultat = mysqli_query($conexiune, $cerereSQL);
	while ($rand = mysqli_fetch_assoc($rezultat)) {
		echo '
					<a href="home/' . $rand['path'] . '" rel="lightbox[Top Mariage]" title="' . $rand['nume'] . '"><img src="home/thumb/' . $rand['path'] . '" alt="" align="middle"></a>
				';
	}
	echo '
		</td>
	  </tr>
	</table>
	';
}
////////////// BUTOANE ////////////////////

$nr = 0;
$cerereSQL = 'SELECT * FROM `butonh` ORDER BY `id` ASC';
$rezultat = mysqli_query($conexiune, $cerereSQL);
echo
'<p></p>
						 <table width="100%" cellspacing="10" cellpadding="0" border="0">
							<tr>';

while ($rand = mysqli_fetch_assoc($rezultat)) {
	$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `categorii` WHERE `nume`="' . $rand['link'] . '" '));
	if ($intrari_totale == 0) {
		$cerereSQL2 = 'SELECT * FROM `subcategorii` WHERE `nume`="' . $rand['link'] . '"';
		$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
		while ($rand2 = mysqli_fetch_assoc($rezultat2)) {
			$link = $rand2['url'];
		}
	} else {
		$cerereSQL3 = 'SELECT * FROM `categorii` WHERE `nume`="' . $rand['link'] . '"';
		$rezultat3 = mysqli_query($conexiune, $cerereSQL3);
		while ($rand3 = mysqli_fetch_assoc($rezultat3)) {
			$link = $rand3['url'];
		}
	}
	$nr++;
	echo
	'<td align="center">
									<table width="130" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td width="130" height="15" colspan="3" background="images/chenar_01.gif"></td>
										</tr>
										<tr>
											<td width="15" height="75" background="images/chenar_02.gif"></td>
											<td width="100" height="75"><a href="' . $link . '"><img src="home/' . $rand['imagine'] . '" width="100" height="75" alt=""></a></td>
											<td width="15" height="75" background="images/chenar_04.gif"></td>
										</tr>
										<tr>
											<td width="130" height="30" colspan="3" align="center" valign="middle" background="images/chenar_05.gif"><a href="' . $link . '">' . $rand['nume'] . '</a></td>
										</tr>
									</table>
								</td>';
	if ($nr % 4 == 0) echo '</tr><tr><td></td></tr><tr>';
}
echo '</tr></table>';

echo '<p align="center"><img src="images/b.gif" alt=""></p>';

include('footer.php');
