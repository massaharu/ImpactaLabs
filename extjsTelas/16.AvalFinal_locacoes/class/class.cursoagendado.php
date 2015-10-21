<?
# @AUTOR = jrangel #
class CursoAgendado
{
	
	private $server = 'SATURN';
	
	public $idcursoagendado;
	public $idcurso;
	public $descurso;
	public $dtinicio;
	public $dttermino;
	public $idperiodo;
	public $desperiodo;
	public $idsala;
	public $idinstrutor;
	public $desobs;
	public $qtcargahoraria;
	public $nrcargahoraria;
	public $inturmafechada;
	public $dtcadastro;
	
	public $idempresa = 0;
	public $idreposicao = 0;
	
	public $solicitante = false;
	
	public $flags = array();
	public $datas = array();
	
	public $Curso = false;
	public $Instrutor = false;
	public $Sala = false;
	public $Reposicao = false;
	public $Empresa = false;
	public $Palestra = false;
	
	public function __construct($idcursoagendado = ''){
		
		if(is_numeric($idcursoagendado)){
			return $this->load($idcursoagendado);
		}else{
			return false;
		}
		
	}
	
	public function load($idcursoagendado){
		
		$a = Sql::select($this->server,'Simpac', "sp_cursoagendado_get $idcursoagendado");
		
		if(!$a['idcursoagendado']){
			$this->server = 'RANGER';
			$a = Sql::select($this->server,'Simpac', "sp_cursoagendado_get $idcursoagendado");
		}
		
		if ($a['idcursoagendado']){
			$this->idcursoagendado = $a['idcursoagendado'];
			$this->idcurso = $a['idcurso'];
			$this->dtinicio = timestamp($a['dtinicio']);
			$this->dttermino = timestamp($a['dttermino']);
			$this->idperiodo = $a['idperiodo'];
			$this->desperiodo = utf8_encode($a['desperiodo']);
			$this->idsala = $a['idsala'];
			$this->idinstrutor = $a['idinstrutor'];
			$this->desobs = utf8_encode($a['desobs']);
			$this->qtcargahoraria = $a['qtcargahoraria'];
			$this->nrcargahoraria = $this->qtcargahoraria;
			$this->inturmafechada = $a['inturmafechada'];
			$this->dtcadastro = strtotime(formatdatetime($a['dtcadastramento'],8));
			
			
			try{
			
			foreach($this->getFlags() as $flag){
				
				array_push($this->flags, (int)$flag['idflag']);
				
			}
			
			if(in_array(3, $this->flags)){
				
				$this->getIdReposicao();
					
			}
			
			if(in_array(4, $this->flags) || in_array(6, $this->flags)){
				
				$this->getIdEmpresa();
					
			}
			
			$this->solicitante = $this->getSolicitante();
		
			}catch(Exception $e){
				
				//Nothing
					
			}
		
			unset($a);
			
			return true;
		}
		else{
			return false;
		}
	}
	
	public function getPalestra(){
		
		if(!$this->Palestra){
			$a = Sql::select('SATURN','Simpac',"sp_cursoagendadopalestra_get $this->idcursoagendado");
			$a['idpalestra'] = (int)$a['idpalestra'];
			$a['despalestra'] = utf8_encode($a['despalestra']);
			$this->Palestra = $a;
		}
		return $this->Palestra;	
			
	}
	
	public function getSolicitante(){
		
		if($this->solicitante){
			return $this->solicitante;
		}else{
			$a = Sql::select('SATURN','Simpac',"sp_cursoagendadoUsuario_get $this->idcursoagendado");
			if($a['idusuario']){
				$this->idusuario = (int)$a['idusuario'];
				return new Usuario($a['idusuario']);
			}else{
				return false;	
			}
		}
			
	}
	
	public function getIdReposicao(){
		
		if(!$this->idreposicao){
			$reposicao = Sql::select('SATURN','Simpac',"sp_cursoagendadoreposicao_get $this->idcursoagendado");
			$this->idreposicao = (int)$reposicao['idcursoagendado'];
			return $this->idreposicao;
		}else{
			return $this->idreposicao;	
		}
			
	}
	
	public function getIdEmpresa(){
		
		if(!$this->idempresa){
			$reposicao = Sql::select('SATURN','Simpac',"sp_cursoagendadoempresa_get $this->idcursoagendado");
			$this->idempresa = (int)$reposicao['idempresa'];
			return $this->idempresa;
		}else{
			return $this->idempresa;	
		}
			
	}
	
	public function getReposicao(){		
		if(!$this->Reposicao && $this->getIdReposicao()){
			$this->Reposicao = new CursoAgendado($this->getIdReposicao());
		}
		return $this->Reposicao;			
	}
	
	public function getEmpresa(){		
		if(!$this->Empresa && $this->getIdEmpresa()){
			$this->Empresa = new Empresa($this->getIdEmpresa());
		}
		return $this->Empresa;			
	}
	
	public function getInstrutor(){
		if(!$this->Instrutor) $this->Instrutor = new Instrutor($this->idinstrutor);
		return $this->Instrutor;
	}
	
	public function getCurso(){
		if(!$this->Curso) $this->Curso = new Curso($this->idcurso);
		return $this->Curso;
	}
	
	public function getSala(){
		if(!$this->Sala) $this->Sala = new Sala($this->idsala);
		return $this->Sala;
	}
	
	public function getHistorico(){
		
		return Sql::arrays('SATURN','Simpac',"sp_cursoagendadohistorico_list $this->idcursoagendado");
			
	}
	
	public function getTotalAlunos(){
		
		$a = Sql::select('SATURN','Simpac', "sp_cursoagendadototalalunos_get $this->idcursoagendado");
		
		return $a['total'];
		
	}
	
	public function getCapacidadeAlunosCurso(){
		
		$a = Sql::select('SATURN','Simpac', "sp_qtdVagasCursoAgendado_get $this->idcursoagendado");
		
		return $a['Capacidade'];
	}
	
	public function getVagas(){
		$a = $this->getCapacidadeAlunosCurso() - $this->getTotalAlunos();
		
		return $a;
	}
	
	public function getVagasCursoAgendado($idcursoagendado){
		
		$vagas = Sql::select("Saturn", "Simpac", "sp_vagas $idcursoagendado");
		return $vagas[0];
	}

	public function getAlunosAgendados(){
		
		$a = Sql::objects('SATURN','Simpac',"sp_cursoagendadolalunos_list $this->idcursoagendado");
		
		$alunos = array();
		
		foreach($a as $a1){
			
			array_push($alunos, 
					   array(
							 "idaluno"=>$a1->idaluno,
							 "nmaluno"=>trim($a1->nmaluno),
							 "dessexo"=>$a1->dessexo
							 )
					   );
			
		}
		
		return $alunos;
		
	}
	
	public function getAlunosMatriculas(){
		
		$a = Sql::objects("Saturn","Simpac","sp_cursoagendadolalunos_list2 $this->idcursoagendado");
		
		$alunos = array();
		
		foreach($a as $rec){
			
			array_push($alunos,
				array(
					"idalunoagendado"=>$rec->idalunoagendado,
					"dtcadastrado"=>$rec->dtcadastramento,
					"matricula"=>$rec->matricula,
					"nrfalta"=>$rec->nrfalta,
					"infinanceiro"=>$rec->infinanceiro,
					"idaluno"=>$rec->idaluno,
					"nmaluno"=>$rec->nmaluno,
					"alunoreserva"=>$rec->nome,
					"nmusuario"=>$rec->nmusuario,
					"nmempresa"=>$rec->nmempresa,
					"idcontrolefinanceiro"=>$rec->idcontrolefinanceiro,
					"inrecebido"=>$rec->inrecebido,
					"idaceito"=>$rec->idaceito
				)
			);
		}
		
		return $alunos;
	}
	
	public function getEmAberto($idcurso, $idperiodo){
		
		return Sql::arrays('SATURN','Simpac',"sp_cursosagendadosemaberto_get $idcurso, $idperiodo");
			
	}
	
	public function addEmAberto($idcurso, $idperiodo, $idcursoagendado = 0){
		
		try{
			
			if($idcursoagendado==0){
			
				$a = Sql::select('SATURN','Simpac',"sp_cursosagendadosemaberto_add $idcurso, $idperiodo");
				$this->refreshOLD($a['idcursoagendado']);				
				
				return $a['idcursoagendado'];
			
			}else{
				
				$a = Sql::select('SATURN','Simpac',"sp_cursosagendadosemabertoexplicit_add $idcurso, $idperiodo, $idcursoagendado");
				$this->refreshOLD($idcursoagendado);
				
				return $idcursoagendado;
					
			}
				
		}catch(Exception $e){
			
			error($e);
			return false;
				
		}
			
	}
	
	public function editDatas(array $datas,array $hourInicio,array $hourTermino,$idSala,$idInstrutor,array $idPeriodo, array $obs,$idcursoagendado){
		
		$CA = new CursoAgendado($idcursoagendado);
		$CA->Log();
		
		$dtIncCA = date('d/m/Y',$CA->dtinicio);
		$dtIncNEW = date('d/m/Y',strtotime($datas[0][0]));
		$dtTermCA = date('d/m/Y',$CA->dttermino);
		$dtTermNEW = date('d/m/Y',strtotime($datas[0][count($datas[0])-1]));
		$hourIncNEW = date('H:i',strtotime($hourInicio[0][0]));
		$hourTermNEW = date('H:i',strtotime($hourTermino[0][count($hourTermino[0])-1]));
		
		$SalaAtual = $this->getSalasAgendadas($CA->idcursoagendado);
		
		$SalaNova = $this->getSalasAgendadas($CA->idcursoagendado);
		
		if($dtIncCA != $dtIncNEW  ||  $dtTermCA != $dtTermNEW){
			
			$contratos = Sql::arrays('SATURN','Simpac',"sp_instrutorcontrato_get ".$CA->idcursoagendado);
				
				if(count($contratos)){
					
					Sql::query('SATURN','Simpac',"sp_contratos_delete ".$CA->idcursoagendado);
					
					$html = array();
					foreach($contratos as $contrato){
						$motivo = (trim($contrato['desmotivo']))?$contrato['desmotivo']:'Nenhum motivo informado';
						array_push($html, '<p><span style="color:grey">ID</span><br/>'.$contrato['idcontrato'].'</p><p><span style="color:grey">Instrutor</span><br/>'.$contrato['nmusual'].'</p><p><span style="color:grey">Valor Hora</span><br/>'.$contrato['vlhoraacordado'].'</p><p><span style="color:grey">Motivo</span><br/>'.$motivo.'</p><p>A alteração foi realizada em <strong>'.date('d/m/Y H:i').'</strong> por <strong>'.$_SESSION['nmlogin'].'</strong>.</p>');
					}
					
					send_email(array(
						"CharSet"=>'utf-8',
						"to"=>"Soraia@impacta.com.br;Rcastro@impacta.com.br",
						"subject"=>"Contrato cancelado devido alteração em turma",
						"body"=>emailpadrao('<p>O treinamento de <strong>'.$CA->getCurso()->descurso.' - '.$CA->desperiodo.' - '.date('d/m/Y', $CA->dtinicio).' a '.date('d/m/Y', $CA->dttermino).' das '.date('H:i', $CA->dtinicio).' às '.date('H:i', $CA->dttermino).'</strong> foi alterado e o contrato cancelado.</p><h3>Dados do Contrato Cancelado</h3>'.implode('',$html)
					)));
					
					unset($CA);
				}
				unset($contratos);	
		}
		
		Sql::query('SATURN','Simpac',"sp_datasCursoAgendado_delete ".$CA->idcursoagendado);
		acao("Datas do curso agendado(".$CA->idcursoagendado.") foram deletadas");
		
		for($d=0; $d<count($datas[0]); $d++){
			Sql::query('SATURN','Simpac',"sp_cursosagendados_datas_add ".$CA->idcursoagendado.", ".$idSala.", ".$idInstrutor.", ".$idPeriodo[0][$d].", '".$datas[0][$d].' '.$hourInicio[0][$d]."', '".$datas[0][$d].' '.$hourTermino[0][$d]."','".$obs[0][$d]."'");
			
			acao("Data(".$datas[0][$d].' '.$hourInicio[0][$d].") do curso agendado(".$CA->idcursoagendado.") foi adicionada");
		}
		
		//Histórico
		Sql::query('SATURN','Simpac', "sp_cursosAgendadosHistorico_add ".$CA->idcursoagendado.", '"."Edição de Treinamentos<br/>Foi Editado o curso (".$CA->idcursoagendado.") cujas características são:<br/><br/>Data de Início: <b>".$dtIncNEW."</b><br/>Data de Término: <b>".$dtTermNEW."</b><br/>Hora de Início: <b>".$hourIncNEW."</b><br/>Hora de Termino: <b>".$hourTermNEW."</b><br/><br/>Sala Anterior: <b>".$SalaAtual['dessala']."</b><br/>Sala Atual: <b>".$SalaNova['dessala']."</b>', ".$_SESSION['idusuario']);
		
		$CA->refreshOLD($CA->idcursoagendado);
	}
	
	public function edit(NewCursoAgendado $NewCursoAgendado){
		
		$result = array(
			"msg"=>array()
		);
		
		try{
			if($NewCursoAgendado->isEditing){
				
				$SalaAtual = $this->getSalasAgendadas($NewCursoAgendado->idcursoagendado);
				
				$CALOG = new CursoAgendado($NewCursoAgendado->idcursoagendado);
				$CALOG->Log();
				unset($CALOG);
				
				if($NewCursoAgendado->desobsintercalado) $weekdaysHuman = $NewCursoAgendado->desobsintercalado;
				
				$NewCursoAgendado->desobs = str_replace($weekdaysHuman,'', $NewCursoAgendado->desobs);
				if(trim($NewCursoAgendado->desobs)) $NewCursoAgendado->desobs .= ' - ';
				$NewCursoAgendado->desobs .= $weekdaysHuman;
				
				//somente alterar se as datas continuam as mesmas	
				for($d=0; $d<count($NewCursoAgendado->datas); $d++){
					Sql::query('SATURN','Simpac',"sp_cursoagendado_datas_save ".$NewCursoAgendado->idcursoagendado.",".$NewCursoAgendado->datas[$d]['idregistro'].",".$NewCursoAgendado->idsala.",".$NewCursoAgendado->idperiodo.",'".$NewCursoAgendado->datas[$d]['dtinicio']."','".$NewCursoAgendado->datas[$d]['dttermino']."'");
				}
				
				Sql::query('SATURN','Simpac',"sp_cursosagendados_save_2 ".$NewCursoAgendado->idcursoagendado.",".$NewCursoAgendado->idcurso.",'".utf8_decode(str_replace("'",'´',$NewCursoAgendado->desobs))."',".$NewCursoAgendado->nrcargahoraria.",'".$NewCursoAgendado->datas[0]['dtinicio']."','".$NewCursoAgendado->datas[count($NewCursoAgendado->datas)-1]['dttermino']."',".$NewCursoAgendado->idperiodo.",".$NewCursoAgendado->idsala."");
				
				$idcursoagendado = $NewCursoAgendado->idcursoagendado;
				
				//Flags
				if(count($NewCursoAgendado->flags)){
					Sql::query('SATURN','Simpac',"sp_cursosagendados_flags_add $idcursoagendado, '".implode(',',$NewCursoAgendado->flags)."'");
				}
				
				$dt1 = strtotime($NewCursoAgendado->datas[0]['dtinicio']);
				$dt2 = strtotime($NewCursoAgendado->datas[count($NewCursoAgendado->datas)-1]['dttermino']);
				
				$SalaNova = $this->getSalasAgendadas($idcursoagendado);
				
				//Histórico
				Sql::query('SATURN','Simpac', "sp_cursosAgendadosHistorico_add $idcursoagendado, '".utf8_decode("Edição de Treinamentos<br/>Foi Editado o curso ($idcursoagendado) cujas características são:<br/><br/>Data de Início: <b>".date('d/m/Y', $dt1)."</b><br/>Data de Término: <b>".date('d/m/Y', $dt2)."</b><br/>Hora de Início: <b>".date('H:i', $dt1)."</b><br/>Hora de Termino: <b>".date('H:i', $dt2)."</b><br/><br/>Sala Anterior: <b>".$SalaAtual['dessala']."</b><br/>Sala Atual: <b>".$SalaNova['dessala'])."</b>', ".$_SESSION['idusuario']);
				
			//Se possui empresa associada ao agendamento
			if($NewCursoAgendado->idempresa) Sql::query('SATURN','Simpac',"sp_cursosagendados_empresa_add $idcursoagendado, $NewCursoAgendado->idempresa");
			
			//Turma Fechada
			if(in_array(4,$NewCursoAgendado->flags)){
				
				Sql::query('SATURN','Simpac',"sp_cursoagendadoatualizaturmafechada_save $idcursoagendado");	
			}
			
			//Reposição 
			if(in_array(3,$NewCursoAgendado->flags)){
				
				if($NewCursoAgendado->idreposicao) Sql::query('SATURN','Simpac',"sp_cursosagendados_reposicao_add $idcursoagendado, $NewCursoAgendado->idreposicao");
			}
			
			//Palestra
			if(in_array(11,$NewCursoAgendado->flags) && $NewCursoAgendado->idpalestra){
				Sql::query('SATURN','Simpac',"sp_cursosagendados_palestra_add $idcursoagendado, ".$NewCursoAgendado->idpalestra);	
			}
			
			//Usuário Solicitante
			if($NewCursoAgendado->idusuario) Sql::query('SATURN','Simpac',"sp_cursosagendadosusuario_v2_add $idcursoagendado, ".$NewCursoAgendado->idusuario);
			
			//Instrutor Confirmação
			$a = Sql::select('SATURN','Simpac', "select idusuario, dtcadastramento from tb_InstrutorConfirmacao where idcursoagendado = $idcursoagendado");
			
			if($a['idusuario']){
				Sql::query('SATURN','Simpac', "insert into tab_cursosagendados_instrutoresConfirmacoes (idregistro, idusuario, dtcadastro) select idregistro, ".$a['idusuario'].", '".formatdatetime($a['dtcadastramento'],8)."' from tab_cursosagendados_datas where idcursoagendado = $idcursoagendado");
			}
			
				unset($a);
			
				$this->refreshOLD($idcursoagendado);
			
				$result['success'] = true;
				return $result;
			}
		}catch(Exception $e){
			
			error($e);
			array_push($result['msg'], 'Não foi possível salvar o curso agendado na tabela principal.');
			$result['success'] = false;
			return $result;	
		}
	}
	
	public function add(NewCursoAgendado $NewCursoAgendado){
		
		//exit("sp_cursosagendados_save $NewCursoAgendado->idcursoagendado, $NewCursoAgendado->idcurso, $NewCursoAgendado->nrcargahoraria, '".utf8_decode(str_replace("'",'´',$NewCursoAgendado->desobs))."'");
		
		// exit("sp_cursosagendadosexplicit_add $NewCursoAgendado->idcursoagendado, $NewCursoAgendado->idcurso, $NewCursoAgendado->nrcargahoraria, '".utf8_decode(str_replace("'",'´',$NewCursoAgendado->desobs))."'");
		
		$result = array(
			"msg"=>array()
		);
		
		try{
			
			if($NewCursoAgendado->isEditing){
				
				$SalaAtual = $this->getSalasAgendadas($NewCursoAgendado->idcursoagendado);
				
				$this->setlog();
				
//				if(!$NewCursoAgendado->desobsdefault) $weekdaysHuman = $this->datesToHuman($NewCursoAgendado->datas);
				if($NewCursoAgendado->desobsintercalado) $weekdaysHuman = $NewCursoAgendado->desobsintercalado;
				
				$NewCursoAgendado->desobs = str_replace($weekdaysHuman,'', $NewCursoAgendado->desobs);
				if(trim($NewCursoAgendado->desobs)) $NewCursoAgendado->desobs .= ' - ';
				$NewCursoAgendado->desobs .= $weekdaysHuman;
				
				$contratos = Sql::arrays('SATURN','Simpac',"sp_instrutorcontrato_get ".$NewCursoAgendado->idcursoagendado);
				
				if(count($contratos)){
					
					
					
					$CA = new CursoAgendado($NewCursoAgendado->idcursoagendado);
					
					$html = array();
					foreach($contratos as $contrato){
						$motivo = (trim($contrato['desmotivo']))?$contrato['desmotivo']:'Nenhum motivo informado';
						array_push($html, '<p><span style="color:grey">ID</span><br/>'.$contrato['idcontrato'].'</p><p><span style="color:grey">Instrutor</span><br/>'.$contrato['nmusual'].'</p><p><span style="color:grey">Valor Hora</span><br/>'.$contrato['vlhoraacordado'].'</p><p><span style="color:grey">Motivo</span><br/>'.$motivo.'</p><p>A alteração foi realizada em <strong>'.date('d/m/Y H:i').'</strong> por <strong>'.$_SESSION['nmlogin'].'</strong>.</p>');
					}
					
					send_email(array(
						"CharSet"=>'utf-8',
						"to"=>"Soraia@impacta.com.br;Rcastro@impacta.com.br",
						"subject"=>"Contrato cancelado devido alteração em turma",
						"body"=>emailpadrao('<p>O treinamento de <strong>'.$CA->getCurso()->descurso.' - '.$CA->desperiodo.' - '.date('d/m/Y', $CA->dtinicio).' a '.date('d/m/Y', $CA->dttermino).' das '.date('H:i', $CA->dtinicio).' às '.date('H:i', $CA->dttermino).'</strong> foi alterado e o contrato cancelado.</p><h3>Dados do Contrato Cancelado</h3>'.implode('',$html)
					)));
					
					unset($CA);
					
				}
				unset($contratos);
				
				$datasSalvas = Sql::arrays('SATURN','Simpac',"sp_cursosagendados_save $NewCursoAgendado->idcursoagendado, $NewCursoAgendado->idcurso, $NewCursoAgendado->nrcargahoraria, '".utf8_decode(str_replace("'",'´',$NewCursoAgendado->desobs))."'");
					
				$idcursoagendado = $NewCursoAgendado->idcursoagendado;
				
				$dt1 = strtotime($NewCursoAgendado->datas[0]['dtinicio']);
				$dt2 = strtotime($NewCursoAgendado->datas[count($NewCursoAgendado->datas)-1]['dttermino']);
				
			}else{
			
				//Cria o Agendamento do Treinamento
				if($NewCursoAgendado->idcursoagendado){
					
					Sql::query('SATURN','Simpac',"sp_cursosagendadosexplicit_add $NewCursoAgendado->idcursoagendado, $NewCursoAgendado->idcurso, $NewCursoAgendado->nrcargahoraria, '".utf8_decode(str_replace("'",'´',$NewCursoAgendado->desobs))."'");
					
					$idcursoagendado = $NewCursoAgendado->idcursoagendado;

				}else{
					
					//if(!$NewCursoAgendado->desobsdefault) $weekdaysHuman = $this->datesToHuman($NewCursoAgendado->datas);
					if($NewCursoAgendado->desobsintercalado) $weekdaysHuman = $NewCursoAgendado->desobsintercalado;
					
					$NewCursoAgendado->desobs = str_replace($weekdaysHuman,'', $NewCursoAgendado->desobs);
					if(trim($NewCursoAgendado->desobs)) $NewCursoAgendado->desobs .= ' - ';
					$NewCursoAgendado->desobs .= $weekdaysHuman;
					
					$a = Sql::select('SATURN','Simpac',"sp_cursosagendados_add $NewCursoAgendado->idcurso, $NewCursoAgendado->nrcargahoraria, '".utf8_decode(str_replace("'",'´',$NewCursoAgendado->desobs))."'");
					
					$idcursoagendado = $a['idcursoagendado'];
					
					$dt1 = strtotime($NewCursoAgendado->datas[0]['dtinicio']);
					$dt2 = strtotime($NewCursoAgendado->datas[count($NewCursoAgendado->datas)-1]['dttermino']);
				
				}
			
			}
			
			//Flags
			if(count($NewCursoAgendado->flags)){
				Sql::query('SATURN','Simpac',"sp_cursosagendados_flags_add $idcursoagendado, '".implode(',',$NewCursoAgendado->flags)."'");
			}
			
			//Dias de Treinamento
			for($i=0; $i<count($NewCursoAgendado->datas); $i++){
				
				$saveIdInstrutor = ($datasSalvas[$i]['idinstrutor'])?$datasSalvas[$i]['idinstrutor']:$saveIdInstrutor;
					
				if(!$saveIdInstrutor) $saveIdInstrutor = 588;
				
				if($NewCursoAgendado->isEditing){
					
					$inst = new Instrutor($saveIdInstrutor);
					
					$conflitos = $inst->hasConflito($item['dtinicio'], $item['dttermino'], $NewCursoAgendado->idcursoagendado);
					
					if(count($conflitos)){
						
						array_push($result['msg'], 'O intervalo de '.date('d/m/Y H:i', strtotime($item['dtinicio'])).' a '.date('d/m/Y H:i', strtotime($item['dttermino'].' não foi agendado devido um conflito de instrutor no momento da gravação.')));
							
					}
				
				}
				
				$item = $NewCursoAgendado->datas[$i];
				
				$sala = new Sala($item['idsala']);
				
				if($NewCursoAgendado->isEditing){
				
					$conflitos = $sala->getAgendamentos($item['dtinicio'], $item['dttermino'], $NewCursoAgendado->idcursoagendado);
				
				}else{
					
					$conflitos = $sala->getAgendamentos($item['dtinicio'], $item['dttermino']);
						
				}
				
				if(count($conflitos)){
					
					array_push($result['msg'], 'O intervalo de '.date('d/m/Y H:i', strtotime($item['dtinicio'])).' a '.date('d/m/Y H:i', strtotime($item['dttermino'].' não foi agendado devido um conflito de sala no momento da gravação.')));
					
					//$conflitoA = new CursoAgendado($NewCursoAgendado->idcursoagendado);
					
					
					/*if(strtotime("2011-8-1")<$conflitoA->dtinicio){
					
						$fileLog = fopen($_SERVER["DOCUMENT_ROOT"]."/simpacweb/logConflito.txt", "a+");
						fwrite($fileLog, "
	$NewCursoAgendado->idcursoagendado - ".trim($conflitoA->getCurso()->descurso)." ".trim($conflitoA->desobs)." - ".date('d/m/Y', $conflitoA->dtinicio)." a ".date('d/m/Y', $conflitoA->dttermino)."\n
	====================================================================================\n\n
	");
					
					}*/
					
				}else{
					
					Sql::query('SATURN','Simpac',"sp_cursosagendados_datas_add $idcursoagendado, ".$item['idsala'].", ".$saveIdInstrutor.",".$item['idperiodo'].", '".$item['dtinicio']."', '".$item['dttermino']."', '".utf8_decode(str_replace("'",'´',$item['desobs']))."'");
					
				}
				
			}
			
			$SalaNova = $this->getSalasAgendadas($idcursoagendado);
			
			//Histórico
			if($NewCursoAgendado->isEditing){
				
				//Edição
				Sql::query('SATURN','Simpac', "sp_cursosAgendadosHistorico_add $idcursoagendado, '".utf8_decode("Edição de Treinamentos<br/>Foi Editado o curso ($idcursoagendado) cujas características são:<br/><br/>Data de Início: <b>".date('d/m/Y', $dt1)."</b><br/>Data de Término: <b>".date('d/m/Y', $dt2)."</b><br/>Hora de Início: <b>".date('H:i', $dt1)."</b><br/>Hora de Termino: <b>".date('H:i', $dt2)."</b><br/><br/>Sala Anterior: <b>".$SalaAtual['dessala']."</b><br/>Sala Atual: <b>".$SalaNova['dessala'])."</b>', ".$_SESSION['idusuario']);
				
			}else{
				
				//Criação
				//Sql::query('SATURN','Simpac', "sp_cursosAgendadosHistorico_add $idcursoagendado, '".utf8_decode("Criação de Treinamentos<br/>Foi ADICIONADO o curso ($idcursoagendado) cujas características são:<br/><br/>Data de Início: <b>".date('d/m/Y', $dt1)."</b><br/>Data de Término: <b>".date('d/m/Y', $dt2)."</b><br/>Hora de Início: <b>".date('H:i', $dt1)."</b><br/>Hora de Termino: <b>".date('H:i', $dt2)."</b><br/><br/>Sala: <b>".$SalaNova['dessala'])."</b>', ".$_SESSION['idusuario']);
				
			}
			
			//Se possui empresa associada ao agendamento
			if($NewCursoAgendado->idempresa) Sql::query('SATURN','Simpac',"sp_cursosagendados_empresa_add $idcursoagendado, $NewCursoAgendado->idempresa");
			
			//Turma Fechada
			if(in_array(4,$NewCursoAgendado->flags)){
				
				Sql::query('SATURN','Simpac',"sp_cursoagendadoatualizaturmafechada_save $idcursoagendado");
					
			}
			
			//Reposição
			if(in_array(3,$NewCursoAgendado->flags)){
				
				if($NewCursoAgendado->idreposicao) Sql::query('SATURN','Simpac',"sp_cursosagendados_reposicao_add $idcursoagendado, $NewCursoAgendado->idreposicao");
					
			}
			
			//Palestra
			if(in_array(11,$NewCursoAgendado->flags) && $NewCursoAgendado->idpalestra){
				# @AUTOR = PedroAraujo #
				if(!is_numeric($NewCursoAgendado->idpalestra)){
					$palestras = Sql::select('Saturn', 'Simpac', "sp_palestras_add '$NewCursoAgendado->idpalestra', ".$_SESSION['idusuario']);
					$NewCursoAgendado->idpalestra = $palestras['idpalestra'];
					unset($palestras);
				}
				Sql::query('SATURN','Simpac',"sp_cursosagendados_palestra_add $idcursoagendado, ".$NewCursoAgendado->idpalestra);
					
			}
			
			//Usuário Solicitante
			if($NewCursoAgendado->idusuario) Sql::query('SATURN','Simpac',"sp_cursosagendadosusuario_add $idcursoagendado, ".$NewCursoAgendado->idusuario);
			
			//Instrutor Confirmação
			$a = Sql::select('SATURN','Simpac', "select idusuario, dtcadastramento from tb_InstrutorConfirmacao where idcursoagendado = $idcursoagendado");
			
			if($a['idusuario']){
				Sql::query('SATURN','Simpac', "insert into tab_cursosagendados_instrutoresConfirmacoes (idregistro, idusuario, dtcadastro) select idregistro, ".$a['idusuario'].", '".formatdatetime($a['dtcadastramento'],8)."' from tab_cursosagendados_datas where idcursoagendado = $idcursoagendado");
			}
			
			unset($a);
			
			/*function detectUser($text){
				
				$text2 = trim(str_replace('Usuário Responsável:', '', substr($text, strpos($text, 'Usuário Responsável:'), strlen($text))));
				
				$nmlogin = substr($text2, 0, strpos($text2, ' '));
				
				$usuario = Sql::select('SATURN', 'Simpac', "sp_usuarios_get_nmlogin '$nmlogin'");
				
				return $usuario['idusuario'];
			
			}*/
			
			/*$historico = Sql::arrays('SATURN', 'Simpac', "select DesHistorico, data from tb_HistoricoCurso where IdCursoAgendado = $idcursoagendado");
			
			if(count($historico)){
				
				foreach($historico as $rec){
					
					$idusuario = detectUser($rec['DesHistorico']);
					
					if($idusuario){
						
						@Sql::query('SATURN','Simpac', "sp_cursosAgendadosHistorico_add $this->idcursoagendado, '".utf8_decode(str_replace("'",'´',$rec['DesHistorico']))."', ".$idusuario);
							
					}
				
				}
					
			}
			
			unset($historico);*/
			
			$this->refreshOLD($idcursoagendado);
			
			//Histórico de Criação
			if(!$NewCursoAgendado->isEditing){
			
				$CA_HISTORY = new CursoAgendado($idcursoagendado);
					Sql::query('SATURN','Simpac', "sp_cursosAgendadosHistorico_add $idcursoagendado, '".utf8_decode('Treinamento Criado com as seguintes características:<br/>'.$CA_HISTORY->getHtmlDescription())."', ".$_SESSION['idusuario']);
					unset($CA_HISTORY);
				
			}
			
			$result['success'] = true;
			return $result;
		
		}catch(Exception $e){
			
			$this->refreshOLD($idcursoagendado);
			error($e);
			array_push($result['msg'], 'Não foi possível salvar o curso agendado na tabela principal.');
			$result['success'] = false;
			return $result;
				
		}
		
	}
	
	public function getData($idregistro){
		
		return Sql::select('SATURN','Simpac', "sp_cursoagendadodata_get $idregistro");
			
	}
	
	public function getCursoByRegistroData($idregistro){
		
		$a = Sql::select('SATURN','Simpac', "sp_CursoByCursoAgendadoRegistroData_get $idregistro");
		return $a['idcurso'];
			
	}
	
	public function getDiaADia($datesql = false){
		
		$this->datas = Sql::arrays('SATURN','Simpac',"sp_cursoagendadoDiaADia_list $this->idcursoagendado", true, $datesql, $datesql);
		
		return $this->datas;
			
	}
	
	public function getFlags($idflags = array()){
		if(!count($idflags)){
			return Sql::arrays('SATURN','Simpac',"sp_cursoagendadoflags_list $this->idcursoagendado");
		}else{
			return Sql::arrays('SATURN','Simpac',"sp_cursoagendadoflagsbyidflags_list '".implode(',',$idflags)."'");
		}
			
	}
	
	public function cancelar(){
		
		$this->Log();
		$this->sendLogEmail('Treinamento Cancelado');
		$this->addHistorico('<span class="red">Treinamento Cancelado</span>');
		Sql::query('SATURN','Simpac', "sp_cursosAgendadosCancelar $this->idcursoagendado");
		
	}
	
	public function addHistorico($text){
		
		$result = Sql::select('SATURN','Simpac', "sp_cursosAgendadosHistorico_add $this->idcursoagendado, '".utf8_decode($text)."', ".$_SESSION['idusuario']);
		return (int)$result['idhistorico'];
			
	}
	
	public function desagendarData($idregistro, $idmotivo, $deshistorico){
		
		$this->Log();
		acao("Desagendou um dos dias de aula (idregistro: $idregistro).");
		$result = Sql::select('SATURN','Simpac',"sp_cursoagendadodata_get $idregistro");
		$idhistorico = $this->addHistorico($deshistorico);
		Sql::query('SATURN','Simpac',"sp_cursosagendados_datasremovidas_add $idregistro, $idmotivo, ".$_SESSION['idusuario'].", $idhistorico");
		unset($result);
		Sql::query('SATURN','Simpac', "sp_cursoagendadodata_delete $idregistro");
		$this->refreshOLD($this->idcursoagendado);
		return true;
			
	}
	
	public function desagendar(){
		
		$this->Log();
		$this->sendLogEmail('Desagendou o treinamento');
		acao("Desagendou o Curso Agendado $this->idcursoagendado");		
		Sql::query('SATURN','Simpac', "sp_cursosAgendados_delete $this->idcursoagendado");
		return true;
			
	}
	
	private function refreshOLD($idcursoagendado){
	//**************************** ATUALIZANDO ESTRUTURA ANTIGA ***********************************//	
		
		Sql::query('SATURN', 'Simpac', "sp_CursoAgendadoAtualizaEstruturaAntiga $idcursoagendado");
	
	//**************************** ATUALIZANDO ESTRUTURA ANTIGA ***********************************//
	}
	
	public function refreshOLDManual(){
		
		return $this->refreshOLD($this->idcursoagendado);
			
	}
	
	public function setlog(){
		
		return $this->Log();
			
	}
	
	public function datesToHuman(array $datas){
		
		$weekdays = array();
		foreach($datas as $dataAgendada){
			array_push($weekdays, date('w', strtotime($dataAgendada['dtinicio'])));
		}
		$integral = true;
		$weekdays_u = array_unique($weekdays);
		$c = 0;
		for($i=min($weekdays); $i<=max($weekdays); $i++){
			if($weekdays_u[$c]!=$i){
				$integral=false;
			}
			$c++;
		}
		if($integral){
			$text = weekdaynumber(min($weekdays_u)).' a '.weekdaynumber(max($weekdays_u));
			if(count($datas)>1){
				return str_replace('sab a sab','',str_replace('dom a dom','',str_replace('2° a 6°','',
							$text
						)));
			}else{
				return '';	
			}
		}else{
			$weekdaysNames = array();
			foreach($weekdays_u as $w){
				array_push($weekdaysNames, left(weekdaynumber($w),3));
			}
			if(count($weekdaysNames)==1){
				if(left($weekdaysNames[0],1)=='S' || left($weekdaysNames[0],1)=='D'){
					return 'todo '.$weekdaysNames[0];
				}else{
					return 'toda '.$weekdaysNames[0];	
				}
			}elseif(count($weekdaysNames)==2){
				return $weekdaysNames[0].' e '.$weekdaysNames[1];
			}else{
				$text = '';
				$t = count($weekdaysNames)-1;
				for($y=0; $y<count($weekdaysNames); $y++){
					if($y<($t-1)){
						$text .= $weekdaysNames[$y].', ';
					}elseif($y==($t-1)){
						$text .= $weekdaysNames[$y].' e ';
					}else{
						$text .= $weekdaysNames[$y];
					}
				}
				return $text;
			}
		}
		
	}
	
	public function getSalasAgendadas($idcursoagendado){
		
		$data = array(
			"idsala"=>array(),
			"dessala"=>array()
		);
		foreach(Sql::arrays('SATURN','Simpac',"sp_cursoagendadoSalas_list $idcursoagendado") as $row){
			
			array_push($data['idsala'], $row['idsala']);
			array_push($data['dessala'], $row['dessala']);
				
		}
		
		$data['idsala'] = implode(', ', $data['idsala']);
		$data['dessala'] = implode(', ', $data['dessala']);
		
		return $data;
	}
	
	public function getListaDePresencaByDia($dt){
		return Sql::arrays('SATURN','Simpac',"sp_ListaDePresenca_list $this->idcursoagendado, '$dt'");
		
	}
	
	/*
	** by Enzo
	-- BASICO      @unidade, @data
	-- POR SALA    @unidade, @data, @idsala
	-- POR CURSO   @unidade, @data, null, @idcurso
	-- POR PERIODO @unidade, @data, null, null, @idperiodo
	-- COMPLETO    @unidade, @data, @idsala, @idcurso, @idperiodo
	** 
	*/		
	public function getListCursoAgendado($idunidade, $date, $idsala = 'NULL', $idcurso = 'NULL', $idperiodo = 'NULL'){
		
		return Sql::arrays('SATURN','SUPORTE',"sp_checklist_list $idunidade, '$date 00:00', $idsala, $idcurso, $idperiodo");
	}
	
	
	public function setAlterCurso($idcurso,$idcursoagendado){
		$CA = new CursoAgendado($idcursoagendado);
		$CA->Log();
		Sql::query('SATURN','SIMPAC',"sp_altercurso_cursoagendado_set $idcurso,$idcursoagendado");
		Sql::query('SATURN','SIMPAC',"sp_altercurso_cursosagendados_set $idcurso,$idcursoagendado");
	}
	
	public function __toString(){
		
		return json_encode(get_object_vars($this));
			
	}
	
	public function saveDataCurso($idregistro,$idperiodo,$dtinicio,$dttermino,$idsala,$obs){
		$this->Log();
		Sql::query('SATURN','Simpac',"sp_dataTreinamento_save $this->idcursoagendado, $idregistro, $idperiodo,'$dtinicio', '$dttermino', $idsala, '$obs'");
		acao("Alterado a dtInicio(".$dtinicio.") e dtTermino(".$dttermino.") do curso agendado(".$this->idcursoagendado.")");
		
		$this->checkDatasTabelas();
	}
	
	public function deleteDataCurso($idregistro){
		$this->Log();		
		Sql::query('SATURN','Simpac',"sp_dayCursoAgendado_delete $idregistro");
		acao("Excluido idregistro(".$idregistro.") referente ao curso agendado(".$this->idcursoagendado.")");
		
		$this->checkDatasTabelas();
	}
	
	public function editSalaCursoAgendado($idsala){
		$this->Log();		
		Sql::query('SATURN','Simpac',"sp_salaCursoAgendado_edit $this->idcursoagendado, $idsala");
		acao("Alterado a sala(".$idsala.") referente ao curso agendado(".$this->idcursoagendado.")");	
	}
	
	public function checkDatasTabelas(){
		
		$this->Log();
		
		$queryCA = Sql::arrays('SATURN','Simpac',"sp_datas_CursoAgendado_list $this->idcursoagendado");
		
		$queryDATAS = Sql::arrays('SATURN','Simpac',"sp_datas_CursoAgendadoDatas_list $this->idcursoagendado");
		
		$hourincioCA = date('H:i',$queryCA[0]['Dtinicio']);
		$hourterminoCA = date('H:i',$queryCA[0]['DtTermino']);
		$dtinicioCA = date('Y-m-d',$queryCA[0]['Dtinicio']);
		$dtterminoCA = date('Y-m-d',$queryCA[0]['DtTermino']);
		/*$salaCA = $queryCA[0]['IdSala'];
		$periodoCA = $queryCA[0]['IdPeriodo'];*/
		
		$dtinicioDATAS = date('Y-m-d',$queryDATAS[0]['dtinicio']);
		$dtterminoDATAS = date('Y-m-d',$queryDATAS[0]['dttermino']);
		
		if($dtinicioCA != $dtinicioDATAS || $dtterminoCA != $dtterminoDATAS){
			
			Sql::query('SATURN','Simpac',"sp_datas_CursoAgendado_edit $this->idcursoagendado,'".$dtinicioDATAS.' '.$hourincioCA."','".$dtterminoDATAS.' '.$hourterminoCA."'");
			acao("Alterada a dtinicio(".$dtinicioDATAS.' '.$hourincioCA.") e/ou dttermino(".$dtterminoDATAS.' '.$hourterminoCA.") do curso agendado(".$this->idcursoagendado.")");
		}
	}
	
	public function saveObsCurso($obs){
		$this->Log();
		Sql::query('SATURN','Simpac',"sp_cursoAgendadoObs_edit $this->idcursoagendado,'$obs'");
		acao("Alterado a obs(".$obs.") do curso agendado(".$this->idcursoagendado.")");
	}	
	
	public function getAll(){
		
		$this->getSolicitante();
		$this->getIdReposicao();
		$this->getIdEmpresa();
		$this->getDiaADia();

	}
	
	private function setInTpl($data, $body, $node = 'datas'){
		
		foreach($data as $field=>$value){
			
			if(is_array($value) && $field==$node){
				
				$for = str_replace('<tpl for="'.$node.'">', '', substr($body, strpos($body, '<tpl for="'.$node.'">'), strpos($body, '</tpl>')-strpos($body, '<tpl for="'.$node.'">')));
				
				$body = str_replace('<tpl for="'.$node.'">'.$for.'</tpl>','{content}', $body);
				
				$resultFor = '';
				foreach($value as $item){	
					
					$for2 = $for;
					
					foreach($item as $c=>$v){
						
						$for2 = str_replace('{'.$c.'}', $v, $for2);
						
					}
					
					$resultFor .= $for2;				
							
				}
				
				$body = str_replace('{content}', $resultFor, $body);
			}
		}
		
		foreach($data as $field=>$value){
			$body = str_replace("{".$field."}", $value, $body);
		}

		return $body;	
	}
	
	public function getHtmlDescription(){
		
		$this->getAll();
		
		$data = array();
		foreach(get_class_vars(get_class($this)) as $key=>$val){
			if($key=='dtinicio' || $key=='dttermino'){
				$data[$key] = date('d/m/Y H:i', $this->{$key});
			}else{
				$data[$key] = $this->{$key};	
			}
		}
		
		$desflags = array();
		foreach($this->getFlags() as $flag){
			array_push($desflags, $flag['desflag']);
		}
		
		$data['descurso'] = $this->getCurso()->descurso;
		$data['dessala'] = $this->getSala()->dessala;
		$data['desinstrutor'] = $this->getInstrutor()->desinstrutor;
		$data['desreposicao'] = ($this->idreposicao)?getName($this->idreposicao, SW_CURSOAGENDADO):'Não';
		$data['desempresa'] = ($this->getEmpresa()->desempresa)?$this->getEmpresa()->desempresa:'Nenhuma';
		$data['desopcoes'] = (count($desflags))?implode(', ',$desflags):'Nenhuma';
		$data['desusuario'] = ($this->solicitante)?$this->solicitante->nmlogin:'Nenhum';
		unset($data['flags'], $data['solicitante'], $data['Curso'], $data['Instrutor'], $data['Sala'], $data['Reposicao'], $data['Empresa']);
		
		foreach($data['datas'] as &$d){
			$d['dtinicio'] = date('d/m/Y H:i', $d['dtinicio']);
			$d['dttermino'] = date('d/m/Y H:i', $d['dttermino']);
		}
		
		return $this->setInTpl($data, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/simpacweb/modulos/cursosagendados/tpl/cursoagendado.html'));
			
	}
	
	public function getFlagsNames($idflags = array()){
		$desflags = array();
		foreach($this->getFlags($idflags) as $flag){
			array_push($desflags, $flag['desflag']);
		}
		return $desflags;
	}
	
	public function Log($acao = ''){
		
		$this->getAll();
		
		$path = $_SERVER['DOCUMENT_ROOT'].'/simpacweb/modulos/cursosagendados/log';
		
		if(!is_dir($path.'/'.date('Y'))){
				chdir($path);
				mkdir(date('Y'));
		}
		
		if(!is_dir($path.'/'.date('Y').'/'.date('m'))){
				chdir($path.'/'.date('Y'));
				mkdir(date('m'));
		}
		
		if(!is_dir($path.'/'.date('Y').'/'.date('m').'/'.date('d'))){
				chdir($path.'/'.date('Y').'/'.date('m'));
				mkdir(date('d'));
		}
		
		$logName = $this->idcursoagendado.'-'.$_SESSION['idusuario'].'-'.time();
		
		$log = fopen($path.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$logName.'.log','w+');
		fwrite($log, json_encode($this));
		fclose($log);
		
		Sql::query('SATURN','Simpac',"sp_cursosagendados_logfile_add ".$this->idcursoagendado.", '".$logName."', ".$_SESSION['idusuario'].", ".$_SESSION['idcomputador_now']);
		
		acao("Alterou CursoAgendado ".$this->idcursoagendado.". Log: $logName.log");
		if($acao) acao('Curso Agendado LOG: '.$acao);
		
		return true;
			
	}
	
	public function getConflitos($dtinicio, $dttermino, $idsala, $idinstrutor, $idregistro = false, $inferiado = true/*Deve conflitar os feriados?*/, $byIdregistro = true){
		
		$idregistro = ($idregistro===false)?0:$idregistro;
		
		$Sala = new Sala($idsala);
		$salaConflitos = $Sala->getAgendamentos($dtinicio, $dttermino, $idregistro, $byIdregistro);
		$Instrutor = new Instrutor($idinstrutor);
		$instrutorConflitos = $Instrutor->getAgendamentos($dtinicio, $dttermino, $idregistro, $byIdregistro);
		
		$feriadosConflitos = array();

		if($inferiado) $feriadosConflitos = $this->getFeriados($dtinicio, $dttermino);
		
		return array(
			'success'=>(!count($salaConflitos) && !count($instrutorConflitos) && !count($feriadosConflitos)), 
			'salas'=>$salaConflitos,
			'instrutores'=>$instrutorConflitos,
			'feriados'=>$feriadosConflitos
		);
		
	}
	
	public function addDataAgenda($dtinicio, $dttermino, $idperiodo, $idsala = 13, $idinstrutor = 588, $desobs = '', $inferiado = true){
		
		$conflitos = $this->getConflitos($dtinicio, $dttermino, $idsala, $idinstrutor, false, $inferiado);
		
		if($conflitos['success']){
		
			$this->Log();
			Sql::query('SATURN','Simpac',"sp_cursosagendados_datas_add ".$this->idcursoagendado.", ".$idsala.", ".$idinstrutor.", ".$idperiodo.", '".$dtinicio."', '".$dttermino."','".$desobs."'");
			$this->refreshOLD($this->idcursoagendado);
			$deshistoricoferiado = ($inferiado)?'<br/><span style="#FF9900>Adicionou ignorando o conflito com feriados.</span>':'';
			$this->addHistorico('Adicionou uma data ao agendamento: <b>'.date('d/m/Y \d\a\s H:i', strtotime($dtinicio)).' a '.date('d/m/Y \a\s H:i', strtotime($dttermino)).' - '.getName($idperiodo, SW_PERIODO).' - Sala: '.getName($idsala, SW_SALA)." - Instrutor: ".getName($idinstrutor, SW_INSTRUTOR).'</b>.'.$deshistoricoferiado);
			$this->sendLogEmail('Adicionou uma data ao agendamento: <b>'.date('d/m/Y \d\a\s H:i', strtotime($dtinicio)).' a '.date('d/m/Y \a\s H:i', strtotime($dttermino)).' - '.getName($idperiodo, SW_PERIODO).' - Sala: '.getName($idsala, SW_SALA)." - Instrutor: ".getName($idinstrutor, SW_INSTRUTOR).'</b>.'.$deshistoricoferiado);
			return array('success'=>true);
		
		}else{
			
			return $conflitos;
				
		}
			
	}
	
	public function setCurso($idcurso){
		
		$this->Log("Alterou o curso de <b>".getName($this->idcurso, SW_CURSO)."</b> para <b>".getName($idcurso, SW_CURSO)."</b>.");
		Sql::query('SATURN','Simpac',"sp_cursosagendadoscurso_save $this->idcursoagendado, $idcurso");
		return true;
			
	}
	
	public function setCargaHoraria($nrcargahoraria){
		
		$this->Log("Alterou a carga horária de <b>".$this->nrcargahoraria."h</b> para <b>".$nrcargahoraria."h</b>.");
		Sql::query('SATURN','Simpac',"sp_cursosagendadoscargahoraria_save $this->idcursoagendado, $nrcargahoraria");
		return true;
			
	}
	
	public function setOBS($desobs){
		
		$this->Log("Alterou a observação de <b>".$this->desobs."</b> para <b>".$desobs."</b>.");
		Sql::query('SATURN','Simpac',"sp_cursosagendadosobs_save $this->idcursoagendado, '".utf8_decode($desobs)."'");
		return true;
			
	}
	
	public function setFlags($flags = array()){
		$this->Log("Marcou as opções <b>".implode(', ',$this->getFlagsNames($flags))."h</b>.");
		Sql::query('SATURN','Simpac',"sp_cursosagendados_flags_remove $this->idcursoagendado");
		Sql::query('SATURN','Simpac',"sp_cursosagendados_flags_add $this->idcursoagendado, '".implode(',',$flags)."'");
		$this->refreshOLD($this->idcursoagendado);
		return true;
	}
	
	public function setEmpresa($idempresa){
		$old = ($this->idempresa)?getName($this->idempresa, SW_EMPRESA):'Nenhuma';
		$this->Log("Alterou a empresa de <b>".$old."</b> para <b>".getName($idempresa, SW_EMPRESA)."</b>.");
		Sql::query('SATURN','Simpac',"sp_cursosagendados_empresa_add $this->idcursoagendado, $idempresa");
		$this->refreshOLD($this->idcursoagendado);
		return true;
	}
	
	public function setSolicitante($idusuario){
		$old = ($this->idusuario)?getName($this->idusuario, SW_USUARIO):'Nenhum';
		$this->Log("Alterou o solicitante de <b>".$old."</b> para <b>".getName($idusuario, SW_USUARIO)."</b>.");
		Sql::query('SATURN','Simpac',"sp_cursosagendadosusuario_add $this->idcursoagendado, $idusuario");
		$this->refreshOLD($this->idcursoagendado);
		return true;
	}
	
	public function setPalestra($idpalestra){
		$old = ($this->idpalestra)?getName($this->idpalestra, SW_PALESTRA):'Nenhuma';
		$this->Log("Alterou a palestra de <b>".$old."</b> para <b>".getName($idpalestra, SW_PALESTRA)."</b>.");
		Sql::query('SATURN','Simpac',"sp_cursosagendados_palestra_add $this->idcursoagendado, $idpalestra");
		$this->refreshOLD($this->idcursoagendado);
		$this->setCurso(625);
		return true;
	}
	
	public function setData($idregistro, $dtinicio /*Y-m-d H:i*/, $dttermino /*Y-m-d H:i*/, $idperiodo, $idsala = 13, $idinstrutor = 588, $desobs = '', $inferiado = true, $byIdregistro = true, $idcursoagendado = 0){
		
		$idConflito = ($byIdregistro)?$idregistro:$idcursoagendado;
		
		$conflitos = $this->getConflitos($dtinicio, $dttermino, $idsala, $idinstrutor, $idConflito, $inferiado, $byIdregistro);
		
		if($conflitos['success']){
					
			$this->Log("Alterou a data <b>".date('d/m/Y', strtotime($dtinicio))." (idregistro: ".$idregistro.")</b> para ".date('d/m/Y H:i', strtotime($dtinicio))." a ".date('d/m/Y H:i', strtotime($dttermino))." - ".getName($idperiodo, SW_PERIODO)." - ".getName($idsala, SW_SALA)." - ".getName($idinstrutor, SW_INSTRUTOR));
			Sql::query('SATURN','Simpac',"sp_cursoagendadodata_save $idregistro, $idsala, $idinstrutor, $idperiodo, '$dtinicio', '$dttermino', '".utf8_decode($desobs)."'");
			$this->refreshOLD($this->idcursoagendado);
			
			return array('success'=>true);
			
		}else{
			
			return $conflitos;
				
		}
			
	}
	
	public function sendLogEmail($desalteracoes){
		
		$this->load($this->idcursoagendado);
		
		$data = array(
			'tpl_cursoagendado'=>utf8_decode($this->getHtmlDescription()),
			'desalteracoes'=>utf8_decode($desalteracoes),
			'idcursoagendado'=>$this->idcursoagendado,
			'nmlogin'=>$_SESSION['nmlogin'],
			'dtalteracao'=>date('d/m/Y H:i')
		);
		
		/*send_email(array(
			'to'=>'jrangel@impacta.com.br;bbarbosa@impacta.com.br',
			'subject'=>utf8_decode('Alteração do Treinamento Marcado ('.$this->idcursoagendado.') - '.$_SESSION['nmlogin']),
			'body'=>emailpadrao($this->setInTpl($data, file_get_contents($_SERVER['DOCUMENT_ROOT'].'/simpacweb/layoutEmail/cursoagendado/alteracoes.html'), 'historicos'))
		));*/
		
		return true;
		
	}
	
	public function getNrSalas(){
		
		$result = Sql::select('SATURN','Simpac',"sp_cursoagendadonrsalas_get $this->idcursoagendado");
		return $result['nrsalas'];
			
	}
	
	public function getNrInstrutores(){
		
		$result = Sql::select('SATURN','Simpac',"sp_cursoagendadonrinstrutores_get $this->idcursoagendado");
		return $result['nrinstrutores'];
			
	}
	
	public function getFeriados($dt1, $dt2){

		return Sql::arrays('SATURN','Simpac',"sp_feriados_list '$dt1', '$dt2'");
			
	}
	
}
?>