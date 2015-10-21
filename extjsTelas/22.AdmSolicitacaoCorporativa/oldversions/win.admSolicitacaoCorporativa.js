//Desabilita o link do LinkPermissao
LinkPermissao.aluno.html = '<span class="linkpermissao"><a href="#" title="{desaluno}"><img title="{desaluno}" src="/simpacweb/images/ico/16/aluno.png">{desaluno}</a></span>';
LinkPermissao.cursoagendado.html = '<span class="linkpermissao"><a href="#" title="{descurso}"><img title="{descurso}" src="/simpacweb/images/ico/16/turma.png">{descurso}</a></span>';

//GLOBALS
var PATH = "/simpacweb/modulos/corporativo/admSolicitacaoCorporativa"; //PRODUÇÃO
//var PATH = "/simpacweb/labs/Massaharu/extjsTelas/22.AdmSolicitacaoCorporativa"; //TESTE
var xt = Ext.getCmp;
var ms = Ext.MessageBox;

var arrObjAlunoAlterado = [];

var MATRICULA = "";
var ISEMPRESA = false;

//var INALUNODESAGENDADO = false;
//var INCADIMPACTAONLINE = false;
//var INTREINAMENTOREPOSICAO = false;
//var INTREINAMENTOREAGENDADO = false;

var today = new Date();
var firstday = new Date(today.getFullYear(), today.getMonth(), 1);
var lastday = new Date(today.getFullYear(), today.getMonth() + 1, 0);

var pendenteCount = 0;
var finalizadoCount = 0;

//////// CLASSES ////////////////////////////////
var Class_Solicitacao = function(args){
	
	var Treinamento;
	var Aluno;
	var Nfalterado;
	var matricula;
	var status;
	
	var construct = function(){
		Treinamento = args.Treinamento;
		Aluno		= args.Aluno;
		Nfalterado	= args.Nfalterado;
		matricula	= args.matricula;
		status		= args.status;
	}
	
	this.getInstancia = function(){
		return {
			Treinamento	: Treinamento,
			Aluno		: Aluno,
			Nfalterado 	: Nfalterado,
			matricula 	: matricula,
			status		: status
		}
	}
	
	this.eraseInstancia = function(){
		Treinamento = "";
		Aluno		= "";
		Nfalterado	= "";
		matricula	= "";
		status		= "";
	}
	
	if(typeof(args) != "undefined") construct();
}

var Class_Aluno = function(){
	var idaluno;
	var idalunoagendado;
	var desaluno;
	var cdemail;
	var desbairro;
	var descidade;
	var desendereco;
	var nrrg;
	var nrcpf;
	var dtnascimento;
	var modifiedfield;
	var cdemailempresa;
	var sgestado;
	var complemento;
	var num;
	var dessexo;
	var tipoendereco;
	var nrcelular;
	var nrtelefonecomercial;
	var nrtelefoneresidencial;
	var nrcep;
	var qtd_alunos;
	
	this.constructAlunoForm = function(){
		if(xt('winsolicitacaosecretariaeditaluno')){
			
			var $modifiedfield = "";
			var dtnascimento = $.trim(fn_getDateString(xt('idsolicitacaosecretariadtnascaluno').getValue()));
			
			if(this.getDesaluno() != xt('idsolicitacaosecretarianomealuno').getValue()){
				$modifiedfield+= "<b>Nome:</b> "+xt('idsolicitacaosecretarianomealuno').getValue()+"\n</br>";
			}					
			if(this.getCdemail() != xt('idsolicitacaosecretariaemailaluno').getValue()){
				$modifiedfield+= "<b>E-mail:</b> "+xt('idsolicitacaosecretariaemailaluno').getValue()+"\n</br>";
			}					
			if(this.getNrrg() != xt('idsolicitacaosecretariargaluno').getValue()){
				$modifiedfield+= "<b>RG:</b> "+xt('idsolicitacaosecretariargaluno').getValue()+"\n</br>";
			}					
			if(this.getNrcpf() != xt('idsolicitacaosecretariacpfaluno').getValue()){
				$modifiedfield+= "<b>CPF:</b> "+xt('idsolicitacaosecretariacpfaluno').getValue()+"\n</br>";	
			}					
			if(this.getDesbairro() != xt('idsolicitacaosecretariabairroaluno').getValue()){
				$modifiedfield+= "<b>Bairro:</b> "+xt('idsolicitacaosecretariabairroaluno').getValue()+"\n</br>";	
			}					
			if(this.getDescidade() != xt('idsolicitacaosecretariacidadealuno').getValue()){
				$modifiedfield+= "<b>Cidade:</b> "+xt('idsolicitacaosecretariacidadealuno').getValue()+"\n</br>";	
			}					
			if(this.getDesendereco() != xt('idsolicitacaosecretariaenderecoaluno').getValue()){
				$modifiedfield+= "<b>Endereco:</b> "+xt('idsolicitacaosecretariaenderecoaluno').getValue()+"\n</br>";	
			}	
			if(this.getCdemailempresa() != xt('idsolicitacaosecretariaeemailempresaaluno').getValue()){
				$modifiedfield+= "<b>Email empresa:</b> "+xt('idsolicitacaosecretariaeemailempresaaluno').getValue()+"\n</br>";	
			}
			if(this.getSgestado() != xt('idsolicitacaosecretariaufaluno').getValue()){
				$modifiedfield+= "<b>UF:</b> "+xt('idsolicitacaosecretariaufaluno').getValue()+"\n</br>";	
			}
			if(this.getComplemento() != xt('idsolicitacaosecretariacompaluno').getValue()){
				$modifiedfield+= "<b>Complemento:</b> "+xt('idsolicitacaosecretariacompaluno').getValue()+"\n</br>";	
			}
			if(this.getNum() != xt('idsolicitacaosecretarianaluno').getValue()){
				$modifiedfield+= "<b>Nº:</b> "+xt('idsolicitacaosecretarianaluno').getValue()+"\n</br>";	
			}
			if(this.getDessexo() != xt('idsolicitacaosecretariasexoaluno').getValue()){
				$modifiedfield+= "<b>Sexo:</b> "+xt('idsolicitacaosecretariasexoaluno').getValue()+"\n</br>";	
			}
			if(this.getTipoendereco() != xt('idsolicitacaosecretarialogradouroaluno').getValue()){
				$modifiedfield+= "<b>Logradouro:</b> "+xt('idsolicitacaosecretarialogradouroaluno').getValue()+"\n</br>";	
			}
			if(this.getNrcelular() != xt('idsolicitacaosecretariacelularaluno').getValue()){
				$modifiedfield+= "<b>Celular:</b> "+xt('idsolicitacaosecretariacelularaluno').getValue()+"\n</br>";	
			}
			if(this.getNrtelefonecomercial() != xt('idsolicitacaosecretariatelcomercialaluno').getValue()){
				$modifiedfield+= "<b>Tel. Comercial:</b> "+xt('idsolicitacaosecretariatelcomercialaluno').getValue()+"\n</br>";	
			}
			if(this.getNrtelefoneresidencial() != xt('idsolicitacaosecretariatelresidencialaluno').getValue()){
				$modifiedfield+= "<b>Tel. Residencial:</b> "+xt('idsolicitacaosecretariatelresidencialaluno').getValue()+"\n</br>";	
			}	
			if(this.getNrcep() != xt('idsolicitacaosecretariacepaluno').getValue()){
				$modifiedfield+= "<b>CEP:</b> "+xt('idsolicitacaosecretariacepaluno').getValue()+"\n</br>";	
			}				
			if(this.getDtnascimento() != dtnascimento){
				$modifiedfield+= "<b>Data de Nascimento:</b> "+dtnascimento+"\n</br>";	
			}					
			
			this.setIdaluno(xt('idsolicitacaosecretariaidaluno').getValue());
			this.setDesaluno(xt('idsolicitacaosecretarianomealuno').getValue());
			this.setCdemail(xt('idsolicitacaosecretariaemailaluno').getValue());
			this.setNrrg(xt('idsolicitacaosecretariargaluno').getValue());
			this.setNrcpf(xt('idsolicitacaosecretariacpfaluno').getValue());
			this.setDesbairro(xt('idsolicitacaosecretariabairroaluno').getValue());
			this.setDescidade(xt('idsolicitacaosecretariacidadealuno').getValue());
			this.setDesendereco(xt('idsolicitacaosecretariaenderecoaluno').getValue());
			this.setDtnascimento(xt('idsolicitacaosecretariadtnascaluno').getValue());
			this.setCdemailempresa(xt('idsolicitacaosecretariaeemailempresaaluno').getValue());
			this.setSgestado(xt('idsolicitacaosecretariaufaluno').getValue());
			this.setComplemento(xt('idsolicitacaosecretariacompaluno').getValue());
			this.setNum(xt('idsolicitacaosecretarianaluno').getValue());
			this.setDessexo(xt('idsolicitacaosecretariasexoaluno').getValue());
			this.setTipoendereco(xt('idsolicitacaosecretarialogradouroaluno').getValue());
			this.setNrcelular(xt('idsolicitacaosecretariacelularaluno').getValue());
			this.setNrtelefonecomercial(xt('idsolicitacaosecretariatelcomercialaluno').getValue());
			this.setNrtelefoneresidencial(xt('idsolicitacaosecretariatelresidencialaluno').getValue());
			this.setNrcep(xt('idsolicitacaosecretariacepaluno').getValue());
				
			this.setModifiedfield($modifiedfield);
			
			return $modifiedfield;
		}
	}
	
	this.constructAlunoGrid = function($row){
		if($row){
			this.setIdaluno($row.get('idaluno'));
			this.setDesaluno($row.get('desaluno'));
			this.setCdemail($row.get('cdemail'));
			this.setNrcpf($row.get('nrcpf'));
			this.setNrrg($row.get('nrrg'));
			this.setDtnascimento($row.get('dtnascimento'));
			this.setDesendereco($row.get('desendereco'));
			this.setDesbairro($row.get('desbairro'));
			this.setDescidade($row.get('descidade'));
			this.setCdemailempresa($row.get('cdemailempresa'));
			this.setSgestado($row.get('sgestado'));
			this.setComplemento($row.get('complemento'));
			this.setNum($row.get('num'));
			this.setDessexo($row.get('dessexo'));
			this.setTipoendereco($row.get('tipoendereco'));
			this.setNrcelular($row.get('nrcelular'));
			this.setNrtelefonecomercial($row.get('nrtelefonecomercial'));
			this.setNrtelefoneresidencial($row.get('nrtelefoneresidencial'));
			this.setNrcep($row.get('nrcep'));
		}
	}
	
	this.getInstancia = function(){
		return {
			idaluno				: this.getIdaluno(),
			desaluno			: this.getDesaluno(),
			cdemail				: this.getCdemail(),
			desbairro			: this.getDesbairro(),
			descidade			: this.getDescidade(),
			desendereco			: this.getDesendereco(),
			nrrg				: this.getNrrg(),
			nrcpf				: this.getNrcpf(),
			dtnascimento		: this.getDtnascimento(),
			modifiedfield		: this.getModifiedfield(),
			cdemailempresa		: this.getCdemailempresa(),
			sgestado			: this.getSgestado(),
			complemento			: this.getComplemento(),
			num					: this.getNum(),
			dessexo				: this.getDessexo(),
			tipoendereco		: this.getTipoendereco(),
			nrcelular			: this.getNrcelular(),
			nrtelefonecomercial	: this.getNrtelefonecomercial(),
			nrtelefoneresidencial: this.getNrtelefoneresidencial(),
			nrcep				: this.getNrcep(),
			qtd_alunos			: this.getQtdalunos()
		}
	}
	
	this.loadFormFields = function(){
		xt('idsolicitacaosecretariaidaluno').setValue(this.getIdaluno());
		xt('idsolicitacaosecretarianomealuno').setValue(this.getDesaluno());
		xt('idsolicitacaosecretariaemailaluno').setValue(this.getCdemail());
		xt('idsolicitacaosecretariacpfaluno').setValue(this.getNrcpf());
		xt('idsolicitacaosecretariargaluno').setValue(this.getNrrg());
		xt('idsolicitacaosecretariadtnascaluno').setValue(this.getDtnascimento());
		xt('idsolicitacaosecretariaenderecoaluno').setValue(this.getDesendereco());
		xt('idsolicitacaosecretariabairroaluno').setValue(this.getDesbairro());
		xt('idsolicitacaosecretariacidadealuno').setValue(this.getDescidade());
		xt('idsolicitacaosecretariaeemailempresaaluno').setValue(this.getCdemailempresa());
		xt('idsolicitacaosecretariaufaluno').setValue(this.getSgestado());
		xt('idsolicitacaosecretariacompaluno').setValue(this.getComplemento());
		xt('idsolicitacaosecretarianaluno').setValue(this.getNum());
		xt('idsolicitacaosecretariasexoaluno').setValue(this.getDessexo());
		xt('idsolicitacaosecretarialogradouroaluno').setValue(this.getTipoendereco());
		xt('idsolicitacaosecretariacelularaluno').setValue(this.getNrcelular());
		xt('idsolicitacaosecretariatelcomercialaluno').setValue(this.getNrtelefonecomercial());
		xt('idsolicitacaosecretariatelresidencialaluno').setValue(this.getNrtelefoneresidencial());
		xt('idsolicitacaosecretariacepaluno').setValue(this.getNrcep());
	}
	
	this.destructAluno = function(){
		this.setIdaluno('');
		this.setDesaluno('');
		this.setCdemail('');
		this.setDesbairro('');
		this.setDescidade('');
		this.setDesendereco('');
		this.setNrrg('');
		this.setNrcpf('');
		this.setDtnascimento('');
		this.setModifiedfield('');
		this.setCdemailempresa('');
		this.setSgestado('');
		this.setComplemento('');
		this.setNum('');
		this.setDessexo('');
		this.setTipoendereco('');
		this.setNrcelular('');
		this.setNrtelefonecomercial('');
		this.setNrtelefoneresidencial('');
		this.setNrcep('');
		this.setQtdalunos('');
	}
	
	this.getIdaluno = function(){
		return idaluno;
	};
	this.setIdaluno = function($idaluno){
		idaluno = ($idaluno)? $.trim($idaluno) : ""; return this;
	}; 
	
	this.getDesaluno = function(){
		return desaluno;
	};
	this.setDesaluno = function($desaluno){
		desaluno = ($desaluno)? $.trim($desaluno) : ""; return this;
	};
	
	this.getCdemail = function(){
		return cdemail;
	};
	this.setCdemail = function($cdemail){
		cdemail = ($cdemail)? $.trim($cdemail) : ""; return this;
	};
	
	this.getDesbairro = function(){
		return desbairro;
	};
	this.setDesbairro = function($desbairro){
		desbairro = ($desbairro)? $.trim($desbairro) : ""; return this;
	};
	
	this.getDescidade = function(){
		return descidade;
	};
	this.setDescidade = function($descidade){
		descidade = ($descidade)? $.trim($descidade) : ""; return this;
	};
	
	this.getDesendereco = function(){
		return desendereco;
	};
	this.setDesendereco = function($desendereco){
		desendereco = ($desendereco)? $.trim($desendereco) : ""; return this;
	};
	
	this.getNrrg = function(){
		return nrrg;
	};
	this.setNrrg = function($nrrg){
		nrrg = ($nrrg)? $.trim($nrrg) : ""; return this;
	};
	
	this.getNrcpf = function(){
		return nrcpf;
	};			
	this.setNrcpf = function($nrcpf){
		nrcpf = ($nrcpf)? $.trim($nrcpf) : ""; return this;
	};
	
	this.getDtnascimento = function(){
		return dtnascimento;
	};
	this.setDtnascimento = function($dtnascimento){
		dtnascimento = ($dtnascimento)? $.trim(fn_getDateString($dtnascimento)) : ""; return this;
	};
	
	this.getModifiedfield = function(){
		return modifiedfield;
	};
	this.setModifiedfield = function($modifiedfield){
		modifiedfield = ($modifiedfield)? $modifiedfield : ""; return this;
	};
	
	this.getNrtelefoneresidencial = function(){
		return nrtelefoneresidencial;
	};
	this.setNrtelefoneresidencial = function($nrtelefoneresidencial){
		nrtelefoneresidencial = ($nrtelefoneresidencial)? $.trim($nrtelefoneresidencial) : ""; return this;
	}; 
	
	this.getNrtelefonecomercial = function(){
		return nrtelefonecomercial;
	};
	this.setNrtelefonecomercial = function($nrtelefonecomercial){
		nrtelefonecomercial = ($nrtelefonecomercial)? $.trim($nrtelefonecomercial) : ""; return this;

	}; 
	
	this.getNrcelular = function(){
		return nrcelular;
	};
	this.setNrcelular = function($nrcelular){
		nrcelular = ($nrcelular)? $.trim($nrcelular) : ""; return this;
	}; 
	
	this.getTipoendereco = function(){
		return tipoendereco;
	};
	this.setTipoendereco = function($tipoendereco){
		tipoendereco = ($tipoendereco)? $.trim($tipoendereco) : ""; return this;
	}; 
	
	this.getDessexo = function(){
		return dessexo;
	};
	this.setDessexo = function($dessexo){
		dessexo = ($dessexo)? $.trim($dessexo) : ""; return this;
	}; 
	
	this.getNum = function(){
		return num;
	};
	this.setNum = function($num){
		num = ($num)? $.trim($num) : ""; return this;
	}; 
	
	this.getComplemento = function(){
		return complemento;
	};
	this.setComplemento = function($complemento){
		complemento = ($complemento)? $.trim($complemento) : ""; return this;
	}; 
	
	this.getSgestado = function(){
		return sgestado;
	};
	this.setSgestado = function($sgestado){
		sgestado = ($sgestado)? $.trim($sgestado) : ""; return this;
	}; 
	
	this.getCdemailempresa = function(){
		return cdemailempresa;
	};
	this.setCdemailempresa = function($cdemailempresa){
		cdemailempresa = ($cdemailempresa)? $.trim($cdemailempresa) : ""; return this;
	}; 
	
	this.getNrcep = function(){
		return nrcep;
	};
	this.setNrcep = function($nrcep){
		nrcep = ($nrcep)? $.trim($nrcep) : ""; return this;
	}; 
	
	this.getQtdalunos = function(){
		return qtd_alunos;
	};
	this.setQtdalunos = function($qtd_alunos){
		qtd_alunos = ($qtd_alunos)? $.trim($qtd_alunos) : ""; return this;
	}; 
}

var Class_Treinamento = function(){
	var idcursoagendado;
	var idalunoagendado;
	var descurso;
	var desinstrutor;
	var dtinicio;
	var dttermino;
	var desperiodo;
	var solicitacaoTreinTipo;
	
	//será setado se for reagendamento ou reposicao
	var treinamento_atual;
	var treinamento_novo; 
	
	var motivoReagendamento; //será setado se for reagendamento
	var motivoDesagendamento; //será setado se for desagendamento
	var motivoReposicao; //será setado se for reposição
	
	var inCadImpactaOnline; //Será setado true se for uma inscrição de treinamento no impacta online
	var inAlunoDesagendado; //Será setado true se for um desagendamento
	var inTreinReposicao; //Será setado true se for uma reposição
	var inTreinReagendado; //Será setado true se for um reagendamento
	var inTreinTroca; //Será setado true se for uma troca de treinamento
	
	this.constructTreinamento = function($row){
		if($row){
			this.setIdcursoagendado($row.get('idcursoagendado'));
			this.setIdalunoagendado($row.get('idalunoagendado'));
			this.setDescurso($row.get('descurso'));
			this.setDesinstrutor($row.get('desinstrutor'));
			this.setDtinicio($row.get('dtinicio'));
			this.setDttermino($row.get('dttermino'));
			this.setDesperiodo($row.get('desperiodo'));
		}
	}
	
	this.destructTreinamento = function(){
		this.setIdcursoagendado('');
		this.setIdalunoagendado('');
		this.setDescurso('');
		this.setDesinstrutor('');
		this.setDtinicio('');
		this.setDttermino('');
		this.setDesperiodo('');
		this.setTreinamento_atual('');
		this.setTreinamento_novo('');
		this.setMotivoReagendamento('');
		this.setMotivoDesagendamento('');
		this.setMotivoReposicao('');
		this.setSolicitacaoTreinTipo('');
		this.setInCadImpactaOnline(false);
		this.setInAlunoDesagendado(false);
		this.setInTreinReposicao(false);
		this.setInTreinReagendado(false);
		this.setInTreinTroca(false);
	}
	
	this.getInstancia = function(){
		return {
			idcursoagendado			: this.getIdcursoagendado(),
			idalunoagendado			: this.getIdalunoagendado(),
			descurso				: this.getDescurso(),
			desinstrutor			: this.getDesinstrutor(),
			dtinicio				: (this.getDtinicio())? this.getDtinicio() : "",
			dttermino				: (this.getDttermino())? this.getDttermino() : "",
			desperiodo				: this.getDesperiodo(),
			treinamento_atual		: this.getTreinamento_atual(),
			treinamento_novo		: this.getTreinamento_novo(),
			motivoReagendamento		: this.getMotivoReagendamento(),
			motivoDesagendamento	: this.getMotivoDesagendamento(),
			motivoReposicao			: this.getMotivoReposicao(),
			solicitacaoTreinTipo	: this.getSolicitacaoTreinTipo(),
			inCadImpactaOnline		: this.getInCadImpactaOnline(),
			inalunoDesagendado		: this.getInAlunoDesagendado(),
			inTreinReposicao		: this.getInTreinReposicao(),
			inTreinReagendado		: this.getInTreinReagendado(),
			inTreinTroca			: this.getInTreinTroca()
		}
	}
	
	this.getIdcursoagendado = function(){
		return idcursoagendado;
	};
	this.setIdcursoagendado = function($idcursoagendado){
		idcursoagendado = $.trim($idcursoagendado); return this;
	};
	
	this.getIdalunoagendado = function(){
		return idalunoagendado;
	};
	this.setIdalunoagendado = function($idalunoagendado){
		idalunoagendado = $.trim($idalunoagendado); return this;
	};
	
	this.getDescurso = function(){
		return descurso;
	};
	this.setDescurso = function($descurso){
		descurso = $.trim($descurso); return this;
	};
	
	this.getDesinstrutor = function(){
		return desinstrutor;
	};
	this.setDesinstrutor = function($desinstrutor){
		desinstrutor = $.trim($desinstrutor); return this;
	};
	
	this.getDtinicio = function(){
		return dtinicio;
	};
	this.setDtinicio = function($dtinicio){
		
		dtinicio = ($dtinicio)? $.trim(fn_getDateString($dtinicio)) : ""; return this;
	};
	
	this.getDttermino = function(){
		return dttermino;
	};
	this.setDttermino = function($dttermino){
		dttermino = ($dttermino)? $.trim(fn_getDateString($dttermino)) : ""; return this;
	};
	
	this.getDesperiodo = function(){
		return desperiodo;
	};
	this.setDesperiodo = function($desperiodo){
		desperiodo = $.trim($desperiodo); return this;
	};
	
	this.getTreinamento_atual = function(){
		return treinamento_atual;
	};
	this.setTreinamento_atual = function($treinamento_atual){
		treinamento_atual = $treinamento_atual; return this;
	};
	
	this.getTreinamento_novo = function(){
		return treinamento_novo;
	};
	this.setTreinamento_novo = function($treinamento_novo){
		treinamento_novo = $treinamento_novo; return this;
	};
	
	this.getMotivoReagendamento = function(){
		return motivoReagendamento;
	};
	this.setMotivoReagendamento = function($motivoReagendamento){
		motivoReagendamento = $.trim($motivoReagendamento); return this;
	};
	
	this.getMotivoDesagendamento = function(){
		return motivoDesagendamento;
	};
	this.setMotivoDesagendamento = function($motivoDesagendamento){
		motivoDesagendamento = $.trim($motivoDesagendamento); return this;
	};
	
	this.getMotivoReposicao = function(){
		return motivoReposicao;
	};
	this.setMotivoReposicao = function($motivoReposicao){
		motivoReposicao = $.trim($motivoReposicao); return this;
	};
	
	this.getInCadImpactaOnline = function(){
		return inCadImpactaOnline;
	};
	this.setInCadImpactaOnline = function($inCadImpactaOnline){
		inCadImpactaOnline = $.trim($inCadImpactaOnline); return this;
	};
	
	this.getInAlunoDesagendado = function(){
		return inAlunoDesagendado;
	};
	this.setInAlunoDesagendado = function($inAlunoDesagendado){
		inAlunoDesagendado = $.trim($inAlunoDesagendado); return this;
	};
	
	this.getInTreinReposicao = function(){
		return inTreinReposicao;
	};
	this.setInTreinReposicao = function($inTreinReposicao){
		inTreinReposicao = $.trim($inTreinReposicao); return this;
	};
	
	this.getInTreinReagendado = function(){
		return inTreinReagendado;
	};
	this.setInTreinReagendado = function($inTreinReagendado){
		inTreinReagendado = $.trim($inTreinReagendado); return this;
	};
	
	this.getInTreinTroca = function(){
		return inTreinTroca;
	};
	this.setInTreinTroca = function($inTreinTroca){
		inInTreinTroca = $.trim($inTreinTroca); return this;
	};
	
	this.getSolicitacaoTreinTipo = function(){
		return solicitacaoTreinTipo;
	};
	this.setSolicitacaoTreinTipo = function($solicitacaoTreinTipo){
		solicitacaoTreinTipo = $.trim($solicitacaoTreinTipo); 
		
		if(solicitacaoTreinTipo == "cadimpactaonline"){
			
			this.setInCadImpactaOnline(true);
			this.setInAlunoDesagendado(false);
			this.setInTreinReposicao(false);
			this.setInTreinReagendado(false);
			this.setInTreinTroca(false);
			
		}else if(solicitacaoTreinTipo == "desagendamento"){
			
			this.setInCadImpactaOnline(false);
			this.setInAlunoDesagendado(true);
			this.setInTreinReposicao(false);
			this.setInTreinReagendado(false);
			this.setInTreinTroca(false);
			
		}else if(solicitacaoTreinTipo == "reposicao"){
			
			this.setInCadImpactaOnline(false);
			this.setInAlunoDesagendado(false);
			this.setInTreinReposicao(true);
			this.setInTreinReagendado(false);
			this.setInTreinTroca(false);
			
		}else if(solicitacaoTreinTipo == "reagendamento"){
			
			this.setInCadImpactaOnline(false);
			this.setInAlunoDesagendado(false);
			this.setInTreinReposicao(false);
			this.setInTreinReagendado(true);
			this.setInTreinTroca(false);
			
		}else if(solicitacaoTreinTipo == "troca"){
			
			this.setInCadImpactaOnline(false);
			this.setInAlunoDesagendado(false);
			this.setInTreinReposicao(false);
			this.setInTreinReagendado(false);
			this.setInTreinTroca(true);
			
		}else{
			
			this.setInCadImpactaOnline(false);
			this.setInAlunoDesagendado(false);
			this.setInTreinReposicao(false);
			this.setInTreinReagendado(false);
			this.setInTreinTroca(false);
		}
		
		return this;
	};
	
	this.setMotivo = function($motivo){
		
		var $motivotipo = this.getSolicitacaoTreinTipo();
	
		if($.trim($motivotipo).toLowerCase() == "desagendamento"){
			this.setMotivoDesagendamento($motivo); return this;
			
		}else if($.trim($motivotipo).toLowerCase() == "reposicao"){
			this.setMotivoReposicao($motivo); return this;
			
		}else if($.trim($motivotipo).toLowerCase() == "reagendamento"){
			this.setMotivoReagendamento($motivo); return this;
			
		}else{
			alert("ERRO!\r\nTipo de motivo desconhecido pelo sistema."); return false;				
		}
	}
	this.getMotivo = function($motivo){
		
		var $motivotipo = this.getSolicitacaoTreinTipo();
	
		if($.trim($motivotipo).toLowerCase() == "desagendamento"){
			return this.getMotivoDesagendamento();
			
		}else if($.trim($motivotipo).toLowerCase() == "reposicao"){
			return this.getMotivoReposicao();
			
		}else if($.trim($motivotipo).toLowerCase() == "reagendamento"){
			return this.getMotivoReagendamento();
			
		}else{
			alert("ERRO!\r\nTipo de motivo desconhecido pelo sistema."); return false;				
		}
	}
}

var Class_AlterarNF = function(){
	var nf_bairro;
	var nf_bairro2;
	var nf_ccm;
	var nf_cep;
	var nf_cep2;
	var nf_cidade;
	var nf_cidade2;
	var nf_combo;
	var nf_comboUF;
	var nf_comboUF2;
	var nf_complemento
	var nf_contato;
	var nf_email;
	var nf_email2;
	var nf_endereco;
	var nf_endereco2;
	var nf_fax;
	var nf_numero;
	var nf_obs;
	var nf_referencia;
	var nf_telefone;
	var nf_tipo_endereco;
	var modifiedfield;
	
	this.constructAlterarNF = function(args){
		nf_ccm = xt('alterarNF_nf_ccm').getValue();
		nf_combo = xt('alterarNF_nf_combo').getValue();
		nf_tipo_endereco = xt('alterarNF_nf_tipo_endereco').getValue();
		nf_endereco = xt('alterarNF_nf_endereco').getValue();
		nf_numero = xt('alterarNF_nf_numero').getValue();
		nf_complemento = xt('alterarNF_nf_complemento').getValue();
		nf_cep = xt('alterarNF_nf_cep').getValue();
		nf_bairro = xt('alterarNF_nf_bairro').getValue();
		nf_cidade = xt('alterarNF_nf_cidade').getValue();
		nf_comboUF = xt('alterarNF_nf_comboUF').getValue();
		nf_email = xt('alterarNF_nf_email').getValue();
		nf_referencia = xt('alterarNF_nf_referencia').getValue();
		nf_obs = xt('alterarNF_nf_obs').getValue();
		nf_contato = xt('alterarNF_nf_contato').getValue();
		nf_telefone = xt('alterarNF_nf_telefone').getValue();
		nf_fax = xt('alterarNF_nf_fax').getValue();
		nf_email2 = xt('alterarNF_nf_email2').getValue();
		nf_endereco2 = xt('alterarNF_nf_endereco2').getValue();
		nf_bairro2 = xt('alterarNF_nf_bairro2').getValue();
		nf_cep2 = xt('alterarNF_nf_cep2').getValue();
		nf_cidade2 = xt('alterarNF_nf_cidade2').getValue();
		nf_comboUF2 = xt('alterarNF_nf_comboUF2').getValue();
		
		if(typeof(args) !== "undefined"){
		
			if(typeof(args.callback) === "function"){
				args.callback();	
			}
		}
	};
	
	this.getModifiedfields = function(){
		var $modifiedfield = "";
		if(nf_ccm != xt('alterarNF_nf_ccm').getValue()){
			$modifiedfield+= "<b>CCM(Emissao):</b> "+xt('alterarNF_nf_ccm').getValue()+"\n</br>";
		}					
		if(nf_combo != xt('alterarNF_nf_combo').getValue()){
			$modifiedfield+= "<b>Combo(Emissao):</b> "+xt('alterarNF_nf_combo').getValue()+"\n</br>";
		}	
		if(nf_tipo_endereco != xt('alterarNF_nf_tipo_endereco').getValue()){
			$modifiedfield+= "<b>Tipo Endereço(Emissao):</b> "+xt('alterarNF_nf_tipo_endereco').getValue()+"\n</br>";
		}
		if(nf_endereco != xt('alterarNF_nf_endereco').getValue()){
			$modifiedfield+= "<b>Endereço(Emissao):</b> "+xt('alterarNF_nf_endereco').getValue()+"\n</br>";
		}
		if(nf_numero != xt('alterarNF_nf_numero').getValue()){
			$modifiedfield+= "<b>Numero(Emissao):</b> "+xt('alterarNF_nf_numero').getValue()+"\n</br>";
		}
		if(nf_complemento != xt('alterarNF_nf_complemento').getValue()){
			$modifiedfield+= "<b>Complemento(Emissao):</b> "+xt('alterarNF_nf_complemento').getValue()+"\n</br>";
		}
		if(nf_cep != xt('alterarNF_nf_cep').getValue()){
			$modifiedfield+= "<b>CEP(Emissao):</b> "+xt('alterarNF_nf_cep').getValue()+"\n</br>";
		}
		if(nf_bairro != xt('alterarNF_nf_bairro').getValue()){
			$modifiedfield+= "<b>Bairro(Emissao):</b> "+xt('alterarNF_nf_bairro').getValue()+"\n</br>";
		}
		if(nf_cidade!= xt('alterarNF_nf_cidade').getValue()){
			$modifiedfield+= "<b>Cidade(Emissao):</b> "+xt('alterarNF_nf_cidade').getValue()+"\n</br>";
		}
		if(nf_comboUF != xt('alterarNF_nf_comboUF').getValue()){
			$modifiedfield+= "<b>UF(Emissao):</b> "+xt('alterarNF_nf_comboUF').getValue()+"\n</br>";
		}
		if(nf_email != xt('alterarNF_nf_email').getValue()){
			$modifiedfield+= "<b>Email(Emissao):</b> "+xt('alterarNF_nf_email').getValue()+"\n</br>";
		}
		if(nf_referencia != xt('alterarNF_nf_referencia').getValue()){
			$modifiedfield+= "<b>Referencia(Emissao):</b> "+xt('alterarNF_nf_referencia').getValue()+"\n</br>";
		}
		if(nf_obs != xt('alterarNF_nf_obs').getValue()){
			$modifiedfield+= "<b>Obs(Emissao):</b> "+xt('alterarNF_nf_obs').getValue()+"\n</br>";
		}
		if(nf_contato != xt('alterarNF_nf_contato').getValue()){
			$modifiedfield+= "<b>Contato(Entrega):</b> "+xt('alterarNF_nf_contato').getValue()+"\n</br>";
		}
		if(nf_telefone != xt('alterarNF_nf_telefone').getValue()){
			$modifiedfield+= "<b>Telefone(Entrega):</b> "+xt('alterarNF_nf_telefone').getValue()+"\n</br>";
		}
		if(nf_fax != xt('alterarNF_nf_fax').getValue()){
			$modifiedfield+= "<b>Fax(Entrega):</b> "+xt('alterarNF_nf_fax').getValue()+"\n</br>";
		}
		if(nf_email2 != xt('alterarNF_nf_email2').getValue()){
			$modifiedfield+= "<b>Email(Entrega):</b> "+xt('alterarNF_nf_email2').getValue()+"\n</br>";
		}
		if(nf_endereco2 != xt('alterarNF_nf_endereco2').getValue()){
			$modifiedfield+= "<b>Enderco(Entrega):</b> "+xt('alterarNF_nf_endereco2').getValue()+"\n</br>";
		}
		if(nf_bairro2 != xt('alterarNF_nf_bairro2').getValue()){
			$modifiedfield+= "<b>Bairro(Entrega):</b> "+xt('alterarNF_nf_bairro2').getValue()+"\n</br>";
		}
		if(nf_cep2 != xt('alterarNF_nf_cep2').getValue()){
			$modifiedfield+= "<b>CEP(Entrega):</b> "+xt('alterarNF_nf_cep2').getValue()+"\n</br>";
		}
		if(nf_cidade2 != xt('alterarNF_nf_cidade2').getValue()){
			$modifiedfield+= "<b>Cidade(Entrega):</b> "+xt('alterarNF_nf_cidade2').getValue()+"\n</br>";
		}
		if(nf_comboUF2 != xt('alterarNF_nf_comboUF2').getValue()){
			$modifiedfield+= "<b>UF(Entrega):</b> "+xt('alterarNF_nf_comboUF2').getValue()+"\n</br>";
		}
		
		modifiedfield = $modifiedfield;
		
		return $modifiedfield;
	}
	
	this.getInstancia = function(){
		return {
			nf_bairro 			: nf_bairro,
			nf_bairro2 			: nf_bairro2,
			nf_ccm 				: nf_ccm,
			nf_cep 				: nf_cep,
			nf_cep2 			: nf_cep2,
			nf_cidade 			: nf_cidade,
			nf_cidade2 			: nf_cidade2,
			nf_combo 			: nf_combo,
			nf_comboUF 			: nf_comboUF,
			nf_comboUF2 		: nf_comboUF2,
			nf_complemento 		: nf_complemento,
			nf_contato 			: nf_contato,
			nf_email 			: nf_email,
			nf_email2 			: nf_email2,
			nf_endereco 		: nf_endereco,
			nf_endereco2 		: nf_endereco2,
			nf_fax 				: nf_fax,
			nf_numero 			: nf_numero,
			nf_obs 				: nf_obs,
			nf_referencia 		: nf_referencia,
			nf_telefone 		: nf_telefone,
			nf_tipo_endereco 	: nf_tipo_endereco,
			modifiedfield 		: modifiedfield
		}
	};
	
	this.destructAlterarNF = function(){
		nf_bairro = "";
		nf_bairro2 = "";
		nf_ccm = "";
		nf_cep = "";
		nf_cep2 = "";
		nf_cidade = "";
		nf_cidade2 = "";
		nf_combo = "";
		nf_comboUF = "";
		nf_comboUF2 = "";
		nf_complemento = "";
		nf_contato = "";
		nf_email = "";
		nf_email2 = "";
		nf_endereco = "";
		nf_endereco2 = "";
		nf_fax = "";
		nf_numero = "";
		nf_obs = "";
		nf_referencia = "";
		nf_telefone = "";
		nf_tipo_endereco = "";
		modifiedfield = "";
	};
	
	this.getModifiedField = function(){
		return modifiedfield;
	}
}
////////////// INSTANCIA GLOBAL DAS CLASSES /////////////////////////////////////

var Aluno = new Class_Aluno();
var Treinamento = new Class_Treinamento();
var AlterarNF = new Class_AlterarNF();

//////////////// STORES //////////////////////////
var storealunomatricula = new Ext.data.JsonStore({
	url:PATH+'/json/aluno_matricula_list.php',
	root:'myData',
	fields:[
		{name:'idaluno', type: 'int'},
		{name:'desaluno'},
		{name:'cdemail'},
		{name:'desbairro'},
		{name:'descidade'},
		{name:'desendereco'},
		{name:'nrrg'},
		{name:'nrcpf'},
		{name:'sgestado'},
		{name:'complemento'},
		{name:'num'},
		{name:'dessexo'},
		{name:'tipoendereco'},
		{name:'nrcelular'},
		{name:'nrtelefonecomercial'},
		{name:'nrtelefoneresidencial'},
		{name:'cdemailempresa'},
		{name:'nrcep'},
		{name:'dtnascimento', type:'date', dateFormat:'timestamp'},
		{name:'isempresa', type:'bit'}
	]
});

var storetreinamentomatricula = new Ext.data.JsonStore({
	url:PATH+'/json/treinamento_matricula_list.php',
	root:'myData',
	fields:[
		{name:'idcursoagendado', type: 'int'},
		{name:'idalunoagendado', type: 'int'},
		{name:'descurso'},
		{name:'idcurso', type: 'int'},
		{name:'dtinicio', type: 'date', dateFormat: 'timestamp'},
		{name:'dttermino', type: 'date', dateFormat: 'timestamp'},
		{name:'desperiodo'},
		{name:'descomentario'},
		{name:'desinstrutor'}
	]
});

var storereagendamentotreinamentomatricula = new Ext.data.JsonStore({
	url:PATH+'/json/reagendamento_cursodatas_list.php',
	root:'myData',
	fields:[
		{name:'idcursoagendado', type: 'int'},
		{name:'descurso'},
		{name:'desinstrutor'},
		{name:'nrcargahoraria'},
		{name:'idcurso', type: 'int'},
		{name:'dtinicio', type: 'date', dateFormat: 'timestamp'},
		{name:'dttermino', type: 'date', dateFormat: 'timestamp'},
		{name:'desperiodo'},
		{name:'nrvagas', type:'int'},
		{name:'nrtotalalunos', type:'int'},
		{name:'inturmafechada', type:'bit'}
	]
});

var storesolicitacaocorporativa = new Ext.data.JsonStore({
	url:PATH+'/json/solicitacaoCorporativa_list.php',
	root:'myData',
	baseParams:{
		dtinicio:fn_getDateString2(firstday),
		dtfinal:fn_getDateString2(today)
	},
	fields:[
		{name:'idsolicitacaocorp', type:'int'}, 
		{name:'matricula'}, 
		{name:'idsolicitante', type:'int'}, 
		{name:'dessolicitante'}, 
		{name:'idsolicitado', type:'int'}, 
		{name:'dessolicitado'}, 
		{name:'idalunoagendado', type:'int'}, 
		{name:'inalunoalterado', type:'bit'}, 
		{name:'incertificado', type:'bit'}, 
		{name:'inlistapresenca', type:'bit'}, 
		{name:'innfalterado', type:'bit'}, 
		{name:'intreinamentoalterado', type:'bit'}, 
		{name:'inalunodesmembrado', type:'bit'}, 
		{name:'inalunodesagendado', type:'bit'}, 
		{name:'incadimpactaonline', type:'bit'},
		{name:'intreinamentoreposicao', type:'bit'},
		{name:'instatus', type:'bit'}, 
		{name:'dtalteracao', type:'date', dateFormat:'timestamp'}, 
		{name:'dtcadastro', type:'date', dateFormat:'timestamp'}
	],
	autoLoad:true
});

var storesolicitacaocorporativafinalizadoscount = new Ext.data.JsonStore({
	url:PATH+'/json/solicitanteAprovadosPendentesCount_get.php',
	root:'myData',
	fields:[
		{name:'finalizado', type:'int'},
		{name:'instatus', type:'bit'}
	]
});

var storematriculas = new Ext.data.JsonStore({
	url:PATH+'/json/matriculabynome.php',
	root:'myData',
	fields:[
		{name:'matricula'}
	]
});

var combobox = Miku.store({
	url:'/simpacweb/modulos/secretaria/FichaMatricula/nf_combo.php',
	fields:[{name:'Text',	type:'int'}
		   ,{name:'Id',		type:'itn'}]
});

//////////////////////// MY FUNCTIONS ///////////////////////////////////////////////
function fn_ifDateIsNull(value){
	if(value){
		value = fn_getDateString(value);
		return value;
	}else{
		return 'Sem data';
	}
}

function fn_getHtmlDate(isInicioOrTermino, value){
	if(isInicioOrTermino.toLowerCase() === 'inicio'){
		return (value)? '<b>Início:</b> '+value : "";
	}else{
		return (value)? '<b>Término:</b> '+value : "";
	}
}

function fn_disableToggleButtons(){
	xt('idsolicitacaosecretarianrvagas').setValue('');
	xt('idsolicitacaosecretarianralunos').setValue('');
	
	var $btnemaberto = xt('idsolicitacaosecretariabtnemaberto');
	var $btncertificado = xt('idsolicitacaosecretariabtncertificado');
	var $btnpresenca = xt('idsolicitacaosecretariabtnpresenca');
	var $btndesagendamento = xt('idsolicitacaosecretariadesagendar');
	
	var $arr_btns = [$btnemaberto, $btncertificado, $btnpresenca, $btndesagendamento];
	
	$.each($arr_btns, function(){
		if(this.pressed){
			this.toggle();
		}
	});
}

function fn_btnEditAlunoShow(){
	var $gridalunomatricula = xt('idsolicitacaosecretariagridalunomatricula');
	
	if($gridalunomatricula.getSelectionModel().hasSelection()){
		xt('idsolicitacaosecretariaeditaluno').enable();
		(ISEMPRESA)? xt('idsolicitacaosecretariadesmembraraluno').enable() : xt('idsolicitacaosecretariadesmembraraluno').disable();
	}else{
		xt('idsolicitacaosecretariaeditaluno').disable();
		xt('idsolicitacaosecretariadesmembraraluno').disable();
	}
}

function fn_btnCertificadoPresencaShow(){
	var $gridalunomatricula = xt('idsolicitacaosecretariagridalunomatricula');
	var $gridtreinamentomatricula =  xt('idsolicitacaosecretariagridtreinamentomatricula');
	
	if($gridalunomatricula.getSelectionModel().hasSelection() && $gridtreinamentomatricula.getSelectionModel().hasSelection()){
		xt('idsolicitacaosecretariabtncertificado').enableToggle = true;
		xt('idsolicitacaosecretariabtncertificado').enable();
		xt('idsolicitacaosecretariabtnpresenca').enableToggle = true;
		xt('idsolicitacaosecretariabtnpresenca').enable();
		xt('idsolicitacaosecretariaimpactaonline').enable();
		xt('idsolicitacaosecretariadesagendar').enable();
	}else{
		xt('idsolicitacaosecretariabtncertificado').disable();
		xt('idsolicitacaosecretariabtnpresenca').disable();
		xt('idsolicitacaosecretariaimpactaonline').disable();
		xt('idsolicitacaosecretariadesagendar').disable();
	}
}

function showEditBtns($gridrow){
	
	if($gridrow){
		xt('idsolicitacaosecretariabtnexcluirsolicitacao').enable();
		//xt('idsolicitacaosecretariabtneditarsolicitacao').enable();
	}else{
		xt('idsolicitacaosecretariabtnexcluirsolicitacao').disable();
		//xt('idsolicitacaosecretariabtneditarsolicitacao').disable();
	}
}

function fn_reagendamentodatasLoad($inemaberto){
	var $rowData = xt('idsolicitacaosecretariagridtreinamentomatricula').getSelectionModel().getSelected();
	
	var mask = new Ext.LoadMask(xt('idsolicitacaosecretariagridreagendamentomatricula').body,{msg:'Aguarde...'});
	
	$inemaberto  = (xt('idsolicitacaosecretariabtnemaberto').pressed)? 1 : 0;
	
	var $titlepanelreagendamento = ($inemaberto)? "Reagendar para o Treinamento aberto: " : "Reagendar Treinamento para: ";
	xt('idsolicitacaosecretariagridreagendamentomatricula').setTitle($titlepanelreagendamento);			
	
	if($rowData){
		
		xt('idsolicitacaosecretariabtnemaberto').enable();
		mask.show();
		
		storereagendamentotreinamentomatricula.reload({
			params:{
				idcurso: $rowData.get('idcurso'),
				inemaberto: $inemaberto
			},
			callback:function(){
				mask.hide();
				xt('idsolicitacaosecretarianrvagas').setValue('');
				xt('idsolicitacaosecretarianralunos').setValue('');
			}
		});
	}else{
		xt('idsolicitacaosecretariabtnemaberto').disable();
	}
}

function fn_getDateString(data){ //Por parametro passa-se um objeto Data
	
	var dataRetorno;
	
	if($.trim(data)){
	
		if(data.getDate() < 10){
			dataRetorno = "0"+data.getDate()+"/".toString();
		}else{			
			dataRetorno = data.getDate()+"/".toString();
		}
		
		if(data.getMonth() < 9){
			dataRetorno+= "0"+(data.getMonth()+1)+"/".toString();
		}else{
			dataRetorno+= (data.getMonth()+1)+"/".toString();
		}
		
		dataRetorno+= data.getFullYear()+" ";
		
		return dataRetorno;
	}
}

function fn_getDateString2(data){
	
	var dataRetorno;
	
	if($.trim(data)){
		
		dataRetorno = data.getFullYear()+"-";
		
		if(data.getMonth() < 9){
			dataRetorno+= "0"+(data.getMonth()+1)+"-".toString();
		}else{
			dataRetorno+= (data.getMonth()+1)+"-".toString();
		}
		
		if(data.getDate() < 10){
			dataRetorno+= "0"+data.getDate().toString();
		}else{			
			dataRetorno+= data.getDate().toString();
		}
		
		return dataRetorno;
	}
}

function fn_getDateInt(data){
	
	var dataRetorno;
	
	if($.trim(data)){
		dataRetorno = data.getFullYear()+"";
		
		if(data.getMonth() < 9){
			dataRetorno+= "0"+(data.getMonth()+1).toString();
		}else{
			dataRetorno+= (data.getMonth()+1).toString();
		}
		
		if(data.getDate() < 10){
			dataRetorno+= "0"+data.getDate().toString();
		}else{			
			dataRetorno+= data.getDate().toString();
		}
		
		return parseInt(dataRetorno);
	}
}

function fn_resetObjAluno(){
	var $row = xt('idsolicitacaosecretariagridalunomatricula').getSelectionModel().getSelected();
	Aluno.constructAlunoGrid($row);
}

function fn_getStatusIcon(status){
	if(status){
		return '<img src="/simpacweb/images/ico/16/OK.png" title="Será emitido">';
	}else{
		return '<img src="/simpacweb/images/ico/16/Essen_consulting.png" title="Não será emitido">';
	}
}

function fn_resetAllData(){
	arrObjAlunoAlterado = [];
	Aluno.destructAluno();
	Treinamento.destructTreinamento();
	fn_disableAllComponents(); 
	AlterarNF.destructAlterarNF();
	
	/*INALUNODESAGENDADO = false;
	INCADIMPACTAONLINE = false;
	INTREINAMENTOREPOSICAO = false;
	INTREINAMENTOREAGENDADO = false;*/
}

function fn_disableAllComponents(){
	fn_disableToggleButtons();
	//fn_disableCheckeBoxes();
	fn_btnEditAlunoShow();
}

function fn_confirmMessage(){
	ms.info('Aviso!', 'Solicitação realizada com sucesso.',  function(){ 
		fn_disableAllComponents(); 
		AlterarNF.destructAlterarNF();
		Aluno.setModifiedfield('');
		Aluno.setQtdalunos('');
		Treinamento.setTreinamento_atual('');
		Treinamento.setTreinamento_novo('');
		Treinamento.setMotivoReagendamento('');
		Treinamento.setMotivoDesagendamento('');
		
		/*INALUNODESAGENDADO = false;
		INCADIMPACTAONLINE = false;
		INTREINAMENTOREPOSICAO = false;
		INTREINAMENTOREAGENDADO = false;*/
	});	
}

function fn_searchbymatricula(){
	var mask1 = new Ext.LoadMask(xt('idsolicitacaosecretariagridalunomatricula').body,{msg:'Aguarde...'});
	
	mask1.show();
	storealunomatricula.reload({
		params:{
			matricula: xt('idsolicitacaosecretariamatricula').getValue()
		},
		callback: function(a, b, c){
			
			xt('idsolicitacaosecretariatabpanel').setActiveTab(0);
			
			ISEMPRESA = false;
			
			$.each(a, function(){
				if(this.get('isempresa')) ISEMPRESA = true;					
			});
			
			if(ISEMPRESA){
				xt('idsolicitacaosecretariadesmembraraluno').enable();
				xt('idsolicitacaosecretariaalterarnf').enable();
			}else{
				xt('idsolicitacaosecretariaalterarnf').disable();
				xt('idsolicitacaosecretariadesmembraraluno').disable();
			}
			
			if(a.length){
				MATRICULA = b.params.matricula;
				mask1.hide();
				fn_resetAllData();
				fn_disableAllComponents();
			}else{
				MATRICULA = "";
				mask1.hide();
				fn_resetAllData();
				fn_disableAllComponents();
				ms.info('Aviso', 'Matricula não encontrada');
			}	
		}
	});
	
	storetreinamentomatricula.removeAll();
}

function fn_searchmatriculabynome($busca){
	new Ext.Window({
		title:"Selecione uma matrícula",
		id:"winsearchmatriculabynome",
		autoHeight:true,
		modal:true,
		width:200,
		items:[{
			xtype:'grid',
			id:'idsolicitacaosecretariagridmatriculasbynome',
			autoScroll:true,
			height:290,
			store:storematriculas,
			stripeRows: true,
			viewConfig:{
				forceFit:true
			},
			sm: new Ext.grid.RowSelectionModel({
				singleSelect: true,
			}),
			columns:[new Ext.grid.TemplateColumn({
				header:'Matricula',
				tpl:LinkPermissao.matricula,
				dataIndex:'matricula'
			}),{
				width:25,
				dataIndex:'matricula',
				renderer:function(v){
					return '<a class="setmatriculasearch" matricula="'+v+'"><img style="margin:0 5px;" src="/simpacweb/images/ico/16/Next.png"/></a>';
				}
			}],
			listeners:{
				'cellclick':function(grid, rowIndex, columnIndex){
					if(columnIndex == 1){
						$mygridrow = grid.getStore().getAt(rowIndex);
						
						xt('idsolicitacaosecretariamatricula').setValue($mygridrow.get('matricula'));
						
						fn_searchbymatricula();
						xt('winsearchmatriculabynome').close();
					}
				}
			}
		}],
		listeners:{
			'afterrender':function(){
				var mask = new Ext.LoadMask(xt('idsolicitacaosecretariagridmatriculasbynome').body,{msg:'Aguarde...'});
				mask.show();
				
				storematriculas.reload({
					params:{
						busca:$busca
					},
					callback:function(a, b, c){
						$('head').append("<style type='text/css'>.setmatriculasearch img{transition: all 0.5s; -webkit-transition: all 0.5s; } .setmatriculasearch img:hover{-webkit-transform: rotate(30deg); transform:rotate(30deg);}</style>");
						mask.hide();
					}
				});
			}
		}
	}).show();
}

function fn_reloadStoreArquivoRetornoByData(dtinicio, dtfinal){
	
	var mask = new Ext.LoadMask(xt('idsolicitacaosecretariavisualizar').body,{msg:'Aguarde...'});
	mask.show();
	
	storesolicitacaocorporativa.reload({
		params:{
			dtinicio:dtinicio,
			dtfinal:dtfinal
		},
		callback:function(resp){
			mask.hide();
		}
	});
}

function fn_getFinalizadosPendentesCount(){
	
	storesolicitacaocorporativafinalizadoscount.reload({
		callback:function(resp){
			$.each(resp, function(){
				
				if(this.get('instatus') == 1){
					var $descricao_1 = (this.get('finalizado') > 1)? "finalizados" : "finalizado";
					xt('iddfsolicitacaosecretariafinalizados').setValue('<span style="font-weight:bolder; font-size:20px; color:green;" alt="'+$descricao_1+'" title="Finalizados" >'+this.get('finalizado')+' </span> <b>'+$descricao_1+'</b>');
					
					if(finalizadoCount != this.get('finalizado')){
						fn_reloadStoreArquivoRetornoByData(
							fn_getDateString2(xt('idsolicitacaosecretariadata_inicio').getValue()), 
							fn_getDateString2(xt('idsolicitacaosecretariadata_final').getValue())
						);
					}
					
					finalizadoCount = this.get('finalizado');
				}
				
				if(this.get('instatus') == 0){
					var $descricao_2 = (this.get('finalizado') > 1)? "pendentes" : "pendente";
					
					xt('iddfsolicitacaosecretariapendente').setValue('<span style="font-weight:bolder; font-size:20px; color:red;" alt="'+$descricao_2+'" title="Pendentes" >'+this.get('finalizado')+' </span> <b>'+$descricao_2+'</b>');	
					
					if(pendenteCount != this.get('finalizado')){
						fn_reloadStoreArquivoRetornoByData(
							fn_getDateString2(xt('idsolicitacaosecretariadata_inicio').getValue()), 
							fn_getDateString2(xt('idsolicitacaosecretariadata_final').getValue())
						);
					}
					
					pendenteCount = this.get('finalizado');
				}
			});
			
		}
	});
}

function fn_status(v, metaData){
	if(v == 1){
		metaData.attr='ext:qtip="Solicitado"';
		return '<img src="/simpacweb/images/ico/16/accept.png"/>';
	}else{
		metaData.attr='ext:qtip="Não solicitado"';
		return '<img src="/simpacweb/images/ico/16/Essen_consulting.png"/>';
	}	
}

/////////////////////////////////////  MAIN WINDOW ////////////////////////////////////////////////////////////////////////////

var mainWin = new Ext.Window({
	title:'Adm. Solicitação Corporativa',
	id:'idsolicitacaosecretariamainwin',
	iconCls:'ico_file',
	width:Page.width-10,
	height:553,
	layout:'fit',
	listeners:{
		'afterrender':function(){
			$height = $(window).height() /2 ;
			$width = ($(window).width() / 2) - 75;
			
			$('body').append("<div id='myimageload' style='position:absolute; top: "+$height+"px; left:"+$width+"px;z-index:100'><img style='width:150px;height:30px' src='"+PATH+"/res/img/load.gif' /></div>");
			$('body').append("<div id='modal-load'></div>");
			$('#modal-load').css({position: 'fixed', height: '100%', width: '100%', background: 'rgba(0, 0, 0, 0.5)', 'z-index':'999999'});
			$('#myimageload img').hide();
			$('#modal-load').hide();
		}
	},
	tbar:[{
		text:'<b>Adicionar Solicitação<b>',
		id:'idsolicitacaosecretariabtnconfirmsolicitacao',
		style:'border: 1px solid #99bbe8; background-image: -webkit-linear-gradient(bottom, rgb(218,227,230) 35%, rgb(210,218,219) 68%, rgb(232,234,235) 84%);',
		scale:'medium',
		iconCls:'ico_plus3d',
		handler:function(){
			console.log('OBJ TREINAMENTO', Treinamento.getInstancia());
			//STATUS variables
			var $inlistapresenca = xt('idsolicitacaosecretariabtnpresenca').pressed;
			var $incertificado = xt('idsolicitacaosecretariabtncertificado').pressed;
			var $inalunoalterado = (Aluno.getModifiedfield())? true : false;
			var $innfalterado = (AlterarNF.getModifiedField())? true :  false;
			var $inalunodesmembrado = (Aluno.getQtdalunos())? true : false;
			var $inalunodesagendado = (Treinamento.getInAlunoDesagendado() == "true")? true : false;
			var $incadimpactaonline = (Treinamento.getInCadImpactaOnline() == "true")? true : false;
			var $intreinamentoalterado = ((Treinamento.getTreinamento_atual() && Treinamento.getTreinamento_novo()) && (Treinamento.getInTreinReagendado() == "true"))? true : false;
			var $intreinamentoreposicao = ((Treinamento.getTreinamento_atual() && Treinamento.getTreinamento_novo()) && Treinamento.getInTreinReposicao() == "true")? true : false;
			console.log({
				getInCadImpactaOnline : Treinamento.getInCadImpactaOnline(),
				getInAlunoDesagendado : Treinamento.getInAlunoDesagendado(),
				getInTreinReagendado : Treinamento.getInTreinReagendado(),
				getInTreinReposicao : Treinamento.getInTreinReposicao()
			});
			
			//GRID rows
			var $alunorows = xt('idsolicitacaosecretariagridalunomatricula').getSelectionModel().getSelections();
			var $cursoagendadorow = xt('idsolicitacaosecretariagridtreinamentomatricula').getSelectionModel().getSelected();
			
			var Solicitacao = new Class_Solicitacao({
				Treinamento 			: Treinamento.getInstancia(),
				Aluno					: Aluno.getInstancia(),
				Nfalterado 				: AlterarNF.getInstancia(),
				matricula 				: MATRICULA,
				status					: {
					inlistapresenca 		: $inlistapresenca,
					incertificado 			: $incertificado,
					intreinamentoalterado 	: $intreinamentoalterado,
					inalunoalterado 		: $inalunoalterado,
					innfalterado 			: $innfalterado,
					inalunodesmembrado 		: $inalunodesmembrado,
					inalunodesagendado 		: $inalunodesagendado,
					incadimpactaonline		: $incadimpactaonline,
					intreinamentoreposicao  : $intreinamentoreposicao
				}
			});
			
			console.log("ADICIONAR SOLICITAÇÃO", Solicitacao.getInstancia());
			
			//Alteração de dados do aluno
			if($inalunoalterado){
				arrObjAlunoAlterado.push(Solicitacao.getInstancia());
				
				fn_confirmMessage();
				
			//Alteração de dados da emissão de Nota Fiscal	
			}else if($innfalterado){
				arrObjAlunoAlterado.push(Solicitacao.getInstancia());
						
				fn_confirmMessage();
				
			//Desagendamento de alunos
			}else if(Treinamento.getInAlunoDesagendado() == "true"){
				arrObjAlunoAlterado.push(Solicitacao.getInstancia());
						
				fn_confirmMessage();
			
			//Cadastro no Impacta Online
			}else if(Treinamento.getInCadImpactaOnline() == "true"){
				arrObjAlunoAlterado.push(Solicitacao.getInstancia());
						
				fn_confirmMessage();
				
			//Reposição de treinamento
			}else if($intreinamentoreposicao && $cursoagendadorow){
				arrObjAlunoAlterado.push(Solicitacao.getInstancia());
						
				fn_confirmMessage();	
			
			//Reagendamento de treinamento
			}else if($intreinamentoalterado && $cursoagendadorow){
				arrObjAlunoAlterado.push(Solicitacao.getInstancia());
						
				fn_confirmMessage();	
				
			//Emissão de Lista de Presença/Certificado, Desmembramento de aluno
			}else if(($inlistapresenca || $incertificado || $inalunodesmembrado) && ($cursoagendadorow)){
					
				//Mais de um aluno a ser alterado de uma vez
				if($alunorows.length > 1){
					$.each($alunorows, function(){
						Aluno.constructAlunoGrid(this);
						
						arrObjAlunoAlterado.push(Solicitacao.getInstancia());
					});
					
					fn_confirmMessage();
				//Um aluno a ser alterado
				}else{
					
					arrObjAlunoAlterado.push(Solicitacao.getInstancia());
					
					fn_confirmMessage();
				}
			}else{
				ms.info('Aviso!', 'Nenhuma solicitação realizada.');	
			}
		}
	},'-',{
		text:'<b>Visualizar Andamento</b>',
		tooltip:'Visualizar o andamento da solicitação',
		id:'idsolicitacaosecretariabtnvisualizarandamento',
		style:'border: 1px solid #99bbe8; background-image: -webkit-linear-gradient(bottom, rgb(218,227,230) 35%, rgb(210,218,219) 68%, rgb(232,234,235) 84%);',
		scale:'medium',
		iconCls:'ico_monitor2',
		handler:function(){
			var $html = "";
			var $inmodifiedfields = false;
			var $inlistapresenca = false;
			var $incertificado = false;
			var $intreinamentoalterado = false;
			var $innfalterado = false;
			var $inalunodesmembrado = false;
			var $inalunodesagendado = false;
			var $incadimpactaonline = false;
			var $intreinamentoreposicao = false;
			
			console.log("VISUALIZAR ANDAMENTO", arrObjAlunoAlterado);
			
			//Verificação percorrendo as solicitações p/ ver se alguma alteração foi feita
			$.each(arrObjAlunoAlterado, function(){
				
				$inmodifiedfields 		= (this.Aluno.modifiedfield)? true : false;
				$inlistapresenca 		= (this.status.inlistapresenca)? true : false;
				$incertificado 			= (this.status.incertificado)? true : false;
				$intreinamentoalterado 	= (this.Treinamento.treinamento_atual && this.Treinamento.treinamento_novo)? true : false;
				$innfalterado 			= (this.status.innfalterado)? true : false;
				$inalunodesmembrado 	= (this.status.inalunodesmembrado)? true : false;
				$inalunodesagendado 	= (this.status.inalunodesagendado)? true : false;
				$incadimpactaonline		= (this.status.incadimpactaonline)? true : false;
				$intreinamentoreposicao	= (this.status.intreinamentoreposicao)? true : false;
			});
			
			if(!($inmodifiedfields || $inlistapresenca || $incertificado || $intreinamentoalterado || $innfalterado || $inalunodesagendado || $inalunodesmembrado || $incadimpactaonline || $intreinamentoreposicao)){
				ms.info('Aviso!', 'Nenhuma alteração foi feita.');
			}else{
				$.each(arrObjAlunoAlterado, function(){
					
					var $Treinamento = this.Treinamento;
					var $TreinamentoAtual = $Treinamento.treinamento_atual;
					var $TreinamentoNovo = $Treinamento.treinamento_novo;
					var $Nfalterado = this.Nfalterado;
					var $Aluno = this.Aluno;
					var $status = this.status;
					
					var $idcursoagendadoatual = $TreinamentoAtual.idcursoagendado;
					var $idcursoagendadoanovo = $TreinamentoNovo.idcursoagendado;
					
					var $motivoDesagendamento = ($Treinamento.motivoDesagendamento)? $Treinamento.motivoDesagendamento : "Sem motivo";
					var $motivoReagendamento = ($Treinamento.motivoReagendamento)? $Treinamento.motivoReagendamento : "Sem motivo";
					var $motivoReposicao = ($Treinamento.motivoReposicao)? $Treinamento.motivoReposicao : "Sem motivo";
					
					//Reagendamento de Treinamentos
					var $htmltreinamentoreagendado = (($idcursoagendadoatual && $idcursoagendadoanovo) && $status.intreinamentoalterado)? "<div><b style='display: block; margin: 0 auto; width: 200px;'>Reagendamento de treinamento: </b>" : "<div>";
					if(($TreinamentoAtual && $TreinamentoNovo) && $status.intreinamentoalterado){
						
						$htmltreinamentoreagendado+= '<div style="border-bottom:1px solid #99bbe8; ">';
						$htmltreinamentoreagendado+= '<div><b>De treinamento:</b> '+$TreinamentoAtual.descurso+' '+fn_getHtmlDate('inicio', $TreinamentoAtual.dtinicio)+' '+fn_getHtmlDate('termino', $TreinamentoAtual.dttermino)+'</div>';
						$htmltreinamentoreagendado+= '<div><b>Para treinamento:</b> '+$TreinamentoNovo.descurso+fn_getHtmlDate('inicio', $TreinamentoNovo.dtinicio)+' '+fn_getHtmlDate('termino', $TreinamentoNovo.dttermino)+'</div>';
						$htmltreinamentoreagendado+= '<div><b>Motivo do reagendamento: </b>'+$motivoReagendamento+'</div>';
						$htmltreinamentoreagendado+= '</div>';
					}
					$htmltreinamentoreagendado+='</div>';
					
					//Reposicao de Treinamento
					var $htmltreinamentoreposicao = (($idcursoagendadoatual && $idcursoagendadoanovo) && $status.intreinamentoreposicao)? "<div><b style='display: block; margin: 0 auto; width: 200px;'>Reposição de Treinamento: </b>" : "<div>";
					if(($TreinamentoAtual && $TreinamentoNovo) && $status.intreinamentoreposicao){
						
						$htmltreinamentoreposicao+= '<div style="border-bottom:1px solid #99bbe8; ">';
						$htmltreinamentoreposicao+= '<div><b>De treinamento:</b> '+$TreinamentoAtual.descurso+' '+fn_getHtmlDate('inicio', $TreinamentoAtual.dtinicio)+' '+fn_getHtmlDate('termino', $TreinamentoAtual.dttermino)+'</div>';
						$htmltreinamentoreposicao+= '<div><b>Para treinamento:</b> '+$TreinamentoNovo.descurso+fn_getHtmlDate('inicio', $TreinamentoNovo.dtinicio)+' '+fn_getHtmlDate('termino', $TreinamentoNovo.dttermino)+'</div>';
						$htmltreinamentoreposicao+= '<div><b>Motivo da reposição: </b>'+$motivoReposicao+'</div>';
						$htmltreinamentoreposicao+= '</div>';
					}
					$htmltreinamentoreposicao+='</div>';
					
					//Cadastrar Aluno Impacta Online
					var $htmlcadimpactaonline = ($status.incadimpactaonline)? "<div style='border-bottom:1px solid #99bbe8;'><b style='display: block; margin: 0 auto; width: 200px;'>Cadastro no Impacta Online: </b>" : "<div>";
					if($status.incadimpactaonline){
						$htmlcadimpactaonline += "<div><b>Aluno</b> : "+$Aluno.desaluno+"</div>";
						$htmlcadimpactaonline += "<div><b>CPF</b> : "+$Aluno.nrcpf+"</div>";
						
					}
					$htmlcadimpactaonline+= "</div>";
					
					//Desmembramento de Alunos
					var $htmlalunodesmembrado = ($.trim($Aluno.qtd_alunos) != "")? "<div style='border-bottom:1px solid #99bbe8;'><b style='display: block; margin: 0 auto; width: 200px;'>Desmembramento: </b>" : "<div>";
					if($.trim($Aluno.qtd_alunos) != "" && $status.inalunodesmembrado){
						$htmlalunodesmembrado += "<div><b>Aluno</b> : "+$Aluno.desaluno+"</div>";
						$htmlalunodesmembrado += "<div><b>Desmembrado para</b> : "+$Aluno.qtd_alunos+" Alunos</div>";
					}
					$htmlalunodesmembrado+= "</div>";
					
					//Alteração de NF
					var $htmlnfalterado = ($status.innfalterado)? "<div style='border-bottom:1px solid #99bbe8;'><b style='display: block; margin: 0 auto; width: 200px;'>Alteração de NF: </b>"+$Nfalterado.modifiedfield+"</div>" : "<div></div>";
					
					//Alteração de Aluno
					var $htmlalunoalterado = ($status.inalunoalterado)? "<div style='border-bottom:1px solid #99bbe8;'><b style='display: block; margin: 0 auto; width: 200px;'>Alteração de Cadastro do Aluno: </b>"+$Aluno.modifiedfield+"</div>" : "<div></div>";
					
					//Desagendar Aluno da turma
					var $htmlalunodesagendado = ($status.inalunodesagendado)? "<div style='border-bottom:1px solid #99bbe8;'><b style='display: block; margin: 0 auto; width: 200px;'>Desagendamento: </b>" : "<div>";
					if($status.inalunodesagendado){
						$htmlalunodesagendado += "<div><b>Aluno : </b>"+$Aluno.desaluno+"</div>";
						$htmlalunodesagendado += "<div><b>Treinamento: </b>"+$Treinamento.descurso+" "+fn_getHtmlDate('inicio', $Treinamento.dtinicio)+' '+fn_getHtmlDate('termino', $Treinamento.dttermino)+"</div>";
						$htmlalunodesagendado += "<div><b>Motivo: </b>"+$motivoDesagendamento+"</div>";
					}
					$htmlalunodesagendado+= "</div>";
			
					$html+= (
						'<div style="border-bottom:4px solid #99bbe8;padding:10px;">'+
							'<h1>Aluno: '+$Aluno.desaluno+' - matricula: '+this.matricula+'</h1>'+
							'<div style="border-top:1px solid #99bbe8; border-bottom:1px solid #99bbe8;">'+
								$htmlalunoalterado+
								$htmlnfalterado+
								$htmlalunodesmembrado+
								$htmlalunodesagendado+
								$htmlcadimpactaonline+
								$htmltreinamentoreposicao+
							'</div>'+
							$htmltreinamentoreagendado
					);
					
					//Emissão Certificado/Lista de Presença									
					if($status.incertificado || $status.inlistapresenca){
						$html+= (	
								'<div>'+	
									'<div>Certificado: '+fn_getStatusIcon($status.incertificado)+' '+$Treinamento.descurso+' '+fn_getHtmlDate('inicio', $Treinamento.dtinicio)+'  '+fn_getHtmlDate('termino', $Treinamento.dttermino)+'</div>'+
									'<div>Lista de Presença: '+fn_getStatusIcon($status.inlistapresenca)+' '+$Treinamento.descurso+' '+fn_getHtmlDate('inicio', $Treinamento.dtinicio)+'  '+fn_getHtmlDate('termino', $Treinamento.dttermino)+'</div>'+
								'</div>'
						);
					}
					
					$html+=(
						'</div>'
					)
				});
			
				if(xt('idwinvisualizarandamento')){
					xt('idwinvisualizarandamento').show();
				}else{
					var winvisualizarandamento = new Ext.Window({
						id:'idwinvisualizarandamento',
						title:'Andamento da solicitação',
						iconCls:'ico_monitor2',
						height:500,
						width:600,
						autoScroll:true,
						html:$html
					}).show();
				}
			}
		}
	},'-',{
		text:'<b>Refazer Solicitação</b>',
		tooltip:'Clique aqui para refazer a solicitação atual.',
		id:'idsolicitacaosecretariabtnrefazersolicitacao',
		style:'border: 1px solid #99bbe8; background-image: -webkit-linear-gradient(bottom, rgb(218,227,230) 35%, rgb(210,218,219) 68%, rgb(232,234,235) 84%);',
		scale:'medium',
		iconCls:'ico_Trash',
		handler:function(){
			ms.confirm('Confirmação', 'Tem certeza que deseja refazer essa solicitação?', function(btn){
				if(btn == "yes"){
					fn_searchbymatricula();
				}
			});
		}
	},'-','->',{
		xtype:'displayfield',
		value:'<b>Nº Matrícula: </b>',
		style:'margin-left:10px'
	},{
		xtype:'textfield',
		id: 'idsolicitacaosecretariamatricula',
		emptyText:'matricula...',
		style:'margin-left:10px',
		enableKeyEvents:true,
		listeners:{
			keyup:function(a, b){
				if(b.keyCode == 13){
					
					$regexp = /^[0-9]{8,16}$/;
					$value = $.trim(xt('idsolicitacaosecretariamatricula').getValue());
					
					//Se valor passado for um padrão de matricula válido
					if($regexp.test($value)){
						
						fn_searchbymatricula();
						
					}else{
						
						fn_searchmatriculabynome($value);
					}
				}
			}
		}
	}],
	bbar:['->',{
		text:'<b>Finalizar Solicitação</b>',
		tooltip:'Clique aqui para finalizar e enviar a solicitação',
		id:'idsolicitacaosecretariabtnfinalizarsolicitacao',
		style:'border: 1px solid #99bbe8; background-image: -webkit-linear-gradient(bottom, rgb(218,227,230) 35%, rgb(210,218,219) 68%, rgb(232,234,235) 84%);',
		scale:'medium',
		iconCls:'ico_save',
		handler:function(){
			ms.confirm('Confirmação', 'Tem certeza que deseja finalizar a sua solicitação?', function(btn){
				if(btn == "yes"){
					if(arrObjAlunoAlterado.length && arrObjAlunoAlterado.length > 0){
						
						$('#myimageload img').show();
						$('#modal-load').show();
						$('#myimageload').css('z-index', '1000000');
						
						//console.log(arrObjAlunoAlterado);
						Ext.Ajax.request({
							url:PATH+'/ajax/solicitacao_corporativa_save.php',
							params:{
								solicitacoes: JSON.stringify(arrObjAlunoAlterado)
							},
							success: function(response){
								
								$myJson = Ext.util.JSON.decode(response.responseText);
								//console.log($myJson);
								
								function getMessageSolicitacaoNaoRealizada(){
									if(
										!$myJson.reagendamento.success || 
										!$myJson.desmembramento.success || 
										!$myJson.desagendamento.success
									){
										
										var $title;
										
										if(
											!$myJson.reagendamento.success && 
											!$myJson.desmembramento.success &&
											!$myJson.desagendamento.success
										){
											$title = $myJson.reagendamento.title+"/"+$myJson.desmembramento.title+"/"+$myJson.desagendamento.title;
										}else if(
											!$myJson.desmembramento.success &&
											!$myJson.desagendamento.success
										){
											$title = $myJson.desmembramento.title+"/"+$myJson.desagendamento.title;
										}else if(
											!$myJson.desmembramento.success &&
											!$myJson.reagendamento.success
										){
											$title = $myJson.desmembramento.title+"/"+$myJson.reagendamento.title;
										}else if(
											!$myJson.desagendamento.success &&
											!$myJson.reagendamento.success
										){
											$title = $myJson.desagendamento.title+"/"+$myJson.reagendamento.title;
										}else if(!$myJson.reagendamento.success){
											$title = $myJson.reagendamento.title;
										}else if(!$myJson.desmembramento.success){
											$title = $myJson.desmembramento.title;
										}else if(!$myJson.desagendamento.success){
											$title = $myJson.desagendamento.title;
										}
										
										ms.warning("O "+$title+" não pode ser finalizado", $myJson.desmembramento.msg+"<br /><br />"+$myJson.reagendamento.msg+"<br /><br />"+$myJson.desagendamento.msg);
									}
								}
								
								if($myJson.success){
									
									$('#myimageload img').hide();
									$('#modal-load').hide();
									
									ms.info('Solicitação Finalizada', 'Sua solicitação foi finalizado com sucesso! Você pode visualizar a solicitação gerada na aba \"Visualizar Solicitações \".', function(){
										
										getMessageSolicitacaoNaoRealizada();
									});
								}else{
									
									$('#myimageload img').hide();
									$('#modal-load').hide();
									
									ms.warning('Solicitação não concluída', $myJson.msg, function(){
										
										getMessageSolicitacaoNaoRealizada();
									});
								}
								
								fn_searchbymatricula();
							},
							failure:function(){
								$('#myimageload img').hide();
								$('#modal-load').hide();
							}
						});
					}else{
						ms.info('Aviso!', 'Nenhuma solicitação realizada!');
					}
				}
			});
		}
	},'-',{
		text:'<b>Excluir Solicitação<b>',
		tooltip:'Clique aqui para excluir a solicitação',
		id:'idsolicitacaosecretariabtnexcluirsolicitacao',
		disabled:true,
		style:'border: 1px solid #99bbe8; background-image: -webkit-linear-gradient(bottom, rgb(218,227,230) 35%, rgb(210,218,219) 68%, rgb(232,234,235) 84%);',
		scale:'medium',
		iconCls:'ico_cross',
		handler:function(){
			ms.confirm('Confirmação', 'Tem certeza que deseja excluir essa solicitação?', function(btn){
				if(btn == "yes"){
					
					var $gridrow = xt('idsolicitacaosecretariagridsolicitacaosecretaria').getSelectionModel().getSelected();
					
					Ext.Ajax.request({
						url:PATH+'/ajax/solicitacao_corporativa_delete.php',
						params:{
							idsolicitacaocorp: $gridrow.get('idsolicitacaocorp')
						},
						success: function(response){
							var resp = Ext.util.JSON.decode(response.responseText).success;
							var msg = Ext.util.JSON.decode(response.responseText).msg;
							
							fn_getFinalizadosPendentesCount();
							
							if(resp){
								ms.info('Aviso!', msg);
								
								fn_reloadStoreArquivoRetornoByData(
									fn_getDateString2(xt('idsolicitacaosecretariadata_inicio').getValue()), 
									fn_getDateString2(xt('idsolicitacaosecretariadata_final').getValue())
								);
								
							}else{
								ms.warning('Aviso!', msg);
							}
						}
					});
				}						
			});
		}
	}],
	items:[{
		xtype:'tabpanel',
		id:'idsolicitacaosecretariatabpanel',
		activeTab: 0,
		height:430,
		tabPosition:'bottom',
		autoScroll:false,
		border:false,
		items: [{
			xtype:'panel',
			title:'Solicitação Corporativa',
			border:false,
			padding:2,
			listeners:{
				'activate':function(){
					xt('idsolicitacaosecretariabtnexcluirsolicitacao').disable();
				}
			},
			items:[{
				xtype: "panel",
				border: false,
				height: 210,
				layout: "hbox",
				layoutConfig: { columns: 2 },
				items:[{
					xtype:'grid',
					title:'Aluno',
					id:'idsolicitacaosecretariagridalunomatricula',
					flex: 1,
					height:200,
					store:storealunomatricula,
					stripeRows: true,
					viewConfig:{
						forceFit:true
					},
					sm: new Ext.grid.RowSelectionModel({
						//checkOnly:true,
						listeners:{
							'rowdeselect':function(){
								//fn_disableCheckeBoxes();
								fn_disableToggleButtons();
								//console.log('rowdeselect');
							}
						}
					}),
					columns:[{
						hidden:true,
						dataIndex:'idaluno'
					},new Ext.grid.TemplateColumn({
						header:'Nome',
						tpl:LinkPermissao.aluno,
						sortable:true,
						dataIndex:'desaluno'
					})],
					listeners:{
						'rowclick':function(){
							var mask2 = new Ext.LoadMask(xt('idsolicitacaosecretariagridtreinamentomatricula').body,{msg:'Aguarde...'});
							
							var $row = xt('idsolicitacaosecretariagridalunomatricula').getSelectionModel().getSelected();
						
							Aluno.constructAlunoGrid($row);
							
							if($row){
								
								mask2.show();
								
								storetreinamentomatricula.reload({
									params:{
										matricula: MATRICULA,
										idaluno: $row.get('idaluno')
									},
									callback: function(a){
										
										if(a.length){
											mask2.hide();
										}else{
											mask2.hide();
											storetreinamentomatricula.removeAll();
											ms.info('Aviso', 'Nenhum treinamento vinculado a essa mesma matricula e aluno.');
										}
										
										fn_btnCertificadoPresencaShow();
										fn_btnEditAlunoShow();
										fn_disableToggleButtons();
									}
								});
							}
							
							fn_btnCertificadoPresencaShow();
							fn_btnEditAlunoShow();
							fn_disableToggleButtons();
						}
					},
					bbar:[{
						text:'Opções',
						id:'idsolicitacaosecretariaopcoes',
						iconCls:'ico_group_gear',
						menu:[{
							text:'Editar Aluno',
							id:'idsolicitacaosecretariaeditaluno',
							iconCls:'ico_Essen_edit',
							disabled:true,
							handler:function(){
								if(xt('winsolicitacaosecretariaeditaluno')){
									xt('winsolicitacaosecretariaeditaluno').show();
								}else{
									var winsolicitacaosecretariaeditaluno = new Ext.Window({
										id:'winsolicitacaosecretariaeditaluno',
										title:'Editar dados do Aluno',
										width:400,
										modal:true,
										autoHeight:true,
										items:[{
											xtype:'form',
											padding:5,
											autoHeight:true,
											width:380,
											border:false,
											buttonAlign:'center',
											defaults: {
												xtype: 'textfield',
												margins:'10',
											},
											items:[{
												hidden:true,
												id:'idsolicitacaosecretariaidaluno',
												name:'idaluno',
											},{
												hidden:true,
												id:'idsolicitacaosecretariaidalunoagendado',
												name:'idalunoagendado',
											},{
												fieldLabel:'Nome',
												id:'idsolicitacaosecretarianomealuno',
												name:'nomealuno',
												anchor:'100%'
											},{
												fieldLabel:'E-mail',
												id:'idsolicitacaosecretariaemailaluno',
												name:'emailaluno',
												anchor:'100%'
											},{
												fieldLabel:'CPF',
												id:'idsolicitacaosecretariacpfaluno',
												name:'cpfaluno',
												anchor:'100%'
											},{
												fieldLabel:'RG',
												id:'idsolicitacaosecretariargaluno',

												name:'rgaluno',
												anchor:'100%'
											},{
												xtype:'compositefield',
												items:[{
													xtype: 'datefield',
													format:'d/m/Y',
													fieldLabel: 'Data de Nascimento',
													id:'idsolicitacaosecretariadtnascaluno',
												},{
													xtype:'displayfield',
													width:25,
													value:'Cel:'
												},{
													xtype:"textfield",
													width:127,
													id:"idsolicitacaosecretariacelularaluno"
												}]
											},{
												fieldLabel:'Endereco',
												id:'idsolicitacaosecretariaenderecoaluno',
												name:'enderecoaluno',
												anchor:'100%'
											},{
												fieldLabel:'Bairro',
												id:'idsolicitacaosecretariabairroaluno',
												name:'bairroaluno',
												anchor:'100%'
											},{
												xtype:'compositefield',
												items:[{
													fieldLabel:'Cidade',
													xtype:'textfield',
													id:'idsolicitacaosecretariacidadealuno',
													name:'cidadealuno',
													width:120
												},{
													xtype:'displayfield',
													style:"margin-left:3",
													width:30,
													value:'CEP:'
												},{
													xtype:"textfield",
													width:105,
													id:"idsolicitacaosecretariacepaluno"
												}]
											},{
												xtype:'compositefield',
												items:[{
													xtype:'textfield',
													fieldLabel:'UF',
													width:30,
													id:'idsolicitacaosecretariaufaluno'
												},{
													xtype:'displayfield',
													style:"margin-left:3",
													width:85,
													value:'Complemento:'
												},{						
													xtype:"textfield",
													width:140,
													id:"idsolicitacaosecretariacompaluno"
												}]
											},{
												xtype:'compositefield',
												items:[{
													xtype:'textfield',
													fieldLabel: 'Nº',
													width:35,
													id:'idsolicitacaosecretarianaluno'
												},{
													xtype:'displayfield',
													style:"margin-left:3",
													width:40,
													value:'Sexo:'
												},{
													xtype:"textfield",
													width:20,
													id:"idsolicitacaosecretariasexoaluno"
												},{
													xtype:'displayfield',
													style:"margin-left:3",
													width:70,
													value:'Logradouro:'
												},{
													xtype:"textfield",
													width:80,
													id:"idsolicitacaosecretarialogradouroaluno"
												}]
											},{
												fieldLabel:'Email empresa',
												id:'idsolicitacaosecretariaeemailempresaaluno',
												name:'emailempresa1',
												anchor:'100%'
											},{
												fieldLabel:'Tel. Comercial',
												id:'idsolicitacaosecretariatelcomercialaluno',
												name:'telcomercialaluno',
												anchor:'100%'
											},{
												fieldLabel:'Tel. Residencial',
												id:'idsolicitacaosecretariatelresidencialaluno',
												name:'telresidencialaluno',
												anchor:'100%'
											}],
											buttons:[{
												text:'OK',
												scale:'medium',
												iconCls:'ico_ok',
												handler:function(){
													//instancia Aluno
													var $msg = Aluno.constructAlunoForm();
													
													if($msg != ""){
														ms.info('Informações alteradas!', $msg, function(){
															xt('winsolicitacaosecretariaeditaluno').close();
														});
													}else{
														ms.info('Nenhum dado alterado!', 'Para efetuar a alteração dos dados do aluno clique em "\Confirmar Solicitação"\ para finalizar a solicitação.');
													}
												}
											},{
												text:'Resetar',
												scale:'medium',
												iconCls:'ico_Back',
												handler:function(){
													fn_resetObjAluno();
													
													Aluno.loadFormFields();
													//fn_loadFormField();
												}
											},{
												text:'Cancelar',
												scale:'medium',
												iconCls:'ico_cancel',
												handler:function(){
													fn_resetObjAluno();
													
													xt('winsolicitacaosecretariaeditaluno').close();
												}
											},{
												text:'Fechar',
												scale:'medium',
												iconCls:'ico_door_out',
												handler:function(){
													
													xt('winsolicitacaosecretariaeditaluno').close();
												}
											}]
										}],
										listeners:{
											'afterrender':function(){
												
												Aluno.loadFormFields();
												//fn_loadFormField();
											}
										}
									}).show();
								}
							}
						},{
							text:'Desmembrar',
							id:'idsolicitacaosecretariadesmembraraluno',
							disabled:true,
							iconCls:'ico_Expand',
							handler:function(){										  
								Ext.MessageBox.show({
									title:'Desmembrar Aluno',
									msg:'Digite a quantidade de alunos...',
									buttons: Ext.MessageBox.OKCANCEL,
									prompt:true,
									fn:function(btn,text,e){
										if(btn == 'ok'){
											$txt = parseInt(text);
											
											if(!isNaN($txt) && $txt < 100){
												
												Aluno.setQtdalunos($txt);
											}else{
												Ext.MessageBox.alert('Inválido', 'Você digitou: '+text);	
											}
										}
									}
								});
							}
						},{
							text:'Desagendar',
							id:'idsolicitacaosecretariadesagendar',
							tooltip:'Desagendar o aluno da turma',
							disabled:true,
							iconCls:'ico_action_remove',
							handler:function(){
								
								Ext.MessageBox.show({
									title:"Desagendamento",
									msg:"Deseja desagendar o aluno: "+Aluno.getDesaluno()+" desta turma? Clique em OK para desagendar e em seguida em \"Adicionar Solicitação\".",
									buttons: Ext.MessageBox.OKCANCEL,
									icon: Ext.MessageBox.QUESTION,
									fn:function(btn, a, b, c){
										
										if(btn == 'ok'){
										
											var $storealuno = 
												xt('idsolicitacaosecretariagridalunomatricula').getSelectionModel().getSelected(); 									
											var $storetreinamento = 
												xt('idsolicitacaosecretariagridtreinamentomatricula').getSelectionModel().getSelected();
											var $isreagendado = false;
											var $isdesagendado = false;
											var $isdesmembrado = false;
											
											Treinamento.constructTreinamento($storetreinamento);
											Treinamento.setSolicitacaoTreinTipo("desagendamento");
											
											//Se o aluno já foi solicitado para ser alterado daquele determinado curso
											$.each(arrObjAlunoAlterado, function(){
												
												var $Aluno = this.Aluno;
												var $Treinamento = this.Treinamento.treinamento_atual;
												var $status = this.status;
												
												if($storetreinamento && $storealuno){
								
													if(
														$Treinamento.idcursoagendado == $storetreinamento.get('idcursoagendado') && 
														$status.intreinamentoalterado == true)
													{
														$isreagendado = true;
													}
													
													if(
														$Treinamento.idalunoagendado == $storetreinamento.get('idalunoagendado') && 
														$status.inalunodesagendado == true
													){
														$isdesagendado = true;
													}
													
													if(
														$Treinamento.idalunoagendado == $storetreinamento.get('idalunoagendado') && 
														$status.inalunodesmembrado == true
													){
														$isdesmembrado = true;
													}
												}
												
											});
											
											if($isdesagendado){
												ms.info('Você fez um desagendamento antes para este treinamento!', 'Se desejar desagendar novamente clique em \"Refazer Solicitação\" e faça a solicitação novamente sem desagendá-lo.');
												return false;
											}		
											if($isdesmembrado){
												ms.info('Você fez um desmembramento antes para este treinamento!', 'Se desejar desagendar, clique em \"Refazer Solicitação\" e faça a solicitação novamente sem desagendá-lo.');
												return false;
											}
											if($isreagendado || Treinamento.getTreinamento_novo()){
												ms.info('Você já reagendou este treinamento!', 'Se desejar desagendar este aluno deste treinamento clique em \"Refazer Solicitação\" e não faça o reagendamento.');
												return false;
											}									
											if(!$storetreinamento){
												ms.info('Nenhum Treinamento selecionado!', 'Favor, selecione um treinamento a partir do qual você quer alterar na tabela acima.');
												return false;
											}
											if(!$storealuno){
												ms.info('Nenhum aluno selecionado', 'Favor selecione um aluno a partir do qual você quer fazer a alteração, e em seguida selecione novamente um curso para reagendar.');
												return false;
											}
											
											//INALUNODESAGENDADO = true;
											
											new Ext.Window({
												id:'winsolicitacaosecretariadesagendamentomotivo',
												title:"Deseja inserir o motivo do Desagendamento?",
												iconCls:'ico_file',
												autoHeight:true,
												width:400,
												items:[{
													xtype:'form',
													border:false,
													padding:5,
													id:'idformsolicitacaosecretariadesagendamentomotivo',
													items:[{
														xtype:'textarea',
														width:'98%',
														style:'margin-bottom:-5px',
														hideLabel:true,
														maxLength:1000,
														name:'justificativa',
														emptyText:'Escreva aqui o motivo do desagendamento',
														id:'idtxtsolicitacaosecretariadesagendamentomotivo',
													}]
												}],
												buttons:['->',{
													text:'Salvar Motivo',
													scale:'medium',
													iconCls:'ico_save',
													handler:function(){
														var $motivo = $.trim(xt('idtxtsolicitacaosecretariadesagendamentomotivo').getValue());
														if($motivo){
															
															Treinamento.setSolicitacaoTreinTipo('desagendamento');
															Treinamento.setMotivo($motivo);
															
															xt('winsolicitacaosecretariadesagendamentomotivo').close();
														}else{
															ms.warning("Aviso!", "Favor, insira um motivo");
														}
														
													}
												},'-',{
													text:'Desagendar sem Motivo',
													scale:'medium',
													iconCls:'ico_Exit',
													handler:function(){
														
														Treinamento.setSolicitacaoTreinTipo('desagendamento');
														Treinamento.setMotivo("");
														
														xt('winsolicitacaosecretariadesagendamentomotivo').close();
													}
												}]
											}).show();
										}
									}
								})
							}
						},{
							text:'Cadastrar no Impacta Online',
							iconCls: 'ico_impacta',
							id:'idsolicitacaosecretariaimpactaonline',
							disabled:true,
							handler:function(){
								Ext.MessageBox.show({
									title:"Cadastrar no Impacta Online",
									msg:"Deseja cadastrar o aluno: "+Aluno.getDesaluno()+" no Impacta Online? Clique em OK para cadastrar e em seguida em \"Adicionar Solicitação\".",
									buttons: Ext.MessageBox.OKCANCEL,
									icon: Ext.MessageBox.QUESTION,
									fn:function(btn, a, b, c){
										
										if(btn == 'ok'){
										
											var $storealuno = 
												xt('idsolicitacaosecretariagridalunomatricula').getSelectionModel().hasSelection(); 									
											var $storetreinamento = 
												xt('idsolicitacaosecretariagridtreinamentomatricula').getSelectionModel().getSelected();
												
											if(!$storealuno){
												ms.info('Nenhum aluno selecionado', 'Favor selecione um aluno a partir do qual você quer fazer a alteração, e em seguida selecione novamente um curso para reagendar.');
												
												Treinamento.setSolicitacaoTreinTipo('');
												//INCADIMPACTAONLINE = false;	
												
												return false;
											}else{
												
												Treinamento.constructTreinamento($storetreinamento);
												Treinamento.setSolicitacaoTreinTipo('cadimpactaonline');
												//INCADIMPACTAONLINE = true;	
											}	
										}
									}
								});
							}
						}]
					},'-',{
						text:'AlterarNF',
						id:'idsolicitacaosecretariaalterarnf',
						disabled:true,
						iconCls:'ico_cart_add',
						handler:function(){
							
							if(Miku.isSet('win.alterarNF')){
								Miku.show('win.alterarNF')
							}else{
								var id2 = 'alterarNF_';
								new Ext.Window({
									id:'win.alterarNF',
									title:'Alteração da Nota Fiscal',
									width:750,
									modal:true,
									iconCls:'ico_cart_add',
									resizable:false,
									buttons:[{
										text:'OK',
										iconCls:'ico_save',
										handler:function(){
											
											var mask = new Ext.LoadMask(xt('win.alterarNF').body,{msg:'Aguarde...'});
											
											var $msg = AlterarNF.getModifiedfields();
											
											if($msg != ""){
												
												AlterarNF.constructAlterarNF({
													callback : function(){
														
														ms.info('Informações alteradas!', $msg+"<br /><br /><b>Confirme clicando em \"Adicionar Solicitação\"</b>", function(){
															mask.show();
															mask.hide();
																
															xt('win.alterarNF').close();
														});
													}
												});
											}else{
												ms.info('Nenhum dado alterado!', 'Não houve nenhuma alteração de cadastro.');
											}
										}
									},{
										text:'Cancelar',
										handler:function(){
											Miku.close("win.alterarNF");
										}
									}],
									items:[{
										xtype:'form',
										id:'form_nf2',
										border:false,
										padding:10,
										items:[{
											xtype:'compositefield',
											border:false,
											items:[{
												xtype:'displayfield',
												value:'CCM'
											},{
												xtype:'textfield',
												disabled:true,
												width: 120,
												id: id2 + 'nf_ccm',
											},{
												xtype:'combo',
												disabled:true,
												width:100,
												store:combobox,
												mode:'remote',
												displayField:"Text",
												valueField:'Id',
												triggerAction:"All",
												id: id2 + 'nf_combo',
												listeners:{
													beforequery: function(qe){
														qe.query = xt(id2 +'matricula').getValue();
													}
												}
											}]
										},{
											xtype: 'fieldset',
											title: 'Endereço para a emissão da Nota Fiscal',
											collapsible:true,
											items:[{
												xtype: 'compositefield',
												border:false,
												items:[{
													xtype: 'textfield',
													fieldLabel: 'Endereço',
													id: id2 + 'nf_tipo_endereco',
													width:35
												},{
													style:'marginLeft: -2;',
													xtype:'textfield',
													id: id2 + 'nf_endereco',
													width:360
												},{
													xtype: 'displayfield',
													value: 'Nº',
													width:20
												},{
													style:'marginLeft:11;',
													xtype:'numberfield',
													id: id2 + 'nf_numero',
													width:80
												}]
											},{
												xtype:'compositefield',
												border:false,
												items:[{
													xtype:'textfield',
													fieldLabel:'Complemento',
													id: id2 + 'nf_complemento',
													width:398,
												},{
													style:'marginLeft: 2;',
													xtype:'displayfield',
													value:'CEP:',
													width:43
												},{
													style:'marginLeft:-10;',
													xtype:'textfield',
													id: id2 + 'nf_cep',
													width:80
												}]
											},{
												xtype:'compositefield',
												border:false,
												items:[{
													xtype:'textfield',
													fieldLabel: 'Bairro',
													id: id2 + 'nf_bairro',
													flex: 2
												},{
													style:'marginLeft:7;',
													xtype:'displayfield',
													value:'Cidade:',
													flex:1
												},{
													xtype:'textfield',
													id: id2 + 'nf_cidade',
													flex: 3
												},{
													style:'marginLeft:7;',
													xtype:'displayfield',
													value: 'Estado:',
													flex: 1
												},{
													xtype:'estados',
													id: id2 + 'nf_comboUF',
													flex:2
												}]
											},{
												xtype:'textfield',
												fieldLabel:'E-mail',
												id: id2 + 'nf_email',
												anchor:'100%'
											},{
												xtype:'textfield',
												fieldLabel:'<font color=red>Referência</font>',
												id:id2 + 'nf_referencia',
												anchor:'100%'
											},{
												xtype:'textarea',
												fieldLabel:'OBS',
												autoScroll:true,
												height: 40,
												anchor:'98%',
												id: id2 + 'nf_obs'
											}]
										},{
											xtype:'fieldset',
											title:'Endereço para a entrega da nota fiscal',
											collapsible:true,
											items:[{
												xtype:'compositefield',
												border:false,
												items:[{
													xtype:'textfield',
													fieldLabel:'Contato',
													id: id2 + 'nf_contato',
													flex:3
												},{
													style:'marginLeft:5;',
													xtype:'displayfield',
													value:'Telefone:',
													flex:1
												},{
													xtype:'textfield',
													id:id2 + 'nf_telefone',
													flex:2
												},{
													style:'marginLeft:33;',
													xtype:'displayfield',
													value:'Fax:',
													flex:1
												},{
													xtype:'textfield',
													id: id2 + 'nf_fax',
													flex:2
												}]
											},{
												xtype:'textfield',
												fieldLabel:'E-mail',
												id: id2 + 'nf_email2',
												anchor:'100%'
											},{
												xtype:'textfield',
												fieldLabel:'Endereço',
												id: id2 + 'nf_endereco2',
												anchor:'100%'
											},{
												xtype:'compositefield',
												border:false,
												items:[{
													xtype:'textfield',
													fieldLabel:'Bairro',
													id:id2 + 'nf_bairro2',
													width:308
												},{
													xtype:'displayfield',
													value:'CEP:',
													width:53
												},{
													xtype:'textfield',
													id: id2 + 'nf_cep2',
													width:150
												}]
											},{
												xtype:'compositefield',
												border: false,
												items:[{
													xtype:'textfield',
													fieldLabel:'Cidade',
													id: id2 + 'nf_cidade2',
													flex: 5.8
												},{
													xtype:'displayfield',
													value: 'Estado',
													flex: 1
												},{
													xtype:'estados',
													id: id2 + 'nf_comboUF2',
													flex: 1
												}]
												
											}]
										}]
									}],
									listeners:{
										'afterrender': function(){
											
											if(AlterarNF.getModifiedfields() == ""){
												Miku.formLoad('form_nf2',{
													url:PATH+'/json/alterarnotafiscalForm2.php',
													params:{
														matricula: MATRICULA
													},
													success:function(){
														AlterarNF.constructAlterarNF();
													}
												});
											}else{
												ms.info("Você já adicionou uma alteração da Nota Fiscal desta empresa. Para Alterar novamente clique em \"Refazer Solicitação\" ");
											}
										}
									}
								}).show();
							}
						}
					}]
				},{
					xtype:'grid',
					title:'Treinamentos',
					id:'idsolicitacaosecretariagridtreinamentomatricula',
					flex: 3,
					height:200,
					store:storetreinamentomatricula,
					stripeRows: true,
					viewConfig:{
						forceFit:true,
						getRowClass:function(record, a, rp){
							 var _class = record.get('dtinicio');
							 if (!_class){
								 return 'cls_turmafechada';
							 }else{
								 return 'black';
							 }
						 }
					},
					sm: new Ext.grid.RowSelectionModel({
						singleSelect: true,
					}),
					columns:[{
						hidden:true,
						dataIndex:'idcursoagendado'
					},{
						hidden:true,
						dataIndex:'idalunoagendado',
					},new Ext.grid.TemplateColumn({
						header:'Treinamento',
						tpl:LinkPermissao.cursoagendado,
						width:300,
						dataIndex:'descurso'
					}),{
						header:'Período',
						dataIndex:'desperiodo'
					},{
						header:'Instrutor',
						dataIndex:'desinstrutor'
					},{
						header:'Observação',
						dataIndex:'descomentario'
					},{
						header:'Início',
						xtype:'datecolumn',
						format:'d/m/Y',
						dataIndex:'dtinicio'
					},{
						header:'Término',
						xtype:'datecolumn',
						format:'d/m/Y',
						dataIndex:'dttermino'
					}],
					listeners:{
						'rowclick':function($this, index){
							
							Treinamento.constructTreinamento($this.getStore().getAt(index));
							
							fn_btnCertificadoPresencaShow();
							fn_disableToggleButtons();
							fn_reagendamentodatasLoad(0);
						}
					},
					bbar:[{
						text:'Lista de Presença',
						id:'idsolicitacaosecretariabtnpresenca',
						iconCls:'ico_list_ok',
						disabled:true,
						enableToggle:true
					},'-',{
						text:'Emitir Certificado',
						id:'idsolicitacaosecretariabtncertificado',
						iconCls:'ico_certificado',
						disabled:true,
						enableToggle:true
					},'->',{
						text:'Em Aberto',
						iconCls:'ico_bullet_gray',
						tooltip:"Os treinamentos em aberto estarão desta cor",
					}]
				}]
			},{
				xtype: "panel",
				border: false,
				style:'margin-top:-8px;',
				height: 250,
				layout: "hbox",
				items:[{
					xtype:'grid',
					title:'Reagendar treinamento para:',
					id:'idsolicitacaosecretariagridreagendamentomatricula',
					height:214,
					flex:1,
					store:storereagendamentotreinamentomatricula,
					stripeRows: true,
					viewConfig:{
						forceFit:true,
						getRowClass:function(record, a, rp){
							 var _class = record.get('inturmafechada');
							 if (_class == true){
								 return 'cls_turmafechada';
							 }else{
								 
								 return 'black';
							 }
						 }
					},
					sm: new Ext.grid.RowSelectionModel({
						singleSelect: true,
					}),
					columns:[{
						hidden:true,
						dataIndex:'idcursoagendado'
					},new Ext.grid.TemplateColumn({
						header:'Treinamento',
						tpl:LinkPermissao.cursoagendado,
						width:300,
						dataIndex:'descurso'
					}),{
						header:'Período',
						width:70,
						dataIndex:'desperiodo'
					},{
						header:'Instrutor',
						dataIndex:'desinstrutor'
					},{
						header:'CH',
						width:30,
						dataIndex:'nrcargahoraria'
					},{
						header:'Início',
						xtype:'datecolumn',
						format:'d/m/Y',
						width:60,
						dataIndex:'dtinicio'
					},{
						header:'Término',
						xtype:'datecolumn',
						format:'d/m/Y',
						width:60,
						dataIndex:'dttermino'
					}],
					bbar:[{
						xtype:'displayfield',
						style:'margin-right:5px;',
						value:'<b>Alunos: </b>'
					},{
						xtype:'displayfield',
						id:'idsolicitacaosecretarianralunos'
					},'-',{
						xtype:'displayfield',
						style:'margin-right:5px;',
						value:'<b>Vagas: </b>'
					},{
						xtype:'displayfield',
						id:'idsolicitacaosecretarianrvagas'
					},'->','-',{
						text:'Em aberto',
						id:'idsolicitacaosecretariabtnemaberto',
						iconCls:'ico_application_view_list',
						disabled:true,
						enableToggle:true,
						toggleHandler:function(btn, state){
							if(state){
								fn_reagendamentodatasLoad(1);
							}else{
								fn_reagendamentodatasLoad(0);
							}
						}
					},'-'],
					listeners:{
						'rowclick': function(a, index, e){
							
							var $storealuno = xt('idsolicitacaosecretariagridalunomatricula').getSelectionModel().getSelected(); 									
							var $storetreinamento = xt('idsolicitacaosecretariagridtreinamentomatricula').getSelectionModel().getSelected();
							
							if($storetreinamento){
								if($storealuno){
									
									var $isreagendado = false;
									var $isdesagendado = false;
									var $isdesmembrado = false;
									
									//Verifica se o reagendamento já foi feito para este Aluno na mesma solicitação
									$.each(arrObjAlunoAlterado, function(){
												
										var $Aluno = this.Aluno;
										var $Treinamento = this.Treinamento.treinamento_atual;
										var $status = this.status;
										
										if($storetreinamento && $storealuno){
								
											if(
												$Treinamento.idcursoagendado == $storetreinamento.get('idcursoagendado') && 
												$status.intreinamentoalterado == true
											){
												$isreagendado = true;
											}
											
											if(
												$Treinamento.idcursoagendado == $storetreinamento.get('idalunoagendado') && 
												$status.inalunodesagendado == true
											){
												$isdesagendado = true;
											}
											
											if(
												$Treinamento.idcursoagendado == $storetreinamento.get('idalunoagendado') && 
												$status.inalunodesmembrado == true
											){
												$isdesmembrado = true;
											}
										}
										
									});
									
									if($isdesagendado){
										ms.info('Você fez um desagendamento antes para este treinamento!', 'Se desejar reagendar, clique em \"Refazer Solicitação\" e faça a solicitação novamente sem desagendá-lo.');
										return false;
									}
									
									if($isdesmembrado){
										ms.info('Você fez um desmembramento antes para este treinamento!', 'Se desejar reagendar, clique em \"Refazer Solicitação\" e faça a solicitação novamente sem desagendá-lo.');
										return false;
									}
									
									if($isreagendado){
										ms.info('Você já reagendou este treinamento!', 'Se desejar reagendar novamente clique em \"Refazer Solicitação\" e faça a solicitação novamente.');
										return false;
									}
									
									var $storereagendamento = xt('idsolicitacaosecretariagridreagendamentomatricula').getStore();
									
									var $btncertificado = xt('idsolicitacaosecretariabtncertificado');
									var $btnpresenca = xt('idsolicitacaosecretariabtnpresenca');
									
									var $arr_btns = [$btncertificado, $btnpresenca];
										
									if(xt('idsolicitacaosecretariagridreagendamentomatricula').getSelectionModel().getSelected()){
										
										$.each($arr_btns, function(){
											if(this.pressed){
												this.toggle();
											}
											
											this.disable();
										});
									}else{
										$.each($arr_btns, function(){
											this.enable();
										});
									}
									
									xt('idsolicitacaosecretarianralunos').setValue($storereagendamento.getAt(index).get('nrtotalalunos'));
									xt('idsolicitacaosecretarianrvagas').setValue($storereagendamento.getAt(index).get('nrvagas'));
									
									//////////////////////////////// REAGENDAMENTO ///////////////////////////////////////////////
									new Ext.menu.Menu({
										items:[{
											text:'<b>[Reagendamento]</b> De: '+fn_ifDateIsNull($storetreinamento.get('dtinicio'))+'('+$storetreinamento.get('desperiodo')+') -> Para: '+fn_ifDateIsNull($storereagendamento.getAt(index).get('dtinicio'))+' ('+$storereagendamento.getAt(index).get('desperiodo')+')',
											iconCls:'ico_arrow_refresh2',
											handler:function(){
												if(!$storereagendamento.getAt(index).get('nrvagas') > 0){
													
													ms.warning('Sem vaga!', 'Não há vaga para o treinamento '+$storereagendamento.getAt(index).get('descurso')+' da data de início '+fn_ifDateIsNull($storereagendamento.getAt(index).get('dtinicio'))+' ('+$storereagendamento.getAt(index).get('desperiodo')+')');
												}else{
													
													var TreinamentoAtual = new Class_Treinamento();
													TreinamentoAtual.constructTreinamento($storetreinamento);
													
													var TreinamentoNovo = new Class_Treinamento();
													TreinamentoNovo.constructTreinamento($storereagendamento.getAt(index));		
													
													Treinamento.setTreinamento_atual(TreinamentoAtual.getInstancia());
													Treinamento.setTreinamento_novo(TreinamentoNovo.getInstancia());													
													
													new Ext.Window({
														id:'winsolicitacaosecretariareagendamentomotivo',
														title:"Deseja inserir o motivo do reagendamento?",
														iconCls:'ico_file',
														autoHeight:true,
														width:400,
														items:[{
															xtype:'form',
															border:false,
															padding:5,
															id:'idformsolicitacaosecretariareagendamentomotivo',
															items:[{
																xtype:'textarea',
																width:'98%',
																style:'margin-bottom:-5px',
																hideLabel:true,
																maxLength:1000,
																name:'justificativa',
																emptyText:'Escreva aqui o motivo do reagendamento',
																id:'idtxtsolicitacaosecretariareagendamentomotivo',
															}]
														}],
														buttons:['->',{
															text:'Salvar Motivo',
															scale:'medium',
															iconCls:'ico_save',
															handler:function(){
																var $motivo = $.trim(xt('idtxtsolicitacaosecretariareagendamentomotivo').getValue());
																if($motivo){
																	
																	Treinamento.setSolicitacaoTreinTipo("reagendamento");
																	Treinamento.setMotivo($motivo);
																	
																	//INTREINAMENTOREAGENDADO = true;
																	
																	xt('winsolicitacaosecretariareagendamentomotivo').close();
																}else{
																	ms.warning("Aviso!", "Favor, insira um motivo");
																}
																
															}
														},'-',{
															text:'Reagendar sem Motivo',
															scale:'medium',
															iconCls:'ico_Exit',
															handler:function(){
																
																Treinamento.setSolicitacaoTreinTipo("reagendamento");
																Treinamento.setMotivo("");
																
																//INTREINAMENTOREAGENDADO = true;
																
																xt('winsolicitacaosecretariareagendamentomotivo').close();
															}
														}]
													}).show();
												}
											}
										},{
										//////////////////////////////// REPOSIÇÃO ////////////////////////////////////////////////
											text:'<b>[Reposição]</b> De: '+'Para: '+fn_ifDateIsNull($storereagendamento.getAt(index).get('dtinicio'))+' ('+$storereagendamento.getAt(index).get('desperiodo')+')',
											iconCls:'ico_action_add',
											handler:function(){
												if(!$storereagendamento.getAt(index).get('nrvagas') > 0){
													
													ms.warning('Sem vaga!', 'Não há vaga para o treinamento '+$storereagendamento.getAt(index).get('descurso')+' da data de início '+fn_ifDateIsNull($storereagendamento.getAt(index).get('dtinicio'))+' ('+$storereagendamento.getAt(index).get('desperiodo')+')');
												}else{
													
													var TreinamentoAtual = new Class_Treinamento();
													TreinamentoAtual.constructTreinamento($storetreinamento);
													
													var TreinamentoNovo = new Class_Treinamento();
													TreinamentoNovo.constructTreinamento($storereagendamento.getAt(index));		
													
													Treinamento.setTreinamento_atual(TreinamentoAtual.getInstancia());
													Treinamento.setTreinamento_novo(TreinamentoNovo.getInstancia());												
													
													new Ext.Window({
														id:'winsolicitacaosecretariareposicaomotivo',
														title:"Deseja inserir o motivo da reposição?",
														iconCls:'ico_file',
														autoHeight:true,
														width:400,
														items:[{
															xtype:'form',
															border:false,
															padding:5,
															id:'idformsolicitacaosecretariareposicaomotivo',
															items:[{
																xtype:'textarea',
																width:'98%',
																style:'margin-bottom:-5px',
																hideLabel:true,
																maxLength:1000,
																name:'justificativa',
																emptyText:'Escreva aqui o motivo da reposicao',
																id:'idtxtsolicitacaosecretariareposicaomotivo',
															}]
														}],
														buttons:['->',{
															text:'Salvar Motivo',
															scale:'medium',
															iconCls:'ico_save',
															handler:function(){
																var $motivo = $.trim(xt('idtxtsolicitacaosecretariareposicaomotivo').getValue());
																if($motivo){
																	
																	Treinamento.setSolicitacaoTreinTipo('reposicao');
																	Treinamento.setMotivo($motivo);
																	
																	//INTREINAMENTOREPOSICAO = true;
																	
																	xt('winsolicitacaosecretariareposicaomotivo').close();
																}else{
																	ms.warning("Aviso!", "Favor, insira um motivo");
																}
															}
														},'-',{
															text:'Agendar reposição sem Motivo',
															scale:'medium',
															iconCls:'ico_Exit',
															handler:function(){
																
																Treinamento.setSolicitacaoTreinTipo('reposicao');
																Treinamento.setMotivo("");
																
																//INTREINAMENTOREPOSICAO = true;
																
																xt('winsolicitacaosecretariareposicaomotivo').close();
															}
														}]
													}).show();
												}
											}
										}]
									}).showAt(e.xy);
								}else{
									ms.info('Nenhum aluno selecionado', 'Favor selecione um aluno a partir do qual você quer fazer a alteração, e em seguida selecione novamente um curso para reagendar.');
								}
							}else{
								ms.info('Nenhum Treinamento selecionado!', 'Favor, selecione um treinamento a partir do qual você quer alterar na tabela acima.');
							}
						}
					}
				}]
			}]
		},{
			xtype: "panel",
			title: 'Visualizar Solicitações', 
			id:'idsolicitacaosecretariavisualizar',
			border: false,
			height: 395,
			layout: "hbox",
			layoutConfig: { columns: 1 },
			listeners:{
				'activate':function(){
					
					var mask = new Ext.LoadMask(xt('idsolicitacaosecretariavisualizar').body,{msg:'Aguarde...'});
					mask.show();
					storesolicitacaocorporativa.reload({
						callback:function(){
							mask.hide();
							fn_getFinalizadosPendentesCount();
			
							setInterval(function(){
								fn_getFinalizadosPendentesCount();
							}, 20000);
							
							var $gridrow = xt('idsolicitacaosecretariagridsolicitacaosecretaria').getSelectionModel().hasSelection();
					
							if($gridrow){
								xt('idsolicitacaosecretariabtnexcluirsolicitacao').enable();
							}
						}
					});
					
					fn_getFinalizadosPendentesCount();
				}
			},
			items:[{
				xtype:'grid',
				title:'Lista de Solicitação Realizadas/Concluídas',
				id:'idsolicitacaosecretariagridsolicitacaosecretaria',
				flex: 1,
				height:415,
				autoScroll:true,
				store:storesolicitacaocorporativa,
				stripeRows: true,
				viewConfig:{
					forceFit:true,
					getRowClass: function(record, rowIndex, rp, ds){ // rp = rowParams
						 var _class = record.get('instatus');
						 if (!_class){
							return 'black'
						 }else{
							 return 'green';
						 }
					}
				},
				sm: new Ext.grid.RowSelectionModel({
					singleSelect: true,
				}),
				cm:new Ext.grid.ColumnModel({
					defaults:{
						sortable:true
					},
					columns:[new Ext.grid.TemplateColumn({
						header:'Matricula',
						tpl:LinkPermissao.matricula,
						width:135,
						dataIndex:'matricula'
					}),{
						header:'Solicitante',
						width:135,
						dataIndex:'dessolicitante'
					},{
						header:'Solicitado',
						dataIndex:'dessolicitado',
						width:135,
						renderer:function(v){
							return (v)? v : "N/A";
						}
					},{
						header:'Aluno',
						dataIndex:'inalunoalterado',
						tooltip:'Alteração de dados do aluno',
						renderer:fn_status		
					},{
						header:'Certificado',
						dataIndex:'incertificado',
						tooltip:'Solicitação de certificado',
						renderer:fn_status	
					},{
						header:'Lista Presença',
						dataIndex:'inlistapresenca',
						tooltip:'Solicitação de lista de presença',
						renderer:fn_status	
					},{
						header:'Faturamento NF',
						dataIndex:'innfalterado',
						tooltip:'Alteração de dados da empresa',
						renderer:fn_status	
					},{
						header:'Reagendado',
						dataIndex:'intreinamentoalterado',
						tooltip:'Reagendamento de treinamento',
						renderer:fn_status	
					},{
						header:'Desmembramento',
						dataIndex:'inalunodesmembrado',
						tooltip:'Desmembramento de Alunos',
						renderer:fn_status
					},{
						header:'Desagendamento',
						dataIndex:'inalunodesagendado',
						tooltip:'Desagendamento de Turma',
						renderer:fn_status
					},{
						header:'Impacta Online',
						dataIndex:'incadimpactaonline',
						tooltip:'Cadastro no Impacta Online',
						renderer:fn_status
					},{
						header:'Reposição',
						dataIndex:'intreinamentoreposicao',
						tooltip:'Reposição de Treinamento',
						renderer:fn_status
					},{
						header:'Finalizado',
						dataIndex:'instatus',
						tooltip:'Solicitação finalizada pela Secretaria',
						renderer:fn_status	
					},{
						header:'Cadastrado',
						width:150,
						xtype:'datecolumn',
						dataIndex:'dtcadastro',
						format:'d/m/Y H:i',
						tooltip:'Data de cadastro da solicitação',
						renderer:fn_status
					}]
				}),
				bbar:['<b>De: </b>',{
					xtype:'datefield',
					id:'idsolicitacaosecretariadata_inicio',
					width:100,
					value:firstday,
					listeners:{
						'select':function(a){
							
							var $dateDe = xt('idsolicitacaosecretariadata_inicio').getValue();
							var $dateAte = xt('idsolicitacaosecretariadata_final').getValue();
							
							if(fn_getDateInt($dateDe) > fn_getDateInt($dateAte)){
								xt('idsolicitacaosecretariadata_final').setValue($dateDe);
							}
							
							fn_reloadStoreArquivoRetornoByData(
								fn_getDateString2(xt('idsolicitacaosecretariadata_inicio').getValue()), 
								fn_getDateString2(xt('idsolicitacaosecretariadata_final').getValue())
							);
						}
					}
				},'<b>Até: </b>',{
					xtype:'datefield',
					id:'idsolicitacaosecretariadata_final',
					width:100,
					value:today,
					listeners:{
						'select':function(a){
							
							var $dateDe = xt('idsolicitacaosecretariadata_inicio').getValue();
							var $dateAte = xt('idsolicitacaosecretariadata_final').getValue();
							
							if(fn_getDateInt($dateAte) < fn_getDateInt($dateDe)){
								
								xt('idsolicitacaosecretariadata_inicio').setValue($dateAte);
							}
							
							fn_reloadStoreArquivoRetornoByData(
								fn_getDateString2(xt('idsolicitacaosecretariadata_inicio').getValue()), 
								fn_getDateString2(xt('idsolicitacaosecretariadata_final').getValue())
							);
						}
					}
				},'-',{
					text:'Ver Todos',
					iconCls:'ico_search',
					handler:function(){
						fn_reloadStoreArquivoRetornoByData('1970-01-01','3000-01-01');
					}
				},'-',{
					xtype:'searcher',
					store:storesolicitacaocorporativa,
					style:'margin-left:20px;',
					emptyText:'Pesquisar...'
				},'->',{
					xtype:'displayfield',
					id:'iddfsolicitacaosecretariafinalizados'
				},'-',{
					xtype:'displayfield',
					id:'iddfsolicitacaosecretariapendente'
				},'-',{
					text:'Realizadas',
					id:'idsolicitacaosecretariabtnfiltroaprovados',
					tooltip:'Solicitações já realizadas pela secretaria',
					iconCls:'ico_accept',
					enableToggle:true,
					toggleHandler: function(button,state){
						
						var $btn = Ext.getCmp('idsolicitacaosecretariabtnfiltroaprovados');
						
						if (state == true) {	
							$btn.setText('Em espera');
							$btn.setIconClass('ico_Essen_consulting');	
							$btn.setTooltip('Solicitações em espera');
							storesolicitacaocorporativa.filter('instatus', true, true, false);
						}else{
							$btn.setText('Realizadas')
							$btn.setIconClass('ico_accept');	
							$btn.setTooltip('Solicitações já realizadas pela secretaria');
							storesolicitacaocorporativa.filter('instatus', false, true, false);
						}
					}
				}],
				listeners:{
					'rowclick':function(){
						var $gridrow = xt('idsolicitacaosecretariagridsolicitacaosecretaria').getSelectionModel().getSelected();
						
						showEditBtns($gridrow);
					},
					'dblclick':function(){
						if(xt('idwinsolicitacaosecretariasolicitacaocorporativa')){
							xt('idwinsolicitacaosecretariasolicitacaocorporativa').show();
						}else{
							new Ext.Window({
								title:'Solicitação Corporativa',
								id:'idwinsolicitacaosecretariasolicitacaocorporativa',
								width:500,
								height:600,
								autoScroll:true,
								modal:true,
								border:false,
								items:[{
									xtype:'panel',
									border:false,
									id:'idpanelsolicitacaosecretariasolicitacaocorporativa',
									listeners:{
										'afterrender':function(){
											
											var $gridrow = xt('idsolicitacaosecretariagridsolicitacaosecretaria').getSelectionModel().getSelected();
											xt('idpanelsolicitacaosecretariasolicitacaocorporativa').load({
												url:PATH+'/ajax/solicitacao_corporativa_load.php?'+new Date().getTime(),
												params:{
													idsolicitacaocorp:$gridrow.get('idsolicitacaocorp')
												},
												text: 'Carregando...',
												timeout: 30,
												scripts: true
											});
										}
									}
								}]
							}).show();
						}
					}
				}
			}]
		}]
	}]
}).show();
