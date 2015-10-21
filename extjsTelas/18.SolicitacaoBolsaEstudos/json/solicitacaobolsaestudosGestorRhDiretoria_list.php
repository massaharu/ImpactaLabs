<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

if(post('idusuario') == "" || post('idusuario') == NULL){
	$idusuario = $_SESSION['idusuario'];
}else{
	$idusuario = post('idusuario');
}

$idpermissao = post('idpermissao');

if($idpermissao == 1){
	$data = Sql::arrays("SATURN", "FIT_NEW", "sp_solicitacaobolsaestudos_gestor_list $idusuario");
}else if($idpermissao == 2){
	$data = Sql::arrays("SATURN", "FIT_NEW", "sp_solicitacaobolsaestudos_rh_list");
}else if($idpermissao == 3){
	$data = Sql::arrays("SATURN", "FIT_NEW", "sp_solicitacaobolsaestudos_diretoria_list");
}

echo json_encode(array("myData"=>$data));
?>
