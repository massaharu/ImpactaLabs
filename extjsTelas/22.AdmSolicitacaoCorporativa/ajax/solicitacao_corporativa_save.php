<?php
# @AUTOR = massaharu #
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

///////////////////// CONSTANTES ////////////////////////////////////////////////////////

$insuccess = true;
$insuccess_reagendamento = true;
$insuccess_desmembramento = true;
$insuccess_desagendamento = true;
$insuccess_cadimpactaonline = true;
$insuccess_treinamentoreposicao = true;
$insuccess_treinamentotransfer = true;

$msg = "";
$msg_reagendamento = "";
$msg_desmembramento = "";
$msg_desagendamento = "";
$msg_cadimpactaonline = "";
$msg_treinamentoreposicao = "";
$msg_treinamentotransfer = "";

$title_reagendamento = "";
$title_desmembramento = "";
$title_desagendamento = "";
$title_cadimpactaonline = "";
$title_treinamentoreposicao = "";
$title_treinamentotransfer = "";

$UsuarioSolicitante = new Usuario($_SESSION["idusuario"]);

$arr_solicitacoes = json_decode(post('solicitacoes'));

///////////////////// FUNCTIONS ////////////////////////////////////////////////////////

function my_envia_email($assunto, $mensagem){
	if($_SESSION['idusuario'] == 1495){

		envia_email($assunto, $mensagem, "massaharu@impacta.com.br");
	}else{
		envia_email($assunto, $mensagem, "massaharu@impacta.com.br; marjori@impacta.com.br; Juliana@impacta.com.br ; Mscabio@impacta.com.br; fsantos@impacta.com.br;");
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////

foreach($arr_solicitacoes as $objsolicitacao){
	$matricula = trim($objsolicitacao->matricula);
	$ObjAluno = $objsolicitacao->Aluno;
	$ObjNfalterado = $objsolicitacao->Nfalterado;
	$Transferencia = $objsolicitacao->Transferencia;
	
	$ObjTreinamento = $objsolicitacao->Treinamento;
	$treinamento_atual = $ObjTreinamento->treinamento_atual;
	$treinamento_novo = $ObjTreinamento->treinamento_novo;
	
	$inalunoalterado = ($objsolicitacao->status->inalunoalterado)? 1 : 0;
	$incertificado = ($objsolicitacao->status->incertificado)? 1 : 0;
	$inlistapresenca = ($objsolicitacao->status->inlistapresenca)? 1 : 0;
	$innfalterado = ($objsolicitacao->status->innfalterado)? 1 : 0;
	$intreinamentoalterado = ($objsolicitacao->status->intreinamentoalterado)? 1 : 0;
	$inalunodesmembrado = ($objsolicitacao->status->inalunodesmembrado)? 1 : 0;
	$inalunodesagendado = ($objsolicitacao->status->inalunodesagendado)? 1 : 0;
	$incadimpactaonline = ($objsolicitacao->status->incadimpactaonline)? 1 : 0;
	$intreinamentoreposicao = ($objsolicitacao->status->intreinamentoreposicao)? 1 : 0;
	$intreinamentotransfer = ($objsolicitacao->status->intreinamentotransfer)? 1 : 0;
	
	//Se existir Matrícula
	if($matricula){
			
		$idalunoagendado = ($ObjTreinamento->idalunoagendado)? $ObjTreinamento->idalunoagendado : "NULL";
		
/////////////////////////////// TRATAMENTO DE ERROS //////////////////////////////////////////////////////////////////////////////////////////
		if($intreinamentoalterado || $inalunodesmembrado || $inalunodesagendado || $incadimpactaonline || $intreinamentoreposicao || $intreinamentotransfer){
			
			$hasSolicitacaoPendente = SolicitacaoCorporativa::hasSolicitacaoPendente($idalunoagendado);
			
			//Se existir um reagendamento pendente para o aluno agendado, o reagendamento não será feito. 
			if(($hasSolicitacaoPendente["intreinamentopendente"])){
				$intreinamentoalterado = 0;	
				$msg_reagendamento = "Existe um reagendamento pendente para este aluno agendado na secretaria. Para fazer esta solicitação, o mesmo deve ser concluído pela secretaria ou excluído.";
				$insuccess_reagendamento = false;
				$title_reagendamento = "Reagendamento";
			}
		
			//Se existir um desmembramento pendente para o aluno agendado, o desmembramento não será feito. 
			if(($hasSolicitacaoPendente["indesmembramentopendente"])){
				$inalunodesmembrado = 0;	
				$msg_desmembramento = "Existe um desmembramento pendente para este aluno agendado na secretaria. Para fazer esta solicitação, o mesmo deve ser concluído pela secretaria ou excluído.";
				$insuccess_desmembramento = false;
				$title_desmembramento = "Desmembramento";
			}
		
			//Se existir um desagendamento pendente para o aluno agendado, o desagendamento não será feito. 
			if(($hasSolicitacaoPendente["indesagendamentopendente"])){
				$inalunodesagendado = 0;	
				$msg_desagendamento = "Existe um desagendamento pendente para este aluno agendado na secretaria. Para fazer esta solicitação, o mesmo deve ser concluído pela secretaria ou excluído.";
				$insuccess_desagendamento = false;
				$title_desagendamento = "Desagendamento";
			}
		
			//Se existir um cadastro no impacta online pendente para o aluno agendado, o cadastro não será feito. 
			if(($hasSolicitacaoPendente["incadimpactaonline"])){
				$incadimpactaonline = 0;	
				$msg_cadimpactaonline = "Existe um cadastro no impacta online pendente para este aluno agendado na secretaria. Para fazer esta solicitação, o mesmo deve ser concluído pela secretaria ou excluído.";
				$insuccess_cadimpactaonline = false;
				$title_cadimpactaonline = "Cadastro no Impacta Online";
			}
			
			//Se existir um cadastro no impacta online pendente para o aluno agendado, o cadastro não será feito. 
			if(($hasSolicitacaoPendente["intreinamentoreposicao"])){
				$intreinamentoreposicao = 0;	
				$msg_treinamentoreposicao = "Existe uma reposição pendente para este aluno agendado na secretaria. Para fazer esta solicitação, o mesmo deve ser concluído pela secretaria ou excluído.";
				$insuccess_treinamentoreposicao = false;
				$title_treinamentoreposicao = "Reposição";
			}
			
			//Se existir um cadastro no impacta online pendente para o aluno agendado, o cadastro não será feito. 
			if(($hasSolicitacaoPendente["intreinamentotransfer"])){
				$intreinamentotransfer = 0;	
				$msg_treinamentotransfer = "Existe uma transferência pendente para este aluno agendado na secretaria. Para fazer esta solicitação, o mesmo deve ser concluído pela secretaria ou excluído.";
				$insuccess_treinamentotransfer = false;
				$title_treinamentotransfer = "Transferência";
			}
		}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if($inalunoalterado || $incertificado || $inlistapresenca || $innfalterado || $intreinamentoalterado || $inalunodesmembrado || $inalunodesagendado || $incadimpactaonline || $intreinamentoreposicao || $intreinamentotransfer){
			
			$idsolicitacaocorp = Sql::insert('SATURN', 'SIMPAC', "sp_solicitacaocorp_save '', '$matricula', ".$_SESSION['idusuario'].", NULL, ".$idalunoagendado.", ".$inalunoalterado.", ".$incertificado.", ".$inlistapresenca.", ".$innfalterado.", ".$intreinamentoalterado.", ".$inalunodesmembrado.", ".$inalunodesagendado.", ".$incadimpactaonline.", '', ".$intreinamentoreposicao.", ".$intreinamentotransfer);
		
			if($idsolicitacaocorp['idsolicitacaocorp']){
				
				if($idalunoagendado){
					$objalunoagendado = new AlunoAgendado($idalunoagendado);
					$objaluno = $objalunoagendado->getAluno();
					$objcursoagendado = new CursoAgendado($objalunoagendado->idcursoagendado);
					$objCurso = $objcursoagendado->getCurso();
					$objInstrutor = $objcursoagendado->getInstrutor();
					
					$descurso = ($objcursoagendado->desobs)? $objCurso->descurso.' - '.$objcursoagendado->desobs : $objCurso->descurso;
					
					$dtinicio = ($objcursoagendado->dtinicio)? date('d/m/Y - H:i:s',$objcursoagendado->dtinicio) : "N/A"; 	
					$dttermino = ($objcursoagendado->dttermino)? date('d/m/Y - H:i:s',$objcursoagendado->dttermino) : "N/A"; 	
						
//////////////////////// CERTIFICADO //////////////////////////////////////////////////////////////////////////////////////		
		
					//Envia um email solicitando a emissão de certificado
					if($incertificado){	
						
						$mensagem = emailpadrao("Favor, emitir o certificado do aluno(a): <b>".$objaluno->nmaluno."</b> / Matrícula: <b>".$matricula."</b><table style='font-family:arial, sans-serif, verdana; font-size:12px;'><tr><td>Treinamento: </td><td><b>".$descurso."</b></td></tr><tr><td>Data de Início: </td><td><b>".$dtinicio."</b></td></tr><tr><td>Data de Término: </td><td><b>".$dttermino."</b></td></tr><tr><td>Carga Horária: </td><td><b>".$objcursoagendado->nrcargahoraria." horas</b></td></tr><tr><td>Instrutor: </td><td><b>".$objInstrutor->nminstrutor."</b></td></tr></table><br />Enviar para <b>".$_SESSION['nmcompleto']."</b>, email: <b>".$_SESSION['cdemail']." </b>");
					
						$assunto = "Emissão de certificado";
						
						my_envia_email($assunto, utf8_decode($mensagem));
					}
//////////////////////// LISTA PRESENÇA //////////////////////////////////////////////////////////////////////////////////////		
					
					//Envia um email solicitando a emissão da lista de presença
					if($inlistapresenca){	
						
						$mensagem = emailpadrao("Favor, emitir a lista de presença do treinamento: <b>".$descurso."</b> / Matrícula: <b>".$matricula."</b><table style='font-family:arial, sans-serif, verdana; font-size:12px;'><tr><td>Data de Início: </td><td><b>".$dtinicio."</b></td></tr><tr><td>Data de Término: </td><td><b>".$dttermino."</b></td></tr><tr><td>Carga Horária: </td><td><b>".$objcursoagendado->nrcargahoraria." horas</b></td></tr><tr><td>Instrutor: </td><td><b>".$objInstrutor->nminstrutor."</b></td></tr></table><br />Enviar para <b>".$_SESSION['nmcompleto']."</b>, email: <b>".$_SESSION['cdemail']." </b>");
					
						$assunto = "Emissão de Lista de Presença";
						
						my_envia_email($assunto, utf8_decode($mensagem));
					}
					
//////////////////////// DESAGENDAR //////////////////////////////////////////////////////////////////////////////////////		
				
					//Envia um email solicitando o desagendamento do aluno da turma
					if($inalunodesagendado){
						$desmotivo = ($ObjTreinamento->motivoDesagendamento)? "'".utf8_decode($ObjTreinamento->motivoDesagendamento)."'" : "NULL";
						
						$AlunoAgendado = new AlunoAgendado($idalunoagendado);
						$idaluno = $AlunoAgendado->idaluno;
						$idcursoagendado = $AlunoAgendado->idcursoagendado;
						if(is_null($AlunoAgendado->idalunoagendado)){
							$AlunoAgendadoAlterados = AlunoAgendado::getAlunoAgendadoAlterados($idalunoagendado);
							$idaluno = $AlunoAgendadoAlterados["idaluno"];
							$idcursoagendado = $AlunoAgendadoAlterados["idcursoagendado"];
							$idalunoagendado = $AlunoAgendadoAlterados["idalunoagendado"];
						}
						$Aluno = new Aluno($idaluno);
						
						Sql::insert('SATURN', 'SIMPAC', "sp_solicitacaocorp_reagendamento_save '',".$idsolicitacaocorp['idsolicitacaocorp'].', '.$idcursoagendado.', NULL, '.$idalunoagendado.', '.$desmotivo.', 2');
						
						$desmotivo = ($ObjTreinamento->motivoDesagendamento)? $ObjTreinamento->motivoDesagendamento :  "Sem motivo";
						
						$mensagem = emailpadrao("Desagendamento solicitado pelo(a) colaborador(a) <b>".$UsuarioSolicitante->nmcompleto."</b> do Aluno Agendado  <b>".$Aluno->nmaluno."</b>. Matrícula: <b>".$matricula."</b>. Curso: <b>".$descurso."</b><table style='font-family:arial, sans-serif, verdana; font-size:12px;'><tr><td>Data de Início: </td><td><b>".$dtinicio."</b></td></tr><tr><td>Data de Término: </td><td><b>".$dttermino."</b></td></tr><tr><td>Carga Horária: </td><td><b>".$objcursoagendado->nrcargahoraria." horas</b></td></tr><tr><td>Instrutor: </td><td><b>".$objInstrutor->nminstrutor."</b></td></tr><tr><td>Motivo: </td><td><b>".$desmotivo."</b></td></tr></table></br ></ br><b>Obs: </b>O desagendamento deve ser feito normalmente. A tela de Solicitações Corporativa trabalha apenas em caráter informativo quanto às solicitações de desagendamento do aluno.");
					
						$assunto = "Desagendamento de turma";
						
						my_envia_email($assunto, utf8_decode($mensagem));
					}
					
//////////////////////// REAGENDAMENTO //////////////////////////////////////////////////////////////////////////////////////							
					
					//Salva as solicitações de reagendamento de treinamento
					if($intreinamentoalterado){
						
						$desmotivo = ($ObjTreinamento->motivoReagendamento)? "'".utf8_decode($ObjTreinamento->motivoReagendamento)."'" : "NULL";
						
						$idreagendamento = Sql::insert('SATURN', 'SIMPAC', "sp_solicitacaocorp_reagendamento_save '',".$idsolicitacaocorp['idsolicitacaocorp'].', '.$treinamento_atual->idcursoagendado.', '.$treinamento_novo->idcursoagendado.', '.$idalunoagendado.', '.$desmotivo.', 1');
						
						//Envia email de aviso para a secretria
						$AlunoAgendado = new AlunoAgendado($idalunoagendado);
						$idaluno = $AlunoAgendado->idaluno;
						if(is_null($AlunoAgendado->idalunoagendado)){
							$AlunoAgendadoAlterados = AlunoAgendado::getAlunoAgendadoAlterados($idalunoagendado);
							$idaluno = $AlunoAgendadoAlterados["idaluno"];
						}
						$Aluno = new Aluno($idaluno);
						
						$desmotivo = ($desmotivo != "NULL")? str_replace("'", "",  $desmotivo) : "Sem motivo";
						
						$mensagem = emailpadrao("Alteração solicitado pelo(a) colaborador(a) <b>".$UsuarioSolicitante->nmcompleto."</b> de reagendamento de turmas do(a) Cliente <b>".$Aluno->nmaluno."</b> com a matrícula: <b>".$matricula."</b>. Motivo: <b>".utf8_encode($desmotivo)."</b>. Favor, confirmar esta alteração na tela de Solicitação do Corporativo: SimpacWeb -> Secretaria -> Solicitação Corporativa");
						$assunto = "Reagendamento de Turmas";
						
						my_envia_email($assunto, utf8_decode($mensagem));
						
					}
//////////////////////// REPOSIÇÃO //////////////////////////////////////////////////////////////////////////////////////		
					
					if($intreinamentoreposicao){
						
						$desmotivo = ($ObjTreinamento->motivoReposicao)? "'".utf8_decode($ObjTreinamento->motivoReposicao)."'" : "NULL";
						
						$idreposicao = Sql::insert('SATURN', 'SIMPAC', "sp_solicitacaocorp_reagendamento_save '',".$idsolicitacaocorp['idsolicitacaocorp'].', '.$treinamento_atual->idcursoagendado.', '.$treinamento_novo->idcursoagendado.', '.$idalunoagendado.', '.$desmotivo.', 3');
						
						//Envia email de aviso para a secretria
						$AlunoAgendado = new AlunoAgendado($idalunoagendado);
						$idaluno = $AlunoAgendado->idaluno;
						if(is_null($AlunoAgendado->idalunoagendado)){
							$AlunoAgendadoAlterados = AlunoAgendado::getAlunoAgendadoAlterados($idalunoagendado);
							$idaluno = $AlunoAgendadoAlterados["idaluno"];
						}
						$Aluno = new Aluno($idaluno);
						
						$desmotivo = ($desmotivo != "NULL")? str_replace("'", "",  $desmotivo) : "Sem motivo";
						
						$mensagem = emailpadrao("Alteração solicitado pelo(a) colaborador(a) <b>".$UsuarioSolicitante->nmcompleto."</b> de reposição de turma do(a) Cliente <b>".$Aluno->nmaluno."</b> com a matrícula: <b>".$matricula."</b>. Motivo: <b>".utf8_encode($desmotivo)."</b>. Favor, confirmar esta alteração na tela de Solicitação do Corporativo: SimpacWeb -> Secretaria -> Solicitação Corporativa");
						$assunto = "Reposição de Turma";
						
						my_envia_email($assunto, utf8_decode($mensagem));
					}
					
///////////////////////// TRANSFERÊNCIA /////////////////////////////////////////////////////////////////////////////////////

					if($intreinamentotransfer){
						
						$desmotivo = ($ObjTreinamento->motivoTransfer)? "'".utf8_decode($ObjTreinamento->motivoTransfer)."'" : "NULL";
						$incortesia = ($Transferencia->cortesia)? 1 : 0;
						$inneworcamento = ($Transferencia->neworcamento)? 1 : 0;
						$inreposicao = ($Transferencia->reposicao)? 1 : 0;
						
						
						$idtransferencia = Sql::insert('SATURN', 'SIMPAC', "sp_solicitacaocorp_transferencia_save '',".$idsolicitacaocorp['idsolicitacaocorp'].", ".$incortesia.", '".utf8_decode($Transferencia->descursosantigos)."', '".utf8_decode($Transferencia->descursosnovos)."', '".$Transferencia->idcursosagendadosnovos."', '".$Transferencia->idcursosantigos."', '".$Transferencia->idcursosnovos."', ".$Transferencia->idpedido.", '".$Transferencia->matricula."', ".$inneworcamento.", ".$Transferencia->qtdeparcela.", ".$inreposicao.", '".$Transferencia->vlrcursosantigos."', '".$Transferencia->vlrcursosnovos."', ".str_replace(",", ".", $Transferencia->vlrorcamentoantigo).", ".str_replace(",", ".", $Transferencia->vlrorcamentodiferenca).", ".str_replace(",", ".", $Transferencia->vlrorcamentonovo).", ".$desmotivo.", '".$Transferencia->idalunosagendadosantigos."', '".$Transferencia->idcursosagendadosantigos."'");
						
						//Envia email de aviso para a secretria
						$AlunoAgendado = new AlunoAgendado($idalunoagendado);
						$idaluno = $AlunoAgendado->idaluno;
						if(is_null($AlunoAgendado->idalunoagendado)){
							$AlunoAgendadoAlterados = AlunoAgendado::getAlunoAgendadoAlterados($idalunoagendado);
							$idaluno = $AlunoAgendadoAlterados["idaluno"];
						}
						$Aluno = new Aluno($idaluno);
						
						$desmotivo = ($desmotivo != "NULL")? str_replace("'", "",  $desmotivo) : "Sem motivo";
						
						$mensagem = emailpadrao("Alteração solicitado pelo(a) colaborador(a) <b>".$UsuarioSolicitante->nmcompleto."</b> de transferência de curso do(a) Cliente <b>".$Aluno->nmaluno."</b> com a matrícula: <b>".$matricula."</b>. Motivo: <b>".utf8_encode($desmotivo)."</b>. Favor, confirmar esta alteração na tela de Solicitação do Corporativo: SimpacWeb -> Secretaria -> Solicitação Corporativa");
						$assunto = "Transferência de Curso";
						
						my_envia_email($assunto, utf8_decode($mensagem));
					}					
					
//////////////////////// DESMEMBRAMENTO //////////////////////////////////////////////////////////////////////////////////////							
					
					//Salva o desmembramento para alunos jurídicos (ex: 20 PArticipantes)
					if($inalunodesmembrado){
						$Empresa = new Empresa(0);
						
						$arr_empresa = $Empresa->getAlunoEmpresa($ObjAluno->idaluno);
						
						$idalunodesmembrado = Sql::insert('SATURN', 'SIMPAC', "sp_solicitacaocorp_alunodesmembrado_save '', ".$idsolicitacaocorp['idsolicitacaocorp'].", ".$ObjAluno->idaluno.", ".$idalunoagendado.", ".$ObjAluno->qtd_alunos.", ".$arr_empresa[0]["idempresa"]);
						
						//Envia email de aviso para a secretria
						$Aluno = new Aluno($ObjAluno->idaluno);
						
						$mensagem = emailpadrao("Desmembramento solicitado pelo(a) colaborador(a) <b>".$UsuarioSolicitante->nmcompleto."</b> do Aluno Agendado  <b>".$Aluno->nmaluno."</b> para <b>".$ObjAluno->qtd_alunos."</b> alunos. Matrícula: <b>".$matricula."</b>. Favor, confirmar esta alteração na tela de Solicitação do Corporativo: SimpacWeb -> Secretaria -> Solicitação Corporativa");
						$assunto = "Desmembramento de Turmas";
						
						my_envia_email($assunto, utf8_decode($mensagem));
					}
					
					//Salva as solicitações de alteração de aluno [ E/OU ]
					//Salva as solicitações de Cadastro de Aluno no Impacta Online
					if($inalunoalterado || $incadimpactaonline){
						
						$dtnascimento = explode("/", $ObjAluno->dtnascimento);
						$dtnascimento = $dtnascimento[2].'-'.$dtnascimento[1].'-'.$dtnascimento[0];
						
						$complemento = utf8_decode($ObjAluno->complemento);
						$desaluno = utf8_decode($ObjAluno->desaluno);
						$desbairro  = utf8_decode($ObjAluno->desbairro);
						$descidade = utf8_decode($ObjAluno->descidade);
						$desendereco = utf8_decode($ObjAluno->desendereco);
						
						$idalunoalterado = Sql::insert('SATURN', 'SIMPAC', "sp_solicitacaocorp_alunoalterado_save '',".$idsolicitacaocorp['idsolicitacaocorp'].", '".$ObjAluno->cdemail."', '".$ObjAluno->cdemailempresa."', '".$complemento."', '".$desaluno."', '".$desbairro."', '".$descidade."', '".$desendereco."', '".$ObjAluno->dessexo."', '".$dtnascimento."', ".$ObjAluno->idaluno.", ".$idalunoagendado.", '".$ObjAluno->nrcelular."', '".$ObjAluno->nrcep."', '".$ObjAluno->nrcpf."', '".$ObjAluno->nrrg."', '".$ObjAluno->nrtelefonecomercial."', '".$ObjAluno->nrtelefoneresidencial."', '".$ObjAluno->num."', '".$ObjAluno->sgestado."', '".$ObjAluno->tipoendereco."'");
						
						//Envia email de aviso para a secretria sobre a alteração de dados do Aluno
						
//////////////////////// DADOS ALUNO //////////////////////////////////////////////////////////////////////////////////////								
						if($inalunoalterado){
						
							$mensagem = emailpadrao("Alteração solicitado pelo(a) <b>".$UsuarioSolicitante->nmcompleto."</b> do cadastro do(a)Aluno(a)  <b>".$desaluno."</b> com a matrícula: <b>".$matricula."</b>. Favor, confirmar esta alteração na tela de Solicitação do Corporativo: SimpacWeb -> Secretaria -> Solicitação Corporativa");
							$assunto = "Alteração de cadastro do(a) Aluno(a) ".$desaluno;
							
							my_envia_email($assunto, utf8_decode($mensagem));
						}

//////////////////////// IMPACTA ONLINE //////////////////////////////////////////////////////////////////////////////////////								
						
						//Envia email de aviso para a secretria sobre o cadastro do aluno no Impacta Online
						if($incadimpactaonline){
							
							$mensagem = emailpadrao("Cadastro solicitado pelo(a) <b>".$UsuarioSolicitante->nmcompleto."</b> do(a) Aluno(a)  <b>".$desaluno."</b> com a matrícula: <b>".$matricula."</b>. Favor, confirmar esta solicitação na tela de Solicitação do Corporativo: SimpacWeb -> Secretaria -> Solicitação Corporativa");
							$assunto = "Cadastro do(a) Aluno(a) ".$desaluno." no Impacta Online";
							
							my_envia_email($assunto, utf8_decode($mensagem));
						}
					}
				}
				
//////////////////////// DADOS NF //////////////////////////////////////////////////////////////////////////////////////						
				 
				//Salva as solicitações de alteração de Emissão e Entrega da Nota Fiscal
				if($innfalterado){
					
					$bairro = utf8_decode($ObjNfalterado->nf_bairro);
					$bairroentrega = utf8_decode($ObjNfalterado->nf_bairro2);
					$cidade = utf8_decode($ObjNfalterado->nf_cidade);
					$cidadeentrega = utf8_decode($ObjNfalterado->nf_cidade2);
					$endereco = utf8_decode($ObjNfalterado->nf_endereco);
					$enderecoentrega = utf8_decode($ObjNfalterado->nf_endereco2);
					$contato = utf8_decode($ObjNfalterado->nf_contato);
					$obs = utf8_decode($ObjNfalterado->nf_obs);
					$referencia = utf8_decode($ObjNfalterado->nf_referencia);
					$complemento = utf8_decode($ObjNfalterado->nf_complemento);
					
					$idnffaturamentoalterado = Sql::insert('SATURN', 'SIMPAC', "sp_solicitacaocorp_nffaturamentoalterado_save '', ".$idsolicitacaocorp['idsolicitacaocorp'].", '".$matricula."', '".$endereco."', '".$ObjNfalterado->nf_cep."', '".$bairro."', '".$cidade."', '".$ObjNfalterado->nf_comboUF."', '".$enderecoentrega."', '".$bairroentrega."', '".$cidadeentrega."', '".$ObjNfalterado->nf_comboUF2."', '".$ObjNfalterado->nf_cep2."', '".$contato."', '".$ObjNfalterado->nf_telefone."', '".$ObjNfalterado->nf_fax."', '".$ObjNfalterado->nf_email2."', '".$obs."', '".$referencia ."', '".$ObjNfalterado->nf_tipo_endereco."', '".$ObjNfalterado->nf_numero."', '".$complemento."', '".$ObjNfalterado->nf_email."', '".$ObjNfalterado->nf_ccm."'");
					
					//Envia email de aviso para a secretria
					$SolicitacaoCorporativa = new SolicitacaoCorporativa($idsolicitacaocorp['idsolicitacaocorp']);
					$alunoempresa = $SolicitacaoCorporativa->getAlunoEmpresabyAlunoAgendado();
					$Empresa = new Empresa($alunoempresa[0]["idempresa"]);
					
					$mensagem = emailpadrao("Alteração solicitado pelo(a) <b>".$UsuarioSolicitante->nmcompleto."</b> do cadastro de Emissao/Entrega da Nota Fiscal da empresa <b>".$Empresa->nmempresa."</b> com a matrícula: <b>".$matricula."</b>. Favor, confirmar esta alteração na tela de Solicitação do Corporativo: SimpacWeb -> Secretaria -> Solicitação Corporativa");
					$assunto = "Alteração de cadastro da Emissao/Entrega da Nota Fiscal";
					
					my_envia_email($assunto, utf8_decode($mensagem));
				}
			}else{
				$msg = "Ocorreu um erro ao finalizar a solicitação. Favor, clique em \"Refazer Solicitação\" e tente outra vez";
				$insuccess = false;
			}
		}else{
			$insuccess = false;
			$msg = "Nenhuma solicitação realizada. Favor, tente outra vez e verifique se a alteração já não foi feita para este aluno agendado.";
		}
	}
}

echo json_encode(array(
		'success'=>$insuccess,
		'msg'=>$msg,
		'reagendamento'=>array(
			'success'=>$insuccess_reagendamento,
			'title'=>"reagendamento",
			'msg'=>$msg_reagendamento
		),
		'desmembramento'=>array(
			'success'=>$insuccess_desmembramento,
			'title'=>"desmembramento",
			'msg'=>$msg_desmembramento
		),
		'desagendamento'=>array(
			'success'=>$insuccess_desagendamento,
			'title'=>"desagendamento",
			'msg'=>$msg_desagendamento
		),
		'cadimpactaonline'=>array(
			'success'=>$insuccess_cadimpactaonline,
			'title'=>"cadimpactaonline",
			'msg'=>$msg_cadimpactaonline
		),
		'reposicao'=>array(
			'success'=>$insuccess_treinamentoreposicao,
			'title'=>"reposicao",
			'msg'=>$msg_treinamentoreposicao
		),
		'transferencia'=>array(
			'success'=>$insuccess_treinamentotransfer,
			'title'=>"transferencia",
			'msg'=>$msg_treinamentotransfer
		)
	));
?>