<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$pais = new Pais(post('idpais'));
$pais->instatus = post('instatus');
$pais->save();
/*

$idpais = post('idpais');
$instatus = post('instatus');


Sql::query('SATURN','VENDAS', "sp_paisesstatus_set $idpais $instatus");*/

echo success;

/*sp_paisesstatus_set idpais, instatus

Passe dois parametros, o ID do pais e tambem o id do status sendo 1 para habilitar e dois para desabilitar*/

?>