<?
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

/*$idprerequisito = post('idprerequisito');
$desprerequisito = post('desprerequisito');
Sql::query('SQL_TESTE','DEV_TESTE',"sp_prerequisito_update $idprerequisito,'$desprerequisito'");

$idtreinamento = post('idtreinamento');
$destreinamento = post('destreinamento');
Sql::query('SQL_TESTE','DEV_TESTE',"sp_treinamento_update $idtreinamento,'$destreinamento'");

$idavancado = post('idavancado');
$desavancado = post('desavancado');
Sql::query('SQL_TESTE','DEV_TESTE',"sp_avancado_update $idavancado,'$desavancado'");*/

$idclassificacao = post('idclassificacao');
$idavancado = post('idavancado');
$idcurso = post('idcurso');
$idprerequisito = post('idprerequisito');

Sql::query('SATURN','SIMPAC',"sp_gerenciadortreinamentos_update $idclassificacao, $idcurso, $idprerequisito, $idavancado");


echo success;
?>