<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idfrase = post('idfrase');

Sql::query('JETTA','CHATV2',"sp_chatadmfrases_remove $idfrase");

echo success;

/*sp_chatadmfrases_remove – passe um parâmetro: id da frase.*/
?>





























