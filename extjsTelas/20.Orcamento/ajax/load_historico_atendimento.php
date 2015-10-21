<?php require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
?>
<style type="text/css">
	h2.historico-atendimento-title{
		text-align: center;
		font-size: 18px;
		text-shadow: 1px 1px 4px rgba(0, 0, 0, .4);
		font-weight: bolder;
	}
	div.historico-atendimento{
		border: 7px dashed #d0def0;
	}
	#historico-atendimento-data{
		float:left; 
		margin-top:15px; 
		margin-left:15px;
		text-shadow: 1px 1px 4px rgba(0, 0, 0, .4);
		font-weight: bolder;
	}
	#historico-atendimento-descricao{
		margin-top: 15px; 
		margin-left:225px;
		text-shadow: 1px 1px 4px rgba(0, 0, 0, .4);
		font-weight: bolder;
	}
	#historico-atendimento-maindiv{
		margin:-10px 10px 10px 10px; 
		margin-top:5px; 
		padding: 18 0 0 0; 
		overflow:auto;
	}
	.historico-atendimento-linhas:first-child{
		border-top:1px dashed #d0def0;
	}
	.historico-atendimento-linhas{
		padding:5px;
		border-bottom:1px dashed #d0def0;
		border-left:1px dashed #d0def0;
		border-right:1px dashed #d0def0;
		transition:all 100ms;
		-webkit-transition:all 100ms;
	}
	.historico-atendimento-linhas:hover{
		background-color:#d0def0;
		padding:15px 5px 15px 5px;
	}
</style>
<?

$nrcpf = post('nrcpf');
$idpedido = post('idpedido');
$idcontato = post('idcontato');
$height = post('height');

$lista = Sql::arrays('SATURN','ATENDIMENTO',"sp_SimpacWebHistoricoAtendimentoIdContato '".$idcontato."'");


if(count($lista) == 0){
	unset($lista);
	
	if($nrcpf == NULL || $nrcpf == ""){
		$lista_cpf = Sql::arrays('FOCUS','SIMPAC',"sp_controlefinanceiro_union_cliente_list_matricula '".$idpedido."'");
		$nrcpf = $lista_cpf[0]['nrcpf'];
		unset($lista_cpf);
	}
	
	$lista = Sql::arrays('SATURN','ATENDIMENTO',"sp_SimpacWebHistoricoAtendimentoCPF '".$nrcpf."'");
}
//////////////////////////////////////////////////////////////////////////////////////////////
echo '<h2 class="historico-atendimento-title">Hist&oacute;rico Atendimento</h2>
		<div class="historico-atendimento">
			<div id="historico-atendimento-data"><b>Data atendimento</b></div>
			<div id="historico-atendimento-descricao" ><b>Descrição</b></div>
			<div id="historico-atendimento-maindiv" style="height:'.$height.'px;">';
		
foreach($lista as $r){

	$bgcolor = linhaszebra($bgcolor);
	
	echo '<div class="'.$bgcolor.' historico-atendimento-linhas">'.$r['DesHistorico'].'</div>';

}
//////////////////////////////////////////////////////////////////////////////////////////////
echo '</div></div>';
//////////////////////////////////////////////////////////////////////////////////////////////
unset($lista);
//////////////////////////////////////////////////////////////////////////////////////////////
?>