<?php
#@AUTOR = massaharu
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

///////////// GLOBALS ///////////////////////////////////////////////
$msg = "";
$titleMsg = "";
$success = true;
$arr_finalresponse = array();
$arr_solicitacaoerror = array();

///////////// FUNCTIONS ///////////////////////////////////////////////
function getAlunoDescHistorico($idalunoagendado){
	$alunoagendado = new AlunoAgendado($idalunoagendado);
	$idaluno = $alunoagendado->idaluno;
	
	if(is_null($alunoagendado->idalunoagendado)){
		$arr_AlunoAgendadoAlterados = AlunoAgendado::getAlunoAgendadoAlterados($idalunoagendado);
		$idaluno = $arr_AlunoAgendadoAlterados["idaluno"];
	}
	
	$aluno = new Aluno($idaluno);
	$nmaluno = $aluno->nmaluno;
	$nrcpf = $aluno->nrcpf;
	
	if(is_null($aluno->idaluno)){
		$arr_alunoalterados = Aluno::getAlunoAlterados($idaluno);
		$nmaluno = $arr_alunoalterados["nmaluno"];
		$nrcpf = $arr_alunoalterados["nrcpf"];
	}
	
	return (!is_null(trim($nrcpf)))? trim($nmaluno)." - CPF: ".trim($nrcpf) : trim($nmaluno);
}

function getCursoAgendadoDescHistorico($idcursoagendado, $destino = 'historico'){
	
	$cursoagendado = new CursoAgendado($idcursoagendado);
	$curso = new Curso($cursoagendado->idcurso);
	$descurso = ($cursoagendado->desobs)? $curso->descurso.' - '.$cursoagendado->desobs : $curso->descurso;
	$instrutor = $cursoagendado->getInstrutor();
	$sala = new Sala($cursoagendado->idsala);
	$dtinicio = ($cursoagendado->dtinicio)? date('d/m/Y', $cursoagendado->dtinicio) : "-";
	$dttermino = ($cursoagendado->dttermino)? date('d/m/Y', $cursoagendado->dttermino) : "-";
	$hrinicio = ($cursoagendado->dtinicio)? date('H:i:s', $cursoagendado->dtinicio) : "-";
	$hrtermino = ($cursoagendado->dttermino)? date('H:i:s', $cursoagendado->dttermino) : "-";
	
	if($destino == 'historico'){
		return $descurso.", De: ".$dtinicio." Até: ".$dttermino." das ".$hrinicio." às ".$hrtermino." - Sala: ".$sala->dessala." / Instrutor: ".$instrutor->desinstrutor;
		
	}else if($destino == 'email'){
		return "<b>Curso</b>: ".$descurso."<br/><b>De: </b>".$dtinicio."<br/><b>Até: </b>".$dttermino."<br /><b>Horário:</b> das ".$hrinicio." às ".$hrtermino."<br/><b>Sala: </b>".$sala->dessala."<br/><b>Instrutor: </b>".$instrutor->desinstrutor;
	}
}

function my_envia_email($assunto, $mensagem, $para){
	if($_SESSION["idusuario"] == 1495){
		envia_email($assunto, utf8_decode(emailpadrao($mensagem)), "massaharu@impacta.com.br;");
	}else{
		envia_email($assunto, utf8_decode(emailpadrao($mensagem)), $para." Cleverson@impacta.com.br;");
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$objsolicitacaocorp = new SolicitacaoCorporativa(post('idsolicitacaocorp'));

//Executa a solicitação se a mesma NÃO foi executada anteriormente
if($objsolicitacaocorp->instatus == false){
	
	$UsuarioSolicitante = new Usuario($objsolicitacaocorp->idsolicitante);
	$UsuarioSolicitado = new Usuario($_SESSION["idusuario"]);
	
	//Se a Matrícula NÃO existe e/ou foi CANCELADA
	if(!Sql::arrays("SATURN", "SIMPAC", "sp_controlefinanceiro_get_matricula '$objsolicitacaocorp->matricula'")){
		
		if(!Sql::arrays("SATURN", "SIMPAC", "sp_controlefinanceiro_get_matricula $objsolicitacaocorp->matricula")){
			
			echo json_encode(
				array(
					"success"=>"Matrícula NÃO existe e/ou foi CANCELADA.",
					"msg"=>"Matrícula NÃO existe e/ou foi CANCELADA.",
					'titleMsg'=>false
				)
			);
			exit();
		}
	}
	
	
	//Executa a solicitação caso solicitado apenas a emissão de certificado ou lista de presença
	if($objsolicitacaocorp->inlistapresenca || $objsolicitacaocorp->incertificado){
		
		$alunoagendado = new AlunoAgendado($objsolicitacaocorp->idalunoagendado);
		
//////////////////////////////////// PRESENÇA //////////////////////////////////////////////////////////////
		if($objsolicitacaocorp->inlistapresenca){
			
			$historico_descricao = "Lista de Presença de: ".getCursoAgendadoDescHistorico($alunoagendado->idcursoagendado)." - Emitido por:";
			$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
			
			//envia email de confirmação ao solicitante
			$assunto = "Solicitação de emissão de Lista de Presença Concluída";
			$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
			$mensagem = "A solicitação de emissão de Lista de Presença do Treinamento: ".getCursoAgendadoDescHistorico($alunoagendado->idcursoagendado)." foi concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b>, Matricula: <b>".$objsolicitacaocorp->matricula."</b>";
			
			my_envia_email($assunto, $mensagem, $para);
		}
		
//////////////////////////////////// CERTIFICADO //////////////////////////////////////////////////////////////		
		if($objsolicitacaocorp->incertificado){
			$historico_descricao = "Certificado de: ".getCursoAgendadoDescHistorico($alunoagendado->idcursoagendado)." - ".getAlunoDescHistorico($objsolicitacaocorp->idalunoagendado)." - Emitido por:";
			$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
			
			//envia email de confirmação ao solicitante
			$assunto = "Solicitação de emissão de Certificado Concluída";
			$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
			$mensagem = "A solicitação de emissão de Certificado do(a) Aluno(a) <b>".getAlunoDescHistorico($objsolicitacaocorp->idalunoagendado)."</b> do Treinamento: ".getCursoAgendadoDescHistorico($alunoagendado->idcursoagendado)." foi concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b>, Matricula: <b>".$objsolicitacaocorp->matricula."</b>";
			
			my_envia_email($assunto, $mensagem, $para);
		}
		
		$objsolicitacaocorp->solicitacaoCorpUpStatus();
	}
	
//////////////////////////////////// DADOS NF //////////////////////////////////////////////////////////////	
	if($objsolicitacaocorp->innfalterado){
		
		$arr_nffaturamentoalterado = array();
		$arr_nffaturamentoalterado = $objsolicitacaocorp->getNffaturamentoalteradoBySolicitacao();
		
		$matricula = $arr_nffaturamentoalterado[0]["matricula"]; 
		$alterarNF_nf_endereco = utf8_decode($arr_nffaturamentoalterado[0]["desendereco"]);  
		$alterarNF_nf_cep = $arr_nffaturamentoalterado[0]["descep"];  
		$alterarNF_nf_bairro = utf8_decode($arr_nffaturamentoalterado[0]["desbairro"]);  
		$alterarNF_nf_cidade = utf8_decode($arr_nffaturamentoalterado[0]["descidade"]);  
		$uf = $arr_nffaturamentoalterado[0]["desestado"];  
		$alterarNF_nf_endereco2 = utf8_decode($arr_nffaturamentoalterado[0]["desenderecoentrega"]);  
		$alterarNF_nf_bairro2 = utf8_decode($arr_nffaturamentoalterado[0]["desbairroentrega"]);  
		$alterarNF_nf_cidade2 = utf8_decode($arr_nffaturamentoalterado[0]["descidadeentrega"]);  
		$uf2 = $arr_nffaturamentoalterado[0]["desestadoentrega"];  
		$alterarNF_nf_cep2 = $arr_nffaturamentoalterado[0]["descepentrega"];  
		$alterarNF_nf_contato = $arr_nffaturamentoalterado[0]["descontato"];  
		$alterarNF_nf_telefone = $arr_nffaturamentoalterado[0]["desfone"];  
		$alterarNF_nf_fax = $arr_nffaturamentoalterado[0]["desfax"];  
		$alterarNF_nf_email = utf8_decode($arr_nffaturamentoalterado[0]["desemail"]);  
		$alterarNF_nf_obs = utf8_decode($arr_nffaturamentoalterado[0]["desobs"]);  
		$alterarNF_nf_endereconf = utf8_decode($arr_nffaturamentoalterado[0]["desendereconf"]);  
		$alterarNF_nf_tipo_endereco = $arr_nffaturamentoalterado[0]["desenderecotipo"];  
		$alterarNF_nf_numero = $arr_nffaturamentoalterado[0]["nrendereco"];  
		$alterarNF_nf_complemento = utf8_decode($arr_nffaturamentoalterado[0]["descomplemento"]);  
		$alterarNF_nf_email2 = utf8_decode($arr_nffaturamentoalterado[0]["desemailnf"]);  
		$alterarNF_nf_ccm = $arr_nffaturamentoalterado[0]["nrinscricaomunicipal"]; 
		
		$query = "sp_notafiscal_edit '$matricula', '$alterarNF_nf_endereco', '$alterarNF_nf_cep', '$alterarNF_nf_bairro', '$alterarNF_nf_cidade', '$uf', '$alterarNF_nf_endereco2', '$alterarNF_nf_bairro2', '$alterarNF_nf_cidade2', '$uf2', '$alterarNF_nf_cep2', '$alterarNF_nf_contato', '$alterarNF_nf_telefone', '$alterarNF_nf_fax', '$alterarNF_nf_email', '$alterarNF_nf_obs', '$alterarNF_nf_endereconf', '$alterarNF_nf_tipo_endereco', '$alterarNF_nf_numero', '$alterarNF_nf_complemento', '$alterarNF_nf_email2', '$alterarNF_nf_ccm'";
	
		Sql::insert("SATURN","Simpac",$query);
		
		$alunoempresa = $objsolicitacaocorp->getAlunoEmpresabyAlunoAgendado();
		$empresa = new Empresa($alunoempresa[0]["idempresa"]);
		
		$historico_descricao = "Dados da empresa: ".$empresa->nmempresa." CGC/CNPJ: ".$empresa->nrcgc." - Matrícula: ".$objsolicitacaocorp->matricula." - Alterado pelo(a) ";
		
		$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
		$objsolicitacaocorp->solicitacaoCorpUpStatus();
		
		//envia email de confirmação ao solicitante
		$assunto = "Solicitação de alteração do Cadastro de Emissão/Entrega de Nota Fiscal Concluída.";
		$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
		$mensagem = "A solicitação de alteração do Cadastro de Emissão/Entrega de Nota Fiscal da empresa <b>".$empresa->nmempresa."</b> CGC/CNPJ: <b>".$empresa->nrcgc."</b> - Matrícula: <b>".$objsolicitacaocorp->matricula."</b> Concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b>";
			
		my_envia_email($assunto, $mensagem, $para);
	}
	
//////////////////////////////////// DADOS ALUNO //////////////////////////////////////////////////////////////	
	if($objsolicitacaocorp->inalunoalterado){
		
		$arr_alunoalterado = array();
		$arr_alunoalterado = $objsolicitacaocorp->getAlunoalteradoBySolicitacao();
		
		$idalunoalterado = $arr_alunoalterado[0]["idalunoalterado"];
		$idsolicitacaocorp = $arr_alunoalterado[0]["idsolicitacaocorp"];
		$cdemail = utf8_decode($arr_alunoalterado[0]["desemail"]);
		$cdemailempresa = utf8_decode($arr_alunoalterado[0]["desemailempresa"]);
		$complemento = utf8_decode($arr_alunoalterado[0]["descomplemento"]);
		$nmaluno = utf8_decode($arr_alunoalterado[0]["desaluno"]);
		$desbairro = utf8_decode($arr_alunoalterado[0]["desbairro"]);
		$descidade = utf8_decode($arr_alunoalterado[0]["descidade"]);
		$desendereco = utf8_decode($arr_alunoalterado[0]["desendereco"]);
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
		$dtnascimento = ($dtnascimento)? date('Y-m-d',$dtnascimento) : ''; 	
		
		$aluno = NULL;
		$aluno = new Aluno($idaluno);
		
		if(!is_null($aluno->idaluno)){		
			$query = ("sp_aluno_edit '$cdemail', '$cdemailempresa', '$complemento', '$nmaluno', '$desbairro', '$descidade', '$desendereco', '$dessexo', '$dtnascimento', ".$aluno->idaluno.", '$nrcelular', '$nrcep', '$nrcpf', '$nrrg', '$nrtelefonecomercial', '$nrtelefoneresidencial', '$num', '$sgestado', '$tipoendereco'");
			
			Sql::insert("SATURN", "Simpac", $query);
			
			$aluno = new Aluno($idaluno);
			$alunodados = trim($aluno->nmaluno)." - CPF: ".trim($aluno->nrcpf);
			
			$historico_descricao = "Dados do Cliente: ".$alunodados." - Matrícula: ".$objsolicitacaocorp->matricula." - Alterado pelo(a) ";
			
			$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
			$objsolicitacaocorp->solicitacaoCorpUpStatus();
			
			//envia email de confirmação ao solicitante
			$assunto = "Solicitação de alteração do Cadastro do(a) Aluno(a) ".$nmaluno;
			$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
			$mensagem = "A solicitação de alteração do Cadastro do(a) Aluno(a) ".$alunodados." - Matrícula: ".$objsolicitacaocorp->matricula."</b> Concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b>";
				
			my_envia_email($assunto, $mensagem, $para);
		}else{
			array_push($arr_solicitacaoerror,array(
				"alunoalteradoerror"=>array(
					"error" => true,
					"msg"   => "Aluno não encontrado no sistema."
			)));
		}
	
	}
	
//////////////////////////////////// IMPACTA ONLINE //////////////////////////////////////////////////////////////	
	/* Executa a solicitação de cadastrar o Aluno no Impacta Online */
	if($objsolicitacaocorp->incadimpactaonline){
		$arr_aluno = array();
		$arr_objAccount = array();
		$curso = array(); 
		$arr_aluno = $objsolicitacaocorp->getAlunoalteradoBySolicitacao();
		
		$Aluno = NULL; $AlunoAgendado = NULL; $CursoAgendado = NULL; $Curso = NULL;
		
		$AlunoAgendado = new AlunoAgendado($arr_aluno[0]["idalunoagendado"]);
		
		
		//Se o AlunoAgendado for encontrado
		if($AlunoAgendado->idcursoagendado){
			
			$CursoAgendado = new CursoAgendado($AlunoAgendado->idcursoagendado);
						
			$Curso = new Curso($CursoAgendado->idcurso);
			$Curso = new Curso($Curso->getEADNewVersion()); //Verifica se há uma nova versão do curso online
			
			//Se o curso for EAD
			if($Curso->isEAD()){
				
				$Aluno = new Aluno($AlunoAgendado->idaluno);
				$ImpactaOnline = new ImpactaOnline();
				
				//Se encontrar o id do curso no Impacta Online
				if($ImpactaOnline->getCurso($Curso->idcurso)){
				
					$nrcpf = str_replace(".", "", str_replace("-", "", str_replace(" ", "", $Aluno->nrcpf)));
					$dtnasc =  ($Aluno->dtnascimento)? date("d/m/Y", $Aluno->dtnascimento) : date("d/m/Y");
					
					//Se existe o aluno
					if(!is_null($Aluno->idaluno)){	
					
						if(count(Account::listByCpf($nrcpf)) > 0){
							$arr_account = Account::getByEmail($Aluno->cdemail, 1);
						}else{
							$arr_account = Account::listByCpf($nrcpf);
						}
						
						//Se não existir Account, criar:
						if(count($arr_account) <= 0){
							
							$new_account = Account::add(
								utf8_decode($Aluno->nmaluno), 
								$nrcpf, 
								$Aluno->nrrg, 
								$dtnasc, 
								$Aluno->dessexo, 
								utf8_decode($Aluno->desendereco),
								$Aluno->num,
								$Aluno->complemento,
								$Aluno->desbairro,
								$Aluno->descidade,
								$Aluno->sgestado,
								$Aluno->nmcep,
								$Aluno->nrtelefoneresidencial, 
								$Aluno->cdemail, 
								'Impacta1'
							);
							
							array_push($arr_objAccount, array(
								'objAccount'=>	new Account($new_account)
							));
							
						//Se EXISTIR Account:	
						}else{
							foreach($arr_account as $account){
								array_push($arr_objAccount, array(
									'objAccount'=>	new Account($account['cod_cli'])
								));
							}
						}
						
						//SE ENCONTRAR O ACCOUNT EXISTENTE
						if(count($arr_objAccount) > 0){
							foreach($arr_objAccount as $Account){
								
								//Se NÃO existir uma conta no Impacta Online, criar	
								if(!$ImpactaOnline->getUser($Account['objAccount']->email_cli)){
									echo $Account['objAccount']->email_cli.",".$Account['objAccount']->senha_cli.",".$Account['objAccount']->nome_cli.",1132542200";
									//criar conta no Impacta Online
									if($ImpactaOnline->setUser($Account['objAccount']->email_cli,$Account['objAccount']->senha_cli,$Account['objAccount']->nome_cli,"1132542200")){
											
										if($ImpactaOnline->setCurso()){
											
											$SituationCourses = $ImpactaOnline->getSituacionCourseV2();
											
											//SE o curso for setado no impacta online
											if(count($SituationCourses) > 0){
											
												foreach($SituationCourses as $SituationCourse){
													
													array_push($curso, $SituationCourse->course->title);
												}
											}else{
												$curso = array();
											}
											
											$ImpactaOnline->setEmail($Account['objAccount']->nome_cli,$Account['objAccount']->senha_cli,$Account['objAccount']->email_cli,$curso,1);
										
											$alunodados = trim($Aluno->nmaluno)." - CPF: ".trim($nrcpf);
											$historico_descricao = "Cliente: ".$alunodados." - Matrícula: ".$objsolicitacaocorp->matricula." - Cadastrado no Impacta Online pelo(a) ";
											$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
											$objsolicitacaocorp->solicitacaoCorpUpStatus();
											
											//envia email de confirmação ao solicitante
											$assunto = "Solicitação de Cadastro do(a) Aluno(a) ".$nmaluno." no Impacta Online";
											$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
											$mensagem = "A solicitação de Cadastro do(a) Aluno(a) ".$alunodados." no Impacta Online - Matrícula: ".$objsolicitacaocorp->matricula."</b> Concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b>";
										
											my_envia_email($assunto, $mensagem, $para);
										}else{
											array_push($arr_solicitacaoerror,array(
												"cadalunoimpactaonlineerror" => array(
													"error" => true,
													"msg"   => "O curso online não foi adicionado ao aluno"
											)));
										}
									//error
									}else{
										array_push($arr_solicitacaoerror,array(
											"cadalunoimpactaonlineerror"=>array(
												"error" => true,
												"msg"   => "A conta não foi criada no Impacta Online"
										)));
									}
								//Se EXISTIR uma conta no Impacta Online	
								}else{
									if($ImpactaOnline->setCurso()){
										
										$SituationCourses = $ImpactaOnline->getSituacionCourseV2();
											
										//SE o curso for setado no impacta online
										if(count($SituationCourses) > 0){
											foreach($SituationCourses as $SituationCourse){
												
												array_push($curso, $SituationCourse->course->title);
											}
										}else{
											$curso = array();
										}
										
										$ImpactaOnline->setEmail($Account['objAccount']->nome_cli,$Account['objAccount']->senha_cli,$Account['objAccount']->email_cli,$curso,1);
										$alunodados = trim($Aluno->nmaluno)." - CPF: ".trim($nrcpf);
										$historico_descricao = "Cliente: ".$alunodados." - Matrícula: ".$objsolicitacaocorp->matricula." - Cadastrado no Impacta Online pelo(a) ";
										$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
										$objsolicitacaocorp->solicitacaoCorpUpStatus();
										
										//envia email de confirmação ao solicitante
										$assunto = "Solicitação de Cadastro do(a) Aluno(a) ".$nmaluno." no Impacta Online";
										$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
										$mensagem = "A solicitação de Cadastro do(a) Aluno(a) ".$alunodados." no Impacta Online - Matrícula: ".$objsolicitacaocorp->matricula."</b> Concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b><br /><br /><b>Obs: <b>O Cadastro deste aluno já era existente no Impacta Online";
									
										my_envia_email($assunto, $mensagem, $para);
									}else{
										array_push($arr_solicitacaoerror,array(
											"cadalunoimpactaonlineerror"=>array(
												"error" => true,
												"msg"   => "O curso online não foi adicionado ao aluno"
										)));
									}
								}
							}
						}else{
							array_push($arr_solicitacaoerror,array(
								"cadalunoimpactaonlineerror"=>array(
									"error" => true,
									"msg"   => "Account não encontrado"
							)));
						}
					}else{
						array_push($arr_solicitacaoerror,array(
							"cadalunoimpactaonlineerror"=>array(
								"error" => true,
								"msg"   => "Aluno não encontrado"
						)));
					}
				}else{
					array_push($arr_solicitacaoerror,array(
						"cadalunoimpactaonlineerror"=>array(
							"error" => true,
							"msg"   => "O curso online não foi encontrado no Impacta Online"
					)));
				}
			}else{
				array_push($arr_solicitacaoerror,array(
						"cadalunoimpactaonlineerror"=>array(
						"error" => true,
						"msg"   => "O curso não é do tipo EAD"
				)));
			}
		}else{
			array_push($arr_solicitacaoerror,array(
					"cadalunoimpactaonlineerror"=>array(
					"error" => true,
					"msg"   => "O Aluno Agendado não foi encontrado no sistema"
			)));
		}
	}
	
	
//////////////////////////////////// REAGENDAMENTO //////////////////////////////////////////////////////////////	
	if($objsolicitacaocorp->intreinamentoalterado){
		
		$arr_reagendamento = array();
		$arr_reagendamento = $objsolicitacaocorp->getReagendamentoBySolicitacao();
		$desmotivo = ($arr_reagendamento[0]["desmotivo"])? $arr_reagendamento[0]["desmotivo"] : "Sem motivo";
		
		Sql::insert('SATURN', 'SIMPAC', "sp_alunoagendado_reagendamento '$objsolicitacaocorp->matricula', ".$arr_reagendamento[0]["idcursoagendadonovo"].", ".$arr_reagendamento[0]["idalunoagendado"]);
		
		//Salva Histórico		
		$historico_descricao = "Cliente: ".getAlunoDescHistorico($arr_reagendamento[0]["idalunoagendado"])." desinscrito do treinamento ".getCursoAgendadoDescHistorico($arr_reagendamento[0]["idcursoagendadoatual"])." e inscrito no treinamento ".getCursoAgendadoDescHistorico($arr_reagendamento[0]["idcursoagendadonovo"])." - Matrícula: ".$objsolicitacaocorp->matricula.". Motivo: ".$desmotivo;
		
		$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
		$objsolicitacaocorp->solicitacaoCorpUpStatus();
		
		//envia email de confirmação ao solicitante
		$assunto = "Solicitação de reagendamento de Turmas";
		$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
		$mensagem = "<div style='text-align:left'>A solicitação de reagendamento de turma do(a) Cliente ".getAlunoDescHistorico($arr_reagendamento[0]["idalunoagendado"])."<br /><h4>Desinscrito do treinamento:</h4>".getCursoAgendadoDescHistorico($arr_reagendamento[0]["idcursoagendadoatual"], 'email')."<br /><h4>Inscrito no treinamento: </h4>".getCursoAgendadoDescHistorico($arr_reagendamento[0]["idcursoagendadonovo"], 'email')."<br /><br />Matrícula: <b>".$objsolicitacaocorp->matricula."</b><br />Motivo :<b>".$desmotivo." </b><br />Concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b></div>";
			
		my_envia_email($assunto, $mensagem, $para);
	}
	
//////////////////////////////////// REPOSIÇÃO //////////////////////////////////////////////////////////////	
	if($objsolicitacaocorp->intreinamentoreposicao){
		
		$arr_reposicao = array();
		$arr_reposicao = $objsolicitacaocorp->getReagendamentoBySolicitacao();
		$desmotivo = ($arr_reposicao[0]["desmotivo"])? $arr_reposicao[0]["desmotivo"] : "Sem motivo";
		
		Sql::insert('SATURN', 'SIMPAC', "sp_alunoagendado_reposicao '$objsolicitacaocorp->matricula', ".$arr_reposicao[0]["idcursoagendadonovo"].", ".$arr_reposicao[0]["idalunoagendado"]);
		
		//Salva Histórico		
		$historico_descricao = "Cliente: ".getAlunoDescHistorico($arr_reposicao[0]["idalunoagendado"])." reposto no treinamento ".getCursoAgendadoDescHistorico($arr_reposicao[0]["idcursoagendadonovo"])." - Matrícula: ".$objsolicitacaocorp->matricula.". Motivo: ".$desmotivo;
		
		$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
		$objsolicitacaocorp->solicitacaoCorpUpStatus();
		
		//envia email de confirmação ao solicitante
		$assunto = "Solicitação de reposição de Turmas";
		$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
		$mensagem = "<div style='text-align:left'>A solicitação de reposição de turma do(a) Cliente ".getAlunoDescHistorico($arr_reposicao[0]["idalunoagendado"])."<br /><h4>Treinamento:</h4>".getCursoAgendadoDescHistorico($arr_reposicao[0]["idcursoagendadoatual"], 'email')."<br /><h4>Reposto no treinamento: </h4>".getCursoAgendadoDescHistorico($arr_reposicao[0]["idcursoagendadonovo"], 'email')."<br /><br />Matrícula: <b>".$objsolicitacaocorp->matricula."</b><br />Motivo :<b>".$desmotivo." </b><br />Concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b></div>";
			
		my_envia_email($assunto, $mensagem, $para);
	}
	
//////////////////////////////////// TRANSFERÊNCIA //////////////////////////////////////////////////////////////	
	if($objsolicitacaocorp->intreinamentotransfer){
		$arr_transfer = array();
		$arr_transfer = $objsolicitacaocorp->getTransferenciaBySolicitacao();
		
		$arr_idalunosagendados = explode(',', $arr_transfer[0]["idalunosagendadosantigos"]);
		$arr_idcursosagendadosnovos = explode(',', $arr_transfer[0]["idcursosagendadosnovos"]);
		$arr_idcursosagendadosantigos = explode(',', $arr_transfer[0]["idcursosagendadosantigos"]);
		
		$desmotivo = ($arr_transfer[0]["desmotivo"])? $arr_transfer[0]["desmotivo"] : "Sem motivo";
		
		/*******************************************************************************/
		/*******************************************************************************/
		/* SCRIPT PARA FAZER A TRANSFERÊNCIA
		*/
		//////////////////////////////////////////////////////////////////////////////////
		
		//Variáveis necessárias
		$matricula = $arr_transfer[0]["matricula"];
		$idpedido = $arr_transfer[0]["idpedido"];
		$idcursosantigos = $arr_transfer[0]["idcursosantigos"];
		$descursosantigos = $arr_transfer[0]["descursosantigos"];
		$vlrcursosantigos = $arr_transfer[0]["vlrcursosantigos"];
		$cortesia = ($arr_transfer[0]["incortesia"])? 1 : 0;
		$idcursosnovos = $arr_transfer[0]["idcursosnovos"];
		$descursosnovos = $arr_transfer[0]["descursosnovos"];
		$idcursosagendadosnovos = $arr_transfer[0]["idcursosagendadosnovos"];
		$vlrcursosnovos = $arr_transfer[0]["vlrcursosnovos"];
		$vlrorcamentoantigo = $arr_transfer[0]["vlrorcamentoantigo"];
		$vlrorcamentonovo = $arr_transfer[0]["vlrorcamentonovo"];
		$vlrorcamentodiferenca = $arr_transfer[0]["vlrorcamentodiferenca"];
		$neworcamento = $arr_transfer[0]["inneworcamento"];
		$pedidoNovo = (int)$idpedido;
		$qtdeparcela = (int)$arr_transfer[0]["qtdeparcela"];
		$reposicao = $arr_transfer[0]["inreposicao"];
		
		//////////////////////////////////////////////////////////////////////////////////
		//Array com os id de curso sagendados e aluno agendado do aluno
		$array_idcursoagendadosantigos = array();
		$array_idalunoagendadosantigos = array();
		
		//////////////////////////////////////////////////////////////////////////////////
		//Instancia a classe de controle financeiro
		$Matricula = new Matricula($matricula);
		$cf = ControleFinanceiro::getControleFinanceiroByMatricula($matricula);
		
		//Obtem informações do aluno
		$AlunoAgendado = new AlunoAgendado($arr_idalunosagendados[0]);
		$Aluno = new Aluno($AlunoAgendado->idaluno);
		
		//Obtem informações da empresa
		$Empresa = new Empresa($cf[0]['IdCliente']);
		
		//Passa por cada idalunoagendado
		foreach ($Aluno->getAgendamentos('idalunoagendado', $matricula) as $t){
			//Instancia a classe para obter mais informações necessárias
			$ca = new CursoAgendado($t->idcursoagendado);
			
			//Verifica se o curso está entre os selecionados para ser trocado
			if (in_array($ca->idcurso, explode(',', $idcursosantigos))){
				//Empilha o curso agendado e o aluno agendado nos arrays
				array_push($array_idalunoagendadosantigos, $t->idalunoagendado);
				array_push($array_idcursoagendadosantigos, $ca->idcursoagendado);
			}
		}
		
		//Tranferencia com necessidade de criar um novo orçamento
		//Instancia a classe pedido
		$pedido = new Pedido($idpedido);
		
		//Cria o novo orçamento
		//$pedidoNovo = $pedido->pedidoRenegociar(str_replace(",", ".", $vlrorcamentonovo), $idcursosantigos, $idcursosagendadosnovos, $vlrcursosnovos, implode(',', $array_idcursoagendadosantigos), $cortesia);
		
		//Instancia o novo pedido
		//$newpedido = new Pedido($pedidoNovo);	
		
		//Adiciona um historico referente aos dois pedidos
		//$pedido->setNewHistorico("Devido a transferencia do aluno de curso feita pelo usuário ".$_SESSION['nmcompleto'].", este pedido foi atualizado para o novo pedido: ".$pedidoNovo.".");
		//$newpedido->setNewHistorico("Devido a transferencia do aluno de curso feita pelo usuário ".$_SESSION['nmcompleto'].", este pedido foi criado a partir do pedido antigo: ".$idpedido.".");
		
		/////////////////////////////////////////////////////////////////////
		//Inserção do aluno em novos cursos
		//Converte para a Array
		$arrayidcursosagendadosnovos = explode(",", $idcursosagendadosnovos);
				
		//Força a obtenção da matricula
		$mat = ControleFinanceiro::getControleFinanceiroByMatricula($matricula);
		
		//Instancia a classe aluno agendado
		$aa2 = new AlunoAgendado($array_idalunoagendadosantigos[0]);
		
		//Coloca o aluno nos cursos agendados selecionados
		for ($i = 0; $i < count($arrayidcursosagendadosnovos); $i++){
			//Método que insere o aluno na turma
			$aa2->addJuridico($arrayidcursosagendadosnovos[$i], $Aluno->idaluno, $aa2->idusuario, $mat[0]['IdControleFinanceiro'], $mat[0]['Matricula'], $aa2->descomentario, $aa2->infinanceiro);
		}
		
		/////////////////////////////////////////////////////////////////////
		//Retira o aluno dos cursos agendados solicitados
		for ($i = 0; $i < count($array_idcursoagendadosantigos); $i++){
			//Instancia a classe aluno agendado
			$aa = new AlunoAgendado($array_idalunoagendadosantigos[$i]);
			
			//Chama método que remove o aluno da turma
			$aa->removeJuridico($array_idcursoagendadosantigos[$i], $array_idalunoagendadosantigos[$i]);
		}
	
		//MATRICULA CORTESIA
		if($arr_transfer[0]['incortesia']){
			
			//Atualiza o pedidocortesia
			$Matricula->atualizaPedidosCursosCortesiaJuridico();
			
		}else{
		
			//Recria o pedidoscurso da matricula
			$Matricula->atualizaPedidosCursosJuridico();
		
		}	
		
		//////////////////////////////////////////////////////////////////////////////////
		//Verifica se apenas uma tranferencia simples ou com necessidade de criar um novo orçamento
		/*if ($neworcamento == "true"){
			//Tranferencia com necessidade de criar um novo orçamento
			//Instancia a classe pedido
			$pedido = new Pedido($idpedido);
			
			//Cria o novo orçamento
			$pedidoNovo = $pedido->pedidoRenegociar(str_replace(",", ".", $vlrorcamentonovo), $idcursosantigos, $idcursosagendadosnovos, $vlrcursosnovos, implode(',', $array_idcursoagendadosantigos), $cortesia);
			
			//Instancia o novo pedido
			$newpedido = new Pedido($pedidoNovo);	
			
			//Adiciona um historico referente aos dois pedidos
			$pedido->setNewHistorico("Devido a transferencia do aluno de curso feita pelo usuário ".$_SESSION['nmcompleto'].", este pedido foi atualizado para o novo pedido: ".$pedidoNovo.".");
			$newpedido->setNewHistorico("Devido a transferencia do aluno de curso feita pelo usuário ".$_SESSION['nmcompleto'].", este pedido foi criado a partir do pedido antigo: ".$idpedido.".");
			
			/////////////////////////////////////////////////////////////////////
			//Inserção do aluno em novos cursos
			//Converte para a Array
			$arrayidcursosagendadosnovos = explode(",", $idcursosagendadosnovos);
					
			//Força a obtenção da matricula
			$mat = ControleFinanceiro::getControleFinanceiroByMatricula($matricula);
			
			//Instancia a classe aluno agendado
			$aa2 = new AlunoAgendado($array_idalunoagendadosantigos[0]);
			
			//Coloca o aluno nos cursos agendados selecionados
			for ($i = 0; $i < count($arrayidcursosagendadosnovos); $i++){
				//Método que insere o aluno na turma
				$aa2->addJuridico($arrayidcursosagendadosnovos[$i], $Aluno->idaluno, $aa2->idusuario, $mat[0]['IdControleFinanceiro'], $mat[0]['Matricula'], $aa2->descomentario, $aa2->infinanceiro);
			}
			
			/////////////////////////////////////////////////////////////////////
			//Retira o aluno dos cursos agendados solicitados
			for ($i = 0; $i < count($array_idcursoagendadosantigos); $i++){
				//Instancia a classe aluno agendado
				$aa = new AlunoAgendado($array_idalunoagendadosantigos[$i]);
				
				//Chama método que remove o aluno da turma
				$aa->removeJuridico($array_idcursoagendadosantigos[$i], $array_idalunoagendadosantigos[$i]);
			}
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//Alteração feita apenas se houver diferença entre os valores
			if ($vlrorcamentodiferenca < 0){
				//----------------------------Gerar Credito----------------------------
				//Variavel com o valor do credito
				$credito = abs($vlrorcamentodiferenca);
				$descritivo = "Transação inserida automaticamente devido alteração de curso jurídico";
				
				//Instancia a classe pessoa
				//$p = new Pessoa((string)$Empresa->nrcgc);
				$p = new Pessoa((string)$Aluno->nrcpf);
				//Insere credito para o aluno
				$p->addCredito($descritivo, str_replace(',', '.',(string)$credito), array(
					Transacao::TIPO_AVULSO
				));
			}
			else if ($vlrorcamentodiferenca > 0){
				//----------------------------Gerar Orçamento----------------------------
				//Metodo que distribui o valor em parcelas
				$vlrparcelas = Math::distribution((float)$vlrorcamentodiferenca, $qtdeparcela);
				
				//Obtem informações do pedido
				$p = new Pedido($idpedido);
				$pc = Parcela::load($matricula);
				$cb = Cobranca::getParcelasCobranca($matricula);
				
				//Seta o numero da ultima parcela
				$nrparcela = (count($p->list_pedidoparcela()) + 1);
				
				//Obtem a ultima data de vencimento
				$dtvencimentoultima = date("Y-m-d", $pc[(count($pc) - 1)]['dtvencimento']);
				
				//Passa por cada nova parcela que será criada
				for ($i = 0; $i < $qtdeparcela; $i++){
					//Incrementa um mes a partir da ultima data de vencimento
					$dtvencimentoultima = date("Y-m-d", strtotime("+1 month", strtotime($dtvencimentoultima)));
					
					//Insere a parcela no PedidoParcela
					$p->setNewPedidoParcela(($nrparcela + $i), str_replace(",", ".", (string)$vlrparcelas[$i]), $dtvencimentoultima, $pc[0]['idtipoformapagamento'], "Parcela resultante de transferencia.");
					
					//Insere no parcelas
					//Parcela::setNewParcela($pc[0]['idcontrolefinanceiro'], ($nrparcela + $i), $matricula, str_replace(",", ".", (string)$vlrparcelas[$i]), $dtvencimentoultima, $pc[0]['idtipoformapagamento'], "Parcela resultante de transferencia.");
					
					//Insere no cobranca
					//Cobranca::setNewCobranca($cb[0]['idcontrolefinanceiro'], ($nrparcela + $i), $cb[0]['idcobranca'], $matricula, $pc[0]['idtipoformapagamento'], str_replace(",", ".", (string)$vlrparcelas[$i]), $dtvencimentoultima, 'NULL', "Parcela resultante de transferencia.");
				}
				
				//Atualiza pedidorecibo
				Pedido::parcelaPedidoReciboRenegociar($idpedido, $pedidoNovo);
				
				//Insere para o que o orçamento seja aceito
				Sql::arrays('SATURN', 'Simpac', "sp_pedidorecepcao_add ".$pedidoNovo.";");
				
				//Apaga das matriculas recriadas para não dar problema no robô quando o mesmo rodar
				Sql::arrays('SATURN', 'Simpac', "sp_matriculaspedidosrecriadas_remove ".$idpedido.", '".$matricula."';");
				
				//Cria a nova relação da matricula com o novo pedido para que o robô rode corretamente
				Sql::arrays('SATURN', 'Simpac', "sp_matriculaspedidosrecriadas_add ".$pedidoNovo.", '".$matricula."';");
				
				//----------------------------Alterar a coluna numero de parcelas no controle financeiro----------------------------
				//Obtem informação do controle financeiro
				//$mat = ControleFinanceiro::getControleFinanceiroByMatricula($matricula);
				
				//Instancia a classe controle finanaceiro
				//$c = new ControleFinanceiro($mat[0]['IdControleFinanceiro']);
				
				//Altera o numero de parcelas no controle finanaceiro
				//$c->setQtdeParcelas(($nrparcela + $qtdeparcela - 1));
			}
		}else{
			
			//Instancia a classe alunoagendado
			$aa = new AlunoAgendado($array_idalunoagendadosantigos[0]);
			
			//Verifica se é transferencia normal ou reposição
			if (!$reposicao){
				//Transfere o aluno de treinamento
				$aa->addAlunoEmpresa($idcursosagendadosnovos, $matricula);
			}
			
			
	//	}*/
		
		//////////////////////////////////////////////////////////////////////////////////	
		//Salva log
		//if ($_SESSION['idusuario'] != 1498){
			acao("O usuário ".$_SESSION['nmlogin']."(".$_SESSION['idusuario'].") transferiu ".(($reposicao == "false") ?"(reposição)" :"")." o aluno ".$Aluno->idaluno." do Orçamento ".$idpedido." gerando diferença de R$ ".$vlrorcamentodiferenca." na matricula ".$matricula." em ".date('d/m/Y H:i').".");
			
			//Salva no histórico da secretaria
			Secretaria::addHistoricoSecretaria(str_replace("'", "´", date("d/m/Y H:i:s")." - Cliente inscrito no treinamento: ".$descursosnovos.", Aluno(a): ".$Aluno->nmaluno." - CPF: ".$Aluno->nrcpf."- Matrícula: ".$matricula."  Usuário Responsável: ".$_SESSION['nmcompleto']." - ".date("d/m/Y H:i:s")), $matricula);
		//}
		
		/*******************************************************************************/
		/*******************************************************************************/
		/*******************************************************************************/
		
		$objsolicitacaocorp->solicitacaoCorpUpStatus();
		
		$cursosagendadosantigos = "";
		foreach($arr_idcursosagendadosantigos as $idcursosagendadosantigos){
		
			$cursosagendadosantigos .= getCursoAgendadoDescHistorico($idcursosagendadosantigos, 'email')."<hr />";
		}	
		
		$cursosagendadosnovos = "";
		foreach($arr_idcursosagendadosnovos as $idcursosagendadosnovos){
		
			$cursosagendadosnovos .= getCursoAgendadoDescHistorico($idcursosagendadosnovos, 'email')."<hr />";
		}
		
		//envia email de confirmação ao solicitante
		$assunto = "Solicitação de Transferência de Turmas";
		$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
		$mensagem = "<div style='text-align:left'>A solicitação de transferência de curso do(a) Cliente ".getAlunoDescHistorico($arr_idalunosagendados[0])."<br /><h4>Treinamento:</h4>".$cursosagendadosantigos."<br /><h4>Transferido para o curso: </h4>".$cursosagendadosnovos."<br /><br />Matrícula: <b>".$objsolicitacaocorp->matricula."</b><br />Motivo:<b> ".$desmotivo." </b><br />Concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b>
			<table>
				<tbody>
					<tr>
						<td>Orçamento:</td>
						<td>".($arr_transfer[0]["idpedido"] + 15000)."</td>
					</tr>
					<tr>
						<td>Valor do Orçamento:</td>
						<td>R$ ".number_format($arr_transfer[0]["vlrorcamentoantigo"], 2, ",", ".")."</td>
					</tr>
					<tr>
						<td>Valor do novo Orçamento:</td>
						<td>R$ ".number_format($arr_transfer[0]["vlrorcamentonovo"], 2, ",", ".")."</td>
					</tr>
					<tr>
						<td>Diferença:</td>
						<td>R$ ".number_format($arr_transfer[0]["vlrorcamentodiferenca"], 2, ",", ".")."</td>
					</tr>
					<tr>
						<td>Parcelas:</td>
						<td>".$arr_transfer[0]["qtdeparcela"]."</td>
					</tr>
				</tbody>
			</table>
		</div>";
			
		my_envia_email($assunto, $mensagem, $para);
	}
//////////////////////////////////// DESAGENDAMENTO //////////////////////////////////////////////////////////////	
	if($objsolicitacaocorp->inalunodesagendado){
		
		$arr_desagendado = array();
		$arr_desagendado = $objsolicitacaocorp->getReagendamentoBySolicitacao();
		$desmotivo = ($arr_desagendado[0]["desmotivo"])? $arr_desagendado[0]["desmotivo"] : "Sem motivo";
		
		$alunoagendado = new AlunoAgendado($objsolicitacaocorp->idalunoagendado);
		
		$historico_descricao = "Aluno ".getAlunoDescHistorico($objsolicitacaocorp->idalunoagendado)." desagendado do treinamento : ".getCursoAgendadoDescHistorico($alunoagendado->idcursoagendado)." Motivo: ".$desmotivo." - Emitido por:";
		$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
		
		//envia email de confirmação ao solicitante
		$assunto = "Solicitação de Desagendamento concluído";
		$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
		$mensagem = "A solicitação de desagendamento do(a) Aluno(a) <b>".getAlunoDescHistorico($objsolicitacaocorp->idalunoagendado)."</b> do Treinamento: ".getCursoAgendadoDescHistorico($alunoagendado->idcursoagendado)." Motivo: <b>".$desmotivo."</b> foi concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b>, Matricula: <b>".$objsolicitacaocorp->matricula."</b>";
		
		my_envia_email($assunto, $mensagem, $para);
		
		$objsolicitacaocorp->solicitacaoCorpUpStatus();
		
	}
	
//////////////////////////////////// DESMEMBRAMENTO //////////////////////////////////////////////////////////////	
	if($objsolicitacaocorp->inalunodesmembrado){
		
		$arr_desmembramento = array();
		$arr_desmembramento = $objsolicitacaocorp->getAlunoDesmembradoBySolicitacao();
		$arr_alunoagendado = Sql::arrays('SATURN', 'SIMPAC', "sp_alunoagendado_list ".$arr_desmembramento[0]["idaluno"]);
		
		$i = 0;
		$arr_idaluno = array();
		
		//Itera por todos os cursos que o aluno está agendado (idalunoagendado)
		foreach($arr_alunoagendado as $val){
			$Empresa = new Empresa(0);
			$AlunoAgendado = new AlunoAgendado($val["idalunoagendado"]);
			$arr_empresa = $Empresa->getAlunoEmpresa($AlunoAgendado->idaluno, $AlunoAgendado->idcursoagendado);
			
			//Executará apenas uma vez na primeira iteração
			if($i == 0){
				
				$arr_idaluno = @Sql::arrays("SATURN", "SIMPAC", "sp_alunoagendado_desmembramento '$objsolicitacaocorp->matricula', ".$arr_desmembramento[0]["idaluno"].", ".$val["idalunoagendado"].", '".$arr_empresa[0]["nmempresa"]."', ".$arr_desmembramento[0]["nralunos"].", ".$_SESSION["idusuario"].", 'J'"); 
				
				$arr_presencas = @Sql::arrays("SATURN", "SIMPAC", "sp_presencaalunobycursoagendado_list ".$arr_desmembramento[0]["idaluno"].", ".$AlunoAgendado->idcursoagendado);
					
				//Se o aluno que estiver sendo desmembrado tiver presenças copiar as presencas para os alunos desmembrados
				if(count($arr_presencas) > 0){
					foreach($arr_presencas as $presenca){
						
						$inpresenca = ($presenca["inpresenca"])? "1" : "0";
						
						if(count($arr_idaluno) > 0){
							foreach($arr_idaluno as $idaluno){
								@Sql::insert("SATURN", "SIMPAC", "sp_presencaalunodesmembrado_add ".$idaluno["idaluno"].", ".$presenca["idcursoagendado"].", ".$presenca["idinstrutor"].", '".date("Y-m-d", $presenca["dtpresenca"])."', ".$inpresenca.", '".date("Y-m-d H:i:s", $presenca["dtcadastro"])."'");
							}
						}
					}
				}
				
				@Sql::query("SATURN", "SIMPAC", "sp_AlunoEmpresaDelete3 ".$val["idalunoagendado"].", ''");
				@Sql::query("SATURN", "SIMPAC", "sp_alunoagendado_delete ".$val["idalunoagendado"]);
			}
			
			//Se o aluno agendado estiver agendado em mais de um cursoagendado, agendar os mesmos alunos agendados nos outros cursosagendados
			if(count($arr_idaluno) > 0 && $i > 0){
				
				$arr_presencas = @Sql::arrays("SATURN", "SIMPAC", "sp_presencaalunobycursoagendado_list ".$arr_desmembramento[0]["idaluno"].", ".$AlunoAgendado->idcursoagendado);
				//Itera pelos alunos desmembrados
				foreach($arr_idaluno as $idaluno){
					@Sql::insert("SATURN", "SIMPAC", "sp_aluno_agendamento '$objsolicitacaocorp->matricula', ".$idaluno["idaluno"].", ".$val["idalunoagendado"]);
					
					//Se o aluno que estiver sendo desmembrado tiver presenças copiar as presencas para os alunos desmembrados
					if(count($arr_presencas) > 0){
						foreach($arr_presencas as $presenca){
							$inpresenca = ($presenca["inpresenca"])? "1" : "0";
							
							@Sql::insert("SATURN", "SIMPAC", "sp_presencaalunodesmembrado_add ".$idaluno["idaluno"].", ".$presenca["idcursoagendado"].", ".$presenca["idinstrutor"].", '".date("Y-m-d", $presenca["dtpresenca"])."', ".$inpresenca.", '".date("Y-m-d H:i:s", $presenca["dtcadastro"])."'");
						}
					}
				}
				
				@Sql::query("SATURN", "SIMPAC", "sp_AlunoEmpresaDelete3 ".$val["idalunoagendado"].", ''");
				@Sql::query("SATURN", "SIMPAC", "sp_alunoagendado_delete ".$val["idalunoagendado"]);
			}
			
			$i = $i + 1;
			
			//Salva Histórico
			$historico_descricao = "Aluno Agendado: ".getAlunoDescHistorico($AlunoAgendado->idalunoagendado)." desmembrado para ".$arr_desmembramento[0]["nralunos"]." Alunos no treinamento: ".getCursoAgendadoDescHistorico($AlunoAgendado->idcursoagendado)." - Matrícula: ".$objsolicitacaocorp->matricula;
			$objsolicitacaocorp->HistoricoSecretariaSave($historico_descricao);
			
			//envia email de confirmação ao solicitante
			$assunto = "Solicitação de desmembramento de Alunos(Jurídicos)";
			$para = "massaharu@impacta.com.br; ".$UsuarioSolicitante->cdemail.";";
			$mensagem = "Aluno Agendado: ".getAlunoDescHistorico($AlunoAgendado->idalunoagendado)." desmembrado para ".$arr_desmembramento[0]["nralunos"]." Alunos no treinamento: ".getCursoAgendadoDescHistorico($AlunoAgendado->idcursoagendado)." - Matrícula: <b>".$objsolicitacaocorp->matricula."</b> Concluído pelo(a) colaborador(a) <b>".$UsuarioSolicitado->nmcompleto."</b>";
				
			my_envia_email($assunto, $mensagem, $para);
		}
		
		@Sql::query("SATURN", "SIMPAC", "sp_presencaalunodesmembrado_remove ".$arr_desmembramento[0]["idaluno"]);
		@Sql::query("SATURN", "SIMPAC", "DELETE tb_aluno WHERE idaluno = ".$arr_desmembramento[0]["idaluno"]);
		@Sql::query("SATURN", "SIMPAC", "DELETE tb_cliente WHERE idcliente = ".$arr_desmembramento[0]["idaluno"]);
		
		//ATUALIZA O PEDIDOSCURSO DA MATRICULA
		$Matricula = new Matricula($objsolicitacaocorp->matricula);
		$Matricula->atualizaPedidosCursosJuridico();
		
		$objsolicitacaocorp->solicitacaoCorpUpStatus();
		
	}
	
//////////////////////////////////////// TRATAMENTO DE ERROS //////////////////////////////////////////////////////////
	//Se não tiver nenhum erro
	if(count($arr_solicitacaoerror) == 0){
		array_push($arr_finalresponse, 
			array(
				'success'=>true,
				'msg'=>"Solicitação concluída com sucesso.",
				'titleMsg'=>"Solicitação totalmente concluída!"
			)
		);
		
	//Se uma dessas solicitações não efetuarem
	}else{
		//itera por todos os erros 
		foreach($arr_solicitacaoerror as $error){
			//Dados Aluno
			if($error["alunoalteradoerror"]["error"]){
				array_push($arr_finalresponse,
					array(
						'success'=>true,
						'msg'=>$error["alunoalteradoerror"]["msg"],
						'titleMsg'=>"Solicitação parcialmente concluída!"
					)
				);
			}
			//Cadastro Impacta Online
			if($error["cadalunoimpactaonlineerror"]["error"]){
				array_push($arr_finalresponse,
					array(
						'success'=>true,
						'msg'=>$error["cadalunoimpactaonlineerror"]["msg"],
						'titleMsg'=>"Solicitação parcialmente concluída!"
					)
				);
			}
		}
	}

//Se a Solicitação já foi executada
}else{
	
	array_push($arr_finalresponse, 
		array(
			'success'=>false,
			'msg'=>"Não foi possível executar esta solicitação",
			'titleMsg'=>"Solicitação já foi concluída."
		)
	);
	
	array_push($arr_finalresponse, 
		array(
			'success'=>false,
			'msg'=>"Não foi possível executar esta solicitação2",
			'titleMsg'=>"Solicitação já foi concluída2."
		)
	);
}

echo json_encode($arr_finalresponse);
?>