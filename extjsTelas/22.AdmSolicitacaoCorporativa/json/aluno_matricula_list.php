<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
///////////////////////////////////////////////////////////////////////////////////////

$Matricula = new Matricula(post('matricula'));
//$matricula =  new Matricula('9911073368');
$Alunos = $Matricula->getIdAluno();
$arr_controleFinanceiro = ControleFinanceiro::getControleFinanceiroByMatricula($Matricula->matricula);

$isempresa = ($arr_controleFinanceiro[0]['InTipo'] == "J")? true : false;
$idpedido = $arr_controleFinanceiro[0]['IdPedido'];

$myData = array();

//////////////////////////////////////////////////////////////////////////////////////

foreach($Alunos as $Aluno){
	
	$Aluno = new Aluno($Aluno['idaluno']);
	 
	array_push($myData, array(
		"cdemail"=>$Aluno->cdemail,
		"cdemailempresa"=>$Aluno->cdemailempresa,
		"complemento"=>$Aluno->complemento,
		"desbairro"=>$Aluno->desbairro,
		"descidade"=>$Aluno->descidade,
		"desendereco"=>$Aluno->desendereco,
		"dessexo"=>$Aluno->dessexo,
		"dtcadastramento"=>$Aluno->dtcadastramento,
		"dtnascimento"=>$Aluno->dtnascimento,
		"endereco"=>$Aluno->endereco,
		"idaluno"=>$Aluno->idaluno,
		"desaluno"=>$Aluno->nmaluno,
		"nrcelular"=>$Aluno->nrcelular,
		"nrcep"=>$Aluno->nrcep,
		"nrcpf"=>$Aluno->nrcpf,
		"nrrg"=>$Aluno->nrrg,
		"nrtelefonecomercial"=>$Aluno->nrtelefonecomercial,
		"nrtelefoneresidencial"=>$Aluno->nrtelefoneresidencial,
		"num"=>$Aluno->num,
		"sgestado"=>$Aluno->sgestado,
		"tipoendereco"=>$Aluno->tipoendereco,
		"isempresa"=>$isempresa,
		"idpedido"=>$idpedido
	));	
}

echo json_encode(array(
	'success'=>true, 
	'myData'=>$myData
));

?>