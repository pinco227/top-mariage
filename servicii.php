<?php
require_once('config.php');
$pagimg = '<img src="page_img/home.gif" width="609" height="239" alt="">';

$cerereSQL = 'SELECT * FROM `categorii` WHERE `nume`="Servicii" ';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {
	$title = $rand['descriere'];
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

echo '
	<p align="center"><font size="5"><b>Servicii</b></font></p>
	<p align="center"><img src="images/a.gif" alt=""></p>';

$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `cat`="Servicii" ORDER BY `nrordine` ASC';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {
	echo '
				<p align="center"><a href="' . $rand['url'] . '">' . $rand['nume'] . '</a></p>
			';
}

echo '<p align="center"><img src="images/b.gif" alt=""></p>';

include('footer.php');
