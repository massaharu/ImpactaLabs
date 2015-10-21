<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$depto = post('iddepartamento');
$desfrase = post('desfrase');

Sql::query('JETTA','CHATV2',"sp_chatadmfrases_add '$desfrase', $depto");

echo success;

/*sp_chatadmfrases_add – passe dois parametros: conteudo da frase e o id do departamento.*/
?>