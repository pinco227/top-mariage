<?php
echo '<p align="center">';
$cerereSQL = 'SELECT * FROM `categorii` ORDER BY `nrordine` ASC';
$rezultat = mysqli_query($conexiune, $cerereSQL);
while ($rand = mysqli_fetch_assoc($rezultat)) {
  echo '
				<a href="' . $rand['url'] . '">' . $rand['nume'] . '</a> - ' . $rand['descriere'] . '<br>
			';
}
$cerereSQL2 = 'SELECT * FROM `subcategorii` ORDER BY `nrordine` ASC';
$rezultat2 = mysqli_query($conexiune, $cerereSQL2);
while ($rand = mysqli_fetch_assoc($rezultat2)) {
  echo '
				<a href="' . $rand['url'] . '">' . $rand['nume'] . '</a> - ' . $rand['descriere'] . '<br>
			';
}
echo '</p>';
?> </td>
<td width="15" height="50%" background="images/index_18.gif">&nbsp;</td>
<td width="22" height="100%" rowspan="3">&nbsp;</td>
</tr>
<tr>
  <td width="16" height="18" background="images/index_19.gif">&nbsp;</td>
  <td width="609" height="18" background="images/index_20.gif">&nbsp;</td>
  <td width="15" height="18" background="images/index_21.gif">&nbsp;</td>
</tr>
<tr>
  <td height="100%" colspan="3">
    <table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="16" height="12" background="images/index_03.gif"></td>
        <td width="271" height="12" background="images/index_04.gif"></td>
        <td width="15" height="12" background="images/index_05.gif"></td>
      </tr>
      <tr>
        <td width="16" height="100%" background="images/index_16.gif">&nbsp;</td>
        <td width="271" align="center" valign="middle" background="images/pattern.gif">&copy; 2007 TopMariage.Ro. <br />
          Toate drepturile rezervate.<br />
          Creat de <a href="https://github.com/pinco227" target="_blank">Paul Istratoaie</a> .<br /></td>
        <td width="15" height="100%" background="images/index_18.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="16" height="18" background="images/index_19.gif"></td>
        <td width="271" height="18" background="images/index_20.gif"></td>
        <td width="15" height="18" background="images/index_21.gif"></td>
      </tr>
    </table>
  </td>
</tr>
</table>
</td>
<td width="50%" height="100%" valign="top">
  <table width="100%" height="294" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="79">&nbsp;</td>
    </tr>
    <tr>
      <td width="100%" height="215" background="images/index_11.gif">&nbsp;</td>
    </tr>
    <tr></tr>
  </table>
</td>
</tr>
</table>
</body>

</html>