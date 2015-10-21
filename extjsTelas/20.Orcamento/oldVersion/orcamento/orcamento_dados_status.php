<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idpedido = post('idpedido');
	
$lista = Sql::query("FOCUS","Simpac","sp_orcamentostatus_list ".($idpedido-15000));
?>
<h3 style="margin:10px;">Status Atual</h3>
<table class="table" style="margin:10px;" width="auto" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="font-weight:bold; width:250px;">Account</td>
    <td style="font-weight:bold;">Status</td>
    <td style="font-weight:bold; width:110px;">Data do Status</td>
  </tr>
  <?php

	while($r = ors($lista))
	{
		if($r['idstatus'] == 6)
		{
			echo '<tr>
    <td>'.linkpermissao('modulos/account/account_dados.php', 'cod_cli='.$r['cod_cli'], $r['nome_cli'], '', '', 'account.png').'</td>
    <td style="color:#090; font-weight:bold;">'.utf8_encode($r['desstatus']).'</td>
    <td>'.formatdatetime($r['dtcadastro'],0).'</td>
  </tr>';
		}
		elseif($r['idstatus'] == 7)
		{
			echo '<tr>
    <td>'.linkpermissao('modulos/account/account_dados.php', 'cod_cli='.$r['cod_cli'], $r['nome_cli'], '', '', 'account.png').'</td>
    <td style="color:#C00; font-weight:bold;">'.utf8_encode($r['desstatus']).'</td>
    <td>'.formatdatetime($r['dtcadastro'],0).'</td>
  </tr>';
		}
		elseif($r['idstatus'] == 22)
		{
			echo '<tr>
    <td>'.linkpermissao('modulos/account/account_dados.php', 'cod_cli='.$r['cod_cli'], $r['nome_cli'], '', '', 'account.png').'</td>
    <td style="color:#C00; font-weight:bold;">'.utf8_encode($r['desstatus']).'</td>
    <td>'.formatdatetime($r['dtcadastro'],0).'</td>
  </tr>';
		}
		elseif($r['idstatus'] == 23)
		{
			echo '<tr>
    <td>'.linkpermissao('modulos/account/account_dados.php', 'cod_cli='.$r['cod_cli'], $r['nome_cli'], '', '', 'account.png').'</td>
    <td style="color:#C00; font-weight:bold;">'.utf8_encode($r['desstatus']).'</td>
    <td>'.formatdatetime($r['dtcadastro'],0).'</td>
  </tr>';
		}
		elseif($r['idstatus'] == 24)
		{
			echo '<tr>
    <td>'.linkpermissao('modulos/account/account_dados.php', 'cod_cli='.$r['cod_cli'], $r['nome_cli'], '', '', 'account.png').'</td>
    <td style="color:#C00; font-weight:bold;">'.utf8_encode($r['desstatus']).'</td>
    <td>'.formatdatetime($r['dtcadastro'],0).'</td>
  </tr>';
		}
		else
		{
			echo '<tr>
    <td>'.linkpermissao('modulos/account/account_dados.php', 'cod_cli='.$r['cod_cli'], $r['nome_cli'], '', '', 'account.png').'</td>
    <td>'.utf8_encode($r['desstatus']).'</td>
    <td>'.formatdatetime($r['dtcadastro'],0).'</td>
  </tr>';
		}
		
	}
	
	unset($lista);
  ?>
</table>