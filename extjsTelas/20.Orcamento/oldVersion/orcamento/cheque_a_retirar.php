<?php require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); ?>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////
$idpedido = post('idpedido');
if($idpedido == ''){$idpedido = 0;}
//////////////////////////////////////////////////////////////////////////////////////////////
if(replicacao('FOCUS','Simpac','SPIDER','Simpac','tb_ChequeARetirarContato') == 1)
{
	$a = "'SPIDER','Simpac'";
}
else
{
	$a = "'FOCUS','Simpac'";
}
//////////////////////////////////////////////////////////////////////////////////////////////
$r= Sql::arrays($a,'sp_OrcamentoChequeARetirar '.($idpedido-15000));
//////////////////////////////////////////////////////////////////////////////////////////////
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:10px; margin-top:-10px; text-align:left;padding: 15 0 0 0">
  <tr>
    <th width="100" height="25" align="right" class="th">Data da Retirada:</th>
    <td><?php echo date("d/m/Y", $r[0]['dtretiradacheque']);?></td>
  </tr>
  <tr>
    <th width="100" height="25" align="right" class="th">Contato:</th>
    <td><?php echo $r[0]['nmContato'];?></td>
  </tr>
  <tr>
    <th width="100" height="25" align="right" class="th">Emitente:</th>
    <td><?php echo $r[0]['emitente'];?></td>
  </tr>
  <tr>
    <th width="100" height="25" align="right" class="th">Endere&ccedil;o:</th>
    <td><?php echo $r[0]['desendereco'];?></td>
  </tr>
  <tr>
    <th width="100" height="25" align="right" class="th">Cep:</th>
    <td><?php echo $r[0]['cep'];?></td>
  </tr>
  <tr>
    <th width="100" height="25" align="right" class="th">Telefone:</th>
    <td><?php echo $r[0]['nrtelefone'];?></td>
  </tr>
</table>
<?php unset($lista3);?>