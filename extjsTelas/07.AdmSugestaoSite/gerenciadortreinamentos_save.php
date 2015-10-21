<?
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idcurso = post('idcurso');
$idprerequisito = post('idprerequisito');
$idavancado = post('idavancado');

Sql::query('SATURN','SIMPAC',"sp_cursosclassificados_save $idcurso, $idprerequisito, $idavancado");

echo success;

acao(''.($_SESSION["nmusuario"]).' adicionou um treinamento:'.$idcurso.', Pre-requisito:'.$idprerequisito.' e uma Sugestao:'.$idavancado.' em "Gerenciador de Treinamentos"');
?> 