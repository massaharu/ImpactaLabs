<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$iddata = post('iddata');

if($iddata != "" || $iddata != NULL){

	Sql::query('SATURN','SIMPAC',"sp_retiradadecheque_diasemretirada_delete $iddata");
	
	echo success(TRUE);
}else{
	echo success(FALSE);
}


?>