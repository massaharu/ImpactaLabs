<?php
$GLOBALS['JSON'] = true; $GLOBALS['wallpaper'] = false; $GLOBALS['ext_theme'] = false; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$GESTORIDPERMISSAO = 1;
$RHIDPERMISSAO = 2;
$DIRETORIAIDPERMISSAO = 3;

$idsolicitacaobolsaestudo = get('idsolicitacaobolsaestudo');

$solicitacaobolsaestudo = new SolicitacaoBolsaEstudos($idsolicitacaobolsaestudo);
$usuario = new Usuario($solicitacaobolsaestudo->idusuario);
$cargo = new Cargo($usuario->idcargo);
$curso = $solicitacaobolsaestudo->getCursoBySolicitacaobolsaestudos();
$aprovacaoDiretoria = $solicitacaobolsaestudo->getAprovacaoBySolicitacaobolsaestudos($DIRETORIAIDPERMISSAO);
$aprovacaoRH = $solicitacaobolsaestudo->getAprovacaoBySolicitacaobolsaestudos($RHIDPERMISSAO);

function maskCPF($nrcpf){
	return substr($nrcpf, 0, -8).'.'.substr($nrcpf, 3, -5).'.'.substr($nrcpf, 6, -2).'-'.substr($nrcpf, -2);
}
function getCheckedBox($boxValue, $matchValue){
	if($boxValue == $matchValue){
		echo "<img src='/simpacweb/modulos/RH/solicitacaoBolsaEstudos/img/checked_box.png' />";
	}else{
		echo "<img src='/simpacweb/modulos/RH/solicitacaoBolsaEstudos/img/unchecked_box.png' />";
	}
}
function myGetDate($timestampDate){
	if($timestampDate == "" || $timestampDate == NULL){
		return "-";
	}else{
		return date("d/m/Y", $timestampDate);
	}
}
?>
<html>
    <head>
        <title>Solicitação de Bolsa de Estudos <?=$idsolicitacaobolsaestudo?></title>
        <? echo '<link rel="stylesheet" media="all" type="text/css" href="css/solicitacaoBolsaEstudos.css">';?>
    <head>
    <body>
    	<div id="main-div">
            <div id="main-title">
            	<img src="/simpacweb/modulos/RH/solicitacaoBolsaEstudos/img/print_impacta-logo.png" />
                <h3>SOLICITAÇÃO DE BOLSA DE ESTUDOS</h3>
            </div>   
            <div id="dados-solicitante">
            	<strong>Dados do Solicitante:</strong>
                <table>
                	<tbody>
                    	<tr>
                        	<td class="myborder-bottom" colspan="2"><strong>Nome do Colaborador(a): </strong><?=$usuario->nmcompleto?></td>
                        </tr>
                        <tr class="half">
                        	<td><strong>Departamento:  </strong><?=$usuario->desdepto?></td>
                            <td><strong>Cargo:  </strong><?=$cargo->descargo?></td>
                        </tr>
                        <tr class="half">
                        	<td><strong>Dt Admissão:  </strong><?=myGetDate($usuario->dtadmissao)?></td>
                            <td><strong>CPF:  </strong><?=maskCPF($usuario->nrcpf)?></td>
                        </tr>
                    <tbody>
                </table>
            </div> 
            <div id="beneficiario">
            	<strong>Beneficiário: </strong> 
				<?=getCheckedBox($solicitacaobolsaestudo->idsolicitacaobolsaestudostipo, 1)?><strong>Titular</strong> 
                <?=getCheckedBox($solicitacaobolsaestudo->idsolicitacaobolsaestudostipo, 2)?><strong>Dependente</strong> 
                <table>
                	<tbody>
                    	<tr>
                        	<td class="myborder-bottom" colspan="2">
                            	<strong>Dependente: </strong>
                                <?=getCheckedBox($solicitacaobolsaestudo->iddependentetipo, 1)?><strong>Cônjuge</strong>
                                <?=getCheckedBox($solicitacaobolsaestudo->iddependentetipo, 2)?><strong>Filho(a)</strong> 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Nome do Aluno: </strong><?=utf8_encode($solicitacaobolsaestudo->desnomedependente)?></td>
                        </tr>
                        <tr>
                        	<td colspan="2"><strong>Data Nascimento: </strong><?=myGetDate(timestamp($solicitacaobolsaestudo->dtnascimentodependente))?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>CPF: </strong><?=maskCPF($solicitacaobolsaestudo->nrcpfdependente)?></td>
                        </tr>
                        <tr>
                        	<td colspan="2"><strong>e-mail: </strong><?=$solicitacaobolsaestudo->desemaildependente?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="myborder-top myborder-left myborder-right"><strong>Nome do Curso: </strong><?=utf8_encode($curso['curso_titulo'])?></td>
                        </tr>
                        <tr>
                        	<td colspan="2" class="myborder-bottom myborder-left myborder-right"><strong>Semestre Letivo: </strong><?=utf8_encode($curso['dessemestre'])?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Justificativa: </strong> <?=$solicitacaobolsaestudo->desjustificativa?></td>
                        </tr>
                        <tr>
                        	<td class="half">
                                <div>____________________________</div><strong>
                                <strong>Assinatura do Colaborador(a)<strong>
                        	</td>
                            <td class="half">
                                <div>____________________________</div>
                                <strong>Assinatura do Superior Imediato<strong>
                        	</td>
                        </tr>
                    <tbody>
                </table>
            </div>
            <div id="reservado-analise">
            	<table>
                	<tbody>
                    	<tr>
                        	<td colspan="2"><strong>Reservado para Análise: </strong></td>
                        </tr>
                    	<tr>	
                        	<td colspan="2">
                                <?=getCheckedBox($aprovacaoDiretoria['instatus'], 1)?><strong>Deferido</strong>
                                <?=getCheckedBox($aprovacaoDiretoria['instatus'], 0)?><strong>Indeferido</strong> 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Motivo: </strong><?=utf8_encode($aprovacaoDiretoria['desmotivo'])?> </td>
                       <tr>
                        	<td class="myborder-bottom"colspan="2"><strong>Percentual: </strong><?=utf8_encode($aprovacaoRH['nrpercentual']).'%'?></td>
                       </tr>
                       <tr>
                        	<td class="half">
                                <strong>Data: _____/_____/_____</strong>
                        	</td>
                            <td class="half">
                               <strong>Diretoria: _________________________________</strong>
                        	</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    <script type="text/javascript">
		window.print();
		setTimeout(function(){
			window.close();		
		},1000);
	</script>
</html>

