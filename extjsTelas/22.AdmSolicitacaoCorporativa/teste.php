<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

//$matricula = new Matricula('0413030782');
//
//$idalunoagendado = $matricula->getIdAlunoAgendado();
//
//$hasSameAluno_count = 0;
//
//foreach($idalunoagendado as $key=>$value){
//	$alunoagendado = new AlunoAgendado($value['idalunoagendado']);
//	$aluno = $alunoagendado->getAluno();
//	
//	
//	$arr_idaluno = array();
//	array_push($arr_idaluno, $aluno->idaluno);
//	
//	//Verifica se o idaluno encontrado em alunoagendado já existe
//	foreach($arr_idaluno as $key=>$value){
//		
//		if($aluno->idaluno == $value) $hasSameAluno_count++;
//		
//			
//		if($hasSameAluno_count <= 1){
//			
//			var_dump($alunoagendado->getAluno());
//		}
//	}
//	
//	
//	/*echo '<pre>';
//	var_dump($alunoagendado->getAluno()->idaluno);
//	echo '</pre>';*/		
//}

//var_dump($_SESSION['cdemail']);
//echo date('d/m/Y - H:i:s',1311422400)
/*$cursoagendado = new CursoAgendado(65363);
$curso = new Curso($cursoagendado->idcurso);
$descurso = ($cursoagendado->desobs)? $curso->descurso.' - '.$cursoagendado->desobs : $curso->descurso;
$instrutor = $cursoagendado->getInstrutor();
$sala = new Sala($cursoagendado->idsala);
$dtinicio = date('d/m/Y', $cursoagendado->dtinicio);
$dttermino = date('d/m/Y', $cursoagendado->dttermino);
$hrinicio = date('H:i:s', $cursoagendado->dtinicio);
$hrtermino = date('H:i:s', $cursoagendado->dttermino);

echo $descurso.", De: ".$dtinicio." Até: ".$dttermino." das ".$hrinicio." às ".$hrtermino." - Sala: ".$sala->dessala." / Instrutor: ".$instrutor->desinstrutor." ".$cursoagendado->dtinicio;*/

/*$solicitacao = new SolicitacaoCorporativa(71);
$alunoempresa = $solicitacao->getAlunoEmpresabyAlunoAgendado();
$empresa = new Empresa($alunoempresa[0]["IdEmpresa"]);

echo $empresa->nmempresa;*/


//echo $_SESSION["idusuario"];

/*$objCheque = new Cheque(413548);
$objControleFinanceiro = new ControleFinanceiro($objCheque->idcontrolefinanceiro);
$objAluno = new Aluno($objControleFinanceiro->idcliente);
var_dump($objAluno);
*/
/*$arr = array(1495, 11);


if((string)array_search(11, $arr) !== ""){
	echo array_search(1495, $arr)."";
};*/

/*$aluno = new AlunoAgendado(0);
$arr = array();

$arr = AlunoAgendado::getAlunoAgendadoAlterados(65093);

echo $arr["IdAlunoAgendado"];*//*
$iduser = 97;
$retorno = Sql::select("SATURN", "SIMPAC", "sp_ultimaMatricula");

$proxima = substr(1234569999, 6, strlen(1234561000)) + 1;

$proxmatricula = $iduser.date("y").date("m").substr("0000".$proxima, strlen($proxima), 5);

echo $proxmatricula;*/

/*$datainicio = '2012-01-01 00:00:00';
	$datatermino = '2013-05-01 23:59:59';
	
	$data = Sql::arrays('SATURN','SIMPAC',"sp_relatorio_vendas_consolidada_site_list '$datainicio','$datatermino'");
	
	//exit("sp_relatorio_vendas_consolidada_site_list '$datainicio','$datatermino'");
	
	echo json_encode(array(
		'success'=>true,
		'site'=>$data
	));*/


/*$NotaFiscal = new NotaFiscalFaturamento(9713090008);

var_dump($NotaFiscal);*/

//$idsolicitacaocorp = new SolicitacaoCorporativa(1);
/*
$permisions = array(1495, 11);


if(array_search($_SESSION["idusuario"], $permisions)){
	echo array_search(1495, $permisions);
}else{
	echo array_search(1495, $permisions);	
}*/

/*$ret = SolicitacaoCorporativa::hasReagendamentoPendente(1487822);
if(is_null($ret["idsolicitacaocorp"]))
	echo "true ".$ret["idsolicitacaocorp"];
else
	echo "false ".$ret["idsolicitacaocorp"];*/
/*
$Empresa = new Empresa(395951);

echo $Empresa->nmempresa;*/
				
/*if((string)array_search($_SESSIONS["idusuario"], $permisions) !== ""){
	$solicitacaocorplist = $idsolicitacaocorp->solicitacaoCorpList($dtinicio, $dtfinal.' 23:59:59');
}*/
/*$search = new Search("Massaharu");
$search->searchMatricula();
echo "<pre>";
var_dump($search->getResultLinkPermissao());
echo "</pre>";*/
/*
$arr_presencas = @Sql::arrays("SATURN", "SIMPAC", "sp_presencaalunobycursoagendado_list 945468, 103169");

foreach($arr_presencas as $presenca){
	echo date("Y-m-d H:i:s", $presenca["dtcadastro"])." ";
}*/
/*
function my_envia_email($assunto, $mensagem, $para){
		envia_email($assunto, $mensagem, $para);
}
$para = "massaharu@impacta.com.br; marjori@impacta.com.br; Juliana@impacta.com.br ; Mscabio@impacta.com.br;";
$assunto = "Reagendamento de Turmas";
$mensagem = emailpadrao("Alteração solicitado pelo(a) colaborador(a) <b>Carlos Eduardo Dias Rodrigues</b> de reagendamento de turmas do(a) Cliente <b>Landoaldo Lima Oliveira/b> com a matrícula: <b>6913060208</b>. Motivo: Sem motivo. Favor, confirmar esta alteração na tela de Solicitação do Corporativo: SimpacWeb -> Secretaria -> Solicitação Corporativa");

my_envia_email($assunto, utf8_decode($mensagem), $para);*/
//$arr = array();
//array_push($arr, array("alfa"=>222));
//array_push($arr, array("beta"=>2342));
//array_push($arr, array("celta"=>87676));
////$arr["beta"] = "Olá";
//
//foreach($arr as $val){
//	echo $val["beta"];	
//}
/*
$Matricula = new Matricula(9713090244);

$arr_idaluno = $Matricula->getIdAluno();
$stat = 0;

foreach($arr_idaluno as $alunos){
	if($alunos["idaluno"] ==  12313)
		$stat = 2;
}
*/
/*
$soli = new solicitacaoCorporativa(383);
$soli = $soli->isAlunoAgendadoInMatricula(986811);

echo $soli;


echo "<br /><br /><pre>";
 echo  " Status: ".$stat;
echo "</pre>";*/

//$ImpactaOnline = new ImpactaOnline();
//$arr_curso = array();
//
//if($ImpactaOnline->getUser('massaharu@impacta.com.br')){
//	
//	$SituationCourses = $ImpactaOnline->getSituacionCourseV2();
//	
//	
//} else {
//	
//	$SituationCourses = array();
//}
//
//
//
//
//
//pre($SituationCourses);
//echo '<hr />';
//foreach($SituationCourses as $SituationCourse){
//	array_push($arr_curso, $SituationCourse->course->title);
//}
//
//$Account = new Account(Account::getIdCliente('39539063809', 'massaharu.kunikane@yahoo.com.br'));
//
//
//pre($Account);
/*
if(Account::isExistsByCpf('39539063809')){
	$account = Account::getByCpf('39539063809');
	echo 'TRUE';
}else{
	$account = Account::getByEmail('39539063809', 1);
	$account = $account[0];
	echo 'FALSE';
}
*/
////pre($Account); 
//echo '<hr />';
//pre($ImpactaOnline->getLoginInfo('massaharu@impacta.com.br', 'Impacta1'));
//echo '<hr />';
//pre($ImpactaOnline->getSituacionCourseV2());
//echo '<hr />';
//pre($arr_curso);
////exit;
//$ImpactaOnline->setEmail($Account->nome_cli,$Account->senha_cli,$Account->email_cli,$arr_curso,1);
/*pre($account);

$cpf = '395.398.390-63';

echo str_replace(".", "", str_replace("-", "", str_replace(" ", "", $cpf)));

echo "<hr />";

$ImpactaOnline = new ImpactaOnline();

pre($ImpactaOnline->getUser('LNeto@impacta.com.br'));
echo count(Account::getByEmail('massaharu.kunikane@yahoo.com.br', 1));
*/
$ImpactaOnline = new ImpactaOnline();

$arr_objAccount = array();

if(count(Account::listByCpf('39539063809')) > 0){
	$arr_account = Account::listByCpf('39539063809');
}else{
	$arr_account = Account::getByEmail('massaharu.kunikane@yahoo.com.br', 1);
}

foreach($arr_account as $account){
	array_push($arr_objAccount, array(
		'objAccount'=>	new Account($account['cod_cli'])
	));
}

echo "setUser -> ".var_dump($ImpactaOnline->setUser("andressa._2012@hotmail.com","Impacta1","Andressa do Nascimento Severino",1132542200));
exit;

foreach($arr_objAccount as $Account){
	echo $Account['objAccount']->email_cli.",".$Account['objAccount']->senha_cli.",".$Account['objAccount']->nome_cli.",1132542200<br /><br />";
	
	echo "setUser -> ".var_dump($ImpactaOnline->setUser($Account['objAccount']->email_cli,$Account['objAccount']->senha_cli,$Account['objAccount']->nome_cli,1132542200))."<br /><br />";
	
	
}

/*
$Curso = new Curso(2793);

//pre($Curso->isEAD(0));

$ImpactaOnline = new ImpactaOnline();
echo $ImpactaOnline->getUser('lneto@impacta.com.br');
pre($ImpactaOnline->getSituacionCourseV2());
*/

/*$credito = abs(-2.00);
$descritivo = "Transação inserida automaticamente devido alteração de curso jurídico";
$p = new Pessoa('59069914000151');*/
//echo $p->getSaldo();
//pre($p);
//34784785884
//echo Transacao::TIPO_AVULSO; exit;
//Insere credito para o aluno
/*$p->addCredito($descritivo, str_replace(',', '.',(string)$credito), array(
	Transacao::TIPO_AVULSO
));	*/
?>