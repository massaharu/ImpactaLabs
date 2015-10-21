<?
$GLOBALS['menu'] = true; $GLOBALS['wallpaper'] = true; $GLOBALS['BOOTSTRAP'] = false;//$GLOBALS['JSON'] = true; 
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
?>
<script type="text/javascript">
	Ext.onReady(function(){
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
		var IDPEDIDO = "";
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
			var Transferencia;
			var matricula;
			var status;
			
			var construct = function(){
				Treinamento 	= args.Treinamento;
				Aluno			= args.Aluno;
				Transferencia 	= args.Transferencia;
				Nfalterado		= args.Nfalterado;
				matricula		= args.matricula;
				status			= args.status;
			}
			
			this.getInstancia = function(){
				return {
					Treinamento		: Treinamento,
					Aluno			: Aluno,
					Transferencia 	: Transferencia,
					Nfalterado 		: Nfalterado,
					matricula 		: matricula,
					status			: status
				}
			}
			
			this.eraseInstancia = function(){
				Treinamento 	= "";
				Aluno			= "";
				Transferencia	= "";
				Nfalterado		= "";
				matricula		= "";
				status			= "";
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
			var motivoTransfer; //será setado se for transferência
			
			var inCadImpactaOnline; //Será setado true se for uma inscrição de treinamento no impacta online
			var inAlunoDesagendado; //Será setado true se for um desagendamento
			var inTreinReposicao; //Será setado true se for uma reposição
			var inTreinReagendado; //Será setado true se for um reagendamento
			var inTreinTransfer; //Será setado true se for uma troca de treinamento
			
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
				this.setInTreinTransfer(false);
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
					motivoTransfer			: this.getMotivoTransfer(),
					solicitacaoTreinTipo	: this.getSolicitacaoTreinTipo(),
					inCadImpactaOnline		: this.getInCadImpactaOnline(),
					inalunoDesagendado		: this.getInAlunoDesagendado(),
					inTreinReposicao		: this.getInTreinReposicao(),
					inTreinReagendado		: this.getInTreinReagendado(),
					inTreinTransfer			: this.getInTreinTransfer()
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
			
			this.getMotivoTransfer = function(){
				return motivoTransfer;
			};
			this.setMotivoTransfer = function($motivoTransfer){
				motivoTransfer = $.trim($motivoTransfer); return this;
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
			
			this.getInTreinTransfer = function(){
				return inTreinTransfer;
			};
			this.setInTreinTransfer = function($inTreinTransfer){
				inTreinTransfer = $.trim($inTreinTransfer); return this;
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
					this.setInTreinTransfer(false);
					
				}else if(solicitacaoTreinTipo == "desagendamento"){
					
					this.setInCadImpactaOnline(false);
					this.setInAlunoDesagendado(true);
					this.setInTreinReposicao(false);
					this.setInTreinReagendado(false);
					this.setInTreinTransfer(false);
					
				}else if(solicitacaoTreinTipo == "reposicao"){
					
					this.setInCadImpactaOnline(false);
					this.setInAlunoDesagendado(false);
					this.setInTreinReposicao(true);
					this.setInTreinReagendado(false);
					this.setInTreinTransfer(false);
					
				}else if(solicitacaoTreinTipo == "reagendamento"){
					
					this.setInCadImpactaOnline(false);
					this.setInAlunoDesagendado(false);
					this.setInTreinReposicao(false);
					this.setInTreinReagendado(true);
					this.setInTreinTransfer(false);
					
				}else if(solicitacaoTreinTipo == "transferencia"){
					
					this.setInCadImpactaOnline(false);
					this.setInAlunoDesagendado(false);
					this.setInTreinReposicao(false);
					this.setInTreinReagendado(false);
					this.setInTreinTransfer(true);
					
				}else{
					
					this.setInCadImpactaOnline(false);
					this.setInAlunoDesagendado(false);
					this.setInTreinReposicao(false);
					this.setInTreinReagendado(false);
					this.setInTreinTransfer(false);
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
					
				}else if($.trim($motivotipo).toLowerCase() == "transferencia"){
					this.setMotivoTransfer($motivo); return this;
					
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
					
				}else if($.trim($motivotipo).toLowerCase() == "transferencia"){
					return this.getMotivoTransfer();
					
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
		
		var Class_Transferencia = function(args){
			var matricula;
			var idpedido;
			var idcursosantigos;
			var descursosantigos;
			var vlrcursosantigos;
			var cortesia;
			var idcursosnovos;
			var descursosnovos;
			var idcursosagendadosnovos;
			var vlrcursosnovos;
			var vlrorcamentoantigo;
			var vlrorcamentonovo;
			var vlrorcamentodiferenca;
			var neworcamento;
			var qtdeparcela;
			var reposicao;
			var idalunosagendadosantigos;	
			var idcursosagendadosantigos;		                                                                                                                                                 
			var motivoTransferencia;
			
			 var construct = function(){
				matricula 				= args.matricula;
				idpedido				= args.idpedido;
				idcursosantigos			= args.idcursosantigos.toString();
				descursosantigos		= args.descursosantigos.toString();
				vlrcursosantigos		= args.vlrcursosantigos.toString();
				cortesia				= args.cortesia;
				idcursosnovos			= args.idcursosnovos.toString();
				descursosnovos			= args.descursosnovos.toString();
				idcursosagendadosnovos	= args.idcursosagendadosnovos.toString();
				vlrcursosnovos			= args.vlrcursosnovos.toString();
				vlrorcamentoantigo		= (typeof(args.vlrorcamentoantigo) == "undefined")? 0 : ((Math.round(Number(args.vlrorcamentoantigo) * 100))/100);
				vlrorcamentonovo		= (typeof(args.vlrorcamentonovo) == "undefined")? 0 : args.vlrorcamentonovo;
				vlrorcamentodiferenca	= args.vlrorcamentodiferenca;
				neworcamento			= args.neworcamento;
				qtdeparcela				= args.qtdeparcela;
				reposicao				= args.reposicao;
				idalunosagendadosantigos = args.idalunosagendadosantigos.toString();
				idcursosagendadosantigos = args.idcursosagendadosantigos.toString();		
			}
			
			this.getInstancia = function(){
				return {
					matricula 				: matricula,
					idpedido				: idpedido,
					idcursosantigos			: idcursosantigos,
					descursosantigos		: descursosantigos,
					vlrcursosantigos		: vlrcursosantigos,
					cortesia				: cortesia,
					idcursosnovos			: idcursosnovos,
					descursosnovos			: descursosnovos,
					idcursosagendadosnovos	: idcursosagendadosnovos,
					vlrcursosnovos			: vlrcursosnovos,
					vlrorcamentoantigo		: vlrorcamentoantigo,
					vlrorcamentonovo		: vlrorcamentonovo,
					vlrorcamentodiferenca	: vlrorcamentodiferenca,
					neworcamento			: neworcamento,
					qtdeparcela				: qtdeparcela,
					reposicao				: reposicao,
					idalunosagendadosantigos : idalunosagendadosantigos,
					idcursosagendadosantigos : idcursosagendadosantigos
				}
			}
			
			this.destructTransferencia = function(){
				matricula 				= "";
				idpedido				= "";
				idcursosantigos			= "";
				descursosantigos		= "";
				vlrcursosantigos		= "";
				cortesia				= "";
				idcursosnovos			= "";
				descursosnovos			= "";
				idcursosagendadosnovos	= "";
				vlrcursosnovos			= "";
				vlrorcamentoantigo		= "";
				vlrorcamentonovo		= "";
				vlrorcamentodiferenca	= "";
				neworcamento			= "";
				qtdeparcela				= "";
				reposicao				= "";
				idalunosagendadosantigos = "";
				idcursosagendadosantigos = "";
			}
			
			if(typeof(args) != "undefined") construct();
		}
		////////////// INSTANCIA GLOBAL DAS CLASSES /////////////////////////////////////
		
		var Aluno = new Class_Aluno();
		var Treinamento = new Class_Treinamento();
		var AlterarNF = new Class_AlterarNF();
		var Transferencia = new Class_Transferencia();
		
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
				{name:'isempresa', type:'bit'},
				{name:'idpedido', type:'bit'}
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
				{name:'desinstrutor'},
				{name:'idpedidocurso', type: 'int'},
				{name:'idpedido', type: 'int'},
				{name:'tabela', type: 'int'},
				{name:'perc', type: 'int'},
				{name:'unitario', type: 'int'},
				{name:'total', type: 'float'},
				{name:'qtde', type: 'float'},
				{name:'inreposicao', type:'bit'}
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
				{name:'intreinamentotransfer', type:'bit'},
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
		
		//Store com os cursos selecionados para transferencia
		var myStoreOrcamentoCursosSelecionados = new Ext.data.ArrayStore({
			fields: [
				{name: 'matricula'},
				{name: 'idpedidocurso'},
				{name: 'idpedido'},
				{name: 'idcurso'},
				{name: 'descurso'},
				{name: 'tabela', type: 'float'},
				{name: 'perc'},
				{name: 'unitario', type: 'float'},
				{name: 'total', type: 'float'},
				{name: 'qtde', type: 'int'},
				{name: 'idalunoagendado', type: 'int'}
			]
		});
		
		//Store com os novos cursos escolhidos
		var myStoreOrcamentoCursosNovos = new Ext.data.ArrayStore({
			fields: [
				{name: 'idcurso'},
				{name: 'descurso'},
				{name: 'vlcurso'},
				{name: 'idcursoagendado'},
				{name: 'dtinicio', type: 'date', dateFormat: 'timestamp'},
				{name: 'dttermino', type: 'date', dateFormat: 'timestamp'},
				{name: 'idperiodo'},
				{name: 'desperiodo'},
				{name: 'idsala'}
			]
		});
		
		//Store com os cursos agendados de um determinado curso selecionado
		var myStoreCursoTreinamentosMarcados = new Ext.data.JsonStore({
			url: PATH+'/json/orcamentoCursoTreinamentosMarcadosList.php',
			root: 'myData',
			fields: [
				{name: 'idcursoagendado'},
				{name: 'idcurso'},
				{name: 'descurso'},
				{name: 'dtinicio', type: 'date', dateFormat: 'timestamp'},
				{name: 'dttermino', type: 'date', dateFormat: 'timestamp'},
				{name: 'idperiodo'},
				{name: 'desperiodo'},
				{name: 'idsala'},
				{name: 'idinstrutor'},
				{name: 'desobs'},
				{name: 'qtcargahoraria'},
				{name: 'nrcargahoraria'},
				{name: 'inturmafechada'},
				{name: 'dtcadastro'},
				{name: 'qtdevagas'},
				{name: 'nminstrutor'}
			],
			listeners: {
				//Após trocar os dados do store
				'load': function(){
					//Chama função que filtra o store
					treinamentosMarcadosFilter();
				}
			}
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
		
		function getMessageSolicitacaoNaoRealizada(msgs){
											
			var $title = "";
			
			$title += (!msgs.reagendamento.success)? msgs.reagendamento.title+" / " : "";
			$title += (!msgs.desmembramento.success)? msgs.desmembramento.title+" / " : "";
			$title += (!msgs.desagendamento.success)? msgs.desagendamento.title+" / " : "";
			$title += (!msgs.cadimpactaonline.success)? msgs.cadimpactaonline.title+" / " : "";
			$title += (!msgs.reposicao.success)? msgs.reposicao.title+" / " : "";
			$title += (!msgs.transferencia.success)? msgs.transferencia.title+" / " : "";
			
			if($.trim($title) != ""){
				
				ms.warning(
					"O "+$title+" não pode(puderam) ser finalizado(s)", 
					msgs.desmembramento.msg+"<br /><br />"+
					msgs.reagendamento.msg+"<br /><br />"+
					msgs.desagendamento.msg+"<br /><br />"+
					msgs.cadimpactaonline.msg+"<br /><br />"+
					msgs.reposicao.msg+"<br /><br />"+
					msgs.transferencia.msg
				);
			}
		}
		
		function fn_disableToggleButtons(){
			xt('idsolicitacaosecretarianrvagas').setValue('');
			xt('idsolicitacaosecretarianralunos').setValue('');
			
			var $btnemaberto = xt('idsolicitacaosecretariabtnemaberto');
			var $btntransfer = xt('idsolicitacaosecretariatransfer');
			var $btncertificado = xt('idsolicitacaosecretariabtncertificado');
			var $btnpresenca = xt('idsolicitacaosecretariabtnpresenca');
			var $btndesagendamento = xt('idsolicitacaosecretariadesagendar');
			
			var $arr_btns = [$btnemaberto, $btncertificado, $btnpresenca, $btndesagendamento, $btntransfer];
			
			$.each($arr_btns, function(){
				if(this.pressed){
					this.toggle();
				}
			});
		}
		
		function fn_unableToggleButtons(){
			xt('idsolicitacaosecretarianrvagas').setValue('');
			xt('idsolicitacaosecretarianralunos').setValue('');
			
			var $btnemaberto = xt('idsolicitacaosecretariabtnemaberto');
			var $btncertificado = xt('idsolicitacaosecretariabtncertificado');
			var $btnpresenca = xt('idsolicitacaosecretariabtnpresenca');
			var $btndesagendamento = xt('idsolicitacaosecretariadesagendar');
			var $cadimpactaonline = xt('idsolicitacaosecretariaimpactaonline');
			
			var $arr_btns = [$btnemaberto, $btncertificado, $btnpresenca, $btndesagendamento, $cadimpactaonline];
			
			$.each($arr_btns, function(){
				if(this.pressed){
					this.toggle();
				}
				this.disable();
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
				xt('idsolicitacaosecretariatransfer').enable();
			}else{
				xt('idsolicitacaosecretariabtncertificado').disable();
				xt('idsolicitacaosecretariabtnpresenca').disable();
				xt('idsolicitacaosecretariaimpactaonline').disable();
				xt('idsolicitacaosecretariadesagendar').disable();
				xt('idsolicitacaosecretariatransfer').disable();
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
		
		function fn_reagendamentodatasLoad(obj){
			var mask = new Ext.LoadMask(xt('idsolicitacaosecretariagridreagendamentomatricula').body,{msg:'Aguarde...'});
				
			var $inemaberto  = (xt('idsolicitacaosecretariabtnemaberto').pressed)? 1 : 0;
			var $intransfer  = (xt('idsolicitacaosecretariatransfer').pressed)? 1 : 0;
			
			var $rowData = xt('idsolicitacaosecretariagridtreinamentomatricula').getSelectionModel().getSelected();
			
			var idcurso = $rowData.get('idcurso');
			
			if($intransfer){
				var $titlepaneltipo = "Transferir";
			}else{
				var $titlepaneltipo = "Reagendar";
			}
			
			$titlepanelreagendamento = 
				($inemaberto)? $titlepaneltipo+" para o Treinamento aberto: " : $titlepaneltipo+" Treinamento para: ";
				
			xt('idsolicitacaosecretariagridreagendamentomatricula').setTitle($titlepanelreagendamento);			
			
			if($rowData){
				
				xt('idsolicitacaosecretariabtnemaberto').enable();
				xt('idsolicitacaosecretariatransfer').enable();
				mask.show();
				
				storereagendamentotreinamentomatricula.reload({
					params:{
						idcurso: idcurso,
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
				xt('idsolicitacaosecretariatransfer').disable();
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
			Transferencia.destructTransferencia();
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
				Transferencia.destructTransferencia();
				Treinamento.setInTreinTransfer(false);
				Treinamento.setTreinamento_atual('');
				Treinamento.setTreinamento_novo('');
				Treinamento.setMotivoReagendamento('');
				Treinamento.setMotivoDesagendamento('');
				Treinamento.setMotivoTransfer('');
				
				storetreinamentomatricula.removeAll();
				storereagendamentotreinamentomatricula.removeAll();
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
						IDPEDIDO = a[0].get('idpedido');
						mask1.hide();
						fn_resetAllData();
						fn_disableAllComponents();
					}else{
						MATRICULA = "";
						IDPEDIDO = "";
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
		
		//Função que chama .php para fazer a tranferencia
		function alunoTransferir(matricula, idpedido, idcursosantigos, descursosantigos, vlrcursosantigos, iscortesia, idcursosnovos, descursosnovos, idcursosagendadosnovos, vlrcursosnovos, vlrorcamentoantigo, vlrorcamentonovo, diferenca, neworcamento, qtdeparcela, reposicao, idalunosagendadosantigos, idcursosagendadosantigos){
			
			//console.log(vlrorcamentoantigo, vlrorcamentonovo);
			Transferencia = new Class_Transferencia({
				matricula					: matricula,
				idpedido					: idpedido,
				idcursosantigos				: idcursosantigos,
				descursosantigos			: descursosantigos,
				vlrcursosantigos			: vlrcursosantigos,
				cortesia					: iscortesia,
				idcursosnovos				: idcursosnovos,
				descursosnovos				: descursosnovos,
				idcursosagendadosnovos		: idcursosagendadosnovos,
				vlrcursosnovos				: vlrcursosnovos,
				vlrorcamentoantigo			: vlrorcamentoantigo,
				vlrorcamentonovo			: (vlrorcamentonovo = vlrorcamentoantigo) /*igualar orçamento antigo com o novo*/,
				vlrorcamentodiferenca		: diferenca,
				neworcamento				: neworcamento,
				qtdeparcela					: qtdeparcela,
				reposicao					: reposicao,
				idalunosagendadosantigos	: idalunosagendadosantigos,
				idcursosagendadosantigos	: idcursosagendadosantigos
			});
			
			//Desabilita o botao
			Ext.getCmp('idButtonConfirmarTransferencia').disable();			
			//Muda o texto do botao
			Ext.getCmp('idButtonConfirmarTransferencia').setText('Carregando');			
			//Muda o icone bo botao
			Ext.getCmp('idButtonConfirmarTransferencia').setIconClass('ico_loading');
			
			new Ext.Window({
				id:'winsolicitacaosecretariatransfermotivo',
				title:"Deseja inserir o motivo da transferência?",
				iconCls:'ico_Stuttgart_tag',
				autoHeight:true,
				width:400,
				items:[{
					xtype:'form',
					border:false,
					padding:5,
					id:'idformsolicitacaosecretariatransfermotivo',
					items:[{
						xtype:'textarea',
						width:'98%',
						style:'margin-bottom:-5px',
						hideLabel:true,
						maxLength:1000,
						name:'justificativa',
						emptyText:'Escreva aqui o motivo da transferência',
						id:'idtxtsolicitacaosecretariatransfermotivo',
					}]
				}],
				buttons:['->',{
					text:'Salvar Motivo',
					scale:'medium',
					iconCls:'ico_save',
		
					handler:function(){
						var $motivo = $.trim(xt('idtxtsolicitacaosecretariatransfermotivo').getValue());
						
						if($motivo){
							
							Treinamento.setSolicitacaoTreinTipo('transferencia');
							Treinamento.setMotivo($motivo);
							
							//Fecha a janela atual
							xt('idWindowTransferencia').close();
							xt('winsolicitacaosecretariatransfermotivo').close();
							
							//Limpa o store
							myStoreCursoTreinamentosMarcados.removeAll();
							
						}else{
							ms.warning("Aviso!", "Favor, insira um motivo");
						}
					}
				},'-',{
					text:'Agendar transferência sem Motivo',
					scale:'medium',
					iconCls:'ico_Exit',
					handler:function(){
						
						Treinamento.setSolicitacaoTreinTipo('transferencia');
						Treinamento.setMotivo("");
						
						//Fecha a janela atual
						xt('idWindowTransferencia').close();
						xt('winsolicitacaosecretariatransfermotivo').close();
						
						//Limpa o store
						myStoreCursoTreinamentosMarcados.removeAll();
					}
				}]
			}).show();
			//Chama .php que faz a transferencia
			/*Ext.Ajax.request({
				url: '/simpacweb/modulos/secretaria/transferenciaAlunoCurso/v4/json/orcamentoTransferenciaSave.php',
				params: {
					matricula: matricula,
					idpedido: idpedido,
					idcursosantigos: idcursosantigos.toString(),
					descursosantigos: descursosantigos.toString(),
					vlrcursosantigos: vlrcursosantigos.toString(),
					cortesia: iscortesia,
					idcursosnovos: idcursosnovos.toString(),
					descursosnovos: descursosnovos.toString(),
					idcursosagendadosnovos: idcursosagendadosnovos.toString(),
					vlrcursosnovos: vlrcursosnovos.toString(),
					vlrorcamentoantigo: ((Math.round(Number(vlrorcamentoantigo) * 100))/100),
					vlrorcamentonovo: vlrorcamentonovo,
					vlrorcamentodiferenca: diferenca,
					neworcamento: neworcamento,
					qtdeparcela: qtdeparcela,
					reposicao: reposicao
				},
				success: function(re){
					re = (JSON.parse(re.responseText).myData);
					
					//Variável necessária
					var msg = 'A tranferencia foi feita com sucesso';
					
					//Avisa o usuário
					if (neworcamento){
						msg += ' e um novo Orçamento com o numero "<span style="font-weight: bold;">'+ re +'</span>" foi criado.';
					}
					else {
						msg += '.';
					}
					
					Ext.MessageBox.alert('Aviso', msg);
					
					//Fecha a janela atual
					Ext.getCmp('idWindowTransferencia').close();
					
					//Limpa o store
					myStoreCursoTreinamentosMarcados.removeAll();
					
					//Atualiza o store base
					myStoreOrcamentoCursos.reload();
				}
			});*/
		}
		
		//Função que filtra o store de treinamentos marcados
		function treinamentosMarcadosFilter(){
			//Pega o store e filtra os dados
			myStoreCursoTreinamentosMarcados.filterBy(function(rec, id){
				//Só retorna o treinamento se houver vaga
				if (rec.get("qtdevagas") > 0){
					return rec;
				}
			});
		}
		
		//Função que calcula e mostra o valor do novo orcamento
		function calcValorNovoOrcamento(){
			//Variavel com o valor atual do orcamento
			var valorAtual = (Number(Ext.getCmp('idDisplayfieldValorOrcamentoAtual').getValue().substring(3).replace(".", "").replace(",", ".")));
			var valorCursosRetirados = 0;
			var valorCursosAdicionados = 0;
			
			//Soma o valor dos cursos que serão retirados
			$.each(myStoreOrcamentoCursosSelecionados.data.items, function(a, b){
				valorCursosRetirados += (Math.round(Number(b.get('total')) * 100))/100;
			});
			
			if (myStoreOrcamentoCursosNovos.data.length < 1){
				//Atribui na variável o valor do novo orcamento
				var orcamentoNovoValor = 0;
				
				//Diferenca entre os orcamentos
				var diferenca = 0;
				
				//console.log('first', orcamentoNovoValor);
				//Mostra o valor para o usuário
				Ext.getCmp('idDisplayfieldValorNovoOrcamento').setValue(Ext.util.Format.brMoney(orcamentoNovoValor));
				
				//Mostra a diferenca para o usuário
				Ext.getCmp('idDisplayfieldDiferencaOrcamento').setValue('<span style="font-style: italic; font-weight: bold; margin-top: 25px; margin-bottom: 25px; color: black;">'+ (diferenca) +'</span>');
			}
			else {
				//Soma o valor dos cursos que serão adicionados
				$.each(myStoreOrcamentoCursosNovos.data.items, function(a, b){
					valorCursosAdicionados += b.get('vlcurso');
				});
				
				//Atribui na variável o valor do novo orcamento
				var orcamentoNovoValor = ((Math.round(Number((valorAtual - valorCursosRetirados) + valorCursosAdicionados) * 100))/100);
				//console.log('second', orcamentoNovoValor);
				//Diferenca entre os orcamentos
				var diferenca = ((Math.round(Number(orcamentoNovoValor - valorAtual) * 100))/100);
				
				//Mostra o valor para o usuário
				Ext.getCmp('idDisplayfieldValorNovoOrcamento').setValue(Ext.util.Format.brMoney(orcamentoNovoValor));
				
				//Cor da fonte
				var cor = "";
				
				if (diferenca > 0){
					cor = "red";
				}
				else if (diferenca < 0) {
					cor = "green";
				}
				else {
					cor = "blue";
				}
				
				//Mostra a diferenca para o usuário
				Ext.getCmp('idDisplayfieldDiferencaOrcamento').setValue('<span style="font-style: italic; font-weight: bold; margin-top: 25px; margin-bottom: 25px; color: '+ cor +';">'+ ((diferenca > 0) ?'+' :'') + Ext.util.Format.brMoney(diferenca) +'</span>');
			}
			
			return orcamentoNovoValor;
		}
		
		//Função que abre janela de seleção de curso
		function openWindowAddCurso(rec, iscortesia, reposicao, newCortesia){
			//Esta função só é necessário dentro deste escopo
			function showInfoCurso(idcursoselecionado, curso, rec, reposicao){
				//Verifica se é o mesmo curso do selecionado para transferencia
				if (rec[0].get('idcurso') == idcursoselecionado){
					//Mostra o valor para o usuário
					Ext.getCmp('idDisplayfieldValorNovoTreinamento').setValue(Ext.util.Format.brMoney(Number(curso.vltotal)));
					
					//Seta o valor máximo nos campos de alteração
					Ext.getCmp('idSliderfieldAlterarValorNovoTreinamento').maxValue = ((Math.round((Number(rec[0].get('total')) + ((rec[0].get('total')) / 2)) * 100))/100);
					Ext.getCmp('idNumberfieldValorParaOrcamento').maxValue = ((Math.round((Number(rec[0].get('total')) + ((rec[0].get('total')) / 2)) * 100))/100);
						
					//Verifica se não é reposição
					if (!reposicao){				
						//Bloqueia a alteração do valor final do Treinamento e mostra o valor
						Ext.getCmp('idSliderfieldAlterarValorNovoTreinamento').disable().setValue(Number(rec[0].get('total')));
						Ext.getCmp('idNumberfieldValorParaOrcamento').disable().setValue(Number(rec[0].get('total')));
					}
					else {
						/*//Liberar a alteração do valor final do Treinamento e mostra o valor
						Ext.getCmp('idSliderfieldAlterarValorNovoTreinamento').enable().setValue(Number(rec[0].get('total')));
						Ext.getCmp('idNumberfieldValorParaOrcamento').enable().setValue(Number(rec[0].get('total')));*/
						
						//Bloqueia a alteração do valor final do Treinamento e mostra o valor
						Ext.getCmp('idSliderfieldAlterarValorNovoTreinamento').disable().setValue(0);
						Ext.getCmp('idNumberfieldValorParaOrcamento').disable().setValue(0);
					}
					
				}
				else {
					//Mostra o valor para o usuário
					Ext.getCmp('idDisplayfieldValorNovoTreinamento').setValue(Ext.util.Format.brMoney(Number(curso.vltotal)));
					
					//Seta o valor máximo nos campos de alteração
					Ext.getCmp('idSliderfieldAlterarValorNovoTreinamento').maxValue = ((Math.round((Number(curso.vltotal) + ((curso.vltotal) / 2)) * 100))/100);
					Ext.getCmp('idNumberfieldValorParaOrcamento').maxValue = ((Math.round((Number(curso.vltotal) + ((curso.vltotal) / 2)) * 100))/100);
					
					//Verifica se não é inserção de cortesia
					if (!newCortesia){
						//Liberar a alteração do valor final do Treinamento e mostra o valor
						Ext.getCmp('idSliderfieldAlterarValorNovoTreinamento').enable().setValue(Number(curso.vltotal));
						Ext.getCmp('idNumberfieldValorParaOrcamento').enable().setValue(Number(curso.vltotal));
					}
					else {
						//Liberar a alteração do valor final do Treinamento e mostra o valor
						Ext.getCmp('idSliderfieldAlterarValorNovoTreinamento').disable().setValue(0);
						Ext.getCmp('idNumberfieldValorParaOrcamento').disable().setValue(0);
					}
				}
				
				//Carrega o Store de treinamentos marcados para este determinado curso
				myStoreCursoTreinamentosMarcados.load({
					params: {
						idcurso: idcursoselecionado
					}
				});
			}
			
			//Cria o CheckBox para os possíveis treinemantos marcados em que o aluno poderá ser transferido
			var checkGridCursoTreinamentosMarcados = new Ext.grid.CheckboxSelectionModel({
				singleSelect: true
			});
			
			//Janela de seleção de curso
			var windowTransferenciaSelecaoCurso = new Ext.Window({
				title: 'Janela de Seleção de Curso',
				id: 'idWindowTransferenciaSelecaoCurso',
				iconCls: 'ico_curso',
				modal: true,
				height: 400,
				width: 600,
				layout: 'fit',
				autoScroll: true,
				items: [{
					xtype: 'form',
					id: 'idFormTransferenciaSelecaoCurso',
					padding: 10,
					autoScroll: true,
					items: [{
						xtype: 'fieldset',
						title: 'Novo Treinemanto para Troca',
						iconCls: 'ico_curso_redes',
						labelWidth: 260,
						items: [{
							xtype: 'combo',
							id: 'idComboNovoCursoSelecionado',
							store: new Ext.data.JsonStore({
								url: PATH+'/json/orcamentoComboCursosList.php',
								root: 'myData',
								autoLoad: true,
								baseParams: {
									cortesia: iscortesia
								},
								fields: [{
									name: 'idcurso'
								},
								{
									name: 'descurso'
								}]
							}),
							triggerAction: 'all',
							typeAhead: true,
							valueField: 'idcurso',
							displayField: 'descurso',
							hideLabel: true,
							forceSelection: true,
							selectOnFocus: true,
							editable: true,
							mode: 'local',
							anchor: '100%',
							allowBlank: false,
							listeners: {
								//Quando selecionar um treinamento
								'select': function(combo, record, index){
									//Chama .php que obtem informações sobre o curso selecionado
									Ext.Ajax.request({
										url: PATH+'/json/cursoInfoGet.php',
										params: {
											idcurso: record.get('idcurso')
										},
										success: function(value){
											//Trata as informações do Treinamento escolhido
											var curso = (JSON.parse(value.responseText).myData);
											
											//Verifica se no caso de haver mais de um curso selecionado para troca, não deixar que o novo curso seja o mesmo de algum dos selecionados
											if (rec.length > 1){
												//Variável controladora
												var exist = false;
												
												$.each(rec, function(a, b){
													//Verifica se é o mesmo curso
													if (record.get('idcurso') == b.get('idcurso')){
														exist = true;
													}
												});
												
												//Verifica se á para carrefar informação ou mostrar mensagem de erro para o usuário
												if (!exist){
													//Chama função que mostra as informações
													showInfoCurso(record.get('idcurso'), curso, rec, false);
												}
												else {
													//Avisa o usuário
													Ext.MessageBox.erro('Erro', 'Você está tentando trocar '+ rec.length +' cursos para o treinamento de <span style="font-weight: bold;">'+ record.get('descurso') +'</span>, sendo este um dos treinamentos selecionado para ser trocado.');
												}
											}
											else {
												//Chama função que mostra as informações
												showInfoCurso(record.get('idcurso'), curso, rec, false);
											}
										}
									});
								}
							}
						},
						{
							xtype: 'displayfield',
							fieldLabel: 'Valor BASE do Treinamento',
							id: 'idDisplayfieldValorNovoTreinamento',
							style: 'font-style: italic;',
							value: Ext.util.Format.brMoney('0.00')
						},
						{
							xtype: 'numberfield',
							fieldLabel: 'Alterar valor do Treinamento',
							id: 'idNumberfieldValorParaOrcamento',
							allowBlank: false,
							maxValue: ((Math.round((Number(rec[0].get('total')) + ((rec[0].get('total')) / 10)) * 100))/100),
							minValue: 0.00,
							disabled: true,
							style: 'font-weight: bold;',
							value: 0.0,
							enableKeyEvents: true,
							listeners: {
								//Quando digitar algo
								'keyup': function (t, e){
									//Obtem o valor no componente
									var vl = Ext.getCmp('idNumberfieldValorParaOrcamento').getValue();
									
									//Só é aceito o valor entre 0 e 10% to valor total do treinamento selecionado
									if ((vl >= 0) && (vl <= Ext.getCmp('idNumberfieldValorParaOrcamento').maxValue)){
										//Seta o valor no Slider
										Ext.getCmp('idSliderfieldAlterarValorNovoTreinamento').setValue(vl, true);
									}
									else if (vl.length == 0){
										
									}
									else {
										//Se o valor fugir do intervalo aceito
										Ext.Msg.erro('Aviso', 'Valor muito acima do valor base do Treinamento!');
									}
								}
							}
						},
						new Ext.slider.SingleSlider({
							id: 'idSliderfieldAlterarValorNovoTreinamento',
							hideLabel: true,
							maxValue: ((Math.round((Number(rec[0].get('total')) + ((rec[0].get('total')) / 10)) * 100))/100),
							minValue: 0.00,
							increment: 0.01,
							disabled: true,
							value: 0,
							listeners: {
								//Quando completar a alteração
								'changecomplete': function(slider, newValue, thumb){
									//Alterar o valor do outro componente
									Ext.getCmp('idNumberfieldValorParaOrcamento').setValue(Ext.getCmp('idSliderfieldAlterarValorNovoTreinamento').getValue());
								}
							}
						}),
						{
							xtype: 'spacer',
							height: 15
						},
						{
							xtype: 'grid',
							id: 'idGridCursoTreinamentosMarcados',
							store: myStoreCursoTreinamentosMarcados,
							height: 150,
							autoScroll: true,
							loadMask: true,
							sm: checkGridCursoTreinamentosMarcados,
							viewConfig: {
								getRowClass: function(r){
									var retorno = '';
									
									if (!r.get('dtinicio')){
										retorno = 'cls_turmafechada ';
									}
									else if (r.get('inturmafechada') == 1){
										retorno = 'blue ';
									}
									
									return retorno;
								}
							},
							columns: [
							checkGridCursoTreinamentosMarcados,
							{
								header: '<center><b>Inicio</b></center>',
								xtype: 'datecolumn',
								format: 'd/m/Y H:i',
								width: 145,
								dataIndex: 'dtinicio'
								
							},
							{
								header: '<center><b>Termino</b></center>',
								xtype: 'datecolumn',
								format: 'd/m/Y H:i',
								width: 145,
								dataIndex: 'dttermino'
							},
							{
								header: '<center><b>Vagas</b></center>',
								width: 100,
								dataIndex: 'qtdevagas'
							},
							{
								header: '<center><b>Instrutor</b></center>',
								width: 150,
								dataIndex: 'nminstrutor'
							},
							{
								header: '<center><b>Periodo</b></center>',
								width: 100,
								dataIndex: 'desperiodo'
							}]
						}]
					}]
				}],
				buttons: [{
					text: 'Adicionar',
					iconCls: 'ico_add',
					handler: function(){
						//Verifica se foi tudo preenchido
						if (Ext.getCmp('idFormTransferenciaSelecaoCurso').getForm().isValid()){
							//Verifica se selecionou algum treinamento marcado
							if (Ext.getCmp('idGridCursoTreinamentosMarcados').getSelectionModel().hasSelection()){
								//Variável controleadora que verifica se o curso selecionado já não foi adicionado
								var exist = false;
								
								//Verifica se não é inserção de cortesia
								if (!newCortesia){
									//Passa por cada curso já adicionado
									$.each(myStoreOrcamentoCursosNovos.data.items, function(a, b){
										//Verifica se o curso selecionado já foi selecionado
										if (b.get('idcurso') == Ext.getCmp('idComboNovoCursoSelecionado').getValue()){
											exist = true;
										}
									});
								}
								else {
									//Passa por cada curso já adicionado
									$.each(myStoreOrcamentoCursosCortesiaNovos.data.items, function(a, b){
										//Verifica se o curso selecionado já foi selecionado
										if (b.get('idcurso') == Ext.getCmp('idComboNovoCursoSelecionado').getValue()){
											exist = true;
										}
									});
								}
								
								//Se o curso ainda não foi escolhido, deixar adicionar, senão, avisar o usuário
								if (!exist){
									//Linha selecionada
									var selected = Ext.getCmp('idGridCursoTreinamentosMarcados').getSelectionModel().getSelected();
									
									//Guarda todos os valores em uma variável para adicionar no store							
									var record = new Ext.data.Record({
										idcurso: selected.get('idcurso'),
										descurso: Ext.getCmp('idComboNovoCursoSelecionado').lastSelectionText,
										vlcurso: Ext.getCmp('idNumberfieldValorParaOrcamento').getValue(),
										idcursoagendado: selected.get('idcursoagendado'),
										dtinicio: selected.get('dtinicio'),
										dttermino: selected.get('dttermino'),
										idperiodo: selected.get('idperiodo'),
										desperiodo: selected.get('desperiodo'),
										idsala: selected.get('idsala')
									});
									
									//Verifica se não é inserção de cortesia
									if (!newCortesia){
										//Adiciona no store
										myStoreOrcamentoCursosNovos.add(record);
									}
									else {
										//Adiciona no store
										myStoreOrcamentoCursosCortesiaNovos.add(record);
									}
									
									//Fecha a janela atual
									windowTransferenciaSelecaoCurso.close();
								}
								else {
									//Avisa o usuário que o curso já esta selecionado para o novo orçamento
									Ext.MessageBox.erro('Erro', 'O curso selecionado já foi adicionado para colocar no novo orçamento, portanto, não é possível adicionar novamente!');
								}
							}
							else {
								//Mensagem para o ususário
								Ext.MessageBox.erro('Erro', 'Deve-se selecionar um treinamento marcado!');
							}
						}
					}
				},
				{
					text: 'Fechar',
					iconCls: 'ico_fechar',
					handler: function(){
						//Fecha a janela atual
						windowTransferenciaSelecaoCurso.close();
					}
				}],
				listeners: {
					//Quando fechar a janela
					'close': function(){
						//Limpar o store de treinamentos marcados
						myStoreCursoTreinamentosMarcados.removeAll();
						
						//Verifica se não é inserção de cortesia
						if (!newCortesia){
							//Recalcula e mostra o valor do novo orçamento
							calcValorNovoOrcamento();
						}
					},
					//Apos carregar e renderizar a Window
					afterrender: function(){
						//Verifica se chamou a janela para selecionar uma reposição
						if (reposicao){
							//Mostra na Combo o curso
							Ext.getCmp('idComboNovoCursoSelecionado').setValue(rec[0].get('descurso'));
							
							//Bloqueia a combo
							Ext.getCmp('idComboNovoCursoSelecionado').disable();
							
							//Obtem informação do curso
							Ext.Ajax.request({
								url: PATH+'/json/cursoInfoGet.php',
								params: {
									idcurso: rec[0].get('idcurso')
								},
								success: function(value){
									//Trata as informações do Treinamento escolhido
									var curso = (JSON.parse(value.responseText).myData);
									
									//Mostra informação para o usuário
									showInfoCurso(rec[0].get('idcurso'), curso, rec, reposicao);
								}
							});
						}
					}
				}
			}).show();
		}
			
		//Função qeu abre a janela de transferencia
		function openWindowTransferencia(rec){
			//Ajax que chama .php para obter mais informações sobre o pedido
			Ext.Ajax.request({
				url: PATH+'/json/orcamentoInfoGet.php',
				params: {
					pedido: IDPEDIDO-15000
				},
				success: function(value){
					//Retorno
					var info = (JSON.parse(value.responseText).myData);
					//console.log(info);
					//Verifica se é cortesia ou não
					var isCortesia = (((trim(MATRICULA)).substring(0, 2) != '70') ?false :true);
					
					//Variavel que guarda o valor da matricula
					var matriculaInit = MATRICULA;
					
					//Soma o valor dos cursos escolhidos
					var somaValorCursosAntigos = 0;
					$.each(rec, function(a, b){
						somaValorCursosAntigos += b.get('total');
					});
					
					//Adiciona os cursos selecionados no store
					myStoreOrcamentoCursosSelecionados.add(rec);
					
					//Janela de transferencia
					var windowTransferencia = new Ext.Window({
						title: 'Janela de Transferência - Matrícula: '+matriculaInit,
						id: 'idWindowTransferencia',
						iconCls: 'ico_Stuttgart_sign-up',
						modal: true,
						height: 600,
						width: 700,
						layout: 'fit',
						autoScroll: true,
						items: [{
							xtype: 'form',
							id: 'idFormTransferencia',
							padding: 10,
							autoScroll: true,
							items: [{/*{
								xtype: 'fieldset',
								title: 'Matricula',
								iconCls: 'ico_matricula',
								labelWidth: 250,
								items: [{
									xtype: 'displayfield',
									anchor: '100%',
									hideLabel: true,
									style: 'font-weight: bold; font-size: 20px; text-align: center;',
									value: matriculaInit
								}]
							},*/
								xtype: 'fieldset',
								title: 'Nome: ',
								iconCls: 'ico_user',
								//labelWidth: 250,
								items: [{
									xtype:'compositefield',
									items:[{
										xtype: 'displayfield',
										value: '<b>Nome:</b>',
										width:50
									},{
										xtype: 'displayfield',
										width: '100%',
										//style: 'font-weight: bold;',
										value: ((info.nome) ?info.nome :' ')
									}]
								},{
									xtype:'compositefield',
									items:[{
										xtype: 'displayfield',
										value: '<b>E-mail:</b>',
										width:50
									},{
										xtype: 'displayfield',
										width: '100%',
										//style: 'font-weight: bold;',
										value: ((info.email) ?info.email :' ')
									}]
								},{
									xtype:'compositefield',
									items:[{
										xtype: 'displayfield',
										value: '<b>CNPJ:</b>',
										width:50
									},{
										xtype: 'displayfield',
										width:'100%',
										//style: 'font-weight: bold;',
										value: ((info.nrcgc) ?info.nrcgc :' ')
									}]
								}]
							},{
								xtype: 'compositefield',
								hideLabel:true,
								items:[{
									xtype: 'fieldset',
									title: 'Informações sobre o Orçamento',
									iconCls: 'ico_information',
									flex: 3,
									//labelWidth: 250,
									items: [{
										xtype:'compositefield',
										width: 300,
										items:[{
											xtype: 'displayfield',
											value: '<b>Orçamento:</b>',
											width:120
										},{
											xtype: 'displayfield',
											width:200,
											//style: 'font-weight: bold;',
											value: ((info.idpedido) + 15000)
										}]
									},{
										xtype: 'compositefield',
										width: 300,
										items:[{
											xtype: 'displayfield',
											value: '<b>Valor do Orçamento:</b>',
											width:120
										},{
											xtype: 'displayfield',
											id: 'idDisplayfieldValorOrcamentoAtual',
											width: 200,
											//style: 'font-weight: bold;',
											value: Ext.util.Format.brMoney(((info.valor) ?info.valor :0))
										}]
									}]
								},{
									xtype:'fieldset',
									title:'Informações sobre o NOVO orçamento',
									hidden: true,
									flex:4,
									iconCls:'ico_information',
									items: [{
										xtype:'compositefield',
										width: 300,
										items:[{
											xtype: 'displayfield',
											value: '<b>Valor do novo Orçamento:</b>',
											width:150
										},{
											xtype: 'displayfield',
											id: 'idDisplayfieldValorNovoOrcamento',
											style: 'font-style: italic; font-weight: bold;',
											width: '100%',
											value: Ext.util.Format.brMoney('0.00')
										}]
									},{
										xtype:'compositefield',
										width: 300,
										items:[{
											xtype: 'displayfield',
											value: '<b>Diferença:</b>',
											width:70
										},{
											xtype: 'displayfield',
											fieldLabel: 'Diferença',
											id: 'idDisplayfieldDiferencaOrcamento',
											width: '100%',
											style: 'font-style: italic; font-weight: bold;',
											value: 0
										}]
									}]
								}]
							},{								
								xtype: 'fieldset',
								title: ((rec.length == 1) ?'Sobre Curso selecionado' :'Sobre Cursos selecionados'),
								iconCls: 'ico_curso_parceiros',
								labelWidth: 250,
								items: [{
									xtype: 'grid',
									id: 'idGridOrcamentoCursosSelecionados',
									store: myStoreOrcamentoCursosSelecionados,
									height: 140,
									autoScroll: true,
									loadMask: true,
									viewConfig: {
										
									},
									columns: [{
										header: '<center><b>Curso</b></center>',
										width: 400,
										dataIndex: 'descurso'
									},{
										header: '<center><b>Valor</b></center>',
										width: 200,
										dataIndex: 'total',
										renderer: function(v){
											return Ext.util.Format.brMoney(v);
										}
									}],
								}]
							},{
								xtype: 'fieldset',
								title: 'Novo(s) Treinamento(s) para Troca',
								iconCls: 'ico_curso_redes',
								labelWidth: 250,
								items: [{
									xtype: 'grid',
									id: 'idGridOrcamentoCursosNovos',
									store: myStoreOrcamentoCursosNovos,
									height: 140,
									autoScroll: true,
									loadMask: true,
									style: {
										marginTop: '15px'
									},
									viewConfig: {
										getRowClass: function(r){
											var retorno = '';
											
											if (!r.get('dtinicio')){
												retorno = 'cls_turmafechada ';
											}
											
											return retorno;
										}
									},
									tbar: ['-',
									{
										text: 'Adicionar',
										iconCls: 'ico_add',
										id: 'idButtonNovoTreinamentoAdd',
										handler: function(){
											//Chama função que acrescenta curso para alteração do orcamento
											openWindowAddCurso(rec, isCortesia, false, false);
										}
									},
									'-',
									{
										text: 'Remover',
										iconCls: 'ico_delete',
										id: 'idButtonNovoTreinamentoRemove',
										handler: function(){
											//Verifica se foi selecionada alguma linha
											if (Ext.getCmp('idGridOrcamentoCursosNovos').getSelectionModel().hasSelection()){
												//Remove a linha selecionada
												myStoreOrcamentoCursosNovos.remove(Ext.getCmp('idGridOrcamentoCursosNovos').getSelectionModel().getSelected());
												
												//Mostra o valor do orcamento
												calcValorNovoOrcamento();
											}
										}
									},
									'-',
									'->',
									'-',
									{
										text: 'Remover tudo',
										iconCls: 'ico_remove',
										id: 'idButtonNovoTreinamentoRemoveAll',
										handler: function(){
											//Remove todos os dados do Store
											myStoreOrcamentoCursosNovos.removeAll();
											
											//Mostra o valor do orcamento
											calcValorNovoOrcamento();
										}
									},
									'-'],
									columns: [{
										header: '<center><b>Curso</b></center>',
										width: 200,
										dataIndex: 'descurso'
									},
									{
										header: '<center><b>Valor</b></center>',
										width: 100,
										dataIndex: 'vlcurso',
										renderer: function(v){
											return Ext.util.Format.brMoney(v);
										}
									},
									{
										header: '<center><b>Inicio</b></center>',
										xtype: 'datecolumn',
										format: 'd/m/Y H:i',
										width: 145,
										dataIndex: 'dtinicio'
									},
									{
										header: '<center><b>Fim</b></center>',
										xtype: 'datecolumn',
										format: 'd/m/Y H:i',
										width: 145,
										dataIndex: 'dttermino'
									},
									{
										header: '<center><b>Período</b></center>',
										width: 100,
										dataIndex: 'desperiodo'
									}],
								}]
							}]
						}],
						buttons: [{
							text: 'Transferir',
							id: 'idButtonConfirmarTransferencia',
							iconCls: 'ico_Stuttgart_sign-in',
							handler: function(){
								//Verifica se preencheu as informações necessárias referente ao formulário
								if (Ext.getCmp('idFormTransferencia').getForm().isValid()){
									//Verifica se foi adicionado algum curso para o novo orçamento
									if (myStoreOrcamentoCursosNovos.data.length > 0){//Exige a confirmação do usuário
										//Exige a confirmação do usuário
										Ext.MessageBox.confirm('Aviso', 'Tem certeza que deseja fazer a transferência mudando o Orçamento?', function(answer){
											if (answer == 'yes'){
												//Array com os id e nome dos cursos antigos
												var arrayIdCursosAntigos = [];
												var arrayDesCursosAntigos = [];
												var arrayVlrCursosAntigos = [];
												var arrarIdAlunosAgendadosAntigos = [];
												var arrayIdCursosAgendadosAntigos = [];
												
												//Array com os id, nomes e idcursos agendados dos novos cursos
												var arrayIdCursosNovos = [];
												var arrayDesCursosNovos = [];
												var arrayIdCursosAgendadosNovos = [];
												var arrayVlrCursosNovos = [];
												
												//Variável com a diferença entre o orcamento novo e o antigo
												var diferenca = ((Math.round(Number((calcValorNovoOrcamento() - ((Math.round(Number(info.valor) * 100))/100))) * 100))/100);
												//console.log('diferenca', diferenca);
												var dif = diferenca;
												
												//Variável que guarda a informação se é um novo orcamento ou não
												var newOrcamento = true;
												
												//Passa por cada posição dos cursos antigos
												$.each(rec, function(a, b){
													arrayIdCursosAntigos.push(b.get('idcurso'));
													arrayDesCursosAntigos.push(b.get('descurso'));
													arrayVlrCursosAntigos.push(b.get('total'));
													arrarIdAlunosAgendadosAntigos.push(b.get('idalunoagendado'));
													arrayIdCursosAgendadosAntigos.push(b.get('idcursoagendado'));
												});
												
												//Passa por cada posição dos novos cursos
												$.each(myStoreOrcamentoCursosNovos.data.items, function(a, b){
													arrayIdCursosNovos.push(b.get('idcurso'));
													arrayDesCursosNovos.push(b.get('descurso'));
													arrayIdCursosAgendadosNovos.push(b.get('idcursoagendado'));
													arrayVlrCursosNovos.push(b.get('vlcurso'));
												});
												
												//Verifica se é uma trasferencia 1 x 1 e para o mesmo treinamento
												if (rec.length == 1){
													if (myStoreOrcamentoCursosNovos.data.length == 1){
														if (rec[0].get('idcurso') == myStoreOrcamentoCursosNovos.data.items[0].get('idcurso')){
															newOrcamento = false;
														}
													}
												};
																																			
												//Se o valor for maior, perguntar em quantas vezes a diferença deve ser paga
												if ((diferenca = 0 /* forçando a diferença para 0 */)  > 0){
													//Variável com a quantidade de parcelas que o valor a mais será dividido
													var qtdeParcela = 1;
													
													//Chama .php que verifica se pode mudar este orçamento
													Ext.Ajax.request({
														url: PATH+'/json/orcamentoInformacaoParaTransferir.php',
														params: {
															idpedido: rec[0].get('idpedido')
														},
														success: function(value){
															//Obtem informação se pode alterar esse orçamento ou não
															var podeAlterar = (JSON.parse(value.responseText).myData);
															
															//Verifica se pode ou não alterar este orçamento
															if (podeAlterar == "false"){
																//Avisa o usuário que ele não pode alterar a matricula
																Ext.MessageBox.alert('Aviso', 'Não é permitido alterar este orçamento, por favor, entrar em conntato com o Desenvolvimento.')
															}
															else {
																//Abre janela de seleção de parcelas
																new Ext.Window({
																	title: 'Seleção de Parcelas',
																	id: 'idWindowSelecaoParcelas',
																	iconCls: 'ico_money',
																	modal: true,
																	height:457,
																	width: 400,
																	layout: 'fit',
																	autoScroll: true,
																	items: [{
																		xtype: 'form',
																		id: 'idFormSelecaoParcelas',
																		padding: 10,
																		autoScroll: true,
																		items: [{
																			xtype: 'fieldset',
																			title: '',
																			items: [{
																				xtype: 'radiogroup',
																				fieldLabel: 'Parcelas',
																				allowBlank: false,
																				id: 'idRadioSelecaoParcelas',
																				columns: 2,
																				vertical: true,
																				items: [{
																					boxLabel: '1x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas1',
																					inputValue: 1,
																					checked: true
																				},
																				{
																					boxLabel: '2x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas2',
																					inputValue: 2
																				},
																				{
																					boxLabel: '3x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas3',
																					inputValue: 3
																				},
																				{
																					boxLabel: '4x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas4',
																					inputValue: 4
																				},
																				{
																					boxLabel: '5x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas5',
																					inputValue: 5
																				},
																				{
																					boxLabel: '6x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas6',
																					inputValue: 6
																				},
																				{
																					boxLabel: '7x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas7',
																					inputValue: 7
																				},
																				{
																					boxLabel: '8x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas8',
																					inputValue: 8
																				},
																				{
																					boxLabel: '9x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas9',
																					inputValue: 9
																				},
																				{
																					boxLabel: '10x',
																					name: 'idRadioSelecaoParcelas',
																					id: 'idRadioSelecaoParcelas10',
																					inputValue: 10
																				}],
																				listeners: {
																					//Toda vez que trocar
																					change: function(t, newValue, oldValue){
																						//Atribui a quantidade de parcelas
																						qtdeParcela = t.getValue();
																						
																						//Se for parcelado em mais de 3 vezes, aplicar o juros
																						if (qtdeParcela <= 3){
																							//Atualiza a diferença somando os juros
																							dif = diferenca;
																							
																							//Mostra o valor que será pago
																							Ext.getCmp('idDisplayfieldSelecaoParcelasDiferenca').setValue('<span style="font-style: italic; font-weight: bold; margin-top: 25px; margin-bottom: 25px;">'+Ext.util.Format.brMoney(dif)+'</span>');
																						}
																						else {
																							dif = _Math.getParcelaJurosTotal(diferenca, qtdeParcela);
																							
																							//Mostra o valor que será pago
																							Ext.getCmp('idDisplayfieldSelecaoParcelasDiferenca').setValue('<span style="font-style: italic; font-weight: bold; margin-top: 25px; margin-bottom: 25px;">'+Ext.util.Format.brMoney(dif)+'</span> (com juros)');
																						}
																						//console.log('dif', dif);
																						//Array com as parcelas criadas
																						var vlrParcelas = _Math.distribution(dif, qtdeParcela);
																						
																						//Proibe parcelas menores que R$100,00
																						if (vlrParcelas[vlrParcelas.length - 1] < 100){
																							//Reinicia o check
																							Ext.getCmp('idRadioSelecaoParcelas').reset();
																							
																							//Passa por cada check iguao e maior que as parcelas proibidas
																							for (i = qtdeParcela; i <= 10; i++){
																								//Desabilita os radios
																								Ext.getCmp('idRadioSelecaoParcelas'+i).disable();
																							}
																							
																							//Avisa o usuário
																							Ext.MessageBox.alert('Aviso', 'Não é permitido parcelas menores que R$ 100,00');
																						}
																						
																						//Variável que guarda a mensagem para o usuário
																						var msgParcelas = '<span style="font-style: italic; font-weight: bold; margin-top: 25px; margin-bottom: 25px;">';
																						
																						//Monta a mensagem para o usuário
																						for (i = 0; i < vlrParcelas.length; i++){
																							msgParcelas += (i + 1)+"ª parcela = "+ Ext.util.Format.brMoney(vlrParcelas[i]) +'. <br />';
																						}
																						msgParcelas += '</span>';
																						
																						//Mostra os valores para o usuário
																						Ext.getCmp('idDisplayfieldSelecaoParcelasInfo').setValue(msgParcelas);
																					}
																				}
																			}]
																		},
																		{
																			xtype: 'fieldset',
																			title: 'Valores',
																			labelWidth: 200,
																			height: 215,
																			items: [{
																				xtype: 'displayfield',
																				fieldLabel: 'Valor a mais que deverá ser pago',
																				id: 'idDisplayfieldSelecaoParcelasDiferenca',
																				value: '<span style="font-style: italic; font-weight: bold; margin-top: 25px; margin-bottom: 25px;">'+Ext.util.Format.brMoney(diferenca)+'</span>'
																			},
																			{
																				xtype: 'displayfield',
																				hideLabel: true,
																				id: 'idDisplayfieldSelecaoParcelasInfo',
																				value: '<span style="font-style: italic; font-weight: bold; margin-top: 25px; margin-bottom: 25px;">1ª parcela = '+Ext.util.Format.brMoney(diferenca)+'. </span>'
																			}]
																		}]
																	}],
																	buttons: [{
																		text: 'Confirmar',
																		iconCls: 'ico_accept',
																		handler: function(){
																			//Verifica se o formulario é valido
																			if (Ext.getCmp('idFormTransferencia').getForm().isValid()){		
																				//console.log('diferença1',dif);														
																				//Chama função que faz transferencia do aluno
																				alunoTransferir(matriculaInit, rec[0].get('idpedido'), arrayIdCursosAntigos, arrayDesCursosAntigos, arrayVlrCursosAntigos, isCortesia, arrayIdCursosNovos, arrayDesCursosNovos, arrayIdCursosAgendadosNovos, arrayVlrCursosNovos, info.valor, ((calcValorNovoOrcamento() - diferenca) + dif), dif, newOrcamento, qtdeParcela, 0, arrarIdAlunosAgendadosAntigos, arrayIdCursosAgendadosAntigos);
																				
																				//Fecha a janela
																				Ext.getCmp('idWindowSelecaoParcelas').close();
																			}
																		}
																	},
																	{
																		text: 'Cancelar',
																		iconCls: 'ico_stop',
																		handler: function(){
																			//Fecha a janela
																			Ext.getCmp('idWindowSelecaoParcelas').close();
																		}
																	}]
																}).show();
															}
														}
													});
												}else{
													//console.log('diferença2', diferenca);
													//Chama função que faz transferencia do aluno
													alunoTransferir(matriculaInit, rec[0].get('idpedido'), arrayIdCursosAntigos, arrayDesCursosAntigos, arrayVlrCursosAntigos, isCortesia, arrayIdCursosNovos, arrayDesCursosNovos, arrayIdCursosAgendadosNovos, arrayVlrCursosNovos, info.valor, calcValorNovoOrcamento(), diferenca, newOrcamento, 0, 0, arrarIdAlunosAgendadosAntigos, arrayIdCursosAgendadosAntigos);
												}
											}
										});
									}else{
										//Avisa o usuário
										Ext.MessageBox.erro('Erro', 'É necessário adicionar algum curso para fazer a tranferência!');
									}
								}
							}
						},
						{
							text: 'Fechar',
							iconCls: 'ico_stop',
							handler: function(){
								//Fecha a janela atual
								windowTransferencia.close();
							}
						}],
						'listeners': {
							//Quando a janela ser fechada
							'close': function(){
								//remover tudo do store
								myStoreOrcamentoCursosSelecionados.removeAll();
								myStoreOrcamentoCursosNovos.removeAll();
								
								if(xt('idsolicitacaosecretariatransfer').pressed){
									xt('idsolicitacaosecretariatransfer').toggle();
								}
							}
						}
					}).show();
				}
			});
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
					//console.log('OBJ TREINAMENTO', Treinamento.getInstancia());
					//console.log('OBJ TRANSFERENCIA', Transferencia.getInstancia())
					//STATUS variables
					var $inlistapresenca = xt('idsolicitacaosecretariabtnpresenca').pressed;
					var $incertificado = xt('idsolicitacaosecretariabtncertificado').pressed;
					var $inalunoalterado = (Aluno.getModifiedfield())? true : false;
					var $innfalterado = (AlterarNF.getModifiedField())? true :  false;
					var $inalunodesmembrado = (Aluno.getQtdalunos())? true : false;
					var $inalunodesagendado = (Treinamento.getInAlunoDesagendado() == "true")? true : false;
					var $incadimpactaonline = (Treinamento.getInCadImpactaOnline() == "true")? true : false;
					var $intreinamentotransfer = (Treinamento.getInTreinTransfer() == "true")? true : false;
					var $intreinamentoalterado = ((Treinamento.getTreinamento_atual() && Treinamento.getTreinamento_novo()) && (Treinamento.getInTreinReagendado() == "true"))? true : false;
					var $intreinamentoreposicao = ((Treinamento.getTreinamento_atual() && Treinamento.getTreinamento_novo()) && Treinamento.getInTreinReposicao() == "true")? true : false;
					
					
					//GRID rows
					var $alunorows = xt('idsolicitacaosecretariagridalunomatricula').getSelectionModel().getSelections();
					var $cursoagendadorow = xt('idsolicitacaosecretariagridtreinamentomatricula').getSelectionModel().getSelected();
					
					var Solicitacao = new Class_Solicitacao({
						Treinamento 			: Treinamento.getInstancia(),
						Aluno					: Aluno.getInstancia(),
						Nfalterado 				: AlterarNF.getInstancia(),
						Transferencia			: Transferencia.getInstancia(),
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
							intreinamentoreposicao  : $intreinamentoreposicao,
							intreinamentotransfer  	: $intreinamentotransfer
						}
					});
					
					//console.log("ADICIONAR SOLICITAÇÃO", Solicitacao.getInstancia());
					
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
					
					//Transferência de treinamento
					}else if(Treinamento.getInTreinTransfer() == "true"){
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
					var $intreinamentotransfer = false;
					
					//console.log("VISUALIZAR ANDAMENTO", arrObjAlunoAlterado);
					
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
						$intreinamentotransfer	= (this.status.intreinamentotransfer)? true : false;
					});
					
					if(!($inmodifiedfields || $inlistapresenca || $incertificado || $intreinamentoalterado || $innfalterado || $inalunodesagendado || $inalunodesmembrado || $incadimpactaonline || $intreinamentoreposicao || $intreinamentotransfer)){
						ms.info('Aviso!', 'Nenhuma alteração foi feita.');
					}else{
						$.each(arrObjAlunoAlterado, function(){
							
							var $Treinamento = this.Treinamento;
							var $TreinamentoAtual = $Treinamento.treinamento_atual;
							var $TreinamentoNovo = $Treinamento.treinamento_novo;
							var $Transferencia = this.Transferencia;
							var $Nfalterado = this.Nfalterado;
							var $Aluno = this.Aluno;
							var $status = this.status;
							
							var $idcursoagendadoatual = $TreinamentoAtual.idcursoagendado;
							var $idcursoagendadoanovo = $TreinamentoNovo.idcursoagendado;
							
							var $motivoDesagendamento = ($Treinamento.motivoDesagendamento)? $Treinamento.motivoDesagendamento : "Sem motivo";
							var $motivoReagendamento = ($Treinamento.motivoReagendamento)? $Treinamento.motivoReagendamento : "Sem motivo";
							var $motivoReposicao = ($Treinamento.motivoReposicao)? $Treinamento.motivoReposicao : "Sem motivo";
							var $motivoTransfer = ($Treinamento.motivoTransfer)? $Treinamento.motivoTransfer : "Sem motivo";
							
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
							
							//Transferência de Treinamento
							var $htmltreinamentotransfer = ($status.intreinamentotransfer)? "<div><b style='display: block; margin: 0 auto; width: 200px;'>Transferência de Treinamento: </b>" : "<div>";
							if($status.intreinamentotransfer){
								
								var $treinantigos = "";
								$.each($Transferencia.descursosantigos.split(","), function(iDescurso, vDescurso){
									$.each($Transferencia.idcursosantigos.split(","), function(iId, vId){
										$.each($Transferencia.vlrcursosantigos.split(","), function(iValor, vValor){
											
											if((iDescurso == iId) && (iDescurso == iValor) && (iId == iValor)){
												
												$treinantigos += 
												
												"<div style='border-bottom:1px solid #99bbe8;'>- "+
													"<b>Curso: </b>"+vDescurso+"<b> | </b>"+
													"<b>Cód. Curso: </b>"+vId+"<b> | </b>"+
													"<b>Valor: </b>"+formatcurrency(vValor)+
												"</div>";
											}
										});	
									});
								});
								
								var $treinnovos = "";
								$.each($Transferencia.descursosnovos.split(","), function(iDescurso, vDescurso){
									$.each($Transferencia.idcursosnovos.split(","), function(iId, vId){
										$.each($Transferencia.vlrcursosnovos.split(","), function(iValor, vValor){
											
											if((iDescurso == iId) && (iDescurso == iValor) && (iId == iValor)){
												
												$treinnovos += 
												
												"<div style='border-bottom:1px solid #99bbe8;'>- "+
													"<b>Curso: </b>"+vDescurso+"<b> | </b>"+
													"<b>Cód. Curso: </b>"+vId+"<b> | </b>"+
													"<b>Valor: </b>"+formatcurrency(vValor)+
												"</div>";
											}
										});	
									});
								});
								
								$htmltreinamentotransfer+= '<div style="border-bottom:1px solid #99bbe8; ">';
								$htmltreinamentotransfer+= '<div><b>Treinamento(s):</b><br />'+$treinantigos+'<br /></div>';
								$htmltreinamentotransfer+= '<div><b>Para treinamento(s):</b><br />'+$treinnovos+'<br /></div>';
								$htmltreinamentotransfer+= '<div><b>Motivo da transferência: </b>'+$motivoTransfer+'</div>';
								$htmltreinamentotransfer+= '</div>';
							}
							$htmltreinamentotransfer+='</div>';
							
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
										$htmltreinamentotransfer+
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
										if($myJson.success){
											
											$('#myimageload img').hide();
											$('#modal-load').hide();
											
											ms.info('Solicitação Finalizada', 'Sua solicitação foi finalizado com sucesso! Você pode visualizar a solicitação gerada na aba \"Visualizar Solicitações \".', function(){
												
												getMessageSolicitacaoNaoRealizada($myJson);
												
												//socket para notificar a tela de solicitação da secretaria que uma solicitação foi salva pelo corporativo
												if(typeof socket == "object"){
													socket.emit('trigger',{
														event: 'salvar_solitacao_corp2', 
														data: {
															tipo: "salvo"
														}
													});
												}
											});
										}else{
											
											$('#myimageload img').hide();
											$('#modal-load').hide();
											
											ms.warning('Solicitação não concluída', $myJson.msg, function(){
												
												getMessageSolicitacaoNaoRealizada($myJson);
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
										
										//socket para notificar a tela de solicitação da secretaria que uma solicitação foi excluída pelo corporativo
										if(typeof socket == "object"){
											socket.emit('trigger',{
												event: 'salvar_solitacao_corp2', 
												data: {
													tipo: "excluído"
												}
											});
										}
										
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
												idpedido: IDPEDIDO,
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
								singleSelect: false,
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
								header:'Valor',
								dataIndex:'unitario',
								renderer: function(v, a, sb){
									if(sb.get('inreposicao')){
										return "n/a";
									}else{
										return formatcurrency(v);
									}
								}
							},{
								header:'Total',
								dataIndex:'total',
								hidden: true,
								renderer: function(v, a, sb){
									if(sb.get('inreposicao')){
										return "n/a";
									}else{
										return formatcurrency(v);
									}
								}
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
									
									if($this.getSelectionModel().getSelections().length == 1){
										Treinamento.constructTreinamento($this.getStore().getAt(index));
									
										fn_btnCertificadoPresencaShow();
										fn_disableToggleButtons();
										fn_reagendamentodatasLoad({
											inaberto : 0,
											intransfer : 0
										});	
									}else{
										xt('idsolicitacaosecretariagridreagendamentomatricula').getStore().removeAll();
										fn_unableToggleButtons();
									}
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
								text:'Transferência',
								iconCls:'ico_Stuttgart_tag',
								id:'idsolicitacaosecretariatransfer',
								disabled:true,
								enableToggle:true,
								toggleHandler:function(btn, state){
									
									var treinamentos = xt('idsolicitacaosecretariagridtreinamentomatricula').getSelectionModel();
									var hasTreinReposicao = false;
									
									//Verifica se algum treinamento de reposição foi selecionado
									$.each(treinamentos.getSelections(), function(){
										if(this.get('inreposicao') == 1){
											hasTreinReposicao = true;
										}
									});
									
									//Se o botão for pressionado
									if(state){
										//xt('idsolicitacaosecretariacmbcursos').show();
										//var idcurso = xt('idsolicitacaosecretariacmbcursos').getValue();
										
										xt('idsolicitacaosecretariagridreagendamentomatricula').getStore().removeAll();
										
										if(treinamentos.hasSelection()){
											
											if(!hasTreinReposicao){
											
												openWindowTransferencia(treinamentos.getSelections());
												
											}else{
												ms.info("Operação Inválida", "Não é permitido transferência de treinamentos de reposição");
											}
										}else{
											ms.info("Operação Inválida", "Por favor, selecione os treinamentos que queira transferir");
										}
										
									//Se o botão for despressionado
									}else{
										//xt('idsolicitacaosecretariacmbcursos').hide();
										
										fn_reagendamentodatasLoad({
											inemaberto: (xt('idsolicitacaosecretariabtnemaberto').pressed)? 1 : 0,
											intransfer: 0
										});
									}
								}
							}/*,'-',{								
								xtype:'combo_cursosativos',
								id:'idsolicitacaosecretariacmbcursos',
								width:300,
								hidden:true,
								typeAhead:true,
								triggerAction:'all',
								lazyRender:true,
								allowBlank:false,//Não permite entradas vazias
								name:'idcurso',
								hiddenName:'idcurso',
								emptyText:'Selecione um curso...',
								listeners:{
								'select':function(){
										fn_reagendamentodatasLoad({
											inemaberto: (xt('idsolicitacaosecretariabtnemaberto').pressed)? 1 : 0,
											intransfer: 1
										});
									}
								}
							}*/,'-',{
								text:'Em aberto',
								id:'idsolicitacaosecretariabtnemaberto',
								iconCls:'ico_application_view_list',
								disabled:true,
								enableToggle:true,
								toggleHandler:function(btn, state){
									if(state){
										fn_reagendamentodatasLoad({
											inaberto : 1,
											intransfer : 0
										});
									}else{
										fn_reagendamentodatasLoad({
											inaberto : 0,
											intransfer : 0
										});
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
														if(xt('idsolicitacaosecretariatransfer').pressed){
															ms.warning('Operação Inválida!', "Não é possível fazer o reagendamento para o Curso selecionado.");
														}else{
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
																			
																			xt('winsolicitacaosecretariareagendamentomotivo').close();
																		}
																	}]
																}).show();
															}
														}
													}
												},{
												//////////////////////////////// REPOSIÇÃO ////////////////////////////////////////////////
													text:'<b>[Reposição]</b> De: '+'Para: '+fn_ifDateIsNull($storereagendamento.getAt(index).get('dtinicio'))+' ('+$storereagendamento.getAt(index).get('desperiodo')+')',
													iconCls:'ico_action_add',
													handler:function(){
														if(xt('idsolicitacaosecretariatransfer').pressed){
															ms.warning('Operação Inválida!', "Não é possível fazer a reposição para o Curso selecionado.");
														}else{
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
													}
												}/*,{
												//////////////////////////// TRANSFERÊNCIA ///////////////////////////////////////////////
													text:'<b>[Transferência]</b> De: '+'Para: '+fn_ifDateIsNull($storereagendamento.getAt(index).get('dtinicio'))+' ('+$storereagendamento.getAt(index).get('desperiodo')+')',
													iconCls:'ico_Stuttgart_tag',
													handler:function(){
														if(xt('idsolicitacaosecretariatransfer').pressed){	
															
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
																	id:'winsolicitacaosecretariatransfermotivo',
																	title:"Deseja inserir o motivo da transferência?",
																	iconCls:'ico_Stuttgart_tag',
																	autoHeight:true,
																	width:400,
																	items:[{
																		xtype:'form',
																		border:false,
																		padding:5,
																		id:'idformsolicitacaosecretariatransfermotivo',
																		items:[{
																			xtype:'textarea',
																			width:'98%',
																			style:'margin-bottom:-5px',
																			hideLabel:true,
																			maxLength:1000,
																			name:'justificativa',
																			emptyText:'Escreva aqui o motivo da transferência',
																			id:'idtxtsolicitacaosecretariatransfermotivo',
																		}]
																	}],
																	buttons:['->',{
																		text:'Salvar Motivo',
																		scale:'medium',
																		iconCls:'ico_save',
																		handler:function(){
																			var $motivo = $.trim(xt('idtxtsolicitacaosecretariatransfermotivo').getValue());
																			if($motivo){
																				
																				Treinamento.setSolicitacaoTreinTipo('transferencia');
																				Treinamento.setMotivo($motivo);
																				
																				//INTREINAMENTOREPOSICAO = true;
																				
																				xt('winsolicitacaosecretariatransfermotivo').close();
																				
																				openWindowTransferencia(
																					xt('idsolicitacaosecretariagridtreinamentomatricula').getSelectionModel().getSelections()
																				);
																			}else{
																				ms.warning("Aviso!", "Favor, insira um motivo");
																			}
																		}
																	},'-',{
																		text:'Agendar transferência sem Motivo',
																		scale:'medium',
																		iconCls:'ico_Exit',
																		handler:function(){
																			
																			Treinamento.setSolicitacaoTreinTipo('transferencia');
																			Treinamento.setMotivo("");
																			
																			//INTREINAMENTOREPOSICAO = true;
																			
																			xt('winsolicitacaosecretariatransfermotivo').close();
																		}
																	}]
																}).show();
															}
														}else{
															ms.warning('Operação Inválida!', "Não é possível fazer a transferência para o Curso selecionado.");
														}
													}
												}*/]
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
								header:'Transferência',
								dataIndex:'intreinamentotransfer',
								tooltip:'Transferência de Treinamento',
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
	});
</script>