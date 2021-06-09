<?php
require_once('config.php');

$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Invitatii"';
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

if (isset($_GET['page']) && ($_GET['page'] == "prod")) {
	$cerereSQL3 = 'SELECT * FROM `subcategorii` WHERE `nume`="Invitatii" ';
	$rezultat3 = mysqli_query($conexiune, $cerereSQL3);
	while ($rand3 = mysqli_fetch_assoc($rezultat3)) {
		$cerereSQL4 = "SELECT * FROM `produse` WHERE `id`='" . $_GET['id'] . "' ";
		$rezultat4 = mysqli_query($conexiune, $cerereSQL4);
		while ($rand = mysqli_fetch_assoc($rezultat4)) {
			$title = $rand['nume'] . ' - ' . $rand3['descriere'];
		}
	}
	$_SESSION['title'] = $title;

	include('header.php');

	$cerereSQL = 'SELECT * FROM `produse` WHERE `id`="' . $_GET['id'] . '"';
	$rezultat = mysqli_query($conexiune, $cerereSQL);

	while ($rand = mysqli_fetch_assoc($rezultat)) {

		$poza = 'invitatii/' . $rand['imagine'];
		list($width, $height) = getimagesize($poza);
		$maxwidth = '545';

		if ($width > $maxwidth) {
			$picwidth = $maxwidth;
			$picheight = round($height / ($width / $maxwidth));
		} else {
			$picwidth = $width;
			$picheight = $height;
		}

		$pretrol = $rand['pret'] * 10000;
		echo '
			<form action="invitatii.php?page=nunta" method="post">
			<p align="center"><font size="5"><b>' . $rand['nume'] . '</b></font></p>
			<input name="nume" type="hidden" value="' . $rand['nume'] . '">
			<p align="center"><img src="images/a.gif" alt=""></p>
			<p align="center"><img src="' . $poza . '" alt="' . $rand['nume'] . '" width="' . $picwidth . '" height="' . $picheight . '" /></p>
			<p align="center" style="padding-left:20px; padding;right:20px;">' . $rand['desc'] . '</p>
			<p align="center"><font size="3">Pret : <b>' . $rand['pret'] . '</b> RON / <b>' . $pretrol . '</b> ROL</font></p>
			<input name="pret" type="hidden" value="' . $rand['pret'] . '">
			<p align="center"><input name="Personalizeaza" type="submit" value="Personalizeaza si comanda !"></a></p>
			<p align="center"><img src="images/b.gif" alt=""></p>
			</form>
		';
	}
} elseif (isset($_GET['page']) && ($_GET['page'] == "nunta")) {
	if (isset($_SESSION['title'])) {
		$title = $_SESSION['title'];
	} else {
		$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Invitatii" ';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$title = $rand['descriere'];
		}
	}
	include('header.php');

	if ((!isset($_POST['nume'])) || (!isset($_POST['pret']))) {
		echo '<p align="center"><font size="5" color="red"><b>ERROR !</b></font></p>
		<p align="center"><img src="images/a.gif" alt=""></p>
		<p align="center"><font color="red">';
		if (!isset($_POST['nume'])) echo 'Nu ati ales nici un produs !<br>';
		if (!isset($_POST['pret'])) echo 'Produsul nu este disponibil !';
		echo '</font></p>
		<p align="center"><img src="images/b.gif" alt=""></p>';
	} else {
		$_SESSION['numep'] = $_POST['nume'];
		$_SESSION['pretp'] = $_POST['pret'];

		echo '
			<form action="invitatii.php?page=pers" method="post">
				<p align="center"><font size="5"><b>Date despre nunta</b></font></p>
				<p align="center"><font color="#999999">Va rugam sa completati exact cum doriti sa apara in invitatie !</font></p>
				<p align="center"><img src="images/a.gif" alt=""></p>
				<table width="500" border="0" align="center" cellpading="2" cellspacing="3">
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Mireasa</i></b></font>
						</td>
					</tr>
						<tr>
							<td align="right" width="150">
								Prenume :
							</td>
							<td align="left">
								<input name="PrenMireasa" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Nume :
							</td>
							<td align="left">
								<input name="NumeMireasa" maxlength="50" size="30">
							</td>
						</tr>
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Mire</i></b></font>
						</td>
					</tr>
						<tr>
							<td align="right">
								Prenume :
							</td>
							<td align="left">
								<input name="PrenMire" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Nume :
							</td>
							<td align="left">
								<input name="NumeMire" maxlength="50" size="30">
							</td>
						</tr>
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Nasi</i></b></font>
						</td>
					</tr>
						<tr>
							<td align="right">
								Prenumele nasei :
							</td>
							<td align="left">
								<input name="PrenNasa" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Prenumele si numele nasului :
							</td>
							<td align="left">
								<input name="PreNumeNas" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Prenumele nasei :
							</td>
							<td align="left">
								<input name="PrenNasa2" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Prenumele si numele nasului :
							</td>
							<td align="left">
								<input name="PreNumeNas2" maxlength="50" size="30">
							</td>
						</tr>
				</table>
				<table width="500" border="0" align="center" cellpading="2" cellspacing="3">
					<tr>
						<td colspan="3" align="left">
							<font size="4"><b><i>Parinti</i></b></font>
						</td>
					</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" align="center">
								<font color="#999999">Bifati casuta "dec" din dreptul parintelui decedat, daca este cazul.</font>
							</td>
						</tr>
						<tr>
							<td rowspan="3" align="right" valign="top" width="100">
								<b><u>Mireasa</u></b>
							</td>
							<td width="120" align="right">
								Prenumele mamei :
							</td>
							<td>
								<input name="PreMama" maxlength="50" size="20">
							</td>
						</tr>
						<tr>
							<td align="right">
								Prenumele tatalui :
							</td>
							<td>
								<input name="PreTata" maxlength="50" size="20">
							</td>
						</tr>
						<tr>
							<td align="right">
								Nume parinti :
							</td>
							<td>
								<input name="NumePar" maxlength="50" size="20">
							</td>
						</tr>
						<tr>
							<td rowspan="3" align="right" valign="top">
								<b><u>Mire</u></b>
							</td>
							<td align="right">
								Prenumele mamei :
							</td>
							<td>
								<input name="PreMama2" maxlength="50" size="20">
							</td>
						</tr>
						<tr>
							<td align="right">
								Prenumele tatalui :
							</td>
							<td>
								<input name="PreTata2" maxlength="50" size="20">
							</td>
						</tr>
						<tr>
							<td align="right">
								Nume parinti :
							</td>
							<td>
								<input name="NumePar2" maxlength="50" size="20">
							</td>
						</tr>
				</table>
				<table width="500" border="0" align="center" cellpading="2" cellspacing="3">
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Cununia Religioasa</i></b></font>
						</td>
					</tr>
						<tr>
							<td align="right" width="150">
								Data cununiei religioase :
							</td>
							<td align="left">
								<select name="ziua">
									<option selected="selected" value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
								</select>
								<select name="luna">
									<option selected="selected" value="1">Ianuarie</option>
									<option value="2">Februarie</option>
									<option value="3">Martie</option>
									<option value="4">Aprilie</option>
									<option value="5">Mai</option>
									<option value="6">Iunie</option>
									<option value="7">Iulie</option>
									<option value="8">August</option>
									<option value="9">Septembrie</option>
									<option value="10">Octombrie</option>
									<option value="11">Noiembrie</option>
									<option value="12">Decembrie</option>
								</select>
								<select name="anul">
									<option selected="selected" value="2007">2007</option>
									<option value="2008">2008</option>
									<option value="2009">2009</option>
									<option value="2010">2010</option>
									<option value="2011">2011</option>
									<option value="2012">2012</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">
								Ora cununie :
							</td>
							<td align="left">
								<select name="ora">
									<option selected="selected" value="8:00">8:00</option>
									<option value="8:30">8:30</option>
									<option value="9:00">9:00 </option>
									<option value="9:30">9:30</option>
									<option value="10:00">10:00</option>
									<option value="10:30">10:30 </option>
									<option value="11:00">11:00</option>
									<option value="11:30">11:30</option>
									<option value="12:00">12:00</option>
									<option value="12:30">12:30</option>
									<option value="13:00">13:00 </option>
									<option value="13:30">13:30</option>
									<option value="14:00">14:00</option>
									<option value="14:30">14:30 </option>
									<option value="15:00">15:00</option>
									<option value="15:30">15:30</option>
									<option value="16:00">16:00</option>
									<option value="16:30">16:30</option>
									<option value="17:00">17:00 </option>
									<option value="17:30">17:30</option>
									<option value="18:00">18:00</option>
									<option value="18:30">18:30 </option>
									<option value="19:00">19:00</option>
									<option value="19:30">19:30</option>
									<option value="20:00">20:00</option>
									<option value="20:30">20:30</option>
									<option value="21:00">21:00 </option>
									<option value="21:30">21:30</option>
									<option value="22:00">22:00</option>
									<option value="22:30">22:30 </option>
									<option value="23:00">23:00</option>
									<option value="23:30">23:30</option>
									<option value="0:00">0:00</option>
									<option value="0:30">0:30 </option>
									<option value="1:00">1:00 </option>
									<option value="1:30">1:30</option>
									<option value="2:00">2:00</option>
									<option value="2:30">2:30 </option>
									<option value="3:00">3:00</option>
									<option value="3:30">3:30</option>
									<option value="4:00">4:00</option>
									<option value="4:30">4:30</option>
									<option value="5:00">5:00 </option>
									<option value="5:30">5:30</option>
									<option value="6:00">6:00</option>
									<option value="6:30">6:30 </option>
									<option value="7:00">7:00</option>
									<option value="7:30">7:30</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">
								Biserica :
							</td>
							<td align="left">
								<input name="Biserica" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Adresa :
							</td>
							<td align="left">
								<input name="AdresaB" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Localitatea :
							</td>
							<td align="left">
								<input name="LocB" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Judet :
							</td>
							<td align="left">
								<select name="JudetB">
									<option>alege</option>
									<option value="1">Alba</option>
									<option value="2">Arad</option>
									<option value="3">Arges</option>
									<option value="4">Bacau</option>
									<option value="5">Bihor</option>
									<option value="6">Bistrita</option>
									<option value="7">Botosani</option>
									<option value="8">Braila</option>
									<option value="9">Brasov</option>
									<option value="25">Bucuresti</option>
									<option value="10">Buzau</option>
									<option value="11">Calarasi</option>
									<option value="12">Caras Severin</option>
									<option value="13">Cluj</option>
									<option value="14">Constanta</option>
									<option value="15">Covasna</option>
									<option value="16">Dambovita</option>
									<option value="17">Dolj</option>
									<option value="18">Galati</option>
									<option value="19">Giurgiu</option>
									<option value="20">Gorj</option>
									<option value="21">Harghita</option>
									<option value="22">Hunedoara</option>
									<option value="23">Ialomita</option>
									<option value="24">Iasi</option>
									<option value="42">International</option>
									<option value="26">Maramures</option>
									<option value="27">Mehedinti</option>
									<option value="28">Mures</option>
									<option value="29">Neamt</option>
									<option value="30">Olt</option>
									<option value="31">Prahova</option>
									<option value="32">Salaj</option>
									<option value="33">Satu Mare</option>
									<option value="34">Sibiu</option>
									<option value="35">Suceava</option>
									<option value="36">Teleorman</option>
									<option value="37">Timis</option>
									<option value="38">Tulcea</option>
									<option value="39">Valcea</option>
									<option value="40">Vaslui</option>
									<option value="41">Vrancea</option>
								</select>
							</td>
						</tr>
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Receptia</i></b></font>
						</td>
					</tr>
						<tr>
							<td align="right" width="150">
								Data nuntii :
							</td>
							<td align="left">
								<select name="ziua2">
									<option selected="selected" value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
								</select>
								<select name="luna2">
									<option selected="selected" value="1">Ianuarie</option>
									<option value="2">Februarie</option>
									<option value="3">Martie</option>
									<option value="4">Aprilie</option>
									<option value="5">Mai</option>
									<option value="6">Iunie</option>
									<option value="7">Iulie</option>
									<option value="8">August</option>
									<option value="9">Septembrie</option>
									<option value="10">Octombrie</option>
									<option value="11">Noiembrie</option>
									<option value="12">Decembrie</option>
								</select>
								<select name="anul2">
									<option selected="selected" value="2007">2007</option>
									<option value="2008">2008</option>
									<option value="2009">2009</option>
									<option value="2010">2010</option>
									<option value="2011">2011</option>
									<option value="2012">2012</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">
								Ora nuntii :
							</td>
							<td align="left">
								<select name="ora2">
									<option selected="selected" value="8:00">8:00</option>
									<option value="8:30">8:30</option>
									<option value="9:00">9:00 </option>
									<option value="9:30">9:30</option>
									<option value="10:00">10:00</option>
									<option value="10:30">10:30 </option>
									<option value="11:00">11:00</option>
									<option value="11:30">11:30</option>
									<option value="12:00">12:00</option>
									<option value="12:30">12:30</option>
									<option value="13:00">13:00 </option>
									<option value="13:30">13:30</option>
									<option value="14:00">14:00</option>
									<option value="14:30">14:30 </option>
									<option value="15:00">15:00</option>
									<option value="15:30">15:30</option>
									<option value="16:00">16:00</option>
									<option value="16:30">16:30</option>
									<option value="17:00">17:00 </option>
									<option value="17:30">17:30</option>
									<option value="18:00">18:00</option>
									<option value="18:30">18:30 </option>
									<option value="19:00">19:00</option>
									<option value="19:30">19:30</option>
									<option value="20:00">20:00</option>
									<option value="20:30">20:30</option>
									<option value="21:00">21:00 </option>
									<option value="21:30">21:30</option>
									<option value="22:00">22:00</option>
									<option value="22:30">22:30 </option>
									<option value="23:00">23:00</option>
									<option value="23:30">23:30</option>
									<option value="0:00">0:00</option>
									<option value="0:30">0:30 </option>
									<option value="1:00">1:00 </option>
									<option value="1:30">1:30</option>
									<option value="2:00">2:00</option>
									<option value="2:30">2:30 </option>
									<option value="3:00">3:00</option>
									<option value="3:30">3:30</option>
									<option value="4:00">4:00</option>
									<option value="4:30">4:30</option>
									<option value="5:00">5:00 </option>
									<option value="5:30">5:30</option>
									<option value="6:00">6:00</option>
									<option value="6:30">6:30 </option>
									<option value="7:00">7:00</option>
									<option value="7:30">7:30</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">
								Localul :
							</td>
							<td align="left">
								<input name="Local" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Adresa :
							</td>
							<td align="left">
								<input name="AdresaN" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Localitatea :
							</td>
							<td align="left">
								<input name="LocN" maxlength="50" size="30">
							</td>
						</tr>
						<tr>
							<td align="right">
								Judet :
							</td>
							<td align="left">
								<select name="JudetN">
									<option>alege</option>
									<option value="1">Alba</option>
									<option value="2">Arad</option>
									<option value="3">Arges</option>
									<option value="4">Bacau</option>
									<option value="5">Bihor</option>
									<option value="6">Bistrita</option>
									<option value="7">Botosani</option>
									<option value="8">Braila</option>
									<option value="9">Brasov</option>
									<option value="25">Bucuresti</option>
									<option value="10">Buzau</option>
									<option value="11">Calarasi</option>
									<option value="12">Caras Severin</option>
									<option value="13">Cluj</option>
									<option value="14">Constanta</option>
									<option value="15">Covasna</option>
									<option value="16">Dambovita</option>
									<option value="17">Dolj</option>
									<option value="18">Galati</option>
									<option value="19">Giurgiu</option>
									<option value="20">Gorj</option>
									<option value="21">Harghita</option>
									<option value="22">Hunedoara</option>
									<option value="23">Ialomita</option>
									<option value="24">Iasi</option>
									<option value="42">International</option>
									<option value="26">Maramures</option>
									<option value="27">Mehedinti</option>
									<option value="28">Mures</option>
									<option value="29">Neamt</option>
									<option value="30">Olt</option>
									<option value="31">Prahova</option>
									<option value="32">Salaj</option>
									<option value="33">Satu Mare</option>
									<option value="34">Sibiu</option>
									<option value="35">Suceava</option>
									<option value="36">Teleorman</option>
									<option value="37">Timis</option>
									<option value="38">Tulcea</option>
									<option value="39">Valcea</option>
									<option value="40">Vaslui</option>
									<option value="41">Vrancea</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">
								Observatii :
							</td>
							<td align="left">
								<textarea name="Observatii" cols="32" rows="4"></textarea>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input name="Submit" value="Pasul urmator" type="submit">
							</td>
						</tr>
				</table>
				<p align="center"><img src="images/b.gif" alt=""></p>
			</form>
		';
	}
} elseif (isset($_GET['page']) && ($_GET['page'] == "pers")) {
	if (isset($_SESSION['title'])) {
		$title = $_SESSION['title'];
	} else {
		$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Invitatii" ';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$title = $rand['descriere'];
		}
	}
	include('header.php');

	if (!isset($_POST['Submit'])) {
		echo '<p align="center"><font size="5" color="red"><b>ERROR !</b></font></p>
		<p align="center"><img src="images/a.gif" alt=""></p>
		<p align="center"><font color="red">
		Nu ati completat unele campuri !
		</font></p>
		<p align="center"><img src="images/b.gif" alt=""></p>';
	} else {
		$_SESSION['PrenMireasa'] = $_POST['PrenMireasa'];
		$_SESSION['NumeMireasa'] = $_POST['NumeMireasa'];
		$_SESSION['PrenMire'] = $_POST['PrenMire'];
		$_SESSION['NumeMire'] = $_POST['NumeMire'];
		$_SESSION['PrenNasa'] = $_POST['PrenNasa'];
		$_SESSION['PreNumeNas'] = $_POST['PreNumeNas'];
		$_SESSION['PrenNasa2'] = $_POST['PrenNasa2'];
		$_SESSION['PreNumeNas2'] = $_POST['PreNumeNas2'];
		$_SESSION['PreMama'] = $_POST['PreMama'];
		$_SESSION['PreTata'] = $_POST['PreTata'];
		$_SESSION['NumePar'] = $_POST['NumePar'];
		$_SESSION['PreMama2'] = $_POST['PreMama2'];
		$_SESSION['PreTata2'] = $_POST['PreTata2'];
		$_SESSION['NumePar2'] = $_POST['NumePar2'];
		$_SESSION['ziua'] = $_POST['ziua'];
		$_SESSION['luna'] = $_POST['luna'];
		$_SESSION['anul'] = $_POST['anul'];
		$_SESSION['ora'] = $_POST['ora'];
		$_SESSION['Biserica'] = $_POST['Biserica'];
		$_SESSION['AdresaB'] = $_POST['AdresaB'];
		$_SESSION['LocB'] = $_POST['LocB'];
		$_SESSION['JudetB'] = $_POST['JudetB'];
		$_SESSION['ziua2'] = $_POST['ziua2'];
		$_SESSION['luna2'] = $_POST['luna2'];
		$_SESSION['anul2'] = $_POST['anul2'];
		$_SESSION['ora2'] = $_POST['ora2'];
		$_SESSION['Local'] = $_POST['Local'];
		$_SESSION['AdresaN'] = $_POST['AdresaN'];
		$_SESSION['LocN'] = $_POST['LocN'];
		$_SESSION['JudetN'] = $_POST['JudetN'];
		$_SESSION['Observatii'] = $_POST['Observatii'];

		echo '
			<SCRIPT language=javascript>
		
				SetCaractere = new Array (7);
				SetCaractere[1] = "Caracter1.gif";
				SetCaractere[2] = "Caracter2.gif";
				SetCaractere[3] = "Caracter3.gif";
				SetCaractere[4] = "Caracter4.gif";
				SetCaractere[5] ="Caracter5.gif";
				SetCaractere[6] = "Caracter6.gif";
				SetCaractere[7] = "Caracter7.gif";
				
				 function SchimbareTipCaracter(textColor,indexCuloare)
				  { 
					Index = indexCuloare + 1;
					document.ImagineCaracter.src = "invitatii/caracter/" + SetCaractere[Index];
				  }
			  
			</SCRIPT>
			<script language="javascript">
				
					Culoare = new Array (17);
						Culoare[1] = "negru.gif";
						Culoare[2] = "auriu.gif";
						Culoare[3] = "mov.gif";
						Culoare[4] = "argintiu.gif";
						Culoare[5] = "albastru.gif";
						Culoare[6] = "bordo.gif";
						Culoare[7] = "maro roscat.gif";
						Culoare[8] = "caramiziu inchis.gif";
						Culoare[9] = "albastru inchis.gif";
						Culoare[10] = "maro inchis.gif";
						Culoare[11] = "caramiziu deschis.gif";
						Culoare[12] = "bordo roscat.gif";
						Culoare[13] = "albastru cyan.gif";
						Culoare[14] = "maro roscat deschis.gif";
						Culoare[15] = "maro pal.gif";
						Culoare[16] = "gri inchis.gif";
						Culoare[17] = "verde inchis.gif";
		
					 function SchimbareCuloare(textColor,indexCuloare)
					  { 
						Index = indexCuloare + 1;
						document.ImagineTextColor.src = "invitatii/caracter/" + Culoare[Index];
					  }
			</script>
			<form action="invitatii.php?page=factura" method="post" name="FormularText">
				<p align="center"><font size="5"><b>Personalizare invitatii</b></font></p>
				<p align="center"><img src="images/a.gif" alt=""></p>
				<table width="500" border="0" align="center" cellpading="2" cellspacing="3">
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Cantitate</i></b></font>
						</td>
					</tr>
						<tr>
							<td align="right" width="150">&nbsp;</td>
							<td align="left">
								<select name="Cantitate">
									<option value="30">30 buc. = ' . $_SESSION['pretp'] * 30 . ' RON</option>
									<option value="40">40 buc. = ' . $_SESSION['pretp'] * 40 . ' RON</option>
									<option value="50">50 buc. = ' . $_SESSION['pretp'] * 50 . ' RON</option>
									<option value="60">60 buc. = ' . $_SESSION['pretp'] * 60 . ' RON</option>
									<option value="70">70 buc. = ' . $_SESSION['pretp'] * 70 . ' RON</option>
									<option value="80">80 buc. = ' . $_SESSION['pretp'] * 80 . ' RON</option>
									<option value="90">90 buc. = ' . $_SESSION['pretp'] * 90 . ' RON</option>
									<option value="100">100 buc. = ' . $_SESSION['pretp'] * 100 . ' RON</option>
									<option value="125">125 buc. = ' . $_SESSION['pretp'] * 125 . ' RON</option>
									<option value="150">150 buc. = ' . $_SESSION['pretp'] * 150 . ' RON</option>
									<option value="175">175 buc. = ' . $_SESSION['pretp'] * 175 . ' RON</option>
									<option value="200">200 buc. = ' . $_SESSION['pretp'] * 200 . ' RON</option>
									<option value="225">225 buc. = ' . $_SESSION['pretp'] * 225 . ' RON</option>
									<option value="250">250 buc. = ' . $_SESSION['pretp'] * 250 . ' RON</option>
									<option value="275">275 buc. = ' . $_SESSION['pretp'] * 275 . ' RON</option>
									<option value="300">300 buc. = ' . $_SESSION['pretp'] * 300 . ' RON</option>
									<option value="325">325 buc. = ' . $_SESSION['pretp'] * 325 . ' RON</option>
									<option value="350">350 buc. = ' . $_SESSION['pretp'] * 350 . ' RON</option>
									<option value="375">375 buc. = ' . $_SESSION['pretp'] * 375 . ' RON</option>
									<option value="400">400 buc. = ' . $_SESSION['pretp'] * 400 . ' RON</option>
									<option value="425">425 buc. = ' . $_SESSION['pretp'] * 425 . ' RON</option>
									<option value="450">450 buc. = ' . $_SESSION['pretp'] * 450 . ' RON</option>
									<option value="475">475 buc. = ' . $_SESSION['pretp'] * 475 . ' RON</option>
									<option value="500">500 buc. = ' . $_SESSION['pretp'] * 500 . ' RON</option>
								</select>
							</td>
						</tr>
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Tip caracter</i></b></font>
						</td>
					</tr>
						<tr>
							<td align="right">&nbsp;</td>
							<td align="left">
								<select name="TipCaracter" onchange="SchimbareTipCaracter(\'ImagineCaracter\', this.selectedIndex)">
									<option selected="selected" value="Caracter1">Caracter 1</option>
									<option value="Caracter2">Caracter 2</option>
									<option value="Caracter3">Caracter 3</option>
									<option value="Caracter4">Caracter 4</option>
									<option value="Caracter5">Caracter 5</option>
									<option value="Caracter6">Caracter 6</option>
									<option value="Caracter7">Caracter 7</option>
								</select>&nbsp;
								<img alt="Mostra tip caracter" name="ImagineCaracter" src="invitatii/caracter/Caracter1.gif" align="middle" border="0" height="32" width="150">
							</td>
						</tr>
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Culoare text</i></b></font>
						</td>
					</tr>
						<tr>
							<td align="right">&nbsp;</td>
							<td align="left">
								<select name="CuloareText" onchange="SchimbareCuloare(\'ImagineTextColor\', this.selectedIndex)" size="1">
									<option selected="selected" value="Negru">Negru</option>
									<option value="Auriu">Auriu</option>
									<option value="Mov">Mov</option>
									<option value="Argintiu">Argintiu</option>
									<option value="Albastru">Albastru</option>
									<option value="Bordo">Bordo</option>
									<option value="Maro roscat">Maro roscat</option>
									<option value="Caramiziu inchis">Caramiziu inchis</option>
									<option value="Albastru inchis">Albastru inchis</option>
									<option value="Maro inchis">Maro inchis</option>
									<option value="Caramiziu deschis">Caramiziu deschis</option>
									<option value="Bordo roscat">Bordo roscat</option>
									<option value="Albastru cyan">Albastru cyan</option>
									<option value="Maro roscat deschis">Maro roscat deschis</option>
									<option value="Maro pal">Maro pal</option>
									<option value="Gri inchis">Gri inchis</option>
									<option value="Verde inchis">Verde inchis</option>
								</select>
								<img alt="Culoare text" name="ImagineTextColor" src="invitatii/caracter/negru.gif" align="top" border="0" height="32" width="150">
							</td>
						</tr>
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Model text</i></b></font>
						</td>
					</tr>
						<tr>
							<td>&nbsp;</td>
							<td> 
								<select name="InvText" onchange="CompletRind()">
									<option selected="selected" value="Text1">Text 1</option> 
									<option value="Text2">Text 2</option>
									<option value="Text3">Text 3</option> 
									<option value="Text4">Text 4</option>
									<option value="Text5">Text 5</option> 
									<option value="Text6">Text 6</option>
									<option value="Text7">Text 7</option> 
									<option value="Text8">Text 8</option>
									<option value="Text9">Text 9</option> 
									<option value="Text10">Text 10</option> 
									<option value="Text11">Text 11</option>
									<option value="Text12">Text 12</option> 
									<option value="Text13">Text 13</option>
									<option value="Text14">Text 14</option> 
									<option value="Text15">Text 15</option>
									<option value="Text16">Text 16</option> 
									<option value="Text17">Text 17</option>
									<option value="Text18">Text 18</option>
									<option value="Text19">Textul dumneavoastra</option> 
								</select>  <br>
								<a href="javascript:void(0)" onclick="TextulAnterior()">&laquo; Textul anterior</a> |
								<a href="javascript:void(0)" onclick="TextulUrmator()">Textul urmator &raquo;</a>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText1" onchange="SchimbaText()" size="68">
								<input name="CimpuriText" value="InvText1" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText2" onchange="SchimbaText()" size="68">
								<input name="CimpuriText" value="InvText2" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText3" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText3" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText4" onchange="SchimbaText()" size="68">
								<input name="CimpuriText" value="InvText4" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText5" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText5" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText6" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText6" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText7" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText7" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText8" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText8" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText9" onchange="SchimbaText()" size="68">
								<input name="CimpuriText" value="InvText9" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText10" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText10" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText11" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText11" type="hidden"> </td></tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText12" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText12" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText13" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText13" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText14" onchange="SchimbaText()" size="68">
								<input name="CimpuriText" value="InvText14" type="hidden">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
							   <input maxlength="100" name="InvText15" onchange="SchimbaText()" size="68"> 
							   <input name="CimpuriText" value="InvText15" type="hidden">
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input maxlength="100" name="InvText16" onchange="SchimbaText()" size="68"> 
								<input name="CimpuriText" value="InvText16" type="hidden">
							</td>
						</tr>
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Motto</i></b></font>
						</td>
					</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<select name="InvMotto" onchange="CompletMotto()">
									<option selected="selected" value="Motto1">Textul dumneavoastra</option>
									<option value="Motto2">M2</option>
									<option value="Motto3">M3</option>
									<option value="Motto4">M4</option>
									<option value="Motto5">M5</option>
									<option value="Motto6">M6</option>
									<option value="Motto7">M7</option>
									<option value="Motto8">M8</option>
									<option value="Motto9">M9</option>
									<option value="Motto10">M10</option>
									<option value="Motto11">M11</option>
									<option value="Motto12">M12</option>
									<option value="Motto13">M13</option>
									<option value="Motto14">M14</option>
									<option value="Motto15">M15</option>
									<option value="Motto16">M16</option>
									<option value="Motto17">M17</option>
									<option value="Motto18">M18</option>
								</select>
								<input name="SelectieMotto" value="InvMotto" type="hidden">
								<br>
								<a href="javascript:void(0)" onclick="MottoAnterior()">&laquo; Motto-ul anterior</a> | 
								<a href="javascript:void(0)" onclick="UrmatorulMotto()">Motto-ul urmator &raquo;</a> 
							</td>
						</tr>
						<tr> 
							<td>&nbsp;</td>
							<td> 
								<input maxlength="100" name="InvMotto1" onchange="SchimbaMotto()" size="68">
								<input name="CimpuriText" value="InvMotto1" type="hidden">
							</td>
						</tr>
						<tr> 
							<td>&nbsp;</td>
							<td> 
								<input maxlength="100" name="InvMotto2" onchange="SchimbaMotto()" size="68">
								<input name="CimpuriText" value="InvMotto2" type="hidden">
							</td>
						</tr>
						<tr> 
							<td>&nbsp;</td>
							<td> 
								<input maxlength="100" name="InvMotto3" onchange="SchimbaMotto()" size="68">
								<input name="CimpuriText" value="InvMotto3" type="hidden">
							</td>
						</tr>
						<tr> 
							<td>&nbsp;</td>
							<td> 
								<input maxlength="100" name="InvMotto4" onchange="SchimbaMotto()" size="68">
								<input name="CimpuriText" value="InvMotto4" type="hidden">
							</td>
						</tr>
						<tr> 
							<td>&nbsp;</td>
							<td> 
								<input maxlength="100" name="InvMotto5" onchange="SchimbaMotto()" size="68">
								<input name="CimpuriText" value="InvMotto5" type="hidden">
							</td>
						</tr>
						<tr> 
							<td>&nbsp;</td>
							<td> 
								<input maxlength="100" name="InvMotto6" onchange="SchimbaMotto()" size="68">
								<input name="CimpuriText" value="InvMotto6" type="hidden">
							</td>
						</tr>
						<script language="JavaScript">CompletMottoOnLoad()</script>
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Livrare</i></b></font>
						</td>
					</tr>
						<tr>
							<td></td>
							<td>
								<label><input name="posta" value="Posta" type="radio" checked="checked"></label>
								Prin Posta (5 RON)
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<label><input name="posta" value="Prioripost" type="radio"></label>
								Prin Prioripost (20 RON)
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<label><input name="posta" value="Curier" type="radio"></label>
								Prin Curier Rapid (20 RON)
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<label><input name="posta" value="Domiciliu" type="radio"></label>
								Prin livrare la domiciliu (doar in Iasi - gratuit)
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input name="Submit" value="Pasul urmator" type="submit">
							</td>
						</tr>
				</table>
				<p align="center"><img src="images/b.gif" alt=""></p>
			</form>
		';
	}
} elseif (isset($_GET['page']) && ($_GET['page'] == "factura")) {
	if (isset($_SESSION['title'])) {
		$title = $_SESSION['title'];
	} else {
		$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Invitatii" ';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$title = $rand['descriere'];
		}
	}
	include('header.php');

	if ((!isset($_POST['Submit']))) {
		echo '<p align="center"><font size="5" color="red"><b>ERROR !</b></font></p>
		<p align="center"><img src="images/a.gif" alt=""></p>
		<p align="center"><font color="red">
		Nu ati completat unele campuri !
		</font></p>
		<p align="center"><img src="images/b.gif" alt=""></p>';
	} else {
		$_SESSION['cantitate'] = $_POST['Cantitate'];
		$_SESSION['pret'] = $_POST['Cantitate'] * $_SESSION['pretp'];
		$_SESSION['TipCaracter'] = $_POST['TipCaracter'];
		$_SESSION['CuloareText'] = $_POST['CuloareText'];
		$_SESSION['InvText'] = $_POST['InvText'];
		$_SESSION['InvMotto'] = $_POST['InvMotto'];
		$text =
			$_POST['InvText1'] . '<br>
			' . $_POST['InvText2'] . '<br>
			' . $_POST['InvText3'] . '<br>
			' . $_POST['InvText4'] . '<br>
			' . $_POST['InvText5'] . '<br>
			' . $_POST['InvText6'] . '<br>
			' . $_POST['InvText7'] . '<br>
			' . $_POST['InvText8'] . '<br>
			' . $_POST['InvText9'] . '<br>
			' . $_POST['InvText10'] . '<br>
			' . $_POST['InvText11'] . '<br>
			' . $_POST['InvText12'] . '<br>
			' . $_POST['InvText13'] . '<br>
			' . $_POST['InvText14'] . '<br>
			' . $_POST['InvText15'] . '<br>
			' . $_POST['InvText16'];
		$_SESSION['Text'] = $text;
		$motto =
			$_POST['InvMotto1'] . '<br>
			' . $_POST['InvMotto2'] . '<br>
			' . $_POST['InvMotto3'] . '<br>
			' . $_POST['InvMotto4'] . '<br>
			' . $_POST['InvMotto5'] . '<br>
			' . $_POST['InvMotto6'];
		$_SESSION['Motto'] = $motto;
		$_SESSION['posta'] = $_POST['posta'];

		if ($_SESSION['posta'] == 'Posta') $postap = '5';
		elseif ($_SESSION['posta'] == 'Prioripost') $postap = '20';
		elseif ($_SESSION['posta'] == 'Curier') $postap = '20';
		elseif ($_SESSION['posta'] == 'Domiciliu') $postap = '0';
		else {
		}
		$_SESSION['postap'] = $postap;
		$total = $_SESSION['pret'] + $_SESSION['postap'];
		$_SESSION['total'] = $total;

		if (isset($_SESSION['Nume'])) $nume = $_SESSION['Nume'];
		else $nume = '';
		if (isset($_SESSION['Adresa'])) $adresa = $_SESSION['Adresa'];
		else $adresa = '';
		if (isset($_SESSION['Oras'])) $oras = $_SESSION['Oras'];
		else $oras = '';
		if (isset($_SESSION['cod_postal'])) $cod_postal = $_SESSION['cod_postal'];
		else $cod_postal = '';
		if (isset($_SESSION['CNP'])) $cnp = $_SESSION['CNP'];
		else $cnp = '';
		if (isset($_SESSION['Mail'])) $mail = $_SESSION['Mail'];
		else $mail = '';
		if (isset($_SESSION['Tel'])) $tel = $_SESSION['Tel'];
		else $tel = '';

		echo '
			<form action="invitatii.php?page=finish" method="post" name="FormularText">
				<p align="center"><font size="5"><b>Factura</b></font></p>
				<p align="center"><img src="images/a.gif" alt=""></p>
				<table width="500" border="0" align="center" cellpading="2" cellspacing="1" style="font-size:9px;">
					<tr>
						<td width="100" align="left"><strong>Produs</strong></td>
						<td align="center"><strong>Text</strong></td>
						<td width="20" align="left"><strong>Cant.</strong></td>
						<td width="20" align="left"><strong>Pret<br>Buc.</strong></td>
						<td width="20" align="left"><strong>Total<br>RON</strong></td>
					</tr>
					<tr>
					  <td align="left" valign="top" bgcolor="#DCFFA8">Invitatii / ' . $_SESSION['numep'] . '</td>
					  <td align="center" valign="top" bgcolor="#DCFFA8">' . $_SESSION['Text'] . '<br />
					  <br />
					  Motto:<br />' . $_SESSION['Motto'] . '</td>
					  <td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['cantitate'] . '</td>
					  <td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['pretp'] . '</td>
					  <td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['pret'] . '</td>
				  </tr>
					<tr>
					  <td height="26" align="left" bgcolor="#B7DB6C">Transport</td>
					  <td align="left" bgcolor="#B7DB6C">&nbsp;</td>
					  <td align="left" bgcolor="#B7DB6C">&nbsp;</td>
					  <td align="left" bgcolor="#B7DB6C">&nbsp;</td>
					  <td align="left" bgcolor="#B7DB6C">' . $postap . '</td>
				  </tr>
					<tr>
					  <td align="left" bgcolor="#DCFFA8"><strong>Total</strong></td>
					  <td align="left" bgcolor="#DCFFA8">&nbsp;</td>
					  <td align="left" bgcolor="#DCFFA8">&nbsp;</td>
					  <td align="left" bgcolor="#DCFFA8">&nbsp;</td>
					  <td align="left" bgcolor="#DCFFA8"><strong>' . $total . '</strong></td>
				  </tr>
				</table>
				<table width="500" border="0" align="center" cellpading="2" cellspacing="3">
					<tr>
					  <td colspan="2" align="left">&nbsp;</td>
					</tr>
					<tr>
							<td colspan="2" align="left">
								<font size="4"><b><i>Date pentru facturare</i></b></font>                        </td>
						</tr>
							<tr>
								<td align="right">Nume si Prenume</td>
								<td>
									<input name="Nume" size="35" type="text" value="' . $nume . '">                            </td>
							</tr>
							<tr>
								<td align="right">Adresa</td>
								<td>
									<input name="Adresa" size="35" type="text" value="' . $adresa . '">                            </td>
							</tr>
							<tr>
								<td align="right">Oras</td>
								<td>
									<input name="Oras" size="35" type="text" value="' . $oras . '">                            </td>
							</tr>
							<tr>
								<td align="right">Cod Postal</td>
								<td>
									<input name="cod_postal" size="35" type="text" value="' . $cod_postal . '">                            </td>
							</tr>
							<tr>
								<td align="right">CNP</td>
								<td>
									<input name="CNP" size="35" type="text" value="' . $cnp . '">                            </td>
							</tr>
							<tr>
								<td align="right">E-Mail</td>
								<td>
									<input name="Mail" size="35" type="text" value="' . $mail . '">                            </td>
							</tr>
							<tr>
								<td align="right">Telefon</td>
								<td>
									<input name="Tel" size="35" type="text" value="' . $tel . '">                            </td>
							</tr>
							<tr>
								<td align="right"></td>
								<td>
									<input name="Submit" value="Comanda !" type="submit">                            </td>
							</tr>
				</table>
			</form>
				<p align="center"><img src="images/b.gif" alt=""></p>
		';
	}
} elseif (isset($_GET['page']) && ($_GET['page'] == "finish")) {
	if (isset($_SESSION['title'])) {
		$title = $_SESSION['title'];
	} else {
		$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Invitatii" ';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$title = $rand['descriere'];
		}
	}
	include('header.php');

	if (($_POST['Nume'] == '') || ($_POST['Adresa'] == '') || ($_POST['Oras'] == '') || ($_POST['cod_postal'] == '') || ($_POST['CNP'] == '') || ($_POST['Mail'] == '') || ($_POST['Tel'] == '') || (!is_numeric($_POST['CNP'])) || (!is_numeric($_POST['Tel'])) || (!is_numeric($_POST['cod_postal']))) {
		echo '<p align="center"><font size="5" color="red"><b>ERROR !</b></font></p>
		<p align="center"><img src="images/a.gif" alt=""></p>
		<p align="center"><font color="red">';
		if ($_POST['Nume'] == '') echo 'Nu ati completat numele d-voastra !<br>';
		if ($_POST['Adresa'] == '') echo 'Nu ati completat adresa d-voastra !<br>';
		if ($_POST['Oras'] == '') echo 'Nu ati completat orasul d-voastra !<br>';
		if ($_POST['cod_postal'] == '') echo 'Nu ati completat codul postal ! Va recomandam <a href="http://www.coduripostale.ro/" target="_blank">Coduripostale.Ro</a>.<br>';
		if ($_POST['CNP'] == '') echo 'Nu ati completat codul numeric personal (CNP) !<br>';
		if ($_POST['Mail'] == '') echo 'Nu ati completat adresa d-voastra de mail !<br>';
		if ($_POST['Tel'] == '') echo 'Nu ati completat numarul d-voastra de telefon !<br>';
		if (!is_numeric($_POST['cod_postal'])) echo 'Codul postal completat nu este valid !<br>';
		if (!is_numeric($_POST['CNP'])) echo 'CNP-ul completat nu este valid !<br>';
		if (!is_numeric($_POST['Tel'])) echo 'Numarul de telefon completat nu este valid !<br>';
		echo '</font></p>
		<p align="center"><img src="images/b.gif" alt=""></p>';
	} else {

		$_SESSION['Nume'] = $_POST['Nume'];
		$_SESSION['Adresa'] = $_POST['Adresa'];
		$_SESSION['Oras'] = $_POST['Oras'];
		$_SESSION['cod_postal'] = $_POST['cod_postal'];
		$_SESSION['CNP'] = $_POST['CNP'];
		$_SESSION['Mail'] = $_POST['Mail'];
		$_SESSION['Tel'] = $_POST['Tel'];

		echo
		'
			<p align="center"><font size="5"><b>Comanda a fost trimisa cu succes !</b></font></p>
			<p align="center"><img src="images/a.gif" alt=""></p>
			<p align="center">Veti primi in scurt timp un e-mail cu Factura Proforma !</p>
			<p align="center"><img src="images/b.gif" alt=""></p>
		';
		$catre = $_SESSION['Mail'];
		$data_trimitere = date('d-m-Y H:i:s');
		$subiect = 'Factura Proforma (' . $_SESSION['cantitate'] . ' invitatii ' . $_SESSION['numep'] . ')';
		$mesaj =
			'
			<table border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:none">
			 <tr>
			  <td width="153" valign="top" style="border:none;">
			  <span style="font-family:"Bernard MT Condensed","serif""><img width="153" height="55" src="images/image001.jpg" alt="Top Mariage"></span>  </td>
			  <td width="540" align="center" valign="middle" style="border:none;background:#F2F2F2;">
			  <span style="font-size:18.0pt;font-family:"Verdana","sans-serif";color:#292929">Factura Proforma</span>
			  </td>
			 </tr>
			</table>
			
			<p><span style="font-size:8.0pt;line-height:115%;font-family: "Verdana","sans-serif";color:#292929">Data factura: ' . $data_trimitere . '</span></p>
			
			<table border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:none; width:693px;">
			 <tr>
			  <td valign="top" style="width:346px;border:solid #D9D9D9 1.0pt;">
			  <b><span style="font-size:8.0pt;line-height:115%;font-family:"Verdana","sans-serif";color:#292929">Beneficiar</span></b>
			  <span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929"><br>
			  ' . $_SESSION['Nume'] . '<br>
			  ' . $_SESSION['Adresa'] . '<br>
			  ' . $_SESSION['Oras'] . ', ' . $_SESSION['cod_postal'] . '<br>
			   CNP :' . $_SESSION['CNP'] . '  </span>
			  </td>
			  <td valign="top" style="width:347px;border:solid #D9D9D9 1.0pt;border-left:none;">
			  <b><span style="font-size:8.0pt;line-height:115%;font-family:"Verdana","sans-serif";color:#292929">Platiti catre</span></b>
			  <span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929"><br>
			  S.C. Expert Events� S.R.L.<br>
			  Cod Fiscal (V.A.T. ID): 20892370<br>
			  Reg. Comert: J22/327/2007<br>
			  Banca: PROCREDIT BANK, Sucursala Jude&#355;ean&#259; Ia&#351;i<br>
			  Cont: RO 87 MIRO 0000707261930501<br>
			  Localitate: Iasi<br>
			  Judet: Iasi</span>
			  </td>
			 </tr>
			</table>
			<table><tr><td></td></tr></table>
			<table border="0" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse;border:none;width:693;">
			 <tr>
			  <td colspan="2" valign="middle" align="center" style="border:solid #D9D9D9 1.0pt;">
			  <b><span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">Descriere</span></b>  </td>
			  <td width="231" valign="middle" align="center" style="border:solid #D9D9D9 1.0pt;border-left:none;">
			  <b><span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">Suma de plata</span></b>  </td>
			 </tr>
			 <tr>
			  <td colspan="2" valign="middle" style="border:solid #D9D9D9 1.0pt;border-top:none;">
			  <span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">' . $_SESSION['cantitate'] . ' x ' . $_SESSION['numep'] . '</span>  </td>
			  <td width="231" align="center" valign="middle" style="border-top:none;border-left:none;border-bottom:solid #D9D9D9 1.0pt;border-right:solid #D9D9D9 1.0pt;">
			  <span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">' . $_SESSION['cantitate'] . ' x ' . $_SESSION['pretp'] . ' RON</span></p>  </td>
			 </tr>
			<tr>
			  <td colspan="2" valign="middle" style="border:solid #D9D9D9 1.0pt;border-top:none;">
			  <span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">Livrare ' . $_SESSION['posta'] . '</span>  </td>
			  <td width="231" align="center" valign="middle" style="border-top:none;border-left:none;border-bottom:solid #D9D9D9 1.0pt;border-right:solid #D9D9D9 1.0pt;">
			  <span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">' . $_SESSION['postap'] . ' RON</span></p>  </td>
			 </tr>
			 <tr>
			  <td colspan="2" align="right" valign="middle" style="border:solid #D9D9D9 1.0pt;border-top:none;">
			  <span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">Total de plata :</span></p>  </td>
			  <td width="231" align="center" valign="middle" style="width:102.8pt;border-top:none;border-left:none;border-bottom:solid #D9D9D9 1.0pt;border-right:solid #D9D9D9 1.0pt;;">
			  <span style="font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">' . $_SESSION['total'] . ' RON</span></p>  </td>
			 </tr>
			 <tr>
			  <td width="231" style="border-top:none;border-left:none;border-bottom:none;border-right:none;">
			  <b><span style="border-top:none;border-left:none;border-bottom:none;border-right:none;font-size:8.0pt;font-family:"Verdana","sans-serif";color:#292929">Detalii plata</span></b>  </td>
			  <td width="231" align="center" valign="top" style="border-top:none;border-left:none;border-bottom:none;border-right:none;">&nbsp;    </td>
			  <td width="231" colspan="2" align="center" valign="top" style="border-top:none;border-left:none;border-bottom:none;border-right:none;">&nbsp;    </td>
			 </tr>
			 <tr>
			  <td width="231" valign="top" style="border-top:none;border-left:none;border-bottom:none;border-right:none;">
			  <b><span style="border-top:none;border-left:none;border-bottom:none;border-right:none;font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">Fara TVA </span></b>
			  <span style="border-top:none;border-left:none;border-bottom:none;border-right:none;font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929"><br>
			  Atribut fiscal: RO</span>  </td>
			  <td width="231" valign="top" style="border-top:none;border-left:none;border-bottom:none;border-right:none;">
			  <b><span style="border-top:none;border-left:none;border-bottom:none;border-right:none;font-size:8.0pt;font-family:"Verdana","sans-serif";color:#292929">Adresa</span></b>
			  <span style="border-top:none;border-left:none;border-bottom:none;border-right:none;font-size:8.0pt;font-family:"Verdana","sans-serif";color:#292929"><br>
			  Sediu Social: Iasi, Str.Nicolina<br>
			  nr. 11, bl. A 5, sc. A, parter</span>  </td>
			  <td width="231" colspan="2" valign="top" style="border-top:none;border-left:none;border-bottom:none;border-right:none;">
			  <b><span style="border-top:none;border-left:none;border-bottom:none;border-right:none;font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929">Date Contact</span></b>
			  <span style="border-top:none;border-left:none;border-bottom:none;border-right:none;font-size:8.0pt;line-height:100%;font-family:"Verdana","sans-serif";color:#292929"><br>
			  Telefon: 0740.29.56.26<br>
			  FIX/Fax: 0332/41.88.41<br>
			  Email: topmariage@yahoo.com<br>
			  Web: <u><a href="http://www.topmariage.ro">www.topmariage.ro</a></u></span></p>  </td>
			 </tr>
			</table>
		';
		$headere = "MIME-Version: 1.0\r\n";
		$headere .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headere .= "From: Top Mariage <topmariage@yahoo.com>\r\n";

		mail($catre, $subiect, $mesaj, $headere);

		$catre2 = 'topmariage@yahoo.com';
		$subiect2 = 'Comanda noua ! ' . $data_trimitere . '';
		$mesaj2 =
			'
			<p>Nume :<b> ' . $_SESSION['Nume'] . '</b><br />
			Adresa : <b>' . $_SESSION['Adresa'] . '</b><br />
			Oras : <b>' . $_SESSION['Oras'] . '</b><br />
			Cod Postal : <b>' . $_SESSION['cod_postal'] . '</b><br />
			CNP : <b>' . $_SESSION['CNP'] . '</b><br />
			Adresa Mail :<b> ' . $_SESSION['Mail'] . '</b><br />
			Telefon :<b> ' . $_SESSION['Tel'] . '</b></p>
			<table width="693" border="0" cellspacing="2" cellpadding="2" style="font-size:10px;">
			  <tr>
				<td><b>Produs</b></td>
				<td align="center"><b>Text</b></td>
				<td align="right"><b>Cantitate</b></td>
				<td align="right"><b>Pret buc.</b></td>
				<td align="right"><b>Pret total</b></td>
			  </tr>
			  <tr>
				<td valign="top" bgcolor="#DCFFA8">Invitatii : ' . $_SESSION['numep'] . '</td>
				<td align="center" valign="top" bgcolor="#DCFFA8">' . $_SESSION['Text'] . '<br />
								  <br />
				Motto:<br />
				' . $_SESSION['Motto'] . '</td>
				<td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['cantitate'] . '</td>
				<td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['pretp'] . '</td>
				<td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['pret'] . '</td>
			  </tr>
			  <tr>
				<td valign="middle" bgcolor="#B7DB6C">' . $_SESSION['posta'] . '</td>
				<td valign="middle" bgcolor="#B7DB6C">&nbsp;</td>
				<td valign="middle" bgcolor="#B7DB6C">&nbsp;</td>
				<td align="right" valign="middle" bgcolor="#B7DB6C">&nbsp;</td>
				<td align="right" valign="middle" bgcolor="#B7DB6C">' . $_SESSION['postap'] . '</td>
			  </tr>
			  <tr>
				<td valign="middle" bgcolor="#DCFFA8"><b>Total</b></td>
				<td valign="middle" bgcolor="#DCFFA8">&nbsp;</td>
				<td valign="middle" bgcolor="#DCFFA8">&nbsp;</td>
				<td align="right" valign="middle" bgcolor="#DCFFA8">&nbsp;</td>
				<td align="right" valign="middle" bgcolor="#DCFFA8"><b>' . $_SESSION['total'] . '</b></td>
			  </tr>
			</table>
			<p>Caracter : ' . $_SESSION['TipCaracter'] . '<br />
			Culoare font : ' . $_SESSION['CuloareText'] . '<br />
			</p>
		';

		$headere2 = "MIME-Version: 1.0\r\n";
		$headere2 .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headere2 .= "From: Top Mariage <topmariage@yahoo.com>\r\n";

		mail($catre2, $subiect2, $mesaj2, $headere2);
	}
	$_SESSION['title'] = '';
} else {
	$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Invitatii" ';
	$rezultat = mysqli_query($conexiune, $cerereSQL);
	while ($rand = mysqli_fetch_assoc($rezultat)) {
		$title = $rand['descriere'];
	}
	include('header.php');

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

	echo '<p align="center"><font size="5"><b>Invitatii de nunta</b></font></p>
	<p align="center"><img src="images/a.gif" alt=""></p>';

	$intrari_totale2 = mysqli_num_rows(mysqli_query($conexiune, 'SELECT `id` FROM `articole` WHERE `pag`="Invitatii"'));
	if ($intrari_totale2 == 0) {
		echo '';
	} else {
		$cerereSQL = 'SELECT * FROM `articole` WHERE `pag`="Invitatii"';
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
	$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT `id` FROM `produse` WHERE `tip`="invitatii"'));

	if ($intrari_totale == 0) {
		echo '<br><center><font color="darkred"><b>Nu exista inca nici un produs in baza de date !</b></font></center>';
	} else {
		if (!isset($_GET['p'])) $pagina = 1;
		else $pagina = $_GET['p'];
		$nr = 0;
		$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
		$cerereSQL = 'SELECT * FROM `produse` WHERE `tip`="invitatii" ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		$pagini_totale = ceil($intrari_totale / $rezultate_maxime);
		if ($pagina > $pagini_totale) echo 'Pagina nu exista !';
		else {
			if ($pagini_totale > 0) {
				echo
				'<table width="100%" cellspacing="10" cellpadding="0" border="0">
					<tr>';

				while ($rand = mysqli_fetch_assoc($rezultat)) {
					$dataMySQL = 'SELECT `data` FROM `produse` WHERE `id`="' . $rand['id'] . '"';
					$resultat = mysqli_query($conexiune, $dataMySQL);
					if (mysqli_num_rows($resultat)) {
						$Now = strtotime(date('d.m.Y'));
						$Action = strtotime(mysqli_num_rows($resultat));

						$dateDiff = $Now - $Action;
						$Days = floor($dateDiff / (60 * 60 * 24));
					}
					if ($Days <= 30) $img = '<img src="images/nou.gif" width="50" height="16" alt="Produs Nou ! />"';
					else $img = '';

					$pretrol = $rand['pret'] * 10000;
					$nr++;
					echo
					'<td align="center" width="185">
							<a href="invitatii.php?page=prod&id=' . $rand['id'] . '"><img src="invitatii/thumb/' . $rand['imagine'] . '" width="100" alt=""></a><br>
							<a href="invitatii.php?page=prod&id=' . $rand['id'] . '"><u>' . $rand['nume'] . '</u></a><br>
							' . $img . '<br>
							<font color="darkred"><b>' . $rand['pret'] . ' RON</b></font><br>
							<font color="darkred"><b>' . $pretrol . ' ROL</b></font>
						</td>';
					if ($nr % 3 == 0) echo '</tr><tr><td></td></tr><tr>';
				}

				echo '</tr></table>';

				if ($pagini_totale == 1) echo '<div align=left> </div>';
				else {

					echo '<div align="center">';

					for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
						if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
						else echo '<a href="invitatii.php?p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
					}
					echo '</div>';
					echo '<table width="100%"><tr>
							<td align="left">';
					if ($pagina > 1) {
						$inapoi = ($pagina - 1);
						echo '<a href="invitatii.php?p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
					}
					echo '</td>
							<td align="right">';
					if ($pagina < $pagini_totale) {
						$inainte = ($pagina + 1);
						echo '<a href="invitatii.php?p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
					}
					echo '</td>
						  </tr></table>';
				}
			}
		}
	}
	echo '<p align="center"><img src="images/b.gif" alt=""></p>';
}

include('footer.php');
