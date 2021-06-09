<?php
require_once('config.php');

$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Marturii"';
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
	$cerereSQL3 = 'SELECT * FROM `subcategorii` WHERE `nume`="Marturii" ';
	$rezultat3 = mysqli_query($conexiune, $cerereSQL3);
	while ($rand3 = mysqli_fetch_assoc($rezultat3)) {
		$cerereSQL4 = "SELECT * FROM `produse` WHERE `id`='" . $_GET['id'] . "' ";
		$rezultat4 = mysqli_query($conexiune, $cerereSQL4);
		while ($rand = mysqli_fetch_assoc($rezultat4)) {
			$title = $rand3['nume'] . ' - ' . $rand['nume'] . ' - ' . $rand3['descriere'];
		}
	}
	$_SESSION['title'] = $title;
	include('header.php');

	$cerereSQL2 = "SELECT * FROM `produse` WHERE `id`='" . $_GET['id'] . "' ";
	$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
	while ($rand = mysqli_fetch_assoc($rezultat2)) {

		$poza = "marturii/" . $rand['imagine'];
		list($width, $height) = getimagesize($poza);
		$maxwidth = '590';

		if ($width > $maxwidth) {
			$picwidth = $maxwidth;
			$picheight = round($height / ($width / $maxwidth));
		} else {
			$picwidth = $width;
			$picheight = $height;
		}

		$pretrol = $rand['pret'] * 10000;
		echo '
			<form action="marturii.php?page=pers" method="post">
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
} elseif (isset($_GET['page']) && ($_GET['page'] == "pers")) {
	if (isset($_SESSION['title'])) {
		$title = $_SESSION['title'];
	} else {
		$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Marturii" ';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$title = $rand['nume'] . ' - ' . $rand['descriere'];
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
			<form action="marturii.php?page=factura" method="post">
				<p align="center"><font size="5"><b>Personalizare marturii</b></font></p>
				<p align="center"><img src="images/a.gif" alt=""></p>
				<table width="500" border="0" align="center" cellpading="2" cellspacing="3">
					<tr>
						<td colspan="2" align="left">
							<font size="4"><b><i>Cantitate</i></b></font>
						</td>
					</tr>
						<tr>
							<td align="right" width="150"></td>
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
		$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Marturii" ';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$title = $rand['nume'] . ' - ' . $rand['descriere'];
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
			<form action="plicuri_bani.php?page=finish" method="post" name="FormularText">
				<p align="center"><font size="5"><b>Factura</b></font></p>
				<p align="center"><img src="images/a.gif" alt=""></p>
				<table width="500" border="0" align="center" cellpading="2" cellspacing="1" style="font-size:9px;">
					<tr>
						<td width="100" align="left"><strong>Produs</strong></td>
						<td width="20" align="left"><strong>Cant.</strong></td>
						<td width="20" align="left"><strong>Pret<br>Buc.</strong></td>
						<td width="20" align="left"><strong>Total<br>RON</strong></td>
					</tr>
					<tr>
					  <td align="left" valign="top" bgcolor="#DCFFA8">Marturii / ' . $_SESSION['numep'] . '</td>
					  <td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['cantitate'] . '</td>
					  <td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['pretp'] . '</td>
					  <td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['pret'] . '</td>
				  </tr>
					<tr>
					  <td height="26" align="left" bgcolor="#B7DB6C">Transport</td>
					  <td align="left" bgcolor="#B7DB6C">&nbsp;</td>
					  <td align="left" bgcolor="#B7DB6C">&nbsp;</td>
					  <td align="left" bgcolor="#B7DB6C">' . $postap . '</td>
				  </tr>
					<tr>
					  <td align="left" bgcolor="#DCFFA8"><strong>Total</strong></td>
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
		$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Marturii" ';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$title = $rand['nume'] . ' - ' . $rand['descriere'];
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
		$subiect = 'Factura Proforma (' . $_SESSION['cantitate'] . ' marturii ' . $_SESSION['numep'] . ')';
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
			  S.C. Expert Events  S.R.L.<br>
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
		$headere .= "From: <Top Mariage>\r\n";

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
				<td align="right"><b>Cantitate</b></td>
				<td align="right"><b>Pret buc.</b></td>
				<td align="right"><b>Pret total</b></td>
			  </tr>
			  <tr>
				<td valign="top" bgcolor="#DCFFA8">Marturii : ' . $_SESSION['numep'] . '</td>
				<td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['cantitate'] . '</td>
				<td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['pretp'] . '</td>
				<td align="right" valign="top" bgcolor="#DCFFA8">' . $_SESSION['pret'] . '</td>
			  </tr>
			  <tr>
				<td valign="middle" bgcolor="#B7DB6C">' . $_SESSION['posta'] . '</td>
				<td valign="middle" bgcolor="#B7DB6C">&nbsp;</td>
				<td align="right" valign="middle" bgcolor="#B7DB6C">&nbsp;</td>
				<td align="right" valign="middle" bgcolor="#B7DB6C">' . $_SESSION['postap'] . '</td>
			  </tr>
			  <tr>
				<td valign="middle" bgcolor="#DCFFA8"><b>Total</b></td>
				<td valign="middle" bgcolor="#DCFFA8">&nbsp;</td>
				<td align="right" valign="middle" bgcolor="#DCFFA8">&nbsp;</td>
				<td align="right" valign="middle" bgcolor="#DCFFA8"><b>' . $_SESSION['total'] . '</b></td>
			  </tr>
			</table>
		';

		$headere2 = "MIME-Version: 1.0\r\n";
		$headere2 .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headere2 .= "From: <Top Mariage>\r\n";

		mail($catre2, $subiect2, $mesaj2, $headere2);
	}
	$_SESSION['title'] = '';
} else {
	$cerereSQL = 'SELECT * FROM `subcategorii` WHERE `nume`="Marturii" ';
	$rezultat = mysqli_query($conexiune, $cerereSQL);
	while ($rand = mysqli_fetch_assoc($rezultat)) {
		$title = $rand['nume'] . ' - ' . $rand['descriere'];
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

	echo '<p align="center"><font size="5"><b>Marturii</b></font></p>
	<p align="center"><img src="images/a.gif" alt=""></p>';

	$intrari_totale2 = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `articole` WHERE `pag`="Marturii"'));
	if ($intrari_totale2 == 0) {
		echo '';
	} else {
		$cerereSQL = 'SELECT * FROM `articole` WHERE `pag`="Marturii"';
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
	$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `produse` WHERE `tip`="marturii"'));

	if ($intrari_totale == 0) {
		echo '<br><center><font color="darkred"><b>Nu exista inca nici un produs in baza de date !</b></font></center>';
	} else {
		if (!isset($_GET['p'])) $pagina = 1;
		else $pagina = $_GET['p'];
		$nr = 0;
		$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
		$cerereSQL = 'SELECT * FROM `produse` WHERE `tip`="marturii" ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
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
							<a href="marturii.php?page=prod&id=' . $rand['id'] . '"><img src="marturii/thumb/' . $rand['imagine'] . '" width="100" alt=""></a><br>
							<a href="marturii.php?page=prod&id=' . $rand['id'] . '"><u>' . $rand['nume'] . '</u></a><br>
							' . $img . '<br>
							<font color="darkred"><b>' . $rand['pret'] . ' RON</b></font><br>
							<font color="darkred"><b>' . $pretrol . ' ROL</b></font>
						</td>';
					if ($nr % 3 == 0) echo '</tr><tr>';
				}

				echo '</tr></table>';

				if ($pagini_totale == 1) echo '<div align=left> </div>';
				else {

					echo '<div align="center">';

					for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
						if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
						else echo '<a href="marturii.php?p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
					}
					echo '</div>';
					echo '<table width="100%"><tr>
							<td align="left">';
					if ($pagina > 1) {
						$inapoi = ($pagina - 1);
						echo '<a href="marturii.php?p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
					}
					echo '</td>
							<td align="right">';
					if ($pagina < $pagini_totale) {
						$inainte = ($pagina + 1);
						echo '<a href="marturii.php?p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
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
