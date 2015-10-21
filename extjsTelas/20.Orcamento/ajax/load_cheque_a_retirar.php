<?php require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
//////////////////////////////////////////////////////////////////////////////////////////////
$idpedido = post('idpedido');
if($idpedido == ''){$idpedido = 0;}
//////////////////////////////////////////////////////////////////////////////////////////////
/*if(replicacao('FOCUS','Simpac','SPIDER','Simpac','tb_ChequeARetirarContato') == 1)
{
	$a = "'SPIDER','Simpac'";
}
else
{
	$a = "'FOCUS','Simpac'";
}*/
//////////////////////////////////////////////////////////////////////////////////////////////
$r= Sql::arrays('SATURN', 'SIMPAC','sp_OrcamentoChequeARetirar '.($idpedido-15000));
//////////////////////////////////////////////////////////////////////////////////////////////
?>
<style type="text/css">
	#orcamento_chequeretirar{
		padding:10px;
	}
	#div_ajax_chequearetirar{
		position:relative;
		margin:0 auto;
		width:600px;
		height:auto;
		padding:20px;
		overflow:auto;
	}
	#div_ajax_chequearetirar > #content_aba_1 table{
		margin:auto;
		margin-top:1%;
		margin-bottom:5%;
		box-shadow: 5px 9px 32px 2px rgb(187, 187, 187);
	}
	#div_ajax_chequearetirar > #content_aba_1 table th{
		border: 3px dashed #FFFFFF;
		height:35px;
		background:rgb(209, 225, 238);
	}
	#div_ajax_chequearetirar > #content_aba_1 table td{
		border: 3px dashed #FFFFFF;
		height:35px;
		background: rgb(232, 243, 252);
	}
	#div_ajax_chequearetirar > #content_aba_1 table th:hover,
	#div_ajax_chequearetirar > #content_aba_1 table td:hover{
		background-color:rgba(245, 245, 245, 0.1);
		border:3px solid #FFFFFF;
	}
</style>
<div id="div_ajax_chequearetirar">
    <div id="content_aba_1">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
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
	</div>
</div>
<?php unset($lista3);?>