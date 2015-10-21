<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idfrase = post('idfrase');
$upfrase = post('upfrase');

Sql::query('JETTA','CHATV2',"sp_chatadmfrases_update  '$upfrase', $idfrase");

echo success;

/*sp_chatadmfrases_update – passe três parâmetros: conteúdo da frase, id da frase*/
?>



