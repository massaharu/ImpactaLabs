<?php require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
//////////////////////////////////////////////////////////////////////////////////////////////
?>
<style type="text/css">
	h2.historico-orcamento-title{
		text-align:center;
		font-size: 18px;
		text-shadow: 1px 1px 4px rgba(0, 0, 0, .4);
		font-weight: bolder;
	}
	#historico-orcamento-maindiv{
		margin:-10px 10px 10px 10px; 
		margin-top:5px; 
		padding: 18 0 0 0; 
		overflow:auto;
	}
	.historico-orcamento-linhas:first-child{
		border-top:1px dashed #d0def0;
	}
	.historico-orcamento-linhas{
		padding:5px;
		border-bottom:1px dashed #d0def0;
		border-left:1px dashed #d0def0;
		border-right:1px dashed #d0def0;
		transition:all 100ms;
		-webkit-transition:all 100ms;
	}
	.historico-orcamento-linhas:hover{
		background-color:#d0def0;
		padding:15px 5px 15px 5px;
	}
	#historico-orcamento-data{
		float:left;
		margin-left:10px;
		text-shadow: 1px 1px 4px rgba(0, 0, 0, .4);
		font-weight: bolder;
	}
	#historico-orcamento-descricao{
		margin-left:250px;
		text-shadow: 1px 1px 4px rgba(0, 0, 0, .4);
		font-weight: bolder;
	}
	#historico-orcamento{
		border: 7px dashed #d0def0;
	}
</style>
<?
$historicOrc = Sql::arrays('SATURN','SIMPAC',"sp_historicopedido_list ".(post('idpedido') - 15000)."");

//////////////////////////////////////////////////////////////////////////////////////////////
echo '<h2 class="historico-orcamento-title">Hist&oacute;rico Orçamento</h2>
		<div id="historico-orcamento">
			<div id="historico-orcamento-data"><b>Data Orçamento</b></div>
			<div id="historico-orcamento-descricao"><b>Descrição</b></div>
			<div id="historico-orcamento-maindiv" style="height:'.post('height').'px;">';

if($historicOrc){
	foreach($historicOrc as $r){
		$bgcolor = linhaszebra($bgcolor);
		echo '<div class="'.$bgcolor.' historico-orcamento-linhas" >'.$r['deshistorico'].'</div>';
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////
echo '</div></div>';
//////////////////////////////////////////////////////////////////////////////////////////////
unset($historicOrc);
//////////////////////////////////////////////////////////////////////////////////////////////
?>