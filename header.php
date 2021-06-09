<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<style type="text/css">
		body {
			background-image: url(images/bg.gif);
			background-repeat: repeat;
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;
			color: #6D0D70;
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 11px;
		}

		img {
			border: none;
		}

		a,
		a:visited {
			color: #6D0D70;
			font-weight: bold;
			text-decoration: none;
		}

		a:hover,
		a:active {
			color: #BB0DC1;
			font-weight: bold;
			text-decoration: none;
		}

		.linkdiv ul {
			margin: 0;
			padding: 0;
			list-style-type: none;
			width: 180px;
			height: 38px;
			border: 0;
		}

		.linkdiv ul li {
			position: relative;
		}


		.linkdiv ul li ul {
			position: absolute;
			width: 180px;
			top: 0;
			visibility: hidden;
		}

		.linkdiv ul li ul li {
			background: #FFFFFF;
			border: 1px solid #D8A428;
		}

		.linkdiv ul li ul li:hover {
			background: #F6E490;
		}

		.linkdiv ul li a {
			display: block;
			overflow: auto;
			color: black;
			text-decoration: none;
			padding: 1px 5px;
			border: 0;
			color: #6D0D70;
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 11px;
			font-weight: bold;
		}

		.linkdiv ul li a:hover,
		a:active {
			color: #BB0DC1;
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 11px;
			font-weight: bold;
		}


		.linkdiv ul li ul li a {
			display: block;
			overflow: auto;
			color: black;
			text-decoration: none;
			padding: 1px 5px;
			border: 0;
			color: #6D0D70;
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 11px;
			font-weight: bold;
		}

		.linkdiv ul li ul lu a:hover,
		a:active {
			color: #BB0DC1;
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 11px;
			font-weight: bold;
		}

		#articole {
			width: 480px;
			float: right;
		}
	</style>

	<script type="text/javascript">
		var menuids = ["linktree"] //Enter id(s) of SuckerTree UL menus, separated by commas

		function buildsubmenus() {
			for (var i = 0; i < menuids.length; i++) {
				var ultags = document.getElementById(menuids[i]).getElementsByTagName("ul")
				for (var t = 0; t < ultags.length; t++) {
					ultags[t].parentNode.getElementsByTagName("a")[0].className = "subfolderstyle"
					if (ultags[t].parentNode.parentNode.id == menuids[i]) //if this is a first level submenu
						ultags[t].style.left = ultags[t].parentNode.offsetWidth + "px" //dynamically position first level submenus to be width of main menu item
					else //else if this is a sub level submenu (ul)
						ultags[t].style.left = ultags[t - 1].getElementsByTagName("a")[0].offsetWidth + "px" //position menu to the right of menu item that activated it
					ultags[t].parentNode.onmouseover = function() {
						this.getElementsByTagName("ul")[0].style.display = "block"
					}
					ultags[t].parentNode.onmouseout = function() {
						this.getElementsByTagName("ul")[0].style.display = "none"
					}
				}
				for (var t = ultags.length - 1; t > -1; t--) { //loop through all sub menus again, and use "display:none" to hide menus (to prevent possible page scrollbars
					ultags[t].style.visibility = "visible"
					ultags[t].style.display = "none"
				}
			}
		}

		if (window.addEventListener)
			window.addEventListener("load", buildsubmenus, false)
		else if (window.attachEvent)
			window.attachEvent("onload", buildsubmenus)
	</script>
	<?php

	if (isset($_GET['page']) && ($_GET['page'] == "pers")) {
		if (isset($_POST['Submit'])) {
			if ($_POST['luna'] = 'Ianuarie') $_SESSION['luna'] = 1;
			elseif ($_POST['luna'] = 'Februarie') $_SESSION['luna'] = 2;
			elseif ($_POST['luna'] = 'Martie') $_SESSION['luna'] = 3;
			elseif ($_POST['luna'] = 'Aprilie') $_SESSION['luna'] = 4;
			elseif ($_POST['luna'] = 'Mai') $_SESSION['luna'] = 5;
			elseif ($_POST['luna'] = 'Iunie') $_SESSION['luna'] = 6;
			elseif ($_POST['luna'] = 'Iulie') $_SESSION['luna'] = 7;
			elseif ($_POST['luna'] = 'August') $_SESSION['luna'] = 8;
			elseif ($_POST['luna'] = 'Septembrie') $_SESSION['luna'] = 9;
			elseif ($_POST['luna'] = 'Octombrie') $_SESSION['luna'] = 10;
			elseif ($_POST['luna'] = 'Noiembrie') $_SESSION['luna'] = 11;
			elseif ($_POST['luna'] = 'Decembrie') $_SESSION['luna'] = 12;
			else {
			}

			$zisapt = date("l", mktime(0, 0, 0, $_SESSION['luna'], $_POST['ziua'], $_POST['anul']));

			if ($zisapt == 'Monday') $_SESSION['zisapt'] = 'Luni';
			elseif ($zisapt == 'Tuesday') $_SESSION['zisapt'] = 'Marti';
			elseif ($zisapt == 'Wednesday') $_SESSION['zisapt'] = 'Miercuri';
			elseif ($zisapt == 'Thursday') $_SESSION['zisapt'] = 'Joi';
			elseif ($zisapt == 'Friday') $_SESSION['zisapt'] = 'Vineri';
			elseif ($zisapt == 'Saturday') $_SESSION['zisapt'] = 'Sambata';
			elseif ($zisapt == 'Sunday') $_SESSION['zisapt'] = 'Duminica';
			else {
			}

			if ($_POST['luna2'] = 'Ianuarie') $_SESSION['luna2'] = 1;
			elseif ($_POST['luna2'] = 'Februarie') $_SESSION['luna2'] = 2;
			elseif ($_POST['luna2'] = 'Martie') $_SESSION['luna2'] = 3;
			elseif ($_POST['luna2'] = 'Aprilie') $_SESSION['luna2'] = 4;
			elseif ($_POST['luna2'] = 'Mai') $_SESSION['luna2'] = 5;
			elseif ($_POST['luna2'] = 'Iunie') $_SESSION['luna2'] = 6;
			elseif ($_POST['luna2'] = 'Iulie') $_SESSION['luna2'] = 7;
			elseif ($_POST['luna2'] = 'August') $_SESSION['luna2'] = 8;
			elseif ($_POST['luna2'] = 'Septembrie') $_SESSION['luna2'] = 9;
			elseif ($_POST['luna2'] = 'Octombrie') $_SESSION['luna2'] = 10;
			elseif ($_POST['luna2'] = 'Noiembrie') $_SESSION['luna2'] = 11;
			elseif ($_POST['luna2'] = 'Decembrie') $_SESSION['luna2'] = 12;
			else {
			}

			$zisapt2 = date("l", mktime(0, 0, 0, $_SESSION['luna2'], $_POST['ziua2'], $_POST['anul2']));

			if ($zisapt2 == 'Monday') $_SESSION['zisapt2'] = 'Luni';
			elseif ($zisapt2 == 'Tuesday') $_SESSION['zisapt2'] = 'Marti';
			elseif ($zisapt2 == 'Wednesday') $_SESSION['zisapt2'] = 'Miercuri';
			elseif ($zisapt2 == 'Thursday') $_SESSION['zisapt2'] = 'Joi';
			elseif ($zisapt2 == 'Friday') $_SESSION['zisapt2'] = 'Vineri';
			elseif ($zisapt2 == 'Saturday') $_SESSION['zisapt2'] = 'Sambata';
			elseif ($zisapt2 == 'Sunday') $_SESSION['zisapt2'] = 'Duminica';
			else {
			}

			echo '
		<SCRIPT language=JavaScript>
	
		RindText = new Array (16); 
		RindText[1] = "InvText1";
		RindText[2] = "InvText2";
		RindText[3] = "InvText3";
		RindText[4] = "InvText4";
		RindText[5] = "InvText5";
		RindText[6] = "InvText6";
		RindText[7] = "InvText7";
		RindText[8] = "InvText8";
		RindText[9] = "InvText9";
		RindText[10] = "InvText10";
		RindText[11] = "InvText11";
		RindText[12] = "InvText12";
		RindText[13] = "InvText13";
		RindText[14] = "InvText14";
		RindText[15] = "InvText15";
		RindText[16] = "InvText16";
		
		Text1 = new Array (16); 
		Text1[1] = "Fie ca ziua de ' . $_SESSION['zisapt'] . ', ' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ' sa ramana"; 
		Text1[2] = "o clipa de neuitat in inimile parintilor nostri"; 
		Text1[3] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text1[4] = "      ' . $_POST['NumePar'] . '                       ' . $_POST['NumePar2'] . '"; 
		Text1[5] = "si a noastra ce pasim pe drumul vietii"; 
		Text1[6] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '";
		Text1[7] = "indrumati cu mandrie si satisfactie de nasii:";
		Text1[8] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text1[9] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text1[10] = "Care vor veghea ca iubirea noastra sa se implineasca";
		Text1[11] = "prin sfanta taina a casatoriei data de "; 
		Text1[12] = "bunul Dumnezeu, ce se va oficia la Biserica ' . $_POST['Biserica'] . '";
		Text1[13] = "din ' . $_POST['AdresaB'] . ' ora ' . $_POST['ora'] . '.";
		Text1[14] = "Ne vom simti onorati sa ve avem alaturi de noi,"; 
		Text1[15] = "in ambianta restaurantului ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . ',"; 
		Text1[16] = "incepand cu ora ' . $_POST['ora2'] . '."; 
		Text1[17] = "Va asteptam cu drag!"; 
	
	
		
		Text2 = new Array (16); 
		Text2[1] = "Dumnezeu le-a dat viata,"; 
		Text2[2] = "iar noi i-am adus pe lume";
		Text2[3] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text2[4] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text2[5] = " un inger bun i-a facut sa se iubeasca, iar ei";
		Text2[6] = "vor sa fie un singur nume"; 
		Text2[7] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text2[8] = "calauziti cu mandrie si satisfactie de nasii:";
		Text2[9] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text2[10] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text2[11] = "care ii vor insoti in Taina Sfintei Cununii,"; 
		Text2[12] = " ce va fi celebrata in Biserica ' . $_POST['Biserica'] . ' din ' . $_POST['AdresaB'] . ',";
		Text2[13] = "' . $_SESSION['zisapt'] . ', ' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ', ora ' . $_POST['ora'] . '."; 
		Text2[14] = "Pentru a ne bucura cu totii, va asteptam cu sufletul deschis,"; 
		Text2[15] = "sa petrecem la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . ',  "; 
		Text2[16] = "incepand cu ora ' . $_POST['ora2'] . '."; 
		Text2[17] = ""; 
		
	Text3 = new Array (16);
	   Text3[1] = "Viata le-am daruit-o noi:"; 
		Text3[2] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text3[3] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text3[4] = "fericirea si-o fauresc singuri:"; 
		Text3[5] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text3[6] = "Bucuria le-o daruim cu totii in ziua de ' . $_SESSION['zisapt'] . ', ' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ' "; 
		Text3[7] = "participand la celebrarea cununiei religioase care"; 
		Text3[8] = "va avea loc la  Biserica ' . $_POST['Biserica'] . ' din ' . $_POST['AdresaB'] . ', ora ' . $_POST['ora'] . ' si la "; 
		Text3[9] = "traditionala petrecere a tinerilor casatoriti"; 
		Text3[10] = "care se va desfasura la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . '"; 
		Text3[11] = "incepand cu ora ' . $_POST['ora2'] . '.";
		Text3[12] = "Pe drumul ce-l vor urma, vor fi calauziti de nasii:"; 
		Text3[13] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text3[14] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text3[15] = "Va asteptam cu drag!"; 
		Text3[16] = ""; 
		Text3[17] = ""; 
		
		Text4 = new Array (16); 
		Text4[1] = "Noi,";
		Text4[2] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '";
		Text4[3] = "pornind pe acelasi drum presarat cu fericire,"; 
		Text4[4] = "dragoste si intelegere, vom face legamant casatoriei,";
		Text4[5] = "spre bucuria parintilor nostri"; 
		Text4[6] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text4[7] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text4[8] = "in data de ' . $_SESSION['zisapt'] . ', ' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ', ora ' . $_POST['ora'] . ' la";
		Text4[9] = "Biserica ' . $_POST['Biserica'] . ' din ' . $_POST['AdresaB'] . '."; 
		Text4[10] = "Destinul nostru va avea o buna calauza, ";
		Text4[11] = "pe nasii nostri:"; 
		Text4[12] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text4[13] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text4[14] = "Va asteptam sa ne bucuram cu totii "; 
		Text4[15] = " incepand cu ora ' . $_POST['ora2'] . ' la restaurantul"; 
		Text4[16] = "' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . '."; 
		
		Text5 = new Array (16);
		Text5[1] = "Noi, cei mai fericiti,"; 
		Text5[2] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text5[3] = "in deplina intelegere si respect vom depune"; 
		Text5[4] = "Juramantul iubirii pe viata."; 
		Text5[5] = "Ne vor fi alaturi pe acest inceput de drum, "; 
		Text5[6] = "parintii:"; 
		Text5[7] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text5[8] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text5[9] = "precum si nasii:"; 
		Text5[10] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text5[11] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text5[12] = "Cununia religioasa se va oficia ' . $_SESSION['zisapt'] . ', ' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ' la"; 
		Text5[13] = "Biserica ' . $_POST['Biserica'] . ' din ' . $_POST['AdresaB'] . '."; 
		Text5[14] = "Prezenta dumneavoastra la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . ', "; 
		  Text5[15] = "incepand cu ora ' . $_POST['ora2'] . ', va fi un prilej pentru ca"; 
		  Text5[16] = "tanara noastra dragoste sa capete taria stancii,"; 
		  Text5[17] = "ce ramane vesnic neclintita in fata valurilor vietii."; 
		  
		
		Text6 = new Array (16); 
		Text6[1] = "Noi,"; 
		Text6[2] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text6[3] = "am hotarit sa pormin pe acelasi drum."; 
		Text6[4] = "Parintii nostri:";
		Text6[5] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text6[6] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text6[7] = "doresc sa fie alaruti de noi, ' . $_SESSION['zisapt'] . ',";
		Text6[8] = "' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ', ora ' . $_POST['ora'] . ' cand bunul Dumnezeu "; 
		Text6[9] = "va binecuvanta acest legamant la Biserica "; 
		Text6[10] = "' . $_POST['Biserica'] . ' din ' . $_POST['AdresaB'] . '. "; 
		Text6[11] = "Pentru a ne bucura cu totii, va asteptam cu "; 
		Text6[12] = " sufletul deschis, sa petrecem la restaurantul"; 
		Text6[13] = "' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . ' incepand cu ora ' . $_POST['ora2'] . '.";
		Text6[14] = "Nasii nostri: ";
		Text6[15] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text6[16] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text6[17] = "vor avea grija ca juramantul sa fie pentru totdeauna.";
		
		Text7 = new Array (16); 
		Text7[1] = "Cu deosebita placere, noi,"; 
		Text7[2] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text7[3] = "alaturi de parintii nostrii:"; 
		Text7[4] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text7[5] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text7[6] = "dorim sa va avem alaturi la celebrarea cununiei  "; 
		Text7[7] = "religioase, care se va oficia  ' . $_SESSION['zisapt'] . ',  ' . $_POST['ziua'] . '  ' . $_POST['luna'] . '  ' . $_POST['anul'] . ',"; 
		Text7[8] = "ora  ' . $_POST['ora'] . ', la Catedrala  ' . $_POST['Biserica'] . ' din  ' . $_POST['AdresaB'] . '"; 
		Text7[9] = "Sarbatorirea evenimentului va avea loc"; 
		Text7[10] = "incepand cu ora  ' . $_POST['ora2'] . ' la restaurantul  ' . $_POST['Local'] . ' din  ' . $_POST['AdresaN'] . '."; 
		Text7[11] = "Cei ce ne vor fi alaturi sunt nasii nostri:"; 
		Text7[12] = " ' . $_POST['PrenNasa'] . ' si  ' . $_POST['PreNumeNas'] . '  "; 
		Text7[13] = " ' . $_POST['PrenNasa2'] . ' si  ' . $_POST['PreNumeNas2'] . '  "; 
		Text7[14] = "Va asteptam cu drag!"; 
		Text7[15] = ""; 
		Text7[16] = ""; 
		
		Text8 = new Array (16); 
		Text8[1] = "Din sincera si profunda iubire, noi,"; 
		Text8[2] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text8[3] = "am hotarat sa ne unim in dragoste si intelegere"; 
		Text8[4] = "si speram ca ziua de azi ' . $_SESSION['zisapt'] . ', ' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ' sa ramana"; 
		Text8[5] = "o clipa de neuitat in inimile parintilor nostri:  ";
		Text8[6] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text8[7] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text8[8] = "Pe drumul vietii vom fi calauziti cu mandrie "; 
		Text8[9] = " si satisfactie de nasii:"; 
		Text8[10] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text8[11] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text8[12] = " care vor veghea ca iubirea noastra sa se implineasca "; 
		Text8[13] = "prin sfanta taina a casatoriei,"; 
		Text8[14] = "ce se va oficia la Biserica ' . $_POST['Biserica'] . ', la ora ' . $_POST['ora'] . '.";
		Text8[15] = "Reusita petrecerii va fi deplina daca ne veti onora cu "; 
		Text8[16] = " prezenta la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . ', incepand cu ora ' . $_POST['ora2'] . '."; 
		Text8[17] = "Va asteptam cu drag! "; 
		
		Text9= new Array (16); 
		Text9[1] = "Familiile  "; 
		Text9[2] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text9[3] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text9[4] = "Cu mare bucurie in inimi va anunta casatoria copiilor lor"; 
		Text9[5] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text9[6] = "si va invita sa luati parte la oficierea "; 
		Text9[7] = "cununiei religioase in ziua de ' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ', ora ' . $_POST['ora'] . ',"; 
		Text9[8] = "la Biserica ' . $_POST['Biserica'] . ', precum si la dineul "; 
		Text9[9] = "ce va urma, incepand cu ora ' . $_POST['ora2'] . ',"; 
		Text9[10] = "la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . '."; 
		Text9[11] = "Nasi: ' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text9[12] = " ' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text9[13] = "Prezenta dumneavoastra va marca  "; 
		Text9[14] = "inceputul noii vieti in doi."; 
		
		Text10 = new Array (16);
		Text10[1] = "Familiile"; 
		Text10[2] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text10[3] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text10[4] = "va invita respectuos sa luati parte la fericitul"; 
		Text10[5] = "eveniment reprezentat de unirea intru Domnul";
		Text10[6] = "a destinelor copiilor nostri"; 
		Text10[7] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text10[8] = "Cea mai frumoasa clipa din viata lor va fi "; 
		Text10[9] = "oficiata la Biserica Biserica, in data";
		Text10[10] = "de ' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ', la ora ' . $_POST['ora'] . '."; 
		Text10[11] = "Felicitarile, masa si dansul se vor "; 
		Text10[12] = "desfasura la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . '";
		Text10[13] = " incepand cu ora ' . $_POST['ora2'] . '. "; 
		Text10[14] = "Nasi: ' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text10[15] = "      ' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
	
	 Text11 = new Array (16);
		Text11[1] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text11[2] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text11[3] = "va invitam sa impartasim impreuna"; 
		Text11[4] = "unirea copiilor nostri "; 
		Text11[5] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text11[6] = "in fata lui Dumnezeu, ' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ',"; 
		Text11[7] = "ora ' . $_POST['ora'] . ', la Biserica ' . $_POST['Biserica'] . ',"; 
		Text11[8] = "alaturi de nasii ' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text11[9] = "               ' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text11[10] = "si pentru a sarbatori juramantul depus, va invitam"; 
		Text11[11] = "la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . ' incepand cu ora ' . $_POST['ora2'] . '."; 
		
	Text12 = new Array (16);
		Text12[1] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text12[2] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text12[3] = "va invitam sa ne fiti alaturi la celebrarea"; 
		Text12[4] = "miracolului iubirii cand fiica si fiul nostru "; 
		Text12[5] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text12[6] = "se vor uni prin sfanta casatorie, ' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ',"; 
		Text12[7] = "la Biserica ' . $_POST['Biserica'] . ', ora ' . $_POST['ora'] . ' sub deosebita "; 
		Text12[8] = "indrumare a nasilor lor"; 
		Text12[9] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text12[10] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text12[11] = "iar apoi va asteptam sa-i felicitam impreuna"; 
		Text12[12] = "in acest moment unic in viata lor la"; 
		Text12[13] = "restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . ' incepand cu ora ' . $_POST['ora2'] . '."; 
		
	Text13 = new Array (16);
		Text13[1] = "In aceasta zi de fericit inceput, ' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ',"; 
		Text13[2] = "va invitam sa fiti alaturi de noi,"; 
		Text13[3] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text13[4] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text13[5] = "si fiii nostri"; 
		Text13[6] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text13[7] = "care se vor insoti in sfanta cununie in fata"; 
		Text13[8] = "in fata lui Dumnezeu la Biserica ' . $_POST['Biserica'] . ', la ora ' . $_POST['ora'] . '."; 
		  Text13[9] = "sub indrumarea inteleapta a nasilor"; 
		Text13[10] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text13[11] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text13[12] = "Apoi ne vom bucura cu totii incepand cu ora ' . $_POST['ora2'] . ',"; 
		Text13[13] = "la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . '."; 
		
	Text14 = new Array (16);
		Text14[1] = "Noi,"; 
		Text14[2] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text14[3] = "vom deveni o singura fiinta si ne vom"; 
		Text14[4] = "impartasi toate zilele vietilor noastre"; 
		Text14[5] = "incepand de ' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ' cand la Biserica ' . $_POST['Biserica'] . ',"; 
		Text14[6] = "la ora ' . $_POST['ora'] . ', vom depune Juramantul iubirii pe viata,"; 
		Text14[7] = "indrumati cu dragoste de parintii "; 
		Text14[8] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text14[9] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text14[10] = "si nasii nostri"; 
		Text14[11] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text14[12] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text14[13] = "si va rugam sa ne onorati cu prezenta "; 
		Text14[14] = "dumneavoastra la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . '"; 
		Text14[15] = "incepand cu ora ' . $_POST['ora2'] . ', pentru a "; 
		Text14[16] = "pecetlui acest inceput."; 
	   
	Text15 = new Array (16);
		Text15[1] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text15[2] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text15[3] = "va invita sa fiti martorii acestui inceput"; 
		Text15[4] = "al copiilor lor"; 
		Text15[5] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text15[6] = "in deosebita zi de ' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ', ora ' . $_POST['ora'] . ', la"; 
		Text15[7] = "Biserica ' . $_POST['Biserica'] . ' cand vor primi"; 
		Text15[8] = "binecuvantarea lui Dumnezeu"; 
		Text15[9] = "alaturi de nasii lor"; 
		Text15[10] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text15[11] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text15[12] = "si va cheama sa impartasiti bucuria"; 
		Text15[13] = "impreuna cu ei la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . '"; 
		Text15[14] = "incepand cu ora ' . $_POST['ora2'] . '."; 
	   
	Text16 = new Array (16);
		Text16[1] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text16[2] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text16[3] = "va invitam sa ne bucuram impreuna de"; 
		Text16[4] = "aceasta zi speciala pentru copiii nostri"; 
		Text16[5] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text16[6] = "' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ', la Biserica ' . $_POST['Biserica'] . ',"; 
		Text16[7] = "ora ' . $_POST['ora'] . ', cand ei vor schimba verighetele si vor primi "; 
		Text16[8] = "binecuvantarea in fata lui Dumnezeu, alaturi de nasii"; 
		Text16[9] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text16[10] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text16[11] = "iar apoi sa marcam acest moment deosebit prin "; 
		Text16[12] = "traditionala petrecere, la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . ' "; 
		Text16[13] = "incepand cu ora ' . $_POST['ora2'] . '."; 
		
	Text17 = new Array (16);
		Text17[1] = "Noi,"; 
		Text17[2] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text17[3] = "cu binecuvantarea parintilor nostri"; 
		Text17[4] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text17[5] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text17[6] = "si a nasilor"; 
		Text17[7] = "' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text17[8] = "' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
		Text17[9] = "vom depune Juramantul iubirii pe viata, "; 
		Text17[10] = "' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ' la biserica ' . $_POST['Biserica'] . ', ora ' . $_POST['ora'] . '."; 
		Text17[11] = "Bucuria noastra va fi completa daca vom "; 
		Text17[12] = "impartasi impreuna cu dumneavoastra aceasta sarbatoare"; 
	 Text17[13] = "la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . '."; 
		
	Text18 = new Array (16);
		Text18[1] = "Mai sunt cateva zile si pe data de ' . $_SESSION['zisapt'] . ',' . $_POST['ziua'] . ' ' . $_POST['luna'] . ' ' . $_POST['anul'] . ', am dori sa,"; 
		Text18[2] = "impartim cu totii aceste clipe de mare importanta pentru noi,"; 
		Text18[3] = "familiile"; 
		Text18[4] = "' . $_POST['PreMama'] . ' si ' . $_POST['PreTata'] . '   ' . $_POST['PreMama2'] . ' si ' . $_POST['PreTata2'] . '";
	 Text18[5] = "      ' . $_POST['NumePar'] . '                  ' . $_POST['NumePar2'] . '"; 
		Text18[6] = "si copiii nostri"; 
		Text18[7] = "' . $_POST['PrenMireasa'] . ' si ' . $_POST['PrenMire'] . '"; 
		Text18[8] = "De aceea va asteptam cu drag la ora ' . $_POST['ora'] . ' la Catedrala ' . $_POST['Biserica'] . ' "; 
		Text18[9] = "din ' . $_POST['AdresaB'] . ' pentru celebrarea cununiei religioase si la masa festiva"; 
		Text18[10] = "ce va avea loc la restaurantul ' . $_POST['Local'] . ' din ' . $_POST['AdresaN'] . '."; 
		Text18[11] = "Nasi: ' . $_POST['PrenNasa'] . ' si ' . $_POST['PreNumeNas'] . '  "; 
		Text18[12] = " ' . $_POST['PrenNasa2'] . ' si ' . $_POST['PreNumeNas2'] . '  "; 
	
	Text19 = new Array (16);
		Text19[1] = ""; 
	
	
	function CompletRindOnLoad(){
			CompletRind();
		}	
	
	
	function CompletRind(){
		textInv = document.FormularText.InvText;
		
		idText = textInv.options[textInv.selectedIndex].value;
		for(contor=1;contor<=16;contor=contor+1){
			actualizarelinie = eval(\'document.FormularText.\' + eval(\'RindText[\' + contor + \']\'));
			actualizarelinie.value = eval(idText + \'[\' + contor + \']\');
			actualizarelinie.value = actualizarelinie.value.replace(/\&quot\;/g, \'"\');
			if (actualizarelinie.value == \'undefined\'){
				actualizarelinie.value = \'\';
			}
		}
	}
	
	function TextulUrmator(){
		textInv = document.FormularText.InvText;
		if (textInv.selectedIndex + 1 < textInv.length){//alert(textInv.selectedIndex + \' < \' + textInv.length);
			textInv.selectedIndex = textInv.selectedIndex + 1;
			CompletRind();
			if (textInv.selectedIndex + 1 == textInv.length){
				alert(\'Ati ajuns la sfirsitul listei.\');
			}
		}	
		else{
			alert(\'Ati ajuns la sfirsitul listei.\');
		}
	}
	
	function TextulAnterior(){
		textInv = document.FormularText.InvText;
		if (textInv.selectedIndex > 0){
			textInv.selectedIndex = textInv.selectedIndex - 1;
			CompletRind();
			if (textInv.selectedIndex == 0){
				alert(\'Ati ajuns la inceputul listei.\');
			}			
		}	
		else{
			alert(\'Ati ajuns la inceputul listei\');
		}
	}	
	
	function SchimbaText(){
	
	
	
		textInv = document.FormularText.InvText;
		for (i = 0; i < textInv.length; i++){
			if (textInv.options[i].value.search(\'Custom\') != -1){
				if (textInv.selectedIndex != i){
					textInv.options[i].selected = true;
					textInv.value = textInv.options[i].value;
					return;
				}
			}
		}
	}
	
	function ActualizareSelect(){
		textInv = document.FormularText.TipCaracter;
		idText = textInv.options[textInv.selectedIndex].value;
		document.ImagineCaracter.src = \'http://www.invitatii.ro/\' + SetCaractere[textInv.selectedIndex+1];
	}
	
	//-->
	</SCRIPT>
	<SCRIPT language=JavaScript>

	Motto1 = new Array (6); 
		Motto1[1] = "";  
		
	Motto2 = new Array (6); 
		Motto2[1] = "Exista o singura fericire in viata,";  
		Motto2[2] = "sa iubesti si sa fii iubit.";  
		Motto2[3] = "                  George Sand";  
		Motto2[4] = "";  
		
	Motto3 = new Array (6); 
		Motto3[1] = "Uniti sa fim in viata";  
		Motto3[2] = "Sa-nvingem tot ce vine,";  
		Motto3[3] = "             S-avem noroc in casa";  
		Motto3[4] = "             Si-n viata fericire.";  
		
	Motto4 = new Array (6); 
		Motto4[1] = "Dragostea ";  
		Motto4[2] = "lumineaza inimile";  
		Motto4[3] = "celor ce o impartasesc";  
		Motto4[4] = "";  
		
	Motto5 = new Array (6); 
		Motto5[1] = "Da-mi mana sa ne unim pentru vecie,";  
		Motto5[2] = "Pe drumul vietii sa mergem fericiti,";  
		Motto5[3] = "Cu toata dragostea te cer sa-mi fii sotie";  
		Motto5[4] = "Caci unul pentru altul de mult am fost sortiti.";  
		Motto5[5] = "                                     EL";  
		
	Motto6 = new Array (6); 
		Motto6[1] = "Iti darui mana, iubirea mea curata,";  
		Motto6[2] = "Caci tu ai fost alesul meu destin.";  
		Motto6[3] = "La tine am gasit intaia data,";  
		Motto6[4] = "Un suflet nobil si-o dragoste de vis.";  
		Motto6[5] = "                           EA";  
	
	Motto7 = new Array (6); 
		Motto7[1] = "Tu esti o unda, eu sunt o zare,";  
		Motto7[2] = "Eu sunt un tarmur, tu esti o mare,";  
		Motto7[3] = "Tu esti o noapte, eu sunt o stea - ";  
		  Motto7[4] = "                      Iubita mea.";  
	
	Motto8 = new Array (6); 
		Motto8[1] = "Tu esti o ziua, eu sunt un soare,";  
		Motto8[2] = "Eu sunt un flutur, tu esti o floare,";  
		Motto8[3] = "Eu sunt un templu, tu esti un zeu - ";  
		Motto8[4] = "                      Iubitul meu.";  
		
		
	Motto9 = new Array (6); 
		Motto9[1] = "Te iubesc nu doar pentru ceea ce esti,";  
		Motto9[2] = "ci si pentru ceea ce sunt cand sunt cu tine.";  
		Motto9[3] = "                             Roy Croft";  
		Motto9[4] = "";  
		
	Motto10 = new Array (6); 
		Motto10[1] = "Lasa sa fie acesta destinul nostru,";  
		Motto10[2] = "sa incepem fiecare noua zi impreuna,";  
		Motto10[3] = "sa ne impartasim vietile pentru vecie.";  
		Motto10[4] = "";  
		Motto10[5] = "";  
		Motto10[6] = "";  
		
	Motto11 = new Array (6); 
		Motto11[1] = "In aceasta zi";  
		Motto11[2] = "vom deveni o singura fiinta";  
		Motto11[3] = "prin puterea dragostei noastre.";  
		Motto11[4] = "";  
		Motto11[5] = "";  
		
	Motto12 = new Array (6); 
		Motto12[1] = "O noua si frumoasa zi, ";  
		Motto12[2] = "ziua noastra;";  
		Motto12[3] = "sa privim trecutul, ascensiunea noastra";  
		Motto12[4] = "cu mandrie;";  
		Motto12[5] = "sa privim inainte, spre viitor";  
		Motto12[6] = "cu speranta.";  
	
	Motto13 = new Array (6); 
		Motto13[1] = "Cuvintele tale sunt hrana mea,";  
		Motto13[2] = "respiratia ta este vinul meu,";  
		Motto13[3] = "tu esti totul pentru mine.";  
		
	Motto14 = new Array (6); 
		Motto14[1] = "Sa stam mana in mana in acest altar,";  
		Motto14[2] = "sa pasim unul langa celalalt prin toate zilele noastre,";  
		Motto14[3] = "sa traim si sa iubim in tacere -";  
		Motto14[4] = "aceasta este adevarata dragoste.";  
		
	Motto15 = new Array (6); 
		Motto15[1] = "Nu merge in fata mea, s-ar putea sa nu te urmez, ";  
		Motto15[2] = "Nu merge in spatele meu, s-ar putea sa-ti pierd pasii ";  
		Motto15[3] = "Mergi doar alaturi de mine si fii al meu prieten pentru";  
		Motto15[4] = "                                         totdeauna.";  
	
	Motto16 = new Array (6); 
		Motto16[1] = "O noua zi ";  
		Motto16[2] = "O noua viata";  
		Motto16[3] = "Impreuna  . . .";  
		
	Motto17 = new Array (6); 
		Motto17[1] = "O dragoste care";  
		Motto17[2] = "este impartasita in doi. . .";  
		
	Motto18 = new Array (6); 
		Motto18[1] = "Fiecare dintre noi o jumatate. . . incompleta -";  
		Motto18[2] = "impreuna suntem un intreg.";  
	
	
		
	
		function CompletMottoOnLoad(){
			CompletMotto();
		}	
	
	
	function CompletMotto(){
		textInv = document.FormularText.InvMotto;
		mottoid = textInv.options[textInv.selectedIndex].value;
		for(contor=1;contor<=6;contor=contor+1){
			actualizarelinie = eval(\'document.FormularText.InvMotto\' + contor);
			actualizarelinie.value = eval(mottoid + \'[\' + contor + \']\');
			if (actualizarelinie.value == \'undefined\'){
				actualizarelinie.value = \'\';
			}
		}
		
	}
	
	function UrmatorulMotto(){
		textInv = document.FormularText.InvMotto;
		if (textInv.selectedIndex + 1 < textInv.length){
			textInv.selectedIndex = textInv.selectedIndex + 1;
			CompletMotto();
			if (textInv.selectedIndex + 1 == textInv.length){
				alert(\'Ati ajuns la sfirsitul listei.\');
			}
		}	
		else{
			alert(\'Ati ajuns la sfirsitul listei.\');
		}
	}
	
	function MottoAnterior(){
		textInv = document.FormularText.InvMotto;
		if (textInv.selectedIndex > 0){
			textInv.selectedIndex = textInv.selectedIndex - 1;
			CompletMotto();
			if (textInv.selectedIndex == 0){
				alert(\'Ati ajuns la inceputul listei.\');
			}			
		}	
		else{
			alert(\'Ati ajuns la inceputul listei.\');
		}
	}	
	
	function SchimbaMotto(){
	
	
	
		textInv = document.FormularText.InvMotto;
		for (i = 0; i < textInv.length; i++){
			if (textInv.options[i].value.search(\'Custom\') != -1){
				if (textInv.selectedIndex != i){
					textInv.options[i].selected = true;
					textInv.value = textInv.options[i].value;
					return;
				}
			}
		}
	}
	
		
	//-->
	</SCRIPT>
	';

			$_SESSION['zisapt'] = '';
			$_SESSION['zisapt2'] = '';
			$_SESSION['luna'] = '';
			$_SESSION['luna2'] = '';
		} else {
		}
	}

	?>
	<script type="text/javascript" src="prototype.js"></script>
	<script type="text/javascript" src="scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="lightbox.js"></script>
	<script language="JavaScript" type="text/javascript" src="wysiwyg.js"></script>
	<link rel="stylesheet" href="lightbox.css" type="text/css" media="screen" />
</head>

<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="0" height="100%" valign="top">
				<table width="100%" height="312" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="90">&nbsp;</td>
					</tr>
					<tr>
						<td height="215" background="images/index_112.gif">&nbsp;</td>
					</tr>
				</table>
			</td>
			<td width="900" height="100%">
				<table width="950" height="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="40" colspan="5">&nbsp;</td>
					</tr>
					<tr>
						<td width="288" height="39"></td>
						<td width="16" height="39" background="images/index_03.gif"></td>
						<td width="609" height="254" rowspan="2">
							<table width="559" height="254" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="609" height="15" background="images/index_04.gif"></td>
								</tr>
								<tr>
									<td width="609" height="239"><?php if (isset($pagimg)) {
																		echo $pagimg;
																	} else {
																		echo '<img src="page_img/home.gif" width="609" height="239" alt="">';
																	} ?></td>
								</tr>
							</table>
						</td>
						<td width="15" height="39" background="images/index_05.gif"></td>
						<td width="22" height="39"></td>
					</tr>
					<tr>
						<td height="215" colspan="2">
							<table width="304" height="215" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="292"><a href="index.php"><img src="images/LOGO.gif" width="292" height="215" border="0" alt="Top Mariage" /></a></td>
									<td width="12" background="images/index_09.gif">&nbsp;</td>
								</tr>
							</table>
						</td>
						<td height="215" colspan="2">
							<table width="37" height="215" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="15" height="215" background="images/index_10.gif">&nbsp;</td>
									<td width="22" background="images/index_11.gif">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td width="288" height="100%" rowspan="3" valign="top">
							<table width="288" height="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="108" height="100%" rowspan="2">&nbsp;</td>
									<td width="180" valign="top">
										<?php

										$categorii = mysqli_num_rows(mysqli_query($conexiune, 'SELECT * FROM `categorii`'));
										if ($categorii == 0) {
											echo 'In constructie !';
										} else {
											echo '
							<div class="linkdiv">
							  <ul id="linktree">';
											$cerereSQL = 'SELECT * FROM `categorii` ORDER BY `nrordine` ASC';
											$rezultat = mysqli_query($conexiune, $cerereSQL);
											while ($rand = mysqli_fetch_assoc($rezultat)) {
												echo '<li><table width="180" heigh="38" border="0" cellpaddin="0" cellspacing="0"><tr><td width="180" height="38" align="center" valign="center" background="images/buton.gif" style="padding-top:5px;"><a href="' . $rand['url'] . '">' . $rand['nume'] . '</a></td></tr></table>';
												if ($rand['subcat'] == 'da') {
													echo '<ul>';
													$cerereSQL2 = 'SELECT * FROM `subcategorii` WHERE `cat`="' . $rand['nume'] . '" ORDER BY `nrordine` ASC';
													$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
													while ($rand2 = mysqli_fetch_assoc($rezultat2)) {
														echo '<li><a href="' . $rand2['url'] . '">' . $rand2['nume'] . '</a></li>';
													}
													echo '</ul>';
												}
												echo '</li>';
											}
											echo '
							  </ul>
							</div>';
										}
										?> </td>
								</tr>
								<tr>
									<td width="180" height="100%">&nbsp;</td>
								</tr>
							</table>
						</td>
						<td width="16" height="50%" background="images/index_16.gif">&nbsp;</td>
						<td width="609" height="1000%" background="images/pattern.gif">