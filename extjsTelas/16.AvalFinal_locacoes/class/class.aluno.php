<?
# @AUTOR = jrangel #
class Aluno
{
	
	private $server = 'SATURN';
	private $database = 'Simpac';
	
	public $idaluno;
	public $nmaluno;
	public $dtnascimento;
	public $nrrg;
	public $nrcpf;
	public $desendereco;
	public $desbairro;
	public $descidade;
	public $sgestado;
	public $nrcep;
	public $cdemail;
	public $nrtelefoneresidencial;
	public $nrtelefonecomercial;
	public $nrcelular;
	public $dtcadastramento;
	public $dessexo;
	public $cdemailempresa;
	public $num;
	public $complemento;
	public $endereco;
	public $tipoendereco;
	
	public function __construct($idaluno){
		
		$this->idaluno = trim($idaluno);
		if(is_numeric($this->idaluno)){
			return $this->load($this->idaluno);
		}else{
			return false;	
		}
		
	}
	
	public function getIdAluno($nrcpf){
		
		$nrcpf = str_replace('-','',str_replace('.','',trim($nrcpf)));
		
		$a = Sql::select($this->server, 'Simpac', "sp_aluno_get_nrcpf '$nrcpf'");
		
		return $a['idaluno'];
			
	}
	
	public function getIdAlunos($nrcpf){
		//Adicionado devido um aluno ter mais de um ID com o mesmo CPF ----> bbarbosa
		return Sql::arrays($this->server, 'Simpac', "sp_aluno_get_idaluno '".str_replace('-','',str_replace('.','',trim($nrcpf)))."'");
	}
	
	public function load($idaluno){
		
		$a = Sql::select($this->server, $this->database, "sp_aluno_get $idaluno");
		
		if(!$a['idaluno']){
			$this->server = 'RANGER';
			$a = Sql::select($this->server, $this->database, "sp_aluno_get $idaluno");
		}
		
		$this->idaluno = $a['idaluno'];
		$this->nmaluno = utf8_encode($a['nmaluno']);
		$this->dtnascimento = timestamp($a['dtnascimento']);
		$this->nrrg = $a['nrrg'];
		$this->nrcpf = $a['nrcpf'];
		$this->desendereco = utf8_encode($a['desendereco']);
		$this->desbairro = utf8_encode($a['desbairro']);
		$this->descidade = utf8_encode($a['descidade']);
		$this->sgestado = utf8_encode($a['sgestado']);
		$this->nrcep = $a['nrcep'];
		$this->cdemail = $a['cdemail'];
		$this->nrtelefoneresidencial = $a['nrtelefoneresidencial'];
		$this->nrtelefonecomercial = $a['nrtelefonecomercial'];
		$this->nrcelular = $a['nrcelular'];
		$this->dtcadastramento = strtotime(formatdatetime($a['dtcadastramento'],8));
		$this->dessexo = $a['dessexo'];
		$this->cdemailempresa = $a['cdemailempresa'];
		$this->num = utf8_encode($a['num']);
		$this->complemento = utf8_encode($a['complemento']);
		
		return $this;
			
	}
	
	public function getAgendamentos($field = 'idalunoagendado'){
		
		$data = array();
		
		$a = Sql::arrays($this->server, $this->database, "sp_alunoagendado_list $this->idaluno");
		
		
		
		if($field=='idcursoagendado'){
			foreach($a as $a1){
				array_push($data, new CursoAgendado($a1['idcursoagendado']));	
			}
		} elseif($field=='idalunoagendado'){
			foreach($a as $a1){
				array_push($data, new AlunoAgendado($a1['idalunoagendado']));	
			}
		}
					
		return $data;
			
	}
	
	public function getAluno($idcursoagendado){
		$arrAluno = array();
		
		//$selected = Sql::query($this->server,"Simpac","sp_CrachaAluno $idcursoagendado");
		$selected = Sql::arrays($this->server,"Simpac","sp_crachasturma_list $idcursoagendado");
		foreach($selected as $e){
			array_push($arrAluno,array(
				"idaluno"=>$e["idaluno"],
				"nmaluno"=>$e["nmaluno"],
				"rg"=>$e["nrrg"],
				"periodo"=>$e["desperiodo"],
				"de"=>date("d/m/Y", $e["dtinicio"]),
				"termino"=>date("d/m/Y", $e["dttermino"]),
				"andar"=>$e["desandar"],
				"sala"=>$e["desandar"],
			));
		}
		
		return $arrAluno;
	}
	
	public function getCursosAgendados(){
		return $this->getAgendamentos('idcursoagendado');
	}
	
	public function getCursosAgendadosRanger(){
		$a = Sql::arrays("RANGER", "Simpac", "sp_alunotreinamentos $this->idaluno");
		$data = array();
		
		foreach($a as $rs){
			array_push($data, array(
				"idcursoagendado"=>$rs['idcursoagendado'],
				"descurso"=>$rs['descurso'],
				"desperiodo"=>$rs['desperiodo'],
				"dtinicio"=>$rs['dtinicio'],
				"dttermino"=>$rs['dttermino'],
			));	
		}
		
		return $data;
	}
		
	public function getTelefones($idcursoagendado){
		$arrDados = array();
		
		$select = Sql::arrays($this->server,"Simpac","sp_ListagemTelefoneAlunos $idcursoagendado");
		foreach($select as $e){
			array_push($arrDados,array(
				"aluno"=>$e["NmAluno"],
				"matricula"=>$e["Matricula"],
				"residencial"=>$e["NrTelefoneResidencial"],
				"comercial"=>$e["NrTelefoneComercial"],
				"celular"=>$e["NrCelular"],
			));
		}
		
		return $arrDados;
	}
	
	public function getTreinamentos($ranger = true){
		
		$data = array();
		
		foreach($this->getCursosAgendados() as $obj){
			
			if($obj->idsala != 30){//cancelado
				array_push($data, array(
					"idcursoagendado"=>$obj->idcursoagendado,
					"descurso"=>$obj->getCurso()->descurso,
					"desperiodo"=>$obj->desperiodo,
					"dtinicio"=>$obj->dtinicio,
					"dttermino"=>$obj->dttermino
				));
			}	
		}
		
		if($ranger){
			return array_merge_recursive($data, $this->getCursosAgendadosRanger());
		}else{
			return $data;
		}		
			
	}
	
	public function hasBloqueioFinanceiro(){
		
		$a = Sql::select($this->server,'Simpac',"sp_verificaFinanceiroBloqueado '$this->nrcpf'");
		
		if($a['total']>0){
			return true;
		}else{
			return false;
		}
			
	}
	
	public function hasAccount(){
		
		$a = Sql::select($this->server,'Simpac',"sp_account_get_cpf '$this->nrcpf'");
		
		if($a['cod_cli']){
			return $a;
		}else{
			return false;	
		}
			
	}
	
	public function getAccount(){
		
		$account = $this->hasAccount();
		if($account){
			return new Account($account['cod_cli']);
		}else{
			return false;	
		}
			
	}
	
	public function setCpfBloqueio($nrcpf,$idusuario,$inbloqueio,$motivo){
		if($nrcpf != NULL || $nrcpf != ''){			
			$a1 = Sql::query($this->server,'Simpac',"sp_bloqueiofinanceiro_list_cpf '$nrcpf'");
			if(sqlsrv_num_rows($a1) == 0){
				Sql::query($this->server,'Simpac',"sp_bloqueiofinanceiro_insert_cpf '$nrcpf',$idusuario,$inbloqueio");
				Sql::query($this->server,'Simpac',"sp_bloqueiofinanceiro_motivo_insert_cpf '$nrcpf',$inbloqueio,$motivo,$idusuario");		
			} else {
				Sql::query($this->server,'Simpac',"sp_bloqueiofinanceiro_update_cpf $inbloqueio,".$_SESSION['idusuario'].",'$nrcpf'");
			}
			$acaoCPF = ($inbloqueio == 1)?"Bloqueio":"Desbloqueio";	
			acao("$acaoCPF do CPF: $nrcpf");
		}
	}
	
	public function getAlunosByCPF($cpf){
	
		return Sql::arrays($this->server,"Simpac","sp_AlunoCPF '$cpf'");
	
	}
	
	public function getAlunoByRG($rg){
	
		return Sql::arrays($this->server,"Simpac","sp_AlunoRG '$rg'");
	
	}
	
	public function getAlunosByCNPJ($cnpj){
		
		return Sql::arrays($this->server,"Simpac","sp_InscreverJuridica '$cnpj'");

	}
	
	public function isPNE($cpf){
	
		return Sql::arrays($this->server,"Simpac","sp_localizaPNE '$cpf'");
	
	}
	
	public function isReposicao($idaluno,$idcursoagendado){
	
		return Sql::arrays($this->server,"Simpac","sp_AlunoAgendado $idaluno, $idcursoagendado");
		
	}
	
	public function inFuturoTrabalho($idaluno){
	
		return Sql::arrays($this->server,"Simpac","sp_FuturoTrabalhoBusca $idaluno");
	
	}
	
	public function getDadosAlunoInscrito($idaluno, $matricula){
	
		return Sql::arrays($this->server,"Simpac","sp_dadosAlunoInscrito_get $idaluno, '$matricula'");
		
	}
	
	public function add($idaluno, $nmaluno, $dtnascimento, $rg, $cpf, $endereco, $bairro, $cidade, $estado, $cep, $email, $emailempresa, $residencial, $comercial, $celular, $sexo, $endereco, $tipoendereco, $num, $complemento){
	
		return Sql::query($this->server,"Simpac","sp_AlunoSalva $idaluno, '$nmaluno', '$dtnascimento', '$rg', '$cpf', '$endereco', '$bairro', '$cidade', '$estado', '$cep', '$email', '$emailempresa', '$residencial', '$comercial', '$celular', '$sexo', '$endereco', '$tipoendereco', '$num', '$complemento'");
		
	}
	
	public function update($idaluno, $nmaluno, $dtnascimento, $rg, $cpf, $endereco, $bairro, $cidade, $estado, $cep, $email, $emailempresa, $residencial, $comercial, $celular, $sexo, $endereco, $tipoendereco, $num, $complemento){
	
		return Sql::query($this->server,"Simpac","sp_AlunoEdita $idaluno, '$nmaluno', '$dtnascimento', '$rg', '$cpf', '$endereco', '$bairro', '$cidade', '$estado', '$cep',  '$email', '$emailempresa', '$residencial', '$comercial', '$celular', '$sexo', '$endereco', '$tipoendereco', '$num', '$complemento'");
		
	}
	
	public function addPNE($cpf, $telefone, $visual, $fala, $fisico, $mental, $auditivo, $descricao){
	
		return Sql::query("Saturn","Impacta4","spSalvaPNE2 '$cpf', '$telefone', $visual, $fala, $fisico, $mental, $auditivo, '$descricao'");
	
	}
	
	public function isBlockBySAC($cpf){
	
		return Sql::arrays($this->server,"Simpac","sp_AlunoProblemaCPF '$cpf'");
	
	}
	
	public function isBlockByFinanceiro($cpf){
	
		return Sql::arrays($this->server,"Simpac","sp_AlunoBloqueioFinanceiro '$cpf'");
		
	}
}
?>