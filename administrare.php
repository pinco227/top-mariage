<?php

require_once('config.php');
$title = 'Panoul Administratorului';
$pagimg = '<img src="page_img/home.gif" width="609" height="239" alt="">';
include('header.php');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';

if ($_SESSION['logat'] == 'Da') {
	echo '<p align="center"><font size="5"><b>Panoul Administratorului</b></font></p>
	<p align="center"><img src="images/a.gif" alt=""></p>';
	echo '
	  <table width="400" border="0" cellspacing="2" cellpadding="0" align="center">
		<tr>
		  <td align="center"><b>Adauga</b></td>
		  <td align="center"><b>Modifica / Sterge</b></td>
		</tr>
		<tr>
		  <td align="center" bgcolor="#B7DB6C"><a href="administrare.php?action=addp">Produse</a></td>
		  <td align="center" bgcolor="#B7DB6C"><a href="administrare.php?action=listp">Produse</a></td>
		</tr>
		<tr>
		  <td align="center" bgcolor="#DCFFA8"><a href="administrare.php?action=addimg">Imagini</a></td>
		  <td align="center" bgcolor="#DCFFA8"><a href="administrare.php?action=listimg">Imagini</a></td>
		</tr>
        <tr>
		  <td align="center" bgcolor="#B7DB6C"><a href="administrare.php?action=addart">Articole</a></td>
		  <td align="center" bgcolor="#B7DB6C"><a href="administrare.php?action=listart">Articole</a></td>
		</tr>
		<tr>
		  <td colspan="2" align="center" bgcolor="#DCFFA8"><a href="administrare.php?action=addimgp">Logo pagini</a></td>
	    </tr>
        <tr>
		  <td colspan="2" align="center" bgcolor="#B7DB6C"><a href="administrare.php?action=listpag">Descriere pagini</a></td>
	    </tr>
        <tr>
		  <td align="center" bgcolor="#DCFFA8"><a href="administrare.php?action=addbutonh">Butoane Home</a></td>
		  <td align="center" bgcolor="#DCFFA8"><a href="administrare.php?action=listbutonh">Butoane Home</a></td>
	    </tr>
		<tr>
		  <td align="center" bgcolor="#B7DB6C"><a href="administrare.php?action=addnew">Anunturi</a></td>
		  <td align="center" bgcolor="#B7DB6C"><a href="administrare.php?action=listnew">Anunturi</a></td>
	    </tr>
		<tr>
		  <td align="center" bgcolor="#DCFFA8"><a href="administrare.php?action=addadm">Admini</a></td>
		  <td align="center" bgcolor="#DCFFA8"><a href="administrare.php?action=listadm">Admini</a></td>
	    </tr>
		<tr>
		  <td colspan="2" align="center" bgcolor="#B7DB6C"><a href="administrare.php?action=logoff">Log-off [' . $_SESSION['username'] . ']</a></td>
	    </tr>
	  </table>
	';

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////// PRODUSE ///////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if ((isset($_GET['action'])) && ($_GET['action'] == 'addp'))  //////////////////// ADAUGA PRODUSE ///////////////////////////////////////////////////
	{
		if (isset($_POST['add'])) {
			$_SESSION['nume'] = $_POST['nume'];
			$_SESSION['descriere'] = $_POST['descriere'];
			$pret = str_replace(",", ".", $_POST['pret']);
			$_SESSION['pret'] = $pret;
			$_SESSION['tip'] = $_POST['tip'];
			$data = date('d.m.Y');

			if (($_SESSION['nume'] == '') || ($_SESSION['descriere'] == '') || ($_SESSION['pret'] == '') || ($_SESSION['tip'] = '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele produsului !</font></td></tr>';
				if ($_SESSION['descriere'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog descrierea produsului !</font></td></tr>';
				if ($_SESSION['pret'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog pretul produsului !</font></td></tr>';
				if ($_SESSION['tip'] == '') echo '<tr><td align="center"><font color="red">Selecteaza te rog tipul produsului !</font></td></tr>';
				echo '</table>';
			} else {
				$uploadpath = $_POST['tip'] . '/';
				$file = $_SESSION['nume'] . '.jpg';
				$uploadpath = $uploadpath . basename($file);
				if (!move_uploaded_file($_FILES['poza']['tmp_name'], $uploadpath))
					die('There was an error uploading the file, please try again!');

				$image_name = $_POST['tip'] . '/' . $_SESSION['nume'] . '.jpg';
				$nume_nou = $_SESSION['nume'] . '.jpg';
				list($width, $height) = getimagesize($image_name);
				$new_image_name = $_POST['tip'] . '/thumb/' . $_SESSION['nume'] . '.jpg';
				$ratio = ($width / 100);
				$new_width = 100;
				$new_height = ($height / $ratio);
				$image_p = imagecreatetruecolor($new_width, $new_height);
				$image = imagecreatefromjpeg($image_name);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagejpeg($image_p, $new_image_name, 100);

				$cerereSQL = "INSERT INTO `produse` ( `nume`, `desc`, `pret`, `imagine`, `tip`, `data`) 
											VALUES ( '" . htmlentities($_SESSION['nume'], ENT_QUOTES) . "', 
													 '" . htmlentities($_SESSION['descriere'], ENT_QUOTES) . "', 
													 '" . htmlentities($_SESSION['pret'], ENT_QUOTES) . "',
													 '" . htmlentities($nume_nou, ENT_QUOTES) . "',
													 '" . htmlentities($_POST['tip'], ENT_QUOTES) . "',
													 '" . $data . "')";
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Adaugarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Produsul s-a adaugat cu succes !</b></center></font><br>';
				$cerereSQL2 = "INSERT INTO `imagini` ( `nume`, `path`, `pentru`) 
											VALUES ( '" . $_SESSION['nume'] . "', 
													 '" . $nume_nou . "', 
													 '" . $_POST['tip'] . "')";
				mysqli_query($conexiune, $cerereSQL2);
			}

			$_SESSION['nume'] = '';
			$_SESSION['descriere'] = '';
			$_SESSION['pret'] = '';
			$_SESSION['tip'] = '';
		} else {
			echo '';
		}

		echo
		'
			<form name="addp" action="administrare.php?action=addp" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td colspan="2" align="left">
								<font size="4"><b><i>Adauga Produs</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="right"><b>Nume:</b></td>
							<td align="left"><input type="text" size="30" name="nume"></td>   
						</tr>
						<tr>
							<td align="right"><b>Descriere:</b></td>
							<td align="left"><textarea cols="23" rows="3" name="descriere"></textarea></td>   
						</tr>
						<tr>
							<td align="right"><b>Pret:</b></td>
							<td align="left"><input type="text" size="30" name="pret"> RON</td>   
						</tr>
						<tr>
							<td align="right"><b>Imagine:</b></td>
							<td align="left"><input name="poza" id="poza" size="17" type="file"></td>
						</tr>
						<tr>
							<td align="right"><b>Tip:</b></td>
							<td align="left">
								<select name="tip">
									<option value=""></option>
									<option value="invitatii">Invitatie</option>
									<option value="marturii">Marturie</option>
									<option value="plic_bani">Plic Bani</option>
									<option value="card_multumire">Card Multumire</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="add" type="submit" value="Adauga"></td>
						</tr>
					</table>
			</form>
		';
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'listp'))  //////////////////// LISTA PRODUSE ////////////////////////////////////////////
	{
		echo
		'
		<p align="center"><a href="administrare.php?action=listp&pr=inv">Invitatii</a> | <a href="administrare.php?action=listp&pr=mar">Marturii</a> | <a href="administrare.php?action=listp&pr=pb">Plicuri Bani</a> | <a href="administrare.php?action=listp&pr=cm">Carduri Multumire</a> | <a href="administrare.php?action=listp">Toate</a></p>
		';
		if ((isset($_GET['pr'])) && ($_GET['pr'] == 'inv')) //////////////// INVITATII ///////////////////////////////////////////////////////////
		{
			$rezultate_maxime = 21;
			$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `produse` WHERE `tip`="invitatii"'));

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
							$nr++;
							echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest produs ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deletep&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
							echo
							'<td align="center" width="185">
									<a href="invitatii.php?page=prod&id=' . $rand['id'] . '"><img src="' . $rand['tip'] . '/thumb/' . $rand['imagine'] . '" width="100" alt=""></a><br>
									<a href="invitatii.php?page=prod&id=' . $rand['id'] . '"><u>' . $rand['nume'] . '</u></a><br>
									<font color="darkred"><b>' . $rand['pret'] . ' RON</b></font><br>
									<a href="administrare.php?action=editp&id=' . $rand['id'] . '">EDIT</a> | <a href="javascript:ok(' . $rand['id'] . ')">STERGE</a>
								</td>';
							if ($nr % 3 == 0) echo '</tr><tr><td></td></tr><tr>';
						}

						echo '</tr></table>';

						if ($pagini_totale == 1) echo '<div align=left> </div>';
						else {

							echo '<div align="center">';

							for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
								if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
								else echo '<a href="administrare.php?action=listp&pr=inv&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
							}
							echo '</div>';
							echo '<table width="100%"><tr>
									<td align="left">';
							if ($pagina > 1) {
								$inapoi = ($pagina - 1);
								echo '<a href="administrare.php?action=listp&pr=inv&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
							}
							echo '</td>
									<td align="right">';
							if ($pagina < $pagini_totale) {
								$inainte = ($pagina + 1);
								echo '<a href="administrare.php?action=listp&pr=inv&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
							}
							echo '</td>
								  </tr></table>';
						}
					}
				}
			}
		} elseif ((isset($_GET['pr'])) && ($_GET['pr'] == 'mar')) //////////////// MARTURII ///////////////////////////////////////////////////////////
		{
			$rezultate_maxime = 21;
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
							$nr++;
							echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest produs ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deletep&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
							echo
							'<td align="center" width="185">
									<a href="marturii.php?page=prod&id=' . $rand['id'] . '"><img src="' . $rand['tip'] . '/thumb/' . $rand['imagine'] . '" width="100" alt=""></a><br>
									<a href="marturii.php?page=prod&id=' . $rand['id'] . '"><u>' . $rand['nume'] . '</u></a><br>
									<font color="darkred"><b>' . $rand['pret'] . ' RON</b></font><br>
									<a href="administrare.php?action=editp&id=' . $rand['id'] . '">EDIT</a> | <a href="javascript:ok(' . $rand['id'] . ')">STERGE</a>
								</td>';
							if ($nr % 3 == 0) echo '</tr><tr><td></td></tr><tr>';
						}

						echo '</tr></table>';

						if ($pagini_totale == 1) echo '<div align=left> </div>';
						else {

							echo '<div align="center">';

							for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
								if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
								else echo '<a href="administrare.php?action=listp&pr=mar&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
							}
							echo '</div>';
							echo '<table width="100%"><tr>
									<td align="left">';
							if ($pagina > 1) {
								$inapoi = ($pagina - 1);
								echo '<a href="administrare.php?action=listp&pr=mar&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
							}
							echo '</td>
									<td align="right">';
							if ($pagina < $pagini_totale) {
								$inainte = ($pagina + 1);
								echo '<a href="administrare.php?action=listp&pr=mar&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
							}
							echo '</td>
								  </tr></table>';
						}
					}
				}
			}
		} elseif ((isset($_GET['pr'])) && ($_GET['pr'] == 'pb')) //////////////// Plicuri Bani ///////////////////////////////////////////////////////////
		{
			$rezultate_maxime = 21;
			$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `produse` WHERE `tip`="plic_bani"'));

			if ($intrari_totale == 0) {
				echo '<br><center><font color="darkred"><b>Nu exista inca nici un produs in baza de date !</b></font></center>';
			} else {
				if (!isset($_GET['p'])) $pagina = 1;
				else $pagina = $_GET['p'];
				$nr = 0;
				$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
				$cerereSQL = 'SELECT * FROM `produse` WHERE `tip`="plic_bani" ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
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
							echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest produs ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deletep&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
							echo
							'<td align="center" width="185">
									<a href="plicuri_bani.php?page=prod&id=' . $rand['id'] . '"><img src="' . $rand['tip'] . '/thumb/' . $rand['imagine'] . '" width="100" alt=""></a><br>
									<a href="plicuri_bani.php?page=prod&id=' . $rand['id'] . '"><u>' . $rand['nume'] . '</u></a><br>
									<font color="darkred"><b>' . $rand['pret'] . ' RON</b></font><br>
									<a href="administrare.php?action=editp&id=' . $rand['id'] . '">EDIT</a> | <a href="javascript:ok(' . $rand['id'] . ')">STERGE</a>
								</td>';
							if ($nr % 3 == 0) echo '</tr><tr><td></td></tr><tr>';
						}

						echo '</tr></table>';

						if ($pagini_totale == 1) echo '<div align=left> </div>';
						else {

							echo '<div align="center">';

							for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
								if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
								else echo '<a href="administrare.php?action=listp&pr=pb&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
							}
							echo '</div>';
							echo '<table width="100%"><tr>
									<td align="left">';
							if ($pagina > 1) {
								$inapoi = ($pagina - 1);
								echo '<a href="administrare.php?action=listp&pr=pb&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
							}
							echo '</td>
									<td align="right">';
							if ($pagina < $pagini_totale) {
								$inainte = ($pagina + 1);
								echo '<a href="administrare.php?action=listp&pr=pb&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
							}
							echo '</td>
								  </tr></table>';
						}
					}
				}
			}
		} elseif ((isset($_GET['pr'])) && ($_GET['pr'] == 'cm')) //////////////// Carduri Multumire ///////////////////////////////////////////////////////////
		{
			$rezultate_maxime = 21;
			$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `produse` WHERE `tip`="card_multumire"'));

			if ($intrari_totale == 0) {
				echo '<br><center><font color="darkred"><b>Nu exista inca nici un produs in baza de date !</b></font></center>';
			} else {
				if (!isset($_GET['p'])) $pagina = 1;
				else $pagina = $_GET['p'];
				$nr = 0;
				$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
				$cerereSQL = 'SELECT * FROM `produse` WHERE `tip`="card_multumire" ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
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
							echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest produs ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deletep&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
							echo
							'<td align="center" width="185">
									<a href="carduri_multumire.php?page=prod&id=' . $rand['id'] . '"><img src="' . $rand['tip'] . '/thumb/' . $rand['imagine'] . '" width="100" alt=""></a><br>
									<a href="carduri_multumire.php?page=prod&id=' . $rand['id'] . '"><u>' . $rand['nume'] . '</u></a><br>
									<font color="darkred"><b>' . $rand['pret'] . ' RON</b></font><br>
									<a href="administrare.php?action=editp&id=' . $rand['id'] . '">EDIT</a> | <a href="javascript:ok(' . $rand['id'] . ')">STERGE</a>
								</td>';
							if ($nr % 3 == 0) echo '</tr><tr><td></td></tr><tr>';
						}

						echo '</tr></table>';

						if ($pagini_totale == 1) echo '<div align=left> </div>';
						else {

							echo '<div align="center">';

							for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
								if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
								else echo '<a href="administrare.php?action=listp&pr=cm&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
							}
							echo '</div>';
							echo '<table width="100%"><tr>
									<td align="left">';
							if ($pagina > 1) {
								$inapoi = ($pagina - 1);
								echo '<a href="administrare.php?action=listp&pr=cm&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
							}
							echo '</td>
									<td align="right">';
							if ($pagina < $pagini_totale) {
								$inainte = ($pagina + 1);
								echo '<a href="administrare.php?action=listp&pr=cm&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
							}
							echo '</td>
								  </tr></table>';
						}
					}
				}
			}
		} else ///////////////////////////////////////////////////// Toate ///////////////////////////////////////////////////////////
		{
			$rezultate_maxime = 21;
			$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `produse`'));

			if ($intrari_totale == 0) {
				echo '<br><center><font color="darkred"><b>Nu exista inca nici un produs in baza de date !</b></font></center>';
			} else {
				if (!isset($_GET['p'])) $pagina = 1;
				else $pagina = $_GET['p'];
				$nr = 0;
				$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
				$cerereSQL = 'SELECT * FROM `produse` ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
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
							echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest produs ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deletep&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
							echo
							'<td align="center" width="185">
									<img src="' . $rand['tip'] . '/thumb/' . $rand['imagine'] . '" width="100" alt=""></a><br>
									<u>' . $rand['nume'] . '</u><br>
									<font color="darkred"><b>' . $rand['pret'] . ' RON</b></font><br>
									<a href="administrare.php?action=editp&id=' . $rand['id'] . '">EDIT</a> | <a href="javascript:ok(' . $rand['id'] . ')">STERGE</a>
								</td>';
							if ($nr % 3 == 0) echo '</tr><tr><td></td></tr><tr>';
						}

						echo '</tr></table>';

						if ($pagini_totale == 1) echo '<div align=left> </div>';
						else {

							echo '<div align="center">';

							for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
								if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
								else echo '<a href="administrare.php?action=listp&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
							}
							echo '</div>';
							echo '<table width="100%"><tr>
									<td align="left">';
							if ($pagina > 1) {
								$inapoi = ($pagina - 1);
								echo '<a href="administrare.php?action=listp&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
							}
							echo '</td>
									<td align="right">';
							if ($pagina < $pagini_totale) {
								$inainte = ($pagina + 1);
								echo '<a href="administrare.php?action=listp&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
							}
							echo '</td>
								  </tr></table>';
						}
					}
				}
			}
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'editp'))  //////////////////// EDITEAZA PRODUS ////////////////////////////////////////////
	{
		if (isset($_POST['edit'])) {
			$_SESSION['nume'] = $_POST['nume'];
			$_SESSION['descriere'] = $_POST['descriere'];
			$pret = str_replace(",", ".", $_POST['pret']);
			$_SESSION['pret'] = $pret;
			$_SESSION['tip'] = $_POST['tip'];
			$_SESSION['id'] = $_POST['id'];
			$data = date('d.m.Y');

			if (($_SESSION['nume'] == '') || ($_SESSION['descriere'] == '') || ($_SESSION['pret'] == '') || ($_SESSION['tip'] = '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele produsului !</font></td></tr>';
				if ($_SESSION['descriere'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog descrierea produsului !</font></td></tr>';
				if ($_SESSION['pret'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog pretul produsului !</font></td></tr>';
				if ($_SESSION['tip'] == '') echo '<tr><td align="center"><font color="red">Selecteaza te rog tipul produsului !</font></td></tr>';
				echo '</table>';
			} else {
				$cerereSQL = 'UPDATE `produse` SET `nume`="' . $_SESSION['nume'] . '", `pret`="' . $_SESSION['pret'] . '", `tip`="' . $_POST['tip'] . '", `desc`="' . $_SESSION['descriere'] . '", `data`="' . $data . '" WHERE `id`="' . $_SESSION['id'] . '"';
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Editarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Produsul s-a editat cu succes !</b></center></font><br>';

				rename("" . $_POST['fosttip'] . "/" . $_POST['imagine'] . "", "" . $_POST['tip'] . "/" . $_POST['imagine'] . "");
				rename("" . $_POST['fosttip'] . "/thumb/" . $_POST['imagine'] . "", "" . $_POST['tip'] . "/thumb/" . $_POST['imagine'] . "");
			}

			$_SESSION['nume'] = '';
			$_SESSION['descriere'] = '';
			$_SESSION['pret'] = '';
			$_SESSION['tip'] = '';
			$_SESSION['id'] = '';
		} else {
			echo '';
		}

		$cerereSQL = 'SELECT * FROM `produse` WHERE `id`="' . $_GET['id'] . '"';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			if ($rand['tip'] == 'invitatii') {
				$a = 'selected="selected"';
				$b = '';
				$c = '';
				$d = '';
			} elseif ($rand['tip'] == 'marturii') {
				$a = '';
				$b = 'selected="selected"';
				$c = '';
				$d = '';
			} elseif ($rand['tip'] == 'plic_bani') {
				$a = '';
				$b = '';
				$c = 'selected="selected"';
				$d = '';
			} elseif ($rand['tip'] == 'card_multumire') {
				$a = '';
				$b = '';
				$c = '';
				$d = 'selected="selected"';
			} else {
				$a = '';
				$b = '';
				$c = '';
				$d = '';
			}
			echo
			'
				<form name="editp" action="administrare.php?action=editp&id=' . $rand['id'] . '" method="post" enctype="multipart/form-data">
						<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
							<tr>
								<td colspan="2" align="left">
									<font size="4"><b><i>Editeaza Produs</i></b></font>
								</td>
							</tr>
							<tr>
								<td align="right"><b>Nume:</b></td>
								<td class="admin" align="left"><input type="text" size="30" name="nume" value="' . $rand['nume'] . '"></td>   
							</tr>
							<tr>
								<td align="right"><b>Descriere:</b></td>
								<td align="left"><textarea cols="23" rows="3" name="descriere">' . $rand['desc'] . '</textarea></td>   
							</tr>
							<tr>
								<td align="right"><b>Pret:</b></td>
								<td align="left"><input type="text" size="30" name="pret" value="' . $rand['pret'] . '"> RON</td>   
							</tr>
							<tr>
								<td align="right"><b>Tip:</b></td>
								<td align="left">
									<select name="tip">
										<option value="invitatii" ' . $a . '>Invitatie</option>
										<option value="marturii" ' . $b . '>Marturie</option>
										<option value="plic_bani" ' . $c . '>Plic Bani</option>
										<option value="card_multumire" ' . $d . '>Card Multumire</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align="center" colspan="2">
									<input type="hidden" name="id" value="' . $rand['id'] . '">
									<input type="hidden" name="fosttip" value="' . $rand['tip'] . '">
									<input type="hidden" name="imagine" value="' . $rand['imagine'] . '">
									<input name="edit" type="submit" value="Editeaza"></td>
							</tr>
						</table>
				</form>
			';
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'deletep'))  //////////////////// STERGE PRODUS ////////////////////////////////////////////
	{
		$cerereDel = "SELECT * FROM `produse` WHERE `id`='" . htmlentities($_GET['id'], ENT_QUOTES) . "'";
		$rezultatDel = mysqli_query($conexiune, $cerereDel);
		while ($rand = mysqli_fetch_assoc($rezultatDel)) {
			if (file_exists("" . $rand['tip'] . "/" . $rand['imagine'] . "")) {
				unlink("" . $rand['tip'] . "/" . $rand['imagine'] . "");
			}
			if (file_exists("" . $rand['tip'] . "/thumb/" . $rand['imagine'] . "")) {
				unlink("" . $rand['tip'] . "/thumb/" . $rand['imagine'] . "");
			}
			$nume = $rand['nume'];
		}
		$cerereSQL = "DELETE FROM `produse` WHERE `id`='" . htmlentities($_GET['id'], ENT_QUOTES) . "'";
		mysqli_query($conexiune, $cerereSQL);
		$cerereSQL2 = "DELETE FROM `imagini` WHERE `nume`='" . $nume . "'";
		mysqli_query($conexiune, $cerereSQL2);
		echo '<br><br><br><center><font color="red"><b>Produsul a fost sters din baza de date !</b></font></center><br><br><br>';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php?action=listp">';
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////// IMAGINI ///////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	elseif ((isset($_GET['action'])) && ($_GET['action'] == 'addimg'))  //////////////////// ADAUGA IMAGINI ///////////////////////////////////////////////////
	{
		if (isset($_POST['add'])) {
			$_SESSION['nume'] = $_POST['nume'];

			if (($_SESSION['nume'] == '') || ($_POST['pentru'] == '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele imaginii !</font></td></tr>';
				if ($_POST['pentru'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele paginii pentru care incarcati imaginea !</font></td></tr>';
				echo '</table>';
			} else {
				if ($_POST['pentru'] == 'Despre Noi') $_SESSION['pentru'] = 'despre_noi';
				elseif ($_POST['pentru'] == 'Galerie Foto') $_SESSION['pentru'] = 'galerie';
				elseif ($_POST['pentru'] == 'Nunta la romani') $_SESSION['pentru'] = 'nunta_romani';
				elseif ($_POST['pentru'] == 'Cursuri Dans') $_SESSION['pentru'] = 'cursuri_dans';
				elseif ($_POST['pentru'] == 'Carduri de multumire') $_SESSION['pentru'] = 'card_multumire';
				elseif ($_POST['pentru'] == 'Momente Artistice') $_SESSION['pentru'] = 'momente_artistice';
				elseif ($_POST['pentru'] == 'Planificari Evenimente') $_SESSION['pentru'] = 'planificari';
				elseif ($_POST['pentru'] == 'Plicuri Bani') $_SESSION['pentru'] = 'plic_bani';
				else $_SESSION['pentru'] = strtolower($_POST['pentru']);

				$uploadpath = $_SESSION['pentru'] . '/';
				$file = $_SESSION['nume'] . '.jpg';
				$uploadpath = $uploadpath . basename($file);
				if (!move_uploaded_file($_FILES['poza']['tmp_name'], $uploadpath))
					die('There was an error uploading the file, please try again!');

				$image_name = $_SESSION['pentru'] . '/' . $_SESSION['nume'] . '.jpg';
				$nume_nou = $_SESSION['nume'] . '.jpg';
				list($width, $height) = getimagesize($image_name);
				$new_image_name = $_SESSION['pentru'] . '/thumb/' . $_SESSION['nume'] . '.jpg';
				$ratio = ($width / 100);
				$new_width = 100;
				$new_height = ($height / $ratio);
				$image_p = imagecreatetruecolor($new_width, $new_height);
				$image = imagecreatefromjpeg($image_name);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagejpeg($image_p, $new_image_name, 100);

				$cerereSQL = "INSERT INTO `imagini` ( `nume`, `path`, `pentru`) 
												VALUES ( '" . $_SESSION['nume'] . "', 
														 '" . $nume_nou . "',
														 '" . $_SESSION['pentru'] . "')";
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Adaugarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Imaginea s-a adaugat cu succes !</b></center></font><br>';
			}

			$_SESSION['nume'] = '';
			$_SESSION['pentru'] = '';
		} else {
			echo '';
		}

		echo
		'
			<form name="addimg" action="administrare.php?action=addimg" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td colspan="2" align="left">
								<font size="4"><b><i>Adauga Imagine</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="right"><b>Nume:</b></td>
							<td align="left"><input type="text" size="30" name="nume"></td>   
						</tr>
						<tr>
							<td align="right"><b>Pentru:</b></td>
							<td align="left">
								<select name="pentru">';
		$cerereSQL = 'SELECT * FROM `categorii` WHERE `subcat`="nu" ORDER BY `nrordine` ASC';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
		}
		$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
		$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
		while ($rand = mysqli_fetch_assoc($rezultat2)) {
			echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
		}
		echo '
								</select>
							</td>   
						</tr>
						<tr>
							<td align="right"><b>Imagine:</b></td>
							<td align="left"><input name="poza" id="poza" size="17" type="file"></td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="add" type="submit" value="Adauga"></td>
						</tr>
					</table>
			</form>
		';
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'listimg'))  //////////////////// LISTA IMAGINI ////////////////////////////////////////////
	{
		echo '<p align="center">';
		$cerereSQL = 'SELECT * FROM `categorii` WHERE `subcat`="nu" ORDER BY `nrordine` ASC';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		$nr = 0;
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$nr++;
			echo '
				<a href="administrare.php?action=listimg&img=' . $rand['nume'] . '">' . $rand['nume'] . '</a>
			';
			if ($nr % 5 == 0) echo '<br>';
			else echo '|';
		}
		$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
		$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
		while ($rand = mysqli_fetch_assoc($rezultat2)) {
			$nr++;
			echo '
				<a href="administrare.php?action=listimg&img=' . $rand['nume'] . '">' . $rand['nume'] . '</a>
			';
			if ($nr % 5 == 0) echo '<br>';
			else echo '|';
		}
		echo '<a href="administrare.php?action=listimg&img=toate">Toate</a></p>';

		if ((!isset($_GET['img'])) || ($_GET['img'] == 'toate')) {
			$rezultate_maxime = 21;
			$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `imagini`'));

			if ($intrari_totale == 0) {
				echo '<br><center><font color="darkred"><b>Nu exista inca nici o imagines in baza de date !</b></font></center>';
			} else {
				if (!isset($_GET['p'])) $pagina = 1;
				else $pagina = $_GET['p'];
				$nr = 0;
				$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
				$cerereSQL = 'SELECT * FROM `imagini` ORDER BY `pentru` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
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
							echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(nume)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti aceasta imagine ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deleteimg&nume='+nume+'';
										}
										else
										{
										}
								}
								</script>
							";
							echo
							'<td align="center" width="185">
									<a href="' . $rand['pentru'] . '/' . $rand['path'] . '" rel="lightbox[' . $rand['pentru'] . ']" title="' . $rand['nume'] . '"><img src="' . $rand['pentru'] . '/thumb/' . $rand['path'] . '" height="100" alt=""></a><br>
									<a href="' . $rand['pentru'] . '/' . $rand['path'] . '" rel="lightbox[' . $rand['pentru'] . ']" title="' . $rand['nume'] . '"><u>' . $rand['nume'] . '</u></a><br>
									<a href="administrare.php?action=editimg&nume=' . $rand['nume'] . '">EDIT</a> | <a href="javascript:ok(\'' . $rand['nume'] . '\')">STERGE</a>
								</td>';
							if ($nr % 3 == 0) echo '</tr><tr><td></td></tr><tr>';
						}

						echo '</tr></table>';

						if ($pagini_totale == 1) echo '<div align=left> </div>';
						else {

							echo '<div align="center">';

							for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
								if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
								else echo '<a href="administrare.php?action=listimg&img=toate&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
							}
							echo '</div>';
							echo '<table width="100%"><tr>
									<td align="left">';
							if ($pagina > 1) {
								$inapoi = ($pagina - 1);
								echo '<a href="administrare.php?action=listimg&img=toate&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
							}
							echo '</td>
									<td align="right">';
							if ($pagina < $pagini_totale) {
								$inainte = ($pagina + 1);
								echo '<a href="administrare.php?action=listimg&img=toate&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
							}
							echo '</td>
								  </tr></table>';
						}
					}
				}
			}
		} else {
			if ($_GET['img'] == 'Despre Noi') $_SESSION['img'] = 'despre_noi';
			elseif ($_GET['img'] == 'Galerie Foto') $_SESSION['img'] = 'galerie';
			elseif ($_GET['img'] == 'Nunta la romani') $_SESSION['img'] = 'nunta_romani';
			elseif ($_GET['img'] == 'Cursuri Dans') $_SESSION['img'] = 'cursuri_dans';
			elseif ($_GET['img'] == 'Carduri de multumire') $_SESSION['img'] = 'card_multumire';
			elseif ($_GET['img'] == 'Momente Artistice') $_SESSION['img'] = 'momente_artistice';
			elseif ($_GET['img'] == 'Planificari Evenimente') $_SESSION['img'] = 'planificari';
			elseif ($_GET['img'] == 'Plicuri Bani') $_SESSION['img'] = 'plic_bani';
			else $_SESSION['img'] = strtolower($_GET['img']);

			$rezultate_maxime = 21;
			$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `imagini` WHERE `pentru`="' . $_SESSION['img'] . '"'));

			if ($intrari_totale == 0) {
				echo '<br><center><font color="darkred"><b>Nu exista inca nici o imagines in baza de date !</b></font></center>';
			} else {
				if (!isset($_GET['p'])) $pagina = 1;
				else $pagina = $_GET['p'];
				$nr = 0;
				$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
				$cerereSQL = 'SELECT * FROM `imagini` WHERE `pentru`="' . $_SESSION['img'] . '" ORDER BY `pentru` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
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
							echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(nume)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti aceasta imagine ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deleteimg&nume='+nume+'';
										}
										else
										{
										}
								}
								</script>
							";
							echo
							'<td align="center" width="185">
									<a href="' . $_SESSION['img'] . '/' . $rand['path'] . '" rel="lightbox[' . $rand['pentru'] . ']" title="' . $rand['nume'] . '"><img src="' . $_SESSION['img'] . '/thumb/' . $rand['path'] . '" height="100" alt="' . $rand['nume'] . '"></a><br>
									<a href="' . $_SESSION['img'] . '/' . $rand['path'] . '" rel="lightbox[' . $rand['pentru'] . ']" title="' . $rand['nume'] . '"><u>' . $rand['nume'] . '</u></a><br>
									<a href="administrare.php?action=editimg&nume=' . $rand['nume'] . '">EDIT</a> | <a href="javascript:ok(\'' . $rand['nume'] . '\')">STERGE</a>
								</td>';
							if ($nr % 3 == 0) echo '</tr><tr><td></td></tr><tr>';
						}

						echo '</tr></table>';

						if ($pagini_totale == 1) echo '<div align=left> </div>';
						else {

							echo '<div align="center">';

							for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
								if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
								else echo '<a href="administrare.php?action=listimg&img=' . $_SESSION['img'] . '&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
							}
							echo '</div>';
							echo '<table width="100%"><tr>
									<td align="left">';
							if ($pagina > 1) {
								$inapoi = ($pagina - 1);
								echo '<a href="administrare.php?action=listimg&img=' . $_SESSION['img'] . '&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
							}
							echo '</td>
									<td align="right">';
							if ($pagina < $pagini_totale) {
								$inainte = ($pagina + 1);
								echo '<a href="administrare.php?action=listimg&img=' . $_SESSION['img'] . '&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
							}
							echo '</td>
								  </tr></table>';
						}
					}
				}
			}
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'editimg'))  //////////////////// EDITEAZA IMAGINI ////////////////////////////////////////////
	{
		if (isset($_POST['edit'])) {
			$_SESSION['nume'] = $_POST['nume'];
			$_SESSION['fostpentru'] = $_POST['fostpentru'];
			$_SESSION['fostnume'] = $_POST['fostnume'];
			$_SESSION['imagine'] = $_POST['imagine'];
			if ($_POST['pentru'] == 'Despre Noi') $_SESSION['pentru'] = 'despre_noi';
			elseif ($_POST['pentru'] == 'Galerie Foto') $_SESSION['pentru'] = 'galerie';
			elseif ($_POST['pentru'] == 'Nunta la romani') $_SESSION['pentru'] = 'nunta_romani';
			elseif ($_POST['pentru'] == 'Cursuri Dans') $_SESSION['pentru'] = 'cursuri_dans';
			elseif ($_POST['pentru'] == 'Carduri de multumire') $_SESSION['pentru'] = 'card_multumire';
			elseif ($_POST['pentru'] == 'Momente Artistice') $_SESSION['pentru'] = 'momente_artistice';
			elseif ($_POST['pentru'] == 'Planificari Evenimente') $_SESSION['pentru'] = 'planificari';
			elseif ($_POST['pentru'] == 'Plicuri Bani') $_SESSION['pentru'] = 'plic_bani';
			else $_SESSION['pentru'] = strtolower($_POST['pentru']);

			if (($_SESSION['nume'] == '') || ($_SESSION['pentru'] == '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele imaginii !</font></td></tr>';
				if ($_SESSION['pentru'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele paginii pentru care incarcati imaginea !</font></td></tr>';
				echo '</table>';
			} else {
				$cerereSQL = 'UPDATE `imagini` SET `nume`="' . $_SESSION['nume'] . '", `pentru`="' . $_SESSION['pentru'] . '" WHERE `nume`="' . $_SESSION['fostnume'] . '"';
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Editarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Imaginea s-a editat cu succes !</b></center></font><br>';

				if ($_SESSION['pentru'] != $_SESSION['fostpentru']) {
					rename("" . $_SESSION['fostpentru'] . "/" . $_SESSION['imagine'] . "", "" . $_SESSION['pentru'] . "/" . $_SESSION['imagine'] . "");
					rename("" . $_SESSION['fostpentru'] . "/thumb/" . $_SESSION['imagine'] . "", "" . $_SESSION['pentru'] . "/thumb/" . $_SESSION['imagine'] . "");
				} else {
					echo '';
				}
			}

			$_SESSION['nume'] = '';
			$_SESSION['pentru'] = '';
			$_SESSION['fostpentru'] = '';
			$_SESSION['fostnume'] = '';
			$_SESSION['imagine'] = '';
		} else {
			echo '';
		}

		$cerereSQL = 'SELECT * FROM `imagini` WHERE `nume`="' . $_GET['nume'] . '"';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			if ($rand['pentru'] == 'Despre Noi') $pentru = 'despre_noi';
			elseif ($rand['pentru'] == 'Galerie Foto') $pentru = 'galerie';
			elseif ($rand['pentru'] == 'Nunta la romani') $pentru = 'nunta_romani';
			elseif ($rand['pentru'] == 'Cursuri Dans') $pentru = 'cursuri_dans';
			elseif ($rand['pentru'] == 'Carduri de multumire') $pentru = 'card_multumire';
			elseif ($rand['pentru'] == 'Momente Artistice') $pentru = 'momente_artistice';
			elseif ($rand['pentru'] == 'Planificari Evenimente') $pentru = 'planificari';
			elseif ($rand['pentru'] == 'Plicuri Bani') $pentru = 'plic_bani';
			else $pentru = strtolower($rand['pentru']);
			echo
			'
				<form name="editimg" action="administrare.php?action=editimg&nume=' . $rand['nume'] . '" method="post" enctype="multipart/form-data">
						<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
							<tr>
								<td colspan="2" align="left">
									<font size="4"><b><i>Editeaza Imagine</i></b></font>
								</td>
							</tr>
							<tr>
								<td align="right"><b>Nume:</b></td>
								<td class="admin" align="left"><input type="text" size="30" name="nume" value="' . $rand['nume'] . '"></td>   
							</tr>
							<tr>
								<td align="right"><b>Tip:</b></td>
								<td align="left">
									<select name="pentru">
										<option value="' . $pentru . '" selected="selected">' . $rand['pentru'] . '</option>';
			$cerereSQL = 'SELECT * FROM `categorii` WHERE `subcat`="nu" ORDER BY `nrordine` ASC';
			$rezultat = mysqli_query($conexiune, $cerereSQL);
			while ($rand2 = mysqli_fetch_assoc($rezultat)) {
				echo '
												<option value="' . $rand2['nume'] . '">' . $rand2['nume'] . '</option>
											';
			}
			$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
			$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
			while ($rand2 = mysqli_fetch_assoc($rezultat2)) {
				echo '
												<option value="' . $rand2['nume'] . '">' . $rand2['nume'] . '</option>
											';
			}
			echo '
									</select>
								</td>
							</tr>
							<tr>
								<td align="center" colspan="2">
									<input type="hidden" name="fostpentru" value="' . $rand['pentru'] . '">
									<input type="hidden" name="fostnume" value="' . $rand['nume'] . '">
									<input type="hidden" name="imagine" value="' . $rand['path'] . '">
									<input name="edit" type="submit" value="Editeaza">
								</td>
							</tr>
						</table>
				</form>
			';
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'deleteimg'))  //////////////////// STERGE IMAGINI ////////////////////////////////////////////
	{
		$cerereDel = "SELECT * FROM `imagini` WHERE `nume`='" . htmlentities($_GET['nume'], ENT_QUOTES) . "'";
		$rezultatDel = mysqli_query($conexiune, $cerereDel);
		while ($rand = mysqli_fetch_assoc($rezultatDel)) {
			if (file_exists("" . $rand['pentru'] . "/" . $rand['path'] . "")) {
				unlink("" . $rand['pentru'] . "/" . $rand['path'] . "");
			}
			if (file_exists("" . $rand['pentru'] . "/thumb/" . $rand['path'] . "")) {
				unlink("" . $rand['pentru'] . "/thumb/" . $rand['path'] . "");
			}
		}
		$cerereSQL = "DELETE FROM `imagini` WHERE `nume`='" . htmlentities($_GET['nume'], ENT_QUOTES) . "'";
		mysqli_query($conexiune, $cerereSQL);
		echo '<br><br><br><center><font color="red"><b>Imaginea a fost sters din baza de date !</b></font></center><br><br><br>';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php?action=listimg">';
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////// LOGO PAGINI ///////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	elseif ((isset($_GET['action'])) && ($_GET['action'] == 'addimgp'))  //////////////////// ADAUGA LOGO ///////////////////////////////////////////////////
	{
		if (isset($_POST['add'])) {
			$ext = explode('.', $_FILES['logo']['name']);

			$_SESSION['pag'] = $_POST['pag'];

			if (($ext[1] == 'jpg') || ($ext[1] == 'jpeg') || ($ext[1] == 'bmp') || ($ext[1] == 'png') || ($ext[1] == 'gif')) {
				list($width, $height) = getimagesize($_FILES['logo']['tmp_name']);
				if (($width != 609) && ($height != 239)) {
					echo
					'
						<table width="400" cellspacing="5" cellpading="5" align="center">
							<tr>
								<td align="center"><font color="red"><b>ERROR !</b></font></td>
							</tr>
							<tr>
								<td align="center"><font color="red">Dimensiunea fisierului nu este de 609x239 pixeli !</font></td>
							</tr>
						</table>
					';
				} else {
					copy($_FILES['logo']['tmp_name'], 'page_img/' . $_SESSION['pag'] . '.' . $ext[1])
						or die('ERROR !');
					$pagimg = 'page_img/' . $_SESSION['pag'] . '.' . $ext[1];

					$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `categorii` WHERE `nume`="' . $_SESSION['pag'] . '"'));
					if ($intrari_totale == 1) {
						$cerereSQL = 'UPDATE `categorii` SET `pagimg`="' . $pagimg . '" WHERE `nume`="' . $_SESSION['pag'] . '"';
						mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Imaginea nu a putut fi setata !</font></b></center>");
						echo '<font color="green"><center><b>Imaginea a fost setata cu succes !</b></center></font><br>';
					} elseif ($intrari_totale == 0) {
						$cerereSQL = 'UPDATE `subcategorii` SET `pagimg`="' . $pagimg . '" WHERE `nume`="' . $_SESSION['pag'] . '"';
						mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Imaginea nu a putut fi setata !</font></b></center>");
						echo '<font color="green"><center><b>Imaginea a fost setata cu succes !</b></center></font><br>';
					} else {
						echo '<center><b><font color="red">Imaginea nu a putut fi setata dar a fost copiata in folderul "page_img" !</font></b></center>';
					}
				}
			} elseif ($ext[1] == 'swf') {
				copy($_FILES['logo']['tmp_name'], 'page_img/' . $_SESSION['pag'] . '.' . $ext[1])
					or die('ERROR !');
				$pagimg = 'page_img/' . $_SESSION['pag'] . '.' . $ext[1];

				$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `categorii` WHERE `nume`="' . $_SESSION['pag'] . '"'));
				if ($intrari_totale == 1) {
					$cerereSQL = 'UPDATE `categorii` SET `pagimg`="' . $pagimg . '" WHERE `nume`="' . $_SESSION['pag'] . '"';
					mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Imaginea nu a putut fi setata !</font></b></center>");
					echo '<font color="green"><center><b>Imaginea a fost setata cu succes !</b></center></font><br>';
				} elseif ($intrari_totale == 0) {
					$cerereSQL = 'UPDATE `subcategorii` SET `pagimg`="' . $pagimg . '" WHERE `nume`="' . $_SESSION['pag'] . '"';
					mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Imaginea nu a putut fi setata !</font></b></center>");
					echo '<font color="green"><center><b>Imaginea a fost setata cu succes !</b></center></font><br>';
				} else {
					echo '<center><b><font color="red">Imaginea nu a putut fi setata dar a fost copiata in folderul "page_img" !</font></b></center>';
				}
			} else {
				echo
				'
					<table width="400" cellspacing="5" cellpading="5" align="center">
						<tr>
							<td align="center"><font color="red"><b>ERROR !</b></font></td>
						</tr>
						<tr>
							<td align="center"><font color="red">Extensia fisierului nu este acceptata !</font></td>
						</tr>
					</table>
				';
			}
			$_SESSION['pag'] = '';
		} else {
			echo '';
		}

		echo
		'
			<form name="addimgp" action="administrare.php?action=addimgp" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td colspan="2" align="left">
								<font size="4"><b><i>Adauga Logo</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="right"><b>Pagina:</b></td>
							<td align="left">
								<select name="pag">';
		$cerereSQL = 'SELECT * FROM `categorii` WHERE `subcat`="nu" ORDER BY `nrordine` ASC';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
		}
		$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
		$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
		while ($rand = mysqli_fetch_assoc($rezultat2)) {
			echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
		}
		echo '
								</select>
							</td>   
						</tr>
						<tr>
							<td align="right"><b>Imagine/Flash:</b></td>
							<td align="left"><input name="logo" id="logo" size="17" type="file"><br>dimeniunea trebuie sa fie 609x239</td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="add" type="submit" value="Adauga"></td>
						</tr>
					</table>
			</form>
		';
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////// BUTOANE HOME //////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	elseif ((isset($_GET['action'])) && ($_GET['action'] == 'addbutonh'))  //////////////////// ADAUGA BUTON HOME //////////////////////////////////////////
	{
		if (isset($_POST['add'])) {
			$_SESSION['nume'] = $_POST['nume'];
			$_SESSION['link'] = $_POST['link'];

			if (($_SESSION['nume'] == '') || ($_SESSION['link'] = '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele paginii butonului !</font></td></tr>';
				if ($_SESSION['link'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog pagina catre care este directionat butonul !</font></td></tr>';
				echo '</table>';
			} else {
				$uploadpath = 'home/';
				$file = $_FILES['imagine']['name'];
				$uploadpath = $uploadpath . basename($file);
				if (!move_uploaded_file($_FILES['imagine']['tmp_name'], $uploadpath))
					die('There was an error uploading the file, please try again!');
				$image_name = 'home/' . $_FILES['imagine']['name'];
				$nume_nou = $_FILES['imagine']['name'];
				list($width, $height) = getimagesize($image_name);
				$new_image_name = 'home/' . $_FILES['imagine']['name'];
				$new_width = 100;
				$new_height = 75;
				$image_p = imagecreatetruecolor($new_width, $new_height);
				$image = imagecreatefromjpeg($image_name);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagejpeg($image_p, $new_image_name, 100);

				$cerereSQL = "INSERT INTO `butonh` ( `nume`, `link`, `imagine`) 
												VALUES ( '" . $_SESSION['nume'] . "', 
														 '" . $_POST['link'] . "', 
														 '" . $_FILES['imagine']['name'] . "')";
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Adaugarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Imaginea s-a adaugat cu succes !</b></center></font><br>';
			}

			$_SESSION['nume'] = '';
			$_SESSION['link'] = '';
		} else {
			echo '';
		}

		echo
		'
			<form name="addbutonh" action="administrare.php?action=addbutonh" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td colspan="2" align="left">
								<font size="4"><b><i>Adauga Buton Home</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="right"><b>Nume:</b></td>
							<td align="left">
								<input type="text" size="30" name="nume">
							</td>
						</tr>
						<tr>
							<td align="right"><b>Catre:</b></td>
							<td align="left">
								<select name="link">';
		$cerereSQL = 'SELECT * FROM `categorii` ORDER BY `nrordine` ASC';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
		}
		$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
		$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
		while ($rand = mysqli_fetch_assoc($rezultat2)) {
			echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
		}
		echo '
								</select>
							</td>   
						</tr>
						<tr>
							<td align="right"><b>Imagine:</b></td>
							<td align="left"><input name="imagine" id="imagine" size="17" type="file"><br>imaginea trebuie sa fie landscape , proportionala cu 1024x768</td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="add" type="submit" value="Adauga"></td>
						</tr>
					</table>
			</form>
		';
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'listbutonh'))  //////////////////// LISTA BUTOANE HOME ////////////////////////////////////////////
	{
		$rezultate_maxime = 20;
		$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `butonh`'));

		if ($intrari_totale == 0) {
			echo '<br><center><font color="darkred"><b>Nu exista inca nici un buton in baza de date !</b></font></center>';
		} else {
			if (!isset($_GET['p'])) $pagina = 1;
			else $pagina = $_GET['p'];
			$nr = 0;
			$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
			$cerereSQL = 'SELECT * FROM `butonh` ORDER BY `id` ASC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
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
						echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest buton ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deletebutonh&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
						echo
						'<td align="center">
									<table width="130" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td width="130" height="15" colspan="3" background="images/chenar_01.gif"></td>
										</tr>
										<tr>
											<td width="15" height="75" background="images/chenar_02.gif"></td>
											<td width="100" height="75"><img src="home/' . $rand['imagine'] . '" width="100" height="75" alt=""></td>
											<td width="15" height="75" background="images/chenar_04.gif"></td>
										</tr>
										<tr>
											<td width="130" height="30" colspan="3" align="center" valign="middle" background="images/chenar_05.gif">' . $rand['nume'] . '<br>' . $rand['link'] . '</td>
										</tr>
									</table>
									<a href="administrare.php?action=editbutonh&id=' . $rand['id'] . '">EDIT</a> | <a href="javascript:ok(\'' . $rand['id'] . '\')">STERGE</a>
								</td>';
						if ($nr % 4 == 0) echo '</tr><tr><td></td></tr><tr>';
					}

					echo '</tr></table>';

					if ($pagini_totale == 1) echo '<div align=left> </div>';
					else {

						echo '<div align="center">';

						for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
							if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
							else echo '<a href="administrare.php?action=listbutonh&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
						}
						echo '</div>';
						echo '<table width="100%"><tr>
									<td align="left">';
						if ($pagina > 1) {
							$inapoi = ($pagina - 1);
							echo '<a href="administrare.php?action=listbutonh&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
						}
						echo '</td>
									<td align="right">';
						if ($pagina < $pagini_totale) {
							$inainte = ($pagina + 1);
							echo '<a href="administrare.php?action=listbutonh&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
						}
						echo '</td>
								  </tr></table>';
					}
				}
			}
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'editbutonh'))  //////////////////// EDIT BUTON HOME ////////////////////////////////////////////
	{
		if (isset($_POST['edit'])) {
			$_SESSION['nume'] = $_POST['nume'];
			$_SESSION['link'] = $_POST['link'];
			$_SESSION['fostimagine'] = $_POST['fostimagine'];

			if (($_SESSION['nume'] == '') || ($_SESSION['link'] == '') || ($_SESSION['fostimagine'] == '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog titlul anuntului !</font></td></tr>';
				if ($_SESSION['link'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog continutul anuntului !</font></td></tr>';
				if ($_SESSION['fostimagine'] == '') echo '';
				echo '</table>';
			} else {
				if ($_FILES['imagine']['tmp_name'] != '') {

					$uploadpath = 'home/';
					$file = $_FILES['imagine']['name'];
					$uploadpath = $uploadpath . basename($file);
					if (!move_uploaded_file($_FILES['imagine']['tmp_name'], $uploadpath))
						die('There was an error uploading the file, please try again!');
					$image_name = 'home/' . $_FILES['imagine']['name'];
					$nume_nou = $_FILES['imagine']['name'];
					list($width, $height) = getimagesize($image_name);
					$new_image_name = 'home/' . $_FILES['imagine']['name'];
					$new_width = 100;
					$new_height = 75;
					$image_p = imagecreatetruecolor($new_width, $new_height);
					$image = imagecreatefromjpeg($image_name);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagejpeg($image_p, $new_image_name, 100);

					unlink("home/" . $_POST['fostimagine'] . "");

					$cerereSQL = 'UPDATE `butonh` SET `nume`="' . $_SESSION['nume'] . '", `link`="' . $_POST['link'] . '", `imagine`="' . $_FILES['imagine']['name'] . '" WHERE `id`="' . $_GET['id'] . '"';
					mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Editarea nu a putut fi realizata !</font></b></center>");
					echo '<font color="green"><center><b>Butonul s-a editat cu succes !</b></center></font><br>';
				} else {
					$cerereSQL = 'UPDATE `butonh` SET `nume`="' . $_SESSION['nume'] . '", `link`="' . $_POST['link'] . '" WHERE `id`="' . $_GET['id'] . '"';
					mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Editarea nu a putut fi realizata !</font></b></center>");
					echo '<font color="green"><center><b>Butonul s-a editat cu succes !</b></center></font><br>';
				}
			}

			$_SESSION['nume'] = '';
			$_SESSION['link'] = '';
			$_SESSION['fostimagine'] = '';
		} else {
			echo '';
		}

		$cerereSQL = 'SELECT * FROM `butonh` WHERE `id`="' . $_GET['id'] . '"';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo
			'
				<form name="editbutonh" action="administrare.php?action=editbutonh&id=' . $rand['id'] . '" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td align="center">
								<font size="4"><b><i>Editeaza Buton Home</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="left"><b>Nume:</b><br><input type="text" size="30" name="nume" value="' . $rand['nume'] . '">
							</td>
						</tr>
						<tr>
							<td align="left"><b>Schimba imagine:</b><br><input name="imagine" id="imagine" size="22" type="file"><br>
							<img src="home/' . $rand['imagine'] . '" alt="">
							<input type="hidden" name="fostimagine" value="' . $rand['imagine'] . '">
							</td>
						</tr>
						<tr>
							<td align="left"><b>Catre:</b><br>
								<select name="link">
									<option value="' . $rand['link'] . '" selected="selected">' . $rand['link'] . '</option>';
			$cerereSQL = 'SELECT * FROM `categorii` ORDER BY `nrordine` ASC';
			$rezultat = mysqli_query($conexiune, $cerereSQL);
			while ($rand = mysqli_fetch_assoc($rezultat)) {
				echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
			}
			$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
			$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
			while ($rand = mysqli_fetch_assoc($rezultat2)) {
				echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
			}
			echo '
								</select>
							</td>   
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="edit" type="submit" value="Editeaza"></td>
						</tr>
					</table>
			</form>
			';
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'deletebutonh'))  //////////////////// STERGE BUTON HOME //////////////////////////////////////
	{
		$cerereDel = "SELECT * FROM `butonh` WHERE `id`='" . $_GET['id'] . "'";
		$rezultatDel = mysqli_query($conexiune, $cerereDel);
		while ($rand = mysqli_fetch_assoc($rezultatDel)) {
			unlink("home/" . $rand['imagine'] . "");
		}
		$cerereSQL = "DELETE FROM `butonh` WHERE `id`='" . $_GET['id'] . "'";
		mysqli_query($conexiune, $cerereSQL);
		echo '<br><br><br><center><font color="red"><b>Butonul a fost sters din baza de date !</b></font></center><br><br><br>';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php?action=listbutonh">';
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////// ARTICOLE //////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	elseif ((isset($_GET['action'])) && ($_GET['action'] == 'addart'))  //////////////////// ADAUGA ARTICOL ///////////////////////////////////////////////////
	{
		if (isset($_POST['add'])) {
			$_SESSION['titlu'] = $_POST['titlu'];
			$_SESSION['continut'] = $_POST['continut'];
			$_SESSION['pagina'] = $_POST['pagina'];
			$data = date('d.m.Y');

			if (($_SESSION['continut'] == '') || ($_SESSION['pagina'] = '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['continut'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog continutul articolului !</font></td></tr>';
				if ($_SESSION['pagina'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele paginii pentru care este articolul !</font></td></tr>';
				echo '</table>';
			} else {
				$cerereSQL = "INSERT INTO `articole` ( `pag`, `titlu` , `continut` , `data` ) 
											VALUES ( '" . $_POST['pagina'] . "',
													 '" . $_SESSION['titlu'] . "', 
													 '" . $_SESSION['continut'] . "', 
													 '" . $data . "');";
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Adaugarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Articolul s-a adaugat cu succes !</b></center></font><br>';
			}
			$_SESSION['titlu'] = '';
			$_SESSION['continut'] = '';
			$_SESSION['pagina'] = '';
		} else {
			echo '';
		}

		echo
		'
			<form name="addart" action="administrare.php?action=addart" method="post" enctype="multipart/form-data">
						<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td align="center">
								<font size="4"><b><i>Adauga Articol</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="left">
								<b>Pentru:</b><br>
								<select name="pagina">
									<option value="" selected="selected">-- alege --</option>';
		$cerereSQL3 = 'SELECT * FROM `categorii` WHERE `subcat`="nu" ORDER BY `nrordine` ASC';
		$rezultat3 = mysqli_query($conexiune, $cerereSQL3);
		while ($rand = mysqli_fetch_assoc($rezultat3)) {
			echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
		}
		$cerereSQL4 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
		$rezultat4 = mysqli_query($conexiune, $cerereSQL4);
		while ($rand = mysqli_fetch_assoc($rezultat4)) {
			echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
		}
		echo '
								</select>
							</td>
						</tr>
						<tr>
							<td align="left"><b>Titlu:</b><br><input type="text" size="60" name="titlu"></td>   
						</tr>
						<tr>
							<td align="left"><b>Continut:</b><br>
								<textarea id="continut" name="continut" style="height: 170px; width: 500px;"></textarea>
								<script language="javascript1.2">
								  generate_wysiwyg(\'continut\');
								</script>
							</td>   
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="add" type="submit" value="Adauga"></td>
						</tr>
					</table>
			</form>
		';
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'listart'))  //////////////////// LISTA ARTICOLE ////////////////////////////////////////////
	{
		echo '<p align="center">';
		$cerereSQL = 'SELECT * FROM `categorii` WHERE `subcat`="nu" ORDER BY `nrordine` ASC';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		$nr = 0;
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			$nr++;
			echo '
				<a href="administrare.php?action=listart&art=' . $rand['nume'] . '">' . $rand['nume'] . '</a>
			';
			if ($nr % 5 == 0) echo '<br>';
			else echo '|';
		}
		$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
		$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
		while ($rand = mysqli_fetch_assoc($rezultat2)) {
			$nr++;
			echo '
				<a href="administrare.php?action=listart&art=' . $rand['nume'] . '">' . $rand['nume'] . '</a>
			';
			if ($nr % 5 == 0) echo '<br>';
			else echo '|';
		}
		echo '<a href="administrare.php?action=listart&art=toate">Toate</a></p>';

		if ((!isset($_GET['art'])) || ($_GET['art'] == 'toate')) {
			$rezultate_maxime = 10;
			$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `articole`'));

			if ($intrari_totale == 0) {
				echo '<br><center><font color="darkred"><b>Nu exista inca nici un articol in baza de date !</b></font></center>';
			} else {
				if (!isset($_GET['p'])) $pagina = 1;
				else $pagina = $_GET['p'];
				$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
				$cerereSQL = 'SELECT * FROM `articole` ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
				$rezultat = mysqli_query($conexiune, $cerereSQL);
				$pagini_totale = ceil($intrari_totale / $rezultate_maxime);
				if ($pagina > $pagini_totale) echo 'Pagina nu exista !';
				else {
					if ($pagini_totale > 0) {
						echo
						'<table width="100%" cellspacing="10" cellpadding="0" border="0">';

						while ($rand = mysqli_fetch_assoc($rezultat)) {
							echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest articol ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deleteart&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
							echo
							'<tr>
									<td align="left">
										<b>Titlu:</b> <i>' . $rand['titlu'] . '</i>
									</td>
								</tr>
								<tr>
									<td align="left">
										<b>Continut:</b>
										<p align="justify"><i>' . $rand['continut'] . '</i></p>
									</td>
								</tr>
								<tr>
									<td align="center" style="border-bottom:1px solid #CECECE;">
										<a href="administrare.php?action=editart&id=' . $rand['id'] . '">EDIT</a> | <a href="javascript:ok(\'' . $rand['id'] . '\')">STERGE</a>
									</td>
								</tr>';
						}

						echo '</table>';

						if ($pagini_totale == 1) echo '<div align=left> </div>';
						else {

							echo '<div align="center">';

							for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
								if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
								else echo '<a href="administrare.php?action=listart&art=toate&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
							}
							echo '</div>';
							echo '<table width="100%"><tr>
									<td align="left">';
							if ($pagina > 1) {
								$inapoi = ($pagina - 1);
								echo '<a href="administrare.php?action=listart&art=toate&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
							}
							echo '</td>
									<td align="right">';
							if ($pagina < $pagini_totale) {
								$inainte = ($pagina + 1);
								echo '<a href="administrare.php?action=listart&art=toate&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
							}
							echo '</td>
								  </tr></table>';
						}
					}
				}
			}
		} else {
			$rezultate_maxime = 10;
			$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `articole` WHERE `pag`="' . $_GET['art'] . '"'));

			if ($intrari_totale == 0) {
				echo '<br><center><font color="darkred"><b>Nu exista inca nici un articol in baza de date pentru aceasta pagina !</b></font></center>';
			} else {
				if (!isset($_GET['p'])) $pagina = 1;
				else $pagina = $_GET['p'];
				$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
				$cerereSQL = 'SELECT * FROM `articole` WHERE `pag`="' . $_GET['art'] . '" ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
				$rezultat = mysqli_query($conexiune, $cerereSQL);
				$pagini_totale = ceil($intrari_totale / $rezultate_maxime);
				if ($pagina > $pagini_totale) echo 'Pagina nu exista !';
				else {
					if ($pagini_totale > 0) {
						echo
						'<table width="100%" cellspacing="10" cellpadding="0" border="0">';

						while ($rand = mysqli_fetch_assoc($rezultat)) {
							echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest articol ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deleteart&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
							echo
							'<tr>
									<td align="left">
										<b>Titlu:</b> <i>' . $rand['titlu'] . '</i>
									</td>
								</tr>
								<tr>
									<td align="left">
										<b>Continut:</b>
										<p align="justify"><i>' . $rand['continut'] . '</i></p>
									</td>
								</tr>
								<tr>
									<td align="center" style="border-bottom:1px solid #CECECE;">
										<a href="administrare.php?action=editart&id=' . $rand['id'] . '">EDIT</a> | <a href="javascript:ok(\'' . $rand['id'] . '\')">STERGE</a>
									</td>
								</tr>';
						}

						echo '</table>';

						if ($pagini_totale == 1) echo '<div align=left> </div>';
						else {

							echo '<div align="center">';

							for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
								if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
								else echo '<a href="administrare.php?action=listart&art=' . $_GET['art'] . '&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
							}
							echo '</div>';
							echo '<table width="100%"><tr>
									<td align="left">';
							if ($pagina > 1) {
								$inapoi = ($pagina - 1);
								echo '<a href="administrare.php?action=listart&art=' . $_GET['art'] . '&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
							}
							echo '</td>
									<td align="right">';
							if ($pagina < $pagini_totale) {
								$inainte = ($pagina + 1);
								echo '<a href="administrare.php?action=listart&art=' . $_GET['art'] . '&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
							}
							echo '</td>
								  </tr></table>';
						}
					}
				}
			}
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'editart'))  //////////////////// EDITEAZA ARTICOLE ////////////////////////////////////////////
	{
		if (isset($_POST['edit'])) {
			$_SESSION['titlu'] = $_POST['titlu'];
			$_SESSION['continut'] = $_POST['continut'];
			$_SESSION['pentru'] = $_POST['pentru'];

			if (($_SESSION['titlu'] == '') || ($_SESSION['continut'] == '') || ($_SESSION['pentru'] == '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['titlu'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog titlul articolului !</font></td></tr>';
				if ($_SESSION['continut'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog continutul articolului !</font></td></tr>';
				if ($_SESSION['pentru'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele paginii pentru care editati articolul !</font></td></tr>';
				echo '</table>';
			} else {
				$cerereSQL = 'UPDATE `articole` SET `titlu`="' . $_SESSION['titlu'] . '", `continut`="' . nl2br($_SESSION['continut']) . '", `pag`="' . $_SESSION['pentru'] . '" WHERE `id`="' . $_GET['id'] . '"';
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Editarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Articolul s-a editat cu succes !</b></center></font><br>';
			}

			$_SESSION['titlu'] = '';
			$_SESSION['continut'] = '';
			$_SESSION['pentru'] = '';
		} else {
			echo '';
		}

		$cerereSQL = 'SELECT * FROM `articole` WHERE `id`="' . $_GET['id'] . '"';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo
			'
				<form name="editart" action="administrare.php?action=editart&id=' . $rand['id'] . '" method="post" enctype="multipart/form-data">
					
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td align="center">
								<font size="4"><b><i>Editeaza Articol</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="left"><b>Titlu:</b><br>
							<input type="text" size="60" name="titlu" value="' . $rand['titlu'] . '"></td>   
						</tr>
						<tr>
							<td align="left"><b>Continut:</b><br>
								<textarea id="continut" name="continut" style="height: 170px; width: 500px;">' . $rand['continut'] . '</textarea>
								<script language="javascript1.2">
								  generate_wysiwyg(\'continut\');
								</script>
							</td>   
						</tr>
						<tr>
							<td align="left">
								<b>Pentru:</b> <br>
								<select name=pentru">
									<option value="' . $rand['pag'] . '" selected="selected">' . $rand['pag'] . '</option>';
			$cerereSQL = 'SELECT * FROM `categorii` WHERE `subcat`="nu" ORDER BY `nrordine` ASC';
			$rezultat = mysqli_query($conexiune, $cerereSQL);
			while ($rand = mysqli_fetch_assoc($rezultat)) {
				echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
			}
			$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
			$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
			while ($rand = mysqli_fetch_assoc($rezultat2)) {
				echo '
											<option value="' . $rand['nume'] . '">' . $rand['nume'] . '</option>
										';
			}
			echo '
								</select>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="edit" type="submit" value="Editeaza"></td>
						</tr>
					</table>
				</form>
			';
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'deleteart'))  //////////////////// STERGE ARTICOLE ////////////////////////////////////////////
	{
		$cerereSQL = "DELETE FROM `articole` WHERE `id`='" . $_GET['id'] . "'";
		mysqli_query($conexiune, $cerereSQL);
		echo '<br><br><br><center><font color="red"><b>Articolul a fost sters din baza de date !</b></font></center><br><br><br>';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php?action=listart">';
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////// ANUNTURI //////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	elseif ((isset($_GET['action'])) && ($_GET['action'] == 'addnew'))  //////////////////// ADAUGA ANUNT ///////////////////////////////////////////////////
	{
		if (isset($_POST['add'])) {
			$_SESSION['titlu'] = $_POST['titlu'];
			$_SESSION['continut'] = $_POST['continut'];
			$_SESSION['durata'] = $_POST['durata'];
			$data = date('d.m.Y');

			list($width, $height) = getimagesize($_FILES['imagine']['tmp_name']);
			if (($_SESSION['titlu'] == '') || ($_SESSION['continut'] == '') || ($_SESSION['durata'] == '') || ($width > '600')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['titlu'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog titlul anuntului !</font></td></tr>';
				if ($_SESSION['continut'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog continutul anuntului !</font></td></tr>';
				if ($_SESSION['durata'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog durata anuntului !</font></td></tr>';
				if ($width > '600') echo '<tr><td align="center"><font color="red">Lungimea imaginii nu trebuie sa fie mai mare de 600 !</font></td></tr>';
				echo '</table>';
			} else {

				copy($_FILES['imagine']['tmp_name'], 'anunturi/' . $_FILES['imagine']['name'])
					or die('ERROR !');

				$cerereSQL = "INSERT INTO `anunturi` (`titlu` , `continut` , `durata`, `data`, `imagine` ) 
											VALUES ( '" . $_SESSION['titlu'] . "', 
													 '" . $_SESSION['continut'] . "', 
													 '" . $_POST['durata'] . "',
													 '" . $data . "',
													 '" . $_FILES['imagine']['name'] . "');";
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Adaugarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Anuntul s-a adaugat cu succes !</b></center></font><br>';
			}
			$_SESSION['titlu'] = '';
			$_SESSION['continut'] = '';
			$_SESSION['durata'] = '';
		} else {
			echo '';
		}

		echo
		'
			<form name="addnews" action="administrare.php?action=addnew" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td align="center">
								<font size="4"><b><i>Adauga Anunt</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="left"><b>Titlu:</b><br><input type="text" size="60" name="titlu"></td>   
						</tr>
						<tr>
							<td align="left"><b>Continut:</b><br>
							<textarea id="continut" name="continut" style="height: 170px; width: 500px;"></textarea>
								<script language="javascript1.2">
								  generate_wysiwyg(\'continut\');
								</script></td>   
						</tr>
						<tr>
							<td align="left"><b>Durata:</b><br><input type="text" size="30" name="durata"> zile</td>   
						</tr>
						<tr>
							<td align="left"><b>Imagine:</b><br><input name="imagine" id="imagine" size="17" type="file"></td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="add" type="submit" value="Adauga"></td>
						</tr>
					</table>
			</form>
		';
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'listnew'))  //////////////////// LISTA ANUNTURI ///////////////////////////////////////////////////
	{
		$rezultate_maxime = 10;
		$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `anunturi`'));

		if ($intrari_totale == 0) {
			echo '<br><center><font color="darkred"><b>Nu exista inca nici un anunt in baza de date !</b></font></center>';
		} else {
			if (!isset($_GET['p'])) $pagina = 1;
			else $pagina = $_GET['p'];
			$from = (($pagina * $rezultate_maxime) - $rezultate_maxime);
			$cerereSQL = 'SELECT * FROM `anunturi` ORDER BY `id` DESC LIMIT ' . $from . ', ' . $rezultate_maxime . '';
			$rezultat = mysqli_query($conexiune, $cerereSQL);
			$pagini_totale = ceil($intrari_totale / $rezultate_maxime);
			if ($pagina > $pagini_totale) echo 'Pagina nu exista !';
			else {
				if ($pagini_totale > 0) {
					echo
					'<table width="100%" cellspacing="10" cellpadding="0" border="0">
							<tr>';

					while ($rand = mysqli_fetch_assoc($rezultat)) {
						echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest anunt ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deletenew&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
						$Now = strtotime(date('d.m.Y'));
						$Action = strtotime($rand['data']);

						$dateDiff = $Now - $Action;
						$Days = floor($dateDiff / (60 * 60 * 24));

						if ($Days <= $rand['durata']) {
							$expirat = '';
						} else {
							$expirat = '<font color="red"><b>[ EXPIRAT ]</b></font>(EDIT pt a reinoi)';
						}
						echo
						'<tr>
									<td align="left">
										<b>Titlu:</b> <i>' . $rand['titlu'] . '</i> ' . $expirat . '
									</td>
								</tr>
								<tr>
									<td align="justify">
										<b>Continut:</b><br><i>' . $rand['continut'] . '</i>
									</td>
								</tr>
								<tr>
									<td align="justify">
										<img src="anunturi/' . $rand['imagine'] . '">
									</td>
								</tr>
								<tr>
									<td align="left">
										<b>Data:</b>[' . $rand['data'] . ']
									</td>
								</tr>
								<tr>
									<td align="left">
										<b>Durata:</b>[' . $rand['durata'] . ']
									</td>
								</tr>
								<tr>
									<td align="center" style="border-bottom:1px solid #CECECE;">
										<a href="administrare.php?action=editnew&id=' . $rand['id'] . '">EDIT</a> | <a href="javascript:ok(\'' . $rand['id'] . '\')">STERGE</a>
									</td>
								</tr>';
					}

					echo '</tr></table>';

					if ($pagini_totale == 1) echo '<div align=left> </div>';
					else {

						echo '<div align="center">';

						for ($pagini = 1; $pagini <= $pagini_totale; $pagini++) {
							if (($pagina) == $pagini) echo '<b><font style="font-size: 14px;	font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . $pagini . '</font></b>&nbsp;';
							else echo '<a href="administrare.php?action=listnew&p=' . $pagini . '">' . $pagini . '</a>&nbsp;';
						}
						echo '</div>';
						echo '<table width="100%"><tr>
									<td align="left">';
						if ($pagina > 1) {
							$inapoi = ($pagina - 1);
							echo '<a href="administrare.php?action=listnew&p=' . $inapoi . '"><img src="images/anterioara.gif" width="30" height="30"></a>';
						}
						echo '</td>
									<td align="right">';
						if ($pagina < $pagini_totale) {
							$inainte = ($pagina + 1);
							echo 'administrare.php?action=listnew&p=' . $inainte . '"><img src="images/urmatoare.gif" width="30" height="30"></a>';
						}
						echo '</td>
								  </tr></table>';
					}
				}
			}
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'editnew'))  //////////////////// EDITEAZA ANUNTURI ////////////////////////////////////////////
	{
		if (isset($_POST['edit'])) {
			$_SESSION['titlu'] = $_POST['titlu'];
			$_SESSION['continut'] = $_POST['continut'];
			$_SESSION['durata'] = $_POST['durata'];
			$_SESSION['fostimg'] = $_POST['fostimg'];
			$data = date('d.m.Y');
			if ($_FILES['imagine']['tmp_name'] != '') list($width, $height) = getimagesize($_FILES['imagine']['tmp_name']);
			if (($_SESSION['titlu'] == '') || ($_SESSION['continut'] == '') || ($_SESSION['durata'] == '') || (($_FILES['imagine']['tmp_name'] != '') && ($width > '600'))) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['titlu'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog titlul anuntului !</font></td></tr>';
				if ($_SESSION['continut'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog continutul anuntului !</font></td></tr>';
				if ($_SESSION['durata'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog durata anuntului !</font></td></tr>';
				if (($_FILES['imagine']['tmp_name'] != '') && ($width > '600')) echo '<tr><td align="center"><font color="red">Lungimea imaginii nu trebuie sa fie mai mare de 600 !</font></td></tr>';
				echo '</table>';
			} else {
				if ($_FILES['imagine']['tmp_name'] != '') {
					copy($_FILES['imagine']['tmp_name'], 'anunturi/' . $_FILES['imagine']['name'])
						or die('ERROR !');

					unlink("anunturi/" . $_SESSION['fostimg'] . "");

					$cerereSQL = 'UPDATE `anunturi` SET `titlu`="' . $_SESSION['titlu'] . '", `continut`="' . $_SESSION['continut'] . '", `durata`="' . $_POST['durata'] . '", `data`="' . $data . '", `imagine`="' . $_FILES['imagine']['name'] . '" WHERE `id`="' . $_GET['id'] . '"';
					mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Editarea nu a putut fi realizata !</font></b></center>");
					echo '<font color="green"><center><b>Anuntul s-a editat cu succes !</b></center></font><br>';
				} else {
					$cerereSQL = 'UPDATE `anunturi` SET `titlu`="' . $_SESSION['titlu'] . '", `continut`="' . $_SESSION['continut'] . '", `durata`="' . $_POST['durata'] . '", `data`="' . $data . '" WHERE `id`="' . $_GET['id'] . '"';
					mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Editarea nu a putut fi realizata !</font></b></center>");
					echo '<font color="green"><center><b>Anuntul s-a editat cu succes !</b></center></font><br>';
				}
			}

			$_SESSION['titlu'] = '';
			$_SESSION['continut'] = '';
			$_SESSION['durata'] = '';
			$_SESSION['fostimg'] = '';
		} else {
			echo '';
		}

		$cerereSQL = 'SELECT * FROM `anunturi` WHERE `id`="' . $_GET['id'] . '"';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo
			'
				<form name="editnew" action="administrare.php?action=editnew&id=' . $rand['id'] . '" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td align="center">
								<font size="4"><b><i>Editeaza Anunt</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="left"><b>Titlu:</b><br><input type="text" size="60" name="titlu" value="' . $rand['titlu'] . '"></td>   
						</tr>
						<tr>
							<td align="left"><b>Continut:</b><br>
							<textarea id="continut" name="continut" style="height: 170px; width: 500px;">' . $rand['continut'] . '</textarea>
								<script language="javascript1.2">
								  generate_wysiwyg(\'continut\');
								</script>
							</td>     
						</tr>
						<tr>
							<td align="left"><b>Durata:</b><br><input type="text" size="30" name="durata" value="' . $rand['durata'] . '"> zile</td>   
						</tr>
						<tr>
							<td align="left"><b>Schimba imagine:</b><br><input name="imagine" id="imagine" size="17" type="file"></td>
						</tr>
						<tr>
							<input type="hidden" name="fostimg" value="' . $rand['imagine'] . '">
							<td align="center" colspan="2"><input name="edit" type="submit" value="Editeaza"></td>
						</tr>
					</table>
			</form>
			';
		}
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'deletenew'))  //////////////////// STERGE ANUNTURI ////////////////////////////////////////////
	{
		$cerereDel = "SELECT * FROM `anunturi` WHERE `id`='" . $_GET['id'] . "'";
		$rezultatDel = mysqli_query($conexiune, $cerereDel);
		while ($rand = mysqli_fetch_assoc($rezultatDel)) {
			unlink("anunturi/" . $rand['imagine'] . "");
		}
		$cerereSQL = "DELETE FROM `anunturi` WHERE `id`='" . $_GET['id'] . "'";
		mysqli_query($conexiune, $cerereSQL);
		echo '<br><br><br><center><font color="red"><b>Anuntul a fost sters din baza de date !</b></font></center><br><br><br>';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php?action=listnew">';
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////// PAGINI ////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	elseif ((isset($_GET['action'])) && ($_GET['action'] == 'listpag'))  //////////////////// LISTA PAGINI ////////////////////////////////////////////////
	{
		echo
		'<table width="100%" cellspacing="10" cellpadding="0" border="0">		
					<tr>
						<td align="center"><b>Titlu</b></td>
						<td align="center"><b>Descriere</b></td>
						<td></td>
					</tr>';
		$cerereSQL = 'SELECT * FROM `categorii` ORDER BY `nrordine` ASC';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo
			'<tr>
									<td align="center">
										' . $rand['nume'] . '
									</td>
									<td align="left">
										' . $rand['descriere'] . '
									</td>
									<td align="left">
										<a href="administrare.php?action=editpag&nume=' . $rand['nume'] . '">EDIT</a>
									</td>
								</tr>
								';
		}
		$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
		$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
		while ($rand = mysqli_fetch_assoc($rezultat2)) {
			echo
			'<tr>
									<td align="center">
										' . $rand['nume'] . '
									</td>
									<td align="left">
										' . $rand['descriere'] . '
									</td>
									<td align="left">
										<a href="administrare.php?action=editpag&nume=' . $rand['nume'] . '">EDIT</a>
									</td>
								</tr>
								';
		}

		echo '</table>';
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'editpag'))  //////////////////// EDITEAZA ANUNTURI ////////////////////////////////////////////
	{
		if (isset($_POST['edit'])) {
			$_SESSION['descriere'] = $_POST['descriere'];
			if ($_SESSION['descriere'] == '') {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				echo '<tr><td align="center"><font color="red">Introdu te rog descrierea paginii !</font></td></tr>';
				echo '</table>';
			} else {
				$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `categorii` WHERE `nume`="' . $_GET['nume'] . '" '));
				if ($intrari_totale == 0) {
					$cerereSQL = 'UPDATE `subcategorii` SET `descriere`="' . $_SESSION['descriere'] . '" WHERE `nume`="' . $_GET['nume'] . '"';
					mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Editarea nu a putut fi realizata !</font></b></center>");
					echo '<font color="green"><center><b>Pagina s-a editat cu succes !</b></center></font><br>';
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php?action=listpag">';
				} else {
					$cerereSQL = 'UPDATE `categorii` SET `descriere`="' . $_SESSION['descriere'] . '" WHERE `nume`="' . $_GET['nume'] . '"';
					mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Editarea nu a putut fi realizata !</font></b></center>");
					echo '<font color="green"><center><b>Pagina s-a editat cu succes !</b></center></font><br>';
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php?action=listpag">';
				}
			}

			$_SESSION['descriere'] = '';
		} else {
			echo '';
		}

		$intrari_totale = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `categorii` WHERE `nume`="' . $_GET['nume'] . '" '));
		if ($intrari_totale == 0) {
			$tip = 'subcategorii';
		} else {
			$tip = 'categorii';
		}
		$cerereSQL = 'SELECT * FROM `' . $tip . '` WHERE `nume`="' . $_GET['nume'] . '"';
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo
			'
				<form name="editpag" action="administrare.php?action=editpag&nume=' . $rand['nume'] . '" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td align="center">
								<font size="4"><b><i>Editeaza pagina : ' . $rand['nume'] . '</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="left"><b>Descriere:</b><br><input type="text" size="60" name="descriere" value="' . $rand['descriere'] . '"></td>   
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="edit" type="submit" value="Editeaza"></td>
						</tr>
					</table>
			</form>
			';
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////// ADMINI ////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	elseif ((isset($_GET['action'])) && ($_GET['action'] == 'addadm'))  //////////////////// ADAUGA ADMIN ////////////////////////////////////////////
	{
		if (isset($_POST['add'])) {
			$_SESSION['nume'] = $_POST['nume'];
			$_SESSION['parola'] = $_POST['parola'];

			if (($_SESSION['nume'] == '') || ($_SESSION['parola'] == '')) {
				echo '<table width="400" cellspacing="5" cellpading="5" align="center"><tr><td align="center"><font color="red"><b>ERROR !</b></font></td></tr>';
				if ($_SESSION['nume'] == '') echo '<tr><td align="center"><font color="red">Introdu te rog numele administratorului !</font></td></tr>';
				echo '</table>';
			} else {
				$cerereSQL = "INSERT INTO `admin` ( `nume`, `parola` ) 
											VALUES ( '" . htmlentities($_SESSION['nume'], ENT_QUOTES) . "', '" . $_SESSION['parola'] . "' )";
				mysqli_query($conexiune, $cerereSQL) or die("<center><b><font color='red'>Adaugarea nu a putut fi realizata !</font></b></center>");
				echo '<font color="green"><center><b>Adminul a fost adaugat cu succes !</b></center></font><br>';
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php?action=addadm">';
			}
			$_SESSION['nume'] = '';
			$_SESSION['parola'] = '';
		} else {
			echo '';
		}
		echo '
				<form name="addadm" action="administrare.php?action=addadm" method="post" enctype="multipart/form-data">
					<table border="0" align="center" width="400" cellspacing="5" cellpadding="5">
						<tr>
							<td align="center">
								<font size="4"><b><i>Adauga Admin</i></b></font>
							</td>
						</tr>
						<tr>
							<td align="right"><b>Nume:</b></td>
							<td align="left"><input type="text" size="30" name="nume"></td>  
						</tr>
						<tr>
							<td align="right"><b>Parola:</b></td>
							<td align="left"><input type="password" size="30" name="parola"></td>   
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="add" type="submit" value="Adauga"></td>
						</tr>
					</table>
				</form>
			';
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'listadm'))  //////////////////// LISTA ADMINI ////////////////////////////////////////////
	{
		$cerereSQL = 'SELECT * FROM `admin` ORDER BY `id`';
		$rezultat = mysqli_query($conexiune, $cerereSQL);

		echo '<table border="0" align="center" width="200" cellspacing="5" cellpadding="5">
					<tr>
						<td class="admin"><b>Nume</b></td>
						<td align="center" class="admin" width="40"><b>Sterge</b></td>
					</tr>';

		while ($rand = mysqli_fetch_assoc($rezultat)) {
			echo "
								<script language='JavaScript' type='text/javascript'>
								function ok(id)
								{ 
										resultat=confirm('Sunteti sigur ca doriti sa stergeti acest anunt ?');
										if(resultat == 1) 
										{ 
											location.href = 'administrare.php?action=deleteadm&id='+id;
										}
										else
										{
										}
								}
								</script>
							";
			echo '<tr>';
			if ($rand['nume'] == '' . $_SESSION['username'] . '') {
				echo '<td class="admin">' . $_SESSION['username'] . '</td>
										  <td align="center" class="admin"><a href=""><font color="lightgrey">[x]</font></a></td>';
			} else {
				echo '<td class="admin">' . $rand['nume'] . '</td>
										  <td align="center" class="admin"><a href="javascript:ok(\'' . $rand['id'] . '\')"><font color="red">[x]</font></a></td>';
			}
			echo '</tr>';
		}
		echo '</table>';
	} elseif ((isset($_GET['action'])) && ($_GET['action'] == 'deleteadm'))  //////////////////// STERGE ADMINI ////////////////////////////////////////////
	{
		$cerereSQL = "DELETE FROM `admin` WHERE `id`='" . $_GET['id'] . "'";
		mysqli_query($conexiune, $cerereSQL);
		echo '<br><br><br><center><font color="red"><b>Administratorul a fost sters din baza de date !</b></font></center><br><br><br>';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php?action=listadm">';
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////// LOG-OFF ///////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	elseif ((isset($_GET['action'])) && ($_GET['action'] == 'logoff'))  //////////////////// LOG-OFF ////////////////////////////////////////////
	{
		$_SESSION['logat'] = 'Nu';
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=administrare.php">';
	} else {
		echo '';
	}

	echo '<p align="center"><img src="images/b.gif" alt=""></p>';
} else {
	echo '<p align="center"><font size="5"><b>Log-In</b></font></p>
	<p align="center"><img src="images/a.gif" alt=""></p>';
	if (isset($_POST['login'])) {
		$admin = $_POST['admin'];
		$pass = $_POST['pass'];

		$admin = mysqli_real_escape_string($conexiune, $admin);
		$pass = mysqli_real_escape_string($conexiune, $pass);

		$_SESSION['username'] = $admin;

		$cerereSQL = "SELECT * FROM `admin` WHERE `nume`='" . htmlentities($admin) . "' AND `parola`='" . htmlentities($pass) . "'";
		$rezultat = mysqli_query($conexiune, $cerereSQL);
		if (mysqli_num_rows($rezultat) == 1) {
			while ($rand = mysqli_fetch_assoc($rezultat)) {
				$_SESSION['logat'] = 'Da';
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=' . $_SERVER['PHP_SELF'] . '">';
			}
		} else {
			echo '<br><center><font color="red"><b>Userul si parola nu corespund ! Incercati din nou !</b></font></center>';
		}
	} else {

		echo '<br><form action="' . $_SERVER['PHP_SELF'] . '" method="post">
					<table width="200" cellspacing="5" cellpading="5" align="center">
							<tr>
								<td class="admin" align="right">
									Nume:
								</td>
								<td class="admin" align="center">
									<input type="text" name="admin" value="" size="18">
								</td>
							</tr>
							<tr>
								<td class="admin" align="right">
									Parola:
								</td>
								<td class="admin" align="center">
									<input type="password" name="pass" value="" size="18">
								</td>
							</tr>
							<tr>
								<td colspan="2" class="admin" align="center">
									<input type="submit" name="login" value="Login">
								</td>
							</tr>
					</table>
			  </form>';
	}
	echo '<p align="center"><img src="images/b.gif" alt=""></p>';
}
include('footer.php');
