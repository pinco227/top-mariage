<?php
require_once('config.php');
$pagimg = '<img src="page_img/home.gif" width="609" height="239" alt="">';
$cerereSQL = 'SELECT * FROM `anunturi` WHERE `id`="' . $_GET['id'] . '"';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {
	$title = 'Top Mariage - ' . $rand['titlu'] . '';
}
include('header.php');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$cerereSQL = 'SELECT * FROM `anunturi` WHERE `id`="' . $_GET['id'] . '"';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {

	echo '
				<p align="center"><font size="5"><b>' . $rand['titlu'] . '</b></font></p>
				<p align="center"><img src="images/a.gif" alt=""></p>
				<p align="center"><img src="anunturi/' . $rand['imagine'] . '" alt=""></p>
				<p align="justify">' . $rand['continut'] . '</p>';
}

echo '<p align="center"><img src="images/b.gif" alt=""></p>';

include('footer.php');
