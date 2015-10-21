<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

//$PATH = "/simpacweb/modulos/corporativo/admSolicitacaoCorporativa"; //PRODUÇÃO
$PATH = "/simpacweb/labs/Massaharu/extjsTelas/22.AdmSolicitacaoCorporativa"; //TESTE
?>
<link rel="stylesheet" href="<?=$PATH?>/res/css/default.css" type="text/css" />
<script type="text/javascript" src="<?=$PATH?>/res/js/default.js?time=<?=time()?>"></script>
<?
$objsolicitacaocorp = new SolicitacaoCorporativa(post('idsolicitacaocorp'));

$solicitante = new Usuario($objsolicitacaocorp->idsolicitante);
$solicitante_nmcompleto = getLinkPermissaoUsuario($objsolicitacaocorp->idsolicitante, $solicitante->nmcompleto);

$dtsolicitante = ($objsolicitacaocorp->dtcadastro->getTimestamp())? date("d/m/Y - H:i:s", $objsolicitacaocorp->dtcadastro->getTimestamp()) : "--/--/--";

//my Functions
function getCursoAgendadoDescHistorico($idcursoagendado){
	$cursoagendado = new CursoAgendado($idcursoagendado);
	$curso = new Curso($cursoagendado->idcurso);
	$desperiodo = $cursoagendado->desperiodo;
	$descurso = ($cursoagendado->desobs)? $curso->descurso.' - '.$cursoagendado->desobs : $curso->descurso;
	$instrutor = $cursoagendado->getInstrutor();
	$sala = new Sala($cursoagendado->idsala);
	$dtinicio = ($cursoagendado->dtinicio)? date('d/m/Y', $cursoagendado->dtinicio) : "-";
	$dttermino = ($cursoagendado->dttermino)? date('d/m/Y', $cursoagendado->dttermino) : "-";
	$hrinicio = ($cursoagendado->dtinicio)? date('H:i:s', $cursoagendado->dtinicio) : "-";
	$hrtermino = ($cursoagendado->dttermino)? date('H:i:s', $cursoagendado->dttermino) : "-";

	return getLinkPermissaoCurso($cursoagendado->idcursoagendado, $descurso)."<br /><b>De:</b> ".$dtinicio." <b>Até:</b> ".$dttermino." <b>das</b> ".$hrinicio." <b>às</b> ".$hrtermino."<br /><b>Sala:</b> ".$sala->dessala." / <b>Instrutor:</b> ".getLinkPermissaoInstrutor($instrutor->idinstrutor, $instrutor->desinstrutor)."<br /><b>Período: </b>".$desperiodo ;
}
function getSolicitado($idsolicitado, $dtalteracao){
	$dtalteracao = date("d/m/Y H:i:s", $dtalteracao->getTimestamp());
	if($idsolicitado && $dtalteracao){
		$solicitado = new Usuario($idsolicitado);
		$solicitado_nmcompleto = $solicitado->nmcompleto;
		
		return "<br /><b>Alterado pelo(a)</b> ".getLinkPermissaoUsuario($idsolicitado, $solicitado_nmcompleto)." <b>às</b> ".$dtalteracao;
	}
}
function getStatusIcon($instatus, $tipo){
	if($instatus)
		return ($tipo == 1)? "<img style='width:40px; height:40px;' src='/simpacweb/images/ico/72/ok_256.png'><span style='color:green;'>Solicitação já executada</span>" : "<img style='width:26px; height:26px;' src='/simpacweb/images/ico/72/ok_256.png' title='Emissão Solicitada' alt='Emissão Solicitada'>";
	else
		return ($tipo == 1)? "<img style='width:40px; height:40px;' src='/simpacweb/images/ico/72/Gnome-Dialog-Question-64.png'><span style='color: rgb(28, 28, 155);'>Solicitação ainda não executada</span>" : "<img style='width:26px; height:26px;' src='/simpacweb/images/ico/72/Gnome-Dialog-Question-64.png' title='Emissão  NÃO Solicitada' alt='Emissão  NÃO Solicitada'>";
}



function getLinkPermissaoMatricula($matricula){
	$matStatus = "";
	
	$arr_controlefinanceiro = Sql::arrays("SATURN", "SIMPAC", "sp_controlefinanceiro_get_matricula '".$matricula."'");
	
	if(count($arr_controlefinanceiro) == 0){
		$arr_controlefinanceiro = Sql::arrays("SATURN", "SIMPAC", "sp_controlefinanceiro_get_matricula ".$matricula);
	}
	
	if(count($arr_controlefinanceiro) == 0){
		$matStatus = "<span style='margin-left:5px; color:red; font-weight:bolder;'>CANCELADO</span>" ;
	}
	
	return '<span class="linkpermissao"><a onclick="javascript:openFichaMatricula('.$matricula.')" matricula="'.$matricula.'" href="#'.$matricula.'" title="'.$matricula.'"><img title="'.$matricula.'" src="/simpacweb/images/ico/16/matricula.png">'.$matricula.'</a></span>'.$matStatus;
}

function getLinkPermissaoUsuario($idusuario, $desusuario){
	return '<span class="linkpermissao"><a target="blank" href="/simpacweb/modulos/usuario/usuario_dados.php?idusuario='.$idusuario.'" title="'.$desusuario.'"><img title="'.$desusuario.'" src="/simpacweb/images/ico/16/usuario.png">'.$desusuario.'</a></span>';
}

function getLinkPermissaoOrcamento($orcamento){
	return '<span class="linkpermissao"><a onclick="javascript:openOrcamentoWindow(this)" idpedido="'.$orcamento.'" href="#'.$orcamento.'" title="'.$orcamento.'"><img title="'.$orcamento.'" src="/simpacweb/images/ico/16/orcamento.png">'.$orcamento.'</a></span>';
}

function getLinkPermissaoAluno($_idaluno){
	
	$Aluno = new Aluno($_idaluno);
	$idaluno = $Aluno->idaluno;
	$nmaluno = $Aluno->nmaluno;
	$nrcpf = $Aluno->nrcpf;
	$alunoStatus;
	
	if(!$Aluno->idaluno){
		if(trim($_idaluno) == ""){ 
			$alunoStatus = "<span style='color:red; font-weight:bolder;'>Aluno não encontrado nesta matricula e/ou ocorreu algum erro. Por favor, refazer a solicitação!</span>"; 
		}else{
			$arr_aluno = Aluno::getAlunoAlterados($_idaluno);
			$idaluno = $arr_aluno["idaluno"];
			$nmaluno = $arr_aluno["nmaluno"];
			$nrcpf = $arr_aluno["nrcpf"];
			if(!$idaluno){
				$alunoStatus = "<span style='color:red; font-weight:bolder;'>Aluno não encontrado nesta matricula!</span>";
			}
		}
	}
	
	$nrcpf = ($nrcpf)? $nrcpf : "N/A";
	
	return '<span class="linkpermissao"><a target="blank" href="/simpacweb/modulos/aluno/aluno_dados.php?idaluno='.$idaluno.'" title="'.$nmaluno.'"><img title="'.$nmaluno.'" src="/simpacweb/images/ico/16/aluno.png">'.$nmaluno.'</a> <b>CPF: </b>'.$nrcpf.'</span>'.$alunoStatus;
}

function getLinkPermissaoCurso($idcursoagendado, $descurso){
	return '<span class="linkpermissao"><a target="blank" href="https://simpac.impacta.com.br/simpacweb/modulos/cursosagendados/treinamento_valoresPagos2.php?idcursoagendado='.$idcursoagendado.'" title="'.$descurso.'"><img title="'.$descurso.'" src="/simpacweb/images/ico/16/curso.png">'.$descurso.'</a></span>';
}

function getLinkPermissaoInstrutor($idinstrutor, $desinstrutor){
	return '<span class="linkpermissao"><a target="blank" href="/simpacweb/modulos/instrutor/instrutor_dados.php?idinstrutor='.$idinstrutor.'" title="'.$desinstrutor.'"><img title="'.$desinstrutor.'" src="/simpacweb/images/ico/16/instrutor.png">'.$desinstrutor.'</a></span>';
}

?>
<body>
	<div id="status_solicitacao" class="status-<?=$objsolicitacaocorp->instatus?>">
    	<?=getStatusIcon($objsolicitacaocorp->instatus,1);?>
    </div>
    <div id="accordion">
   
<!--------------------------- ALTERAÇÃO DE NF -------------------------------------------------->
        <? if($objsolicitacaocorp->innfalterado){ 
		
			$arr_nffaturamentoalterado = array();
			$arr_nffaturamentoalterado = $objsolicitacaocorp->getNffaturamentoalteradoBySolicitacao();
			
			$matricula = $arr_nffaturamentoalterado[0]["matricula"]; 
			$alterarNF_nf_endereco = $arr_nffaturamentoalterado[0]["desendereco"];  
			$alterarNF_nf_cep = $arr_nffaturamentoalterado[0]["descep"];  
			$alterarNF_nf_bairro = $arr_nffaturamentoalterado[0]["desbairro"];  
			$alterarNF_nf_cidade = $arr_nffaturamentoalterado[0]["descidade"];  
			$uf = $arr_nffaturamentoalterado[0]["desestado"];  
			$alterarNF_nf_endereco2 = $arr_nffaturamentoalterado[0]["desenderecoentrega"];  
			$alterarNF_nf_bairro2 = $arr_nffaturamentoalterado[0]["desbairroentrega"];  
			$alterarNF_nf_cidade2 = $arr_nffaturamentoalterado[0]["descidadeentrega"];  
			$uf2 = $arr_nffaturamentoalterado[0]["desestadoentrega"];  
			$alterarNF_nf_cep2 = $arr_nffaturamentoalterado[0]["descepentrega"];  
			$alterarNF_nf_contato = $arr_nffaturamentoalterado[0]["descontato"];  
			$alterarNF_nf_telefone = $arr_nffaturamentoalterado[0]["desfone"];  
			$alterarNF_nf_fax = $arr_nffaturamentoalterado[0]["desfax"];  
			$alterarNF_nf_email = $arr_nffaturamentoalterado[0]["desemail"];  
			$alterarNF_nf_obs = $arr_nffaturamentoalterado[0]["desobs"];  
			$alterarNF_nf_endereconf = $arr_nffaturamentoalterado[0]["desendereconf"];  
			$alterarNF_nf_tipo_endereco = $arr_nffaturamentoalterado[0]["desenderecotipo"];  
			$alterarNF_nf_numero = $arr_nffaturamentoalterado[0]["nrendereco"];  
			$alterarNF_nf_complemento = $arr_nffaturamentoalterado[0]["descomplemento"];  
			$alterarNF_nf_email2 = $arr_nffaturamentoalterado[0]["desemailnf"];  
			$alterarNF_nf_ccm = $arr_nffaturamentoalterado[0]["nrinscricaomunicipal"]; 	
			
			$alunoempresa = $objsolicitacaocorp->getAlunoEmpresabyAlunoAgendado();
			$empresa = new Empresa($alunoempresa[0]["idempresa"]);
			
			if(is_null($empresa->idempresa))
				$status = "<div class='notfound'>Não existe nenhum aluno agendado para esta matrícula!</div>";
			
			$historico_descricao = $status."<b>Dados da empresa: </b>".$empresa->nmempresa."<br /><b>CGC/CNPJ:</b> ".$empresa->nrcgc." / <b>Matrícula:</b> ".getLinkPermissaoMatricula($objsolicitacaocorp->matricula)."<br /><b>Solicitado pelo(a)</b> ".$solicitante_nmcompleto." <b>às</b> ".$dtsolicitante."".getSolicitado($objsolicitacaocorp->idsolicitado, $objsolicitacaocorp->dtalteracao);	
		?>
            <h3>Alterações na Nota Fiscal Faturamento</h3>
            <div>
            	<p><?=$historico_descricao?></p>
                <div class="alterarnfa">
                	<b><p style="text-align:center;">CCM: <?=$alterarNF_nf_ccm?></p></b>
                    <div class="alterarnfb">
                		<p class="title">Endereço para a Emissão da Nota Fiscal</p>
                        <div class="floater"><span>Endereço: </span><?=$alterarNF_nf_tipo_endereco?></div><div class="floater"><span> Rua: </span><?=$alterarNF_nf_endereco?></div><div ><span> Nº: </span><?=$alterarNF_nf_numero?></div>
                        <div class="floater"><span>Complemento: </span><?=$alterarNF_nf_complemento?></div><div ><span> CEP: </span><?=$alterarNF_nf_cep?></div>
                        <div class="floater"><span>Bairro: </span><?=$alterarNF_nf_bairro?></div><div class="floater"><span> Cidade: </span><?=$alterarNF_nf_cidade?></div><div ><span> Estado: </span><?=$uf?></div>
                        <div><span>E-mail: </span><?=$alterarNF_nf_email2?></div>
                        <div><span>Referência: </span><?=$alterarNF_nf_endereconf?></div>
                        <div><span>Obs: </span><?=$alterarNF_nf_obs?></div>
                	</div>
                    <div class="alterarnfb">
                		<p class="title">Endereço para a Entrega da Nota Fiscal</p>	
                        <div class="floater"><span>Contato: </span><?=$alterarNF_nf_contato?></div><div class="floater"><span>Telefone: </span><?=$alterarNF_nf_telefone?></div><div><span>Fax: </span><?=$alterarNF_nf_telefone?></div>
                        <div><span>E-mail: </span><?=$alterarNF_nf_email?></div>
                        <div><span>Endereço: </span><?=$alterarNF_nf_endereco2?></div>
                        <div class="floater"><span>Bairro: </span><?=$alterarNF_nf_bairro2?></div><div><span>CEP: </span><?=$alterarNF_nf_cep2?></div>
                        <div class="floater"><span>Cidade: </span><?=$alterarNF_nf_cidade2?></div><div><span>Estado: </span><?=$uf2?></div>
                	</div>
                </div>
            </div>
        <? } ?>   
        
<!--------------------------- ALTERAÇÃO DE DADOS ALUNO -------------------------------------------------->       
        <? if($objsolicitacaocorp->inalunoalterado){ 
			$arr_alunoalterado = array();
			$arr_alunoalterado = $objsolicitacaocorp->getAlunoalteradoBySolicitacao();
			
			$idalunoalterado = $arr_alunoalterado[0]["idalunoalterado"];
			$idsolicitacaocorp = $arr_alunoalterado[0]["idsolicitacaocorp"];
			$cdemail = $arr_alunoalterado[0]["desemail"];
			$cdemailempresa = $arr_alunoalterado[0]["desemailempresa"];
			$complemento = $arr_alunoalterado[0]["descomplemento"];
			$nmaluno = $arr_alunoalterado[0]["desaluno"];
			$desbairro = $arr_alunoalterado[0]["desbairro"];
			$descidade = $arr_alunoalterado[0]["descidade"];
			$desendereco = $arr_alunoalterado[0]["desendereco"];
			$dessexo = $arr_alunoalterado[0]["dessexo"];
			$dtnascimento = $arr_alunoalterado[0]["dtnascimento"];
			$idaluno = $arr_alunoalterado[0]["idaluno"];
			$idalunoagendado = $arr_alunoalterado[0]["idalunoagendado"];
			$nrcelular = $arr_alunoalterado[0]["nrcelular"];
			$nrcep = $arr_alunoalterado[0]["nrcep"];
			$nrcpf = $arr_alunoalterado[0]["nrcpf"];
			$nrrg = $arr_alunoalterado[0]["nrrg"];
			$nrtelefonecomercial = $arr_alunoalterado[0]["nrtelefonecomercial"];
			$nrtelefoneresidencial = $arr_alunoalterado[0]["nrtelefoneresidencial"];
			$num = $arr_alunoalterado[0]["nr"];
			$sgestado = $arr_alunoalterado[0]["desestadosigla"];
			$tipoendereco = $arr_alunoalterado[0]["desenderecotipo"];
			
			$dtnascimento = ($dtnascimento)? date('d/m/Y',$dtnascimento) : ''; 	
			
			$status = (!$objsolicitacaocorp->isAlunoAgendadoInMatricula($idaluno) && !$objsolicitacaocorp->instatus)? $status = "<div class='notfound'>Aluno não encontrado nesta matricula!</div>" : "";
			$aluno = getLinkPermissaoAluno($idaluno);
			$historico_descricao = $status."<b>Dados do Cliente:</b> ".$aluno."<br /><b>Matrícula:</b> ".getLinkPermissaoMatricula($objsolicitacaocorp->matricula)."<br /><b>Solicitado pelo(a)</b> ".$solicitante_nmcompleto." <b>às</b> ".$dtsolicitante."".getSolicitado($objsolicitacaocorp->idsolicitado, $objsolicitacaocorp->dtalteracao);
		?>     
          <h3>Alterações no Cadastro de Aluno</h3>
          <div>
          	<p><?=$historico_descricao?></p>
            <div class="alteraraluno">
            	<div><span>Nome: </span><?=$nmaluno?></div>
                <div><span>Email: </span><?=$cdemail?></div>
                <div><span>CPF: </span><?=$nrcpf?></div>
                <div><span>RG: </span><?=$nrrg?></div>
                <div class="floater"><span>Data de Nascimento: </span><?=$dtnascimento?></div><div><span>Cel: </span><?=$nrcelular?></div>
                <div><span>Endereço: </span><?=$desendereco?></div>
                <div><span>Bairro: </span><?=$desbairro?></div>
                <div class="floater"><span>Cidade: </span><?=$descidade?></div><div><span>CEP: </span><?=$nrcep?></div>
                <div class="floater"><span>UF: </span><?=$sgestado?></div><div><span>Complemento: </span><?=$complemento?></div>
                <div class="floater"><span>Nº: </span><?=$num?></div><div class="floater"><span>Sexo: </span><?=$dessexo?></div><div><span>Logradouro: </span><?=$tipoendereco?></div>
                <div><span>E-mail empresa: </span><?=$cdemailempresa?></div>
                <div><span>Tel. Comercial: </span><?=$nrtelefonecomercial?></div>
                <div><span>Tel.Residencial: </span><?=$nrtelefoneresidencial?></div>
            </div>
          </div>
        <? } ?>     
        
<!--------------------------- CADASTRO IMPACTA ONLINE -------------------------------------------------->        
        <? if($objsolicitacaocorp->incadimpactaonline){
				$Aluno = NULL;
				$arr_aluno = array();
				
				$arr_aluno = $objsolicitacaocorp->getAlunoalteradoBySolicitacao();
				$Aluno = new Aluno($arr_aluno[0]["idaluno"]);
				
				$idaluno = $Aluno->idaluno;
				$nmaluno = $Aluno->nmaluno;
				$nrcpf = $Aluno->nrcpf;
				$desemail = $Aluno->cdemail;
				
				$AlunoAgendado = new AlunoAgendado($arr_aluno[0]["idalunoagendado"]);
				
				$status = (!$objsolicitacaocorp->isAlunoAgendadoInMatricula($idaluno) && !$objsolicitacaocorp->instatus)? $status = "<div class='notfound'>Aluno não encontrado nesta matricula!</div>" : "";
				$aluno = getLinkPermissaoAluno($idaluno);
				$historico_descricao = $status."<b>Dados do Cliente:</b> ".$aluno."<br /><b>Matrícula:</b> ".getLinkPermissaoMatricula($objsolicitacaocorp->matricula)."<br /><b>Solicitado pelo(a)</b> ".$solicitante_nmcompleto." <b>às</b> ".$dtsolicitante."".getSolicitado($objsolicitacaocorp->idsolicitado, $objsolicitacaocorp->dtalteracao);
		?>
        	 <h3>Cadastro do Aluno(a) no Impacta Online</h3>
             <div>
                <p><?=$historico_descricao?></p>
                <div class="impacta-online">
                    <div><b>Nome: </b><?=$nmaluno?></div>
                    <div><b>CPF: </b><?=$nrcpf?></div>
                    <div><b>E-mail: </b><?=$desemail?></div>
                    <div><b>Codigo do(a) Aluno Agendado(a): </b><?=$AlunoAgendado->idalunoagendado?></div>
                    
                     <div class="impacta-online-trein">
                        <p class="title">Vinculado ao treinamento: </p>	
                        <div><?=getCursoAgendadoDescHistorico($AlunoAgendado->idcursoagendado)?></div>
                    </div>
                </div>
                
                <!-- Apenas solicitações conluídas terá a opção de reenviar email -->
                <? if($objsolicitacaocorp->instatus){ ?>
                <div class="btn-reenviar-email">
                	<button id="btn-reenviar-email" data-path="<?=$PATH?>" data-nrcpf="<?=str_replace(".", "", str_replace("-", "", $nrcpf))?>" data-email="<?=$desemail?>" data-solicitante="<?=$objsolicitacaocorp->idsolicitante?>" class="mybtn mybtn-primary">Reenviar Email</button>
                </div>
                <? } ?>
             </div>
		<? } ?>
        
<!--------------------------- REAGENDAMENTO DE TREINAMENTO -------------------------------------------------->        
        <? if($objsolicitacaocorp->intreinamentoalterado){ 
		
			$arr_reagendamento = array();
			$arr_reagendamento = $objsolicitacaocorp->getReagendamentoBySolicitacao();
			
			$alunoagendado = new AlunoAgendado($arr_reagendamento[0]["idalunoagendado"]);
			$idaluno = $alunoagendado->idaluno;
			
			$status = (!$objsolicitacaocorp->isAlunoAgendadoInMatricula($idaluno) && !$objsolicitacaocorp->instatus)? $status = "<div class='notfound'>Aluno não encontrado nesta matricula!</div>".$objsolicitacaocorp->instatus : "";
				
			$desmotivo = ($arr_reagendamento[0]["desmotivo"])? $arr_reagendamento[0]["desmotivo"] : "Sem motivo";
			
			//Se o alunoagendado tiver sido reagendado, busca o idaluno em tb_alunoagendado_alterados 
			if(is_null($alunoagendado->idalunoagendado)){
				$alunoagendadoalterados = AlunoAgendado::getAlunoAgendadoAlterados($arr_reagendamento[0]["idalunoagendado"]);
				$idaluno = $alunoagendadoalterados["idaluno"];
			}
			
			$aluno = new Aluno($idaluno);
			$aluno = getLinkPermissaoAluno($idaluno);
			
			$historico_descricao = $status."<b>Dados do Cliente:</b> ".$aluno."<br /><b>Matrícula:</b> ".getLinkPermissaoMatricula($objsolicitacaocorp->matricula)."<br /><b>Solicitado pelo(a)</b> ".$solicitante_nmcompleto." <b>às</b> ".$dtsolicitante."".getSolicitado($objsolicitacaocorp->idsolicitado, $objsolicitacaocorp->dtalteracao);
		?>
          <h3>Reagendamento de Treinamento</h3>
          <div>
          	<p><?=$historico_descricao?></p>
            <div class="treinamentoalterado">  
            	<p class="title">De treinamento: </p>	
            	<?=getCursoAgendadoDescHistorico($arr_reagendamento[0]["idcursoagendadoatual"])?>
            </div>
            <div class="treinamentoalterado">  
            	<p class="title">Para treinamento:</p>	
                <?=getCursoAgendadoDescHistorico($arr_reagendamento[0]["idcursoagendadonovo"])?>
            </div>
            <br />
            <div><b>Motivo:</b> <?=$desmotivo?></div>
          </div>
        <? } ?>  
        
<!--------------------------- TRANSFERÊNCIA DE TREINAMENTO -------------------------------------------------->        
        <? if($objsolicitacaocorp->intreinamentotransfer){ 
		
			$arr_transfer = array();
			$arr_transfer = $objsolicitacaocorp->getTransferenciaBySolicitacao();
			
			$desmotivo = ($arr_transfer[0]["desmotivo"])? $arr_transfer[0]["desmotivo"] : "Sem motivo";
			
			$arr_idalunosagendados = explode(',', $arr_transfer[0]["idalunosagendadosantigos"]);
			
			$alunoagendado = new AlunoAgendado($arr_idalunosagendados[0]);
			$idaluno = $alunoagendado->idaluno;
			
			$status = (!$objsolicitacaocorp->isAlunoAgendadoInMatricula($idaluno) && !$objsolicitacaocorp->instatus)? $status = "<div class='notfound'>Aluno não encontrado nesta matricula!</div>".$objsolicitacaocorp->instatus : "";
			
			//Se o alunoagendado tiver sido reagendado, busca o idaluno em tb_alunoagendado_alterados 
			if(is_null($alunoagendado->idalunoagendado)){
				$alunoagendadoalterados = AlunoAgendado::getAlunoAgendadoAlterados($arr_idalunosagendados[0]);
				$idaluno = $alunoagendadoalterados["idaluno"];
			}
			
			$aluno = new Aluno($idaluno);
			$aluno = getLinkPermissaoAluno($idaluno);
			
			$historico_descricao = $status."<b>Dados do Cliente:</b> ".$aluno."<br /><b>Matrícula:</b> ".getLinkPermissaoMatricula($objsolicitacaocorp->matricula)."<br /><b>Solicitado pelo(a)</b> ".$solicitante_nmcompleto." <b>às</b> ".$dtsolicitante."".getSolicitado($objsolicitacaocorp->idsolicitado, $objsolicitacaocorp->dtalteracao);
		?>
          <h3>Transferência de Treinamento</h3>
          <div>
          	<p><?=$historico_descricao?></p>
            <div class="valores-transferencia">
            	<hr />
            	<table>
                	<tbody>
                    	<tr>
                            <td>Orçamento:</td>
                            <td><?=getLinkPermissaoOrcamento($arr_transfer[0]["idpedido"] + 15000)?></td>
                        </tr>
                        <tr>
                            <td>Valor do Orçamento:</td>
                            <td>R$ <?=number_format($arr_transfer[0]["vlrorcamentoantigo"], 2, ",", ".")?></td>
                        </tr>
                        <tr>
                            <td>Valor do novo Orçamento:</td>
                            <td>R$ <?=number_format($arr_transfer[0]["vlrorcamentonovo"], 2, ",", ".")?></td>
                        </tr>
                        <tr>
                            <td>Diferença:</td>
                            <td>R$ <?=number_format($arr_transfer[0]["vlrorcamentodiferenca"], 2, ",", ".")?></td>
                        </tr>
                        <tr>
                            <td>Parcelas:</td>
                            <td><?=$arr_transfer[0]["qtdeparcela"]?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="treinamentoalterado">  
            	<p class="title">De treinamento(s): </p>	
            	<? foreach(explode(',', $arr_transfer[0]["idcursosagendadosantigos"]) as $idcursoagendado){
						echo getCursoAgendadoDescHistorico($idcursoagendado);
						echo '<hr />';
					} 
				?>
            </div>
            <div class="treinamentoalterado">  
            	<p class="title">Para treinamento(s):</p>	
                <? foreach(explode(',', $arr_transfer[0]["idcursosagendadosnovos"]) as $idcursoagendado){
						echo getCursoAgendadoDescHistorico($idcursoagendado);
						echo '<hr />';
					} 
				?>
            </div>
            <br />
            <div><b>Motivo:</b> <?=$desmotivo?></div>
          </div>
        <? } ?>         
        
<!--------------------------- REPOSIÇÃO DE TREINAMENTO -------------------------------------------------->        
        <? if($objsolicitacaocorp->intreinamentoreposicao){ 
		
			$arr_reposicao = array();
			$arr_reposicao = $objsolicitacaocorp->getReagendamentoBySolicitacao();
			
			$alunoagendado = new AlunoAgendado($arr_reposicao[0]["idalunoagendado"]);
			$idaluno = $alunoagendado->idaluno;
			
			$status = (!$objsolicitacaocorp->isAlunoAgendadoInMatricula($idaluno) && !$objsolicitacaocorp->instatus)? $status = "<div class='notfound'>Aluno não encontrado nesta matricula!</div>".$objsolicitacaocorp->instatus : "";
				
			$desmotivo = ($arr_reposicao[0]["desmotivo"])? $arr_reposicao[0]["desmotivo"] : "Sem motivo";
			
			//Se o alunoagendado tiver sido reagendado, busca o idaluno em tb_alunoagendado_alterados 
			if(is_null($alunoagendado->idalunoagendado)){
				$alunoagendadoalterados = AlunoAgendado::getAlunoAgendadoAlterados($arr_reposicao[0]["idalunoagendado"]);
				$idaluno = $alunoagendadoalterados["idaluno"];
			}
			
			$aluno = new Aluno($idaluno);
			$aluno = getLinkPermissaoAluno($idaluno);
			
			$historico_descricao = $status."<b>Dados do Cliente:</b> ".$aluno."<br /><b>Matrícula:</b> ".getLinkPermissaoMatricula($objsolicitacaocorp->matricula)."<br /><b>Solicitado pelo(a)</b> ".$solicitante_nmcompleto." <b>às</b> ".$dtsolicitante."".getSolicitado($objsolicitacaocorp->idsolicitado, $objsolicitacaocorp->dtalteracao);
		?>
          <h3>Reposição de Treinamento</h3>
          <div>
          	<p><?=$historico_descricao?></p>
            <div class="treinamentoalterado">  
            	<p class="title">De treinamento: </p>	
            	<?=getCursoAgendadoDescHistorico($arr_reposicao[0]["idcursoagendadoatual"])?>
            </div>
            <div class="treinamentoalterado">  
            	<p class="title">Para treinamento:</p>	
                <?=getCursoAgendadoDescHistorico($arr_reposicao[0]["idcursoagendadonovo"])?>
            </div>
            <br />
            <div><b>Motivo:</b> <?=$desmotivo?></div>
          </div>
        <? } ?>  
        
<!--------------------------- EMISSÃO LISTA DE PRESENÇA/CERTIFICADO -------------------------------------------------->        
        <? if($objsolicitacaocorp->inlistapresenca || $objsolicitacaocorp->incertificado){ 
		
			$alunoagendado = new AlunoAgendado($objsolicitacaocorp->idalunoagendado);		
			$idaluno = $alunoagendado->idaluno;
			$idcursoagendado = $alunoagendado->idcursoagendado;
			
			$status = (!$objsolicitacaocorp->isAlunoAgendadoInMatricula($idaluno) && !$objsolicitacaocorp->instatus)? $status = "<div class='notfound'>Aluno não encontrado nesta matricula!</div>" : "";
			 
			//Se o alunoagendado tiver sido reagendado, busca o idaluno em tb_alunoagendado_alterados 
			if(is_null($alunoagendado->idalunoagendado)){
				$alunoagendadoalterados = AlunoAgendado::getAlunoAgendadoAlterados($objsolicitacaocorp->idalunoagendado);
				$idaluno = $alunoagendadoalterados["idaluno"];
				$idcursoagendado = $alunoagendadoalterados["idcursoagendado"];
			}
			
			$aluno = new Aluno($idaluno);
			$aluno = getLinkPermissaoAluno($idaluno);
			$cursoagendado = new CursoAgendado($idcursoagendado);
			
			$historico_descricao = $status."<b>Dados do Cliente:</b> ".$aluno."<br /><b>Matrícula:</b> ".getLinkPermissaoMatricula($objsolicitacaocorp->matricula)."<br /><b>Solicitado pelo(a)</b> ".$solicitante_nmcompleto." <b>às</b> ".$dtsolicitante."".getSolicitado($objsolicitacaocorp->idsolicitado, $objsolicitacaocorp->dtalteracao);
			
		?>   
          <h3>Emissão de Certificado/Lista de Presença</h3>
          <div>
          	<p><?=$historico_descricao?></p>
            <div class="emissao">
            	<p class="title"><?=getStatusIcon($objsolicitacaocorp->incertificado, 2)?> Emissao de certificado: </p>
                <div><?=getCursoAgendadoDescHistorico($cursoagendado->idcursoagendado)?></div>
            </div>
            <div class="emissao">
            	<p class="title"><?=getStatusIcon($objsolicitacaocorp->inlistapresenca, 2)?> Emissao de Lista de Presença: </p
                ><div><?=getCursoAgendadoDescHistorico($cursoagendado->idcursoagendado)?></div>
            </div>
          </div>
        <? } ?>   
        
<!--------------------------- DESAGENDAMENTO DE ALUNO -------------------------------------------------->        
        <? if($objsolicitacaocorp->inalunodesagendado){ 
		
			$arr_desagendado = $objsolicitacaocorp->getReagendamentoBySolicitacao();
			
			$alunoagendado = new AlunoAgendado($arr_desagendado[0]["idalunoagendado"]);
			$idaluno = $alunoagendado->idaluno;
			$idcursoagendado = $alunoagendado->idcursoagendado;
			
			$status = (!$objsolicitacaocorp->isAlunoAgendadoInMatricula($idaluno) && !$objsolicitacaocorp->instatus)? $status = "<div class='notfound'>Aluno não encontrado nesta matricula!</div>" : "";
			
			$desmotivo = ($arr_desagendado[0]["desmotivo"])? $arr_desagendado[0]["desmotivo"] : "Sem motivo";
			
			//Se o alunoagendado tiver sido reagendado, busca o idaluno em tb_alunoagendado_alterados 
			if(is_null($alunoagendado->idalunoagendado)){
				$alunoagendadoalterados = AlunoAgendado::getAlunoAgendadoAlterados($objsolicitacaocorp->idalunoagendado);
				$idaluno = $alunoagendadoalterados["idaluno"];
				$idcursoagendado = $alunoagendadoalterados["idcursoagendado"];
			}
				
			$aluno = new Aluno($idaluno);
			$aluno = getLinkPermissaoAluno($idaluno);
			$cursoagendado = new CursoAgendado($idcursoagendado);
			
			$historico_descricao = $status."<b>Dados do Cliente:</b> ".$aluno."<br /><b>Matrícula:</b> ".getLinkPermissaoMatricula($objsolicitacaocorp->matricula)."<br /><b>Solicitado pelo(a)</b> ".$solicitante_nmcompleto." <b>às</b> ".$dtsolicitante."".getSolicitado($objsolicitacaocorp->idsolicitado, $objsolicitacaocorp->dtalteracao);
			
		?>   
          <h3>Desagendamento de Aluno</h3>
          <div>
          	<p><?=$historico_descricao?></p>
            <div class="emissao">
            	<p class="title">Desagendado do treinamento: </p>	
                <div><?=getCursoAgendadoDescHistorico($cursoagendado->idcursoagendado)?></div>
                <div><b>Motivo: </b><?=$desmotivo?></div>
            </div>
          </div>
        <? } ?>   
       
<!--------------------------- DESMEMBRAMENTO DE ALUNOS -------------------------------------------------->        
        <? if($objsolicitacaocorp->inalunodesmembrado){
			$arr_alunodesmembrado = array();
			$alunodesmembrado = array();
			$arr_alunodesmembrado = $objsolicitacaocorp->getAlunoDesmembradoBySolicitacao();
			
			$status = (!$objsolicitacaocorp->isAlunoAgendadoInMatricula($arr_alunodesmembrado[0]["idaluno"]) && !$objsolicitacaocorp->instatus)? $status = "<div class='notfound'>Aluno não encontrado nesta matricula!</div>" : "";
			
			$Aluno = new Aluno($arr_alunodesmembrado[0]["idaluno"]);
			$idaluno = $Aluno->idaluno;
			$nmaluno = $Aluno->nmaluno;
			$nrcpf = $Aluno->nrcpf;
			//Se não existir, buscar no alunos alterados 
			if(is_null($idaluno)){
				$alunodesmembrado = Aluno::getAlunoAlterados($arr_alunodesmembrado[0]["idaluno"]);
				$idaluno = $alunodesmembrado["idaluno"];
				$nmaluno = $alunodesmembrado["nmaluno"];
			}
			
			$AlunoAgendado = new AlunoAgendado($arr_alunodesmembrado[0]["idalunoagendado"]);
			$idalunoagendado = $AlunoAgendado->idalunoagendado;
			$idcursoagendado = $AlunoAgendado->idcursoagendado;
			//Se não existir, buscar no alunoagendado alterados
			if(is_null($idalunoagendado)){
				$arr_alunoagendadoalterados = AlunoAgendado::getAlunoAgendadoAlterados($arr_alunodesmembrado[0]["idalunoagendado"]);
				$idalunoagendado = $arr_alunoagendadoalterados["idalunoagendado"];
				$idcursoagendado = $arr_alunoagendadoalterados["idcursoagendado"];
			}
			
			$Empresa = new Empresa($arr_alunodesmembrado[0]["idempresa"]);
			$arr_alunoagendado = Sql::arrays('SATURN', 'SIMPAC', "sp_alunoagendado_list ".$idaluno);
			
			if(count($arr_alunoagendado) == 0){
				$arr_alunoagendado = Sql::arrays('SATURN', 'SIMPAC', "sp_alunoagendado_alterados_list ".$idaluno);
			}
						
			$historico_descricao = $status."<b>Dados do Cliente:</b> ".getLinkPermissaoAluno($idaluno)."<br /><b>Matrícula:</b> ".getLinkPermissaoMatricula($objsolicitacaocorp->matricula)."<br /><b>Solicitado pelo(a)</b> ".$solicitante_nmcompleto." <b>às</b> ".$dtsolicitante."".getSolicitado($objsolicitacaocorp->idsolicitado, $objsolicitacaocorp->dtalteracao);
		?>	
			<h3>Desmembramento de Aluno</h3>	
            <div>
            	<p><?=$historico_descricao?></p>
                <div class="desmembramento">
                	<div><b>Aluno: </b><?=$nmaluno?></div>
                    <div><b>Para: </b><?=$arr_alunodesmembrado[0]["nralunos"]?> Alunos</div>
                    <div><b>Empresa: </b><?=$Empresa->nmempresa?></div>
                    <div><b> CGC: </b><?=$Empresa->nrcgc?></div>
                </div>
                <? foreach($arr_alunoagendado as $idalunoagendado){
				?>					                	
                    <div class="desmembramento">
                        <p class="title">Agendado no treinamento: </p>	
                        <?=getCursoAgendadoDescHistorico($idalunoagendado["idcursoagendado"])?>
                    </div>
                
                <? } ?>
            </div>
		
		<? } ?> 
    </div>
</body>