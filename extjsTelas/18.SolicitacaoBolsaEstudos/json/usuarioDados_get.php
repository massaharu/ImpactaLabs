<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idusuario = post('idnomecolaborador');

$usuario = new Usuario($idusuario);
$departamento = new Departamento($usuario->iddepto);
$cargo	= new Cargo($usuario->idcargo);

$data = array();

array_push($data, array(
		'desdepartamento'=>$departamento->desdepto,
		'descargo'=>$cargo->descargo,
		'dtadmissao'=>($usuario->dtadmissao)?date('d/m/Y',$usuario->dtadmissao):0,
		'nrcpf'=>$usuario->nrcpf
	)
);

echo json_encode(array("myData"=>$data));


?>
