<?php
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
Sql::query('CALIBRA','Orcamento',"sp_pedidosaceitacao_update ".post('idpedido'));
?>